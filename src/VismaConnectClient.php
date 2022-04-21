<?php

namespace Rackbeat\VismaConnect;

use Rackbeat\VismaConnect\Exceptions\Client\UserAgentRequiredException;
use Rackbeat\VismaConnect\Http\HttpEngine;
use Rackbeat\VismaConnect\Http\MockHttpEngine;

class VismaConnectClient
{
	private string $clientId;
	private string $clientSecret;

	public function __construct(?string $clientId = null, ?string $clientSecret = null)
	{
		$this->clientId     = (string) ($clientId ?: config('visma_connect.client_id'));
		$this->clientSecret = (string) ($clientSecret ?: config('visma_connect.client_secret'));
	}

	public function oauth(): VismaConnectAuthenticationClient
	{
		return new VismaConnectAuthenticationClient($this->clientId, $this->clientSecret);
	}

	public function api(?string $accessToken = null, ?array $scopes = null): VismaConnectApiClient
	{
		return new VismaConnectApiClient($accessToken, $this->clientId, $this->clientSecret, $scopes);
	}
}