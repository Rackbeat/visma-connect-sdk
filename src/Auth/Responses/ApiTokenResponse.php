<?php

namespace Rackbeat\VismaConnect\Auth\Responses;

class ApiTokenResponse
{
	public string $access_token;
	public int    $expires_in;
	public string $token_type;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value) {
			$this->{$key} = $value;
		}
	}
}