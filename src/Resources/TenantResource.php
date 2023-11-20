<?php

namespace Rackbeat\VismaConnect\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Rackbeat\VismaConnect\Exceptions\Models\Tenants\TenantDataValidationException;
use Rackbeat\VismaConnect\Exceptions\Models\Tenants\TenantExternalIdAlreadyInUse;
use Rackbeat\VismaConnect\Exceptions\Models\Tenants\TenantOrganizationNumberIsInvalid;
use Rackbeat\VismaConnect\Exceptions\Models\Users\InvalidPassword;
use Rackbeat\VismaConnect\Models\Collection;
use Rackbeat\VismaConnect\Models\Tenant;
use Rackbeat\VismaConnect\Resources\Traits\CanSearch;

class TenantResource extends CrudResource
{
	use CanSearch;

	protected const MODEL         = Tenant::class;
	protected const RESOURCE_KEY  = 'tenants';
	protected const ENDPOINT_BASE = 'tenants';

	protected function failed(Response $response)
	{
		switch ($response->json('error_code')) {
			case 'ERROR_EXTERNAL_ID_ALREADY_ADDED':
				throw new TenantExternalIdAlreadyInUse('The tenant external id is already used.', $response->status(), $response->toException());
			case 'ERROR_INVALID_ORGANIZATION_NUMBER':
				throw new TenantOrganizationNumberIsInvalid('The organization number (VAT ID) is invalid or not specified.', $response->status(), $response->toException());
			case 'ERROR_TENANT_ID_ALREADY_ADDED':
				throw new TenantDataValidationException('The tenant id is already used.', $response->status(), $response->toException());
			case 'ERROR_INVALID_ORGANIZATION_NAME':
				throw new TenantDataValidationException('The organization name is invalid or not specified.', $response->status(), $response->toException());
			case 'ERROR_INVALID_COUNTRY_CODE':
				throw new TenantDataValidationException('The country code is invalid or not specified.', $response->status(), $response->toException());
			case 'ERROR_THIRD_PARTY_APPLICATION':
				throw new TenantDataValidationException('The Visma application is a third-part and is not permitted to add tenants.', $response->status(), $response->toException());
			case 'ERROR_INVALID_BUSINESS_UNIT_NAME':
				throw new TenantDataValidationException('The Visma business unit name is invalid or not specified.', $response->status(), $response->toException());
		}
	}

	public function syncRolesByApplication(string $tenantId, string $userId, array $roles = [])
	{
		// todo error handling
		return Http::vismaConnectApi()->put(sprintf(static::getSyncRolesByApplicationUrlFormat(), self::ENDPOINT_BASE, $tenantId, config('visma_connect.client_id'), $userId), [
			'roles'  => $roles,
		])->throw()->json();
	}

	public function addUserToTenant(string $tenantId, string $userId)
	{
		// todo error handling
		return Http::vismaConnectApi()->post('tenants/' . $tenantId . '/users/' . $userId)->throw()->json();
	}

	public static function getSyncRolesByApplicationUrlFormat($replacer = '%s') {
		return "{$replacer}/{$replacer}/applications/{$replacer}/users/{$replacer}/roles";
	}
}
