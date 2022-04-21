<?php

namespace Rackbeat\VismaConnect\Auth\Responses;

class OAuthTokenResponse
{
	public string $id_token;
	public string $access_token;
	public int    $expires_in;
	public string $token_type;
	public string $scope;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value) {
			$this->{$key} = $value;
		}
	}
}