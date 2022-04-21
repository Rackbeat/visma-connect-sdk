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

class ApplicationResource extends CrudResource
{
	protected const MODEL         = Tenant::class;
	protected const RESOURCE_KEY  = 'applications';
	protected const ENDPOINT_BASE = 'applications';

	public function syncRoles(string $applicationId, array $roles = [])
	{
		// todo better handling!
		return Http::vismaConnectApi()->patch('applications/' . $applicationId. '/roles', $roles)->throw();
	}
}