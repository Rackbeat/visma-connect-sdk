<?php

namespace Rackbeat\VismaConnect;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Rackbeat\VismaConnect\Auth\Responses\ApiTokenResponse;
use Rackbeat\VismaConnect\Exceptions\Client\UserAgentRequiredException;
use Rackbeat\VismaConnect\Resources\TenantResource;
use Rackbeat\VismaConnect\Resources\UserResource;
use Rackbeat\VismaConnect\Resources\ApplicationResource;

class VismaConnectApiClient
{
	private string  $baseUrl;
	private string  $clientId;
	private string  $clientSecret;
	private ?string $accessToken = null;
	private ?array $scopes = null;

	public const ENDPOINT_TOKEN       = '/connect/token';

	public function __construct(?string $accessToken = null, ?string $clientId = null, ?string $clientSecret = null, ?array $scopes = null)
	{
		$this->clientId     = $clientId;
		$this->clientSecret = $clientSecret;
		$this->accessToken  = $accessToken;
		$this->scopes  = $scopes;

		$this->baseUrl    = config('visma_connect.api.base_urls.'.config('visma_connect.environment'));
		$this->apiVersion = config('visma_connect.api.version');

		$this->bindHttpMacro();
	}

	public function users(): UserResource
	{
		return new UserResource();
	}

	public function tenants(): TenantResource
	{
		return new TenantResource();
	}

	public function applications(): ApplicationResource
	{
		return new ApplicationResource();
	}

	public function requestAccessToken(array $config = []): ApiTokenResponse
	{
		$config = array_merge([
			'client_id'     => $this->clientId,
			'client_secret' => $this->clientSecret,
			'grant_type'    => 'client_credentials',
			'scope'         => implode(' ', $this->scopes ?? config('visma_connect.api.scopes'))
		], $config);

		$response = Http::asForm()->post(
			config('visma_connect.oauth.base_urls.'.config('visma_connect.environment')).static::ENDPOINT_TOKEN,
			$config
		);

		if ($response->failed()) {
			throw $response->throw(); // todo better handling
		}

		return new ApiTokenResponse($response->json());
	}

	public function withToken(string $token)
	{
		$this->accessToken = $token;

		return $this;
	}

	protected function bindHttpMacro(): void
	{
		$url = $this->baseUrl.'/'.$this->apiVersion.'/';

		if (!$this->accessToken) {
			$this->accessToken = $this->requestAccessToken()->access_token;
		}

		$accessToken = $this->accessToken;

		Http::macro('vismaConnectApi', function () use ($url, $accessToken): PendingRequest {
			$client = Http::baseUrl($url);

			$client->withHeaders([
				'X-Forwarded-For' => $_SERVER['SERVER_ADDR'] ?? '127.0.0.1',
				'Content-Type'    => 'application/json',
			]);

			$client->withToken($accessToken);

			return $client;
		});
	}
}