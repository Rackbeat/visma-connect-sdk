<?php

namespace Rackbeat\VismaConnect\Models;

use Illuminate\Support\Facades\Http;
use Rackbeat\VismaConnect\Resources\ApplicationResource;

/**
 * @property string         $id
 * @property-read \DateTime $created_date
 * @property-read \DateTime $updated_date
 */
class Application extends Model
{
	protected static string $RESOURCE = ApplicationResource::class;

	protected string $primaryKey = 'id';

	protected string $keyType = 'string';

	protected array $casts = [
		'id' => 'string',
	];

	public function syncRoles(array $roles = [])
	{
		return $this->getResourceInstance()->syncRoles($this->id, $roles);
	}
}