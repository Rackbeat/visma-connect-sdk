<?php

namespace Rackbeat\VismaConnect\Resources;

use Illuminate\Http\Client\Response;
use Rackbeat\VismaConnect\Auth\Responses\OAuthUserInfoResponse;
use Rackbeat\VismaConnect\Exceptions\Models\Users\InvalidEmail;
use Rackbeat\VismaConnect\Exceptions\Models\Users\InvalidPassword;
use Rackbeat\VismaConnect\Exceptions\Models\Users\UserAlreadyLinkedToClient;
use Rackbeat\VismaConnect\Exceptions\Models\Users\UserDataValidationException;
use Rackbeat\VismaConnect\Models\User;

class UserResource extends CrudResource
{
	protected const MODEL         = User::class;
	protected const ENDPOINT_BASE = 'users';
	protected const RESOURCE_KEY  = 'users';

	protected function failed(Response $response)
	{
		switch ($response->json('error_code')) {
			case 'ERROR_USER_LINKED_TO_CLIENT':
				throw new UserAlreadyLinkedToClient('The user is already linked to this client.', $response->status(), $response->toException());
			case 'ERROR_INSECURE_PASSWORD':
				throw new InvalidPassword('The password is insecure', $response->status(), $response->toException());
			case 'ERROR_PASSWORD_TOO_SHORT':
				throw new InvalidPassword('The password is not long enough.', $response->status(), $response->toException());
			case 'ERROR_PASSWORD_TOO_LONG':
				throw new InvalidPassword('The password is too long (more than 512 characters)', $response->status(), $response->toException());
			case 'ERROR_USER_DATA_IN_PASSWORD':
				throw new InvalidPassword('The password contains user data (name, email, etc.)', $response->status(), $response->toException());
			case 'ERROR_PASSWORD_MISSING_UPPERCASE_CHARACTER':
				throw new InvalidPassword('The password must contain at least one uppercase character.', $response->status(), $response->toException());
			case 'ERROR_PASSWORD_MISSING_LOWERCASE_CHARACTER':
				throw new InvalidPassword('The password must contain at least one lowercase character.', $response->status(), $response->toException());
			case 'ERROR_PASSWORD_MISSING_SPECIAL_CHARACTER':
				throw new InvalidPassword('The password must contain at least one special character (!#%&)', $response->status(), $response->toException());
			case 'ERROR_PASSWORD_MISSING_DIGIT':
				throw new InvalidPassword('The password must contain at least one digit (0-9)', $response->status(), $response->toException());
			case 'ERROR_INVALID_EMAIL':
				throw new InvalidEmail('The e-mail is not valid.', $response->status(), $response->toException());
			case 'ERROR_DOMAIN_DISPOSABLE':
				throw new InvalidEmail('The e-mail is from a disposable e-mail provider.', $response->status(), $response->toException());
			case 'ERROR_COUNTRY_CODE_NOT_EXIST':
				throw new UserDataValidationException('The country code does not exist.', $response->status(), $response->toException());
			case 'ERROR_PREFERRED_LANGUAGE_NOT_EXIST':
			case 'ERROR_INVALID_PREFERRED_LANGUAGE':
				throw new UserDataValidationException('The preferred language does not exist.', $response->status(), $response->toException());
			case 'ERROR_INVALID_FIRST_NAME':
				throw new UserDataValidationException('The first name is invalid.', $response->status(), $response->toException());
			case 'ERROR_INVALID_LAST_NAME':
				throw new UserDataValidationException('The last name is invalid.', $response->status(), $response->toException());
			case 'ERROR_INVALID_COUNTRY_CODE':
				throw new UserDataValidationException('The country code is invalid.', $response->status(), $response->toException());
			case 'ERROR_INVALID_2STEP_ENFORCED_STATE':
				throw new UserDataValidationException('The 2-step enforcement field is invalid.', $response->status(), $response->toException());

		}
	}

	public function createFromUserInfoResponse(OAuthUserInfoResponse $userInfoResponse)
	{
		return $this->create([
			'email'              => $userInfoResponse->email,
			'country_code'       => $userInfoResponse->address['country'],
			'preferred_language' => $userInfoResponse->locale,
			'first_name'         => $userInfoResponse->given_name,
			'last_name'          => $userInfoResponse->family_name,
			//			'unverified_phone_number' => ,
			//			'2step_enforced' => '',
			//			'password' => '',
		]);
	}
}