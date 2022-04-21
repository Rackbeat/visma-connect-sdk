<?php

namespace Rackbeat\VismaConnect\Auth\Responses;

class OAuthUserInfoResponse
{
	public string $sub; // id
	public string $name;
	public string $given_name;
	public string $family_name;
	public string $email;
	public string $picture;
	public string $idp;
	public string $auth_time;
	public string $sid;
	public string $nnin;
	public bool   $email_verified;
	public string $locale;
	public array  $tenants;
	public array  $address;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value) {
			if (in_array($key, ['tenants', 'address']) && !is_array($value)) {
				$this->{$key} = json_decode($value, true);
			} else {
				$this->{$key} = $value;
			}
		}
	}
}