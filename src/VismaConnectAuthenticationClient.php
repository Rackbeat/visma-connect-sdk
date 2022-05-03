<?php

namespace Rackbeat\VismaConnect;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Rackbeat\VismaConnect\Auth\Responses\OAuthTokenResponse;
use Rackbeat\VismaConnect\Auth\Responses\OAuthUserInfoResponse;
use Rackbeat\VismaConnect\Exceptions\Client\UserAgentRequiredException;

class VismaConnectAuthenticationClient
{
	private string $nonce;
	private string $baseUrl;
	private string $clientId;
	private string $clientSecret;

	public const ENDPOINT_USER_INFO   = '/connect/userinfo';
	public const ENDPOINT_END_SESSION = '/connect/endsession';
	public const ENDPOINT_AUTHORIZE   = '/connect/authorize';
	public const ENDPOINT_TOKEN       = '/connect/token';

	public function __construct(?string $clientId = null, ?string $clientSecret = null)
	{
		$this->clientId     = (string) $clientId;
		$this->clientSecret = (string) $clientSecret;

		$this->baseUrl = config('visma_connect.oauth.base_urls.'.config('visma_connect.environment'));
	}

	public function nonce(string $nonce)
	{
		$this->nonce = $nonce;

		return $this;
	}

	public function addNonceToSession(string $nonce = null)
	{
		$this->nonce = $nonce ?? $this->nonce ?? Str::random(32);

		session()->put('VISMA_CONNECT_NONCE', $this->nonce);

		return $this;
	}

	public function getNonceFromSession(): string
	{
		return session()->get('VISMA_CONNECT_NONCE');
	}

	public function getAuthorizationRequestUrl(array $config = []): string
	{
		$url = $this->baseUrl.static::ENDPOINT_AUTHORIZE;

		$config = array_merge(array_filter([
			'client_id'     => $this->clientId,
			'redirect_uri'  => config('visma_connect.oauth.redirect_uri'),
			'response_type' => config('visma_connect.oauth.response_type'),
			'scope'         => config('visma_connect.oauth.scopes'),
			'response_mode' => 'form_post',
			'nonce'         => $this->nonce ?? Str::random(32),
			'state'         => '',
			'prompt'        => 'none',
		]), $config);

		$url .= '?'.http_build_query($config);

		return $url;
	}

	public function getTokensFromAuthorication(string $code, array $config = []): OAuthTokenResponse
	{
		$config = array_merge(array_filter([
			'client_id'     => $this->clientId,
			'client_secret' => $this->clientSecret,
			'grant_type'    => 'authorization_code',
			'code'          => $code,
			'redirect_uri'  => config('visma_connect.oauth.redirect_uri'),
		]), $config);

		$response = Http::timeout(15)->asForm()->post(
			$this->baseUrl.static::ENDPOINT_TOKEN,
			$config
		);

		if ($response->failed()) {
			throw $response->throw(); // todo better handling
		}

		return new OAuthTokenResponse($response->json());
	}

	public function getUserInfo(string $accessToken): OAuthUserInfoResponse
	{
		$response = Http::timeout(15)->withToken($accessToken)->get(
			$this->baseUrl.static::ENDPOINT_USER_INFO
		);

		if ($response->failed()) {
			throw $response->throw(); // todo better handling
		}

		return new OAuthUserInfoResponse($response->json());
	}

	public function getUserInfoFromTokenResponse(OAuthTokenResponse $tokenResponse): OAuthUserInfoResponse
	{
		return $this->getUserInfo($tokenResponse->access_token);
	}

	public function logout(string $idToken)
	{
		$url = static::ENDPOINT_END_SESSION;

		$config = [
			'id_token_hint'            => $idToken,
			'post_logout_redirect_uri' => config('visma_connect.oauth.redirect_uri'),
		];

		return Http::timeout(15)->baseUrl($this->baseUrl)->get($url, $config)->throw();
	}

	public function getLogoutUrl(string $idToken)
	{
		return $this->baseUrl.static::ENDPOINT_END_SESSION.'?id_token_hint='.$idToken.'&post_logout_redirect_uri='.config('visma_connect.oauth.logout_redirect_uri');
	}
}