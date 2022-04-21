<?php

namespace Rackbeat\VismaConnect\Models;

use Rackbeat\VismaConnect\Resources\UserResource;

/**
 * @property-read string    $id
 * @property-read string    $email
 * @property-read boolean    $email_verified
 * @property-read \DateTime $email_verified_date
 * @property-read boolean    $email_not_accessible
 * @property-read boolean    $email_change_allowed
 * @property-read string    $name
 * @property-read string    $first_name
 * @property-read string    $last_name
 * @property-read string    $country_code
 * @property-read string    $preferred_language
 * @property-read \DateTime $created_date
 * @property-read \DateTime $updated_date
 * @property-read integer   $login_count
 * @property-read \DateTime $login_date
 * @property-read \DateTime $last_login_date
 * @property-read integer    $password_retry_count
 * @property-read string    $password_policy
 * @property-read integer   $seconds_until_password_expires
 * @property-read string    $2step_enforced
 * @property-read integer   $user_terms_version
 * @property-read \DateTime $profile_picture_changed_date
 * @property-read boolean   $password_change_required
 */
class User extends Model
{
	protected static string $RESOURCE = UserResource::class;

	protected string $primaryKey = 'id';

	protected string $keyType = 'string';

	protected array $casts = [
		'id'                             => 'string',
		'email'                          => 'string',
		'email_verified'                 => 'boolean',
		'email_verified_date'            => 'datetime',
		'email_not_accessible'           => 'boolean',
		'email_change_allowed'           => 'boolean',
		'name'                           => 'string',
		'first_name'                     => 'string',
		'last_name'                      => 'string',
		'country_code'                   => 'string',
		'preferred_language'             => 'string',
		'login_count'                    => 'integer',
		'login_date'                     => 'datetime',
		'last_login_date'                => 'datetime',
		'password_retry_count'           => 'integer',
		'password_policy'                => 'string',
		'seconds_until_password_expires' => 'integer',
		'2step_enforced'                 => 'boolean',
		'user_terms_version'             => 'integer',
		'profile_picture_changed_date'   => 'datetime',
		'password_change_required'       => 'boolean',
	];
}