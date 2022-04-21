<?php

namespace Rackbeat\VismaConnect\Models;

use Illuminate\Support\Facades\Http;
use Rackbeat\VismaConnect\Resources\TenantResource;

/**
 * @property string         $id                          optional; a valid GUID can be set, if not one will be generated
 * @property string         $organization_name
 * @property string         $organization_number
 * @property string         $address_1                   optional
 * @property string         $address_2                   optional
 * @property string         $postal_code                 optional
 * @property string         $city                        optional
 * @property string         $country_code                must be a valid ISO2 code
 * @property string         $external_id
 * @property string         $business_unit_name          must be a valid Visma Business Unit Name (see GET VismaBusinessUnits method)
 * @property-read string    $application_id
 * @property-read string    $my_domain
 * @property-read \DateTime $created_date
 * @property-read \DateTime $updated_date
 */
class Tenant extends Model
{
	protected static string $RESOURCE = TenantResource::class;

	protected string $primaryKey = 'id';

	protected string $keyType = 'string';

	protected array $casts = [
		'id'                  => 'string',
		'organization_name'   => 'string',
		'organization_number' => 'string',
		'address_1'           => 'string',
		'address_2'           => 'string',
		'postal_code'         => 'string',
		'city'                => 'string',
		'country_code'        => 'string',
		'external_id'         => 'string',
		'business_unit_name'  => 'string',
		'application_id'      => 'string',
		'my_domain'           => 'string',
	];

	public function addApplication(?string $applicationId = null)
	{
		// todo error handling
		return Http::vismaConnectApi()->post($this->getAddApplicationUrl($applicationId))->throw()->json();
	}

	public function getAddApplicationUrl(?string $applicationId = null)
	{
		return sprintf('tenants/%s/applications/%s', $this->id, $applicationId ?? config('visma_connect.client_id'));
	}
}