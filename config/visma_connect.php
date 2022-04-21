<?php
return [
	/*
	|--------------------------------------------------------------------------
	| Environment
	|--------------------------------------------------------------------------
	|
	| Specify if using staging or production. This will change the endpoints.
	|
	*/
	'environment'   => env('VISMA_CONNECT_ENV', env('VISMA_CONNECT_ENVIRONMENT', 'staging')), // staging or production

	/*
	|--------------------------------------------------------------------------
	| Client ID
	|--------------------------------------------------------------------------
	|
	| Visma Connect Client ID. This is used to generate URLs for OAuth.
	|
	*/
	'client_id'     => env('VISMA_CONNECT_CLIENT_ID'),

	/*
	|--------------------------------------------------------------------------
	| Business Unit name
	|--------------------------------------------------------------------------
	|
	| Visma Connect Business unit name (company name or org.)
	|
	*/
	'business_unit_name'     => env('VISMA_CONNECT_BUSINESS_UNIT'),

	/*
	|--------------------------------------------------------------------------
	| Secret
	|--------------------------------------------------------------------------
	|
	| Visma Connect Secret. This is used for API calls
	|
	*/
	'client_secret' => env('VISMA_CONNECT_CLIENT_SECRET'),

	'oauth' => [
		/*
		|--------------------------------------------------------------------------
		| Default Response Type
		|--------------------------------------------------------------------------
		|
		| Which kind of response type do you need from the Oauth flow? This can be
		| overwritten on a per-use basis. Default: "code id_token" as that is used for
		| web apps.
		|
		| Options:
		| - id_token
		| - id_token token
		| - code
		| - code id_token
		|
		| Docs: http://openid.net/specs/openid-connect-core-1_0.html#Authentication
		|
		*/
		'response_type' => env('VISMA_CONNECT_RESPONSE_TYPE', 'code id_token'),

		/*
		|--------------------------------------------------------------------------
		| Default Redirect URI
		|--------------------------------------------------------------------------
		|
		| What url (by default) to redirect users to after OAuth flow.
		|
		*/
		'redirect_uri'  => env('VISMA_CONNECT_REDIRECT_URI'),

		/*
		|--------------------------------------------------------------------------
		| Default Redirect URI
		|--------------------------------------------------------------------------
		|
		| What url (by default) to redirect users to after OAuth flow.
		|
		*/
		'logout_redirect_uri'  => env('VISMA_CONNECT_LOGOUT_REDIRECT_URI'),

		/*
		|--------------------------------------------------------------------------
		| Default Scopes
		|--------------------------------------------------------------------------
		|
		| Which scopes to request. openid is required.
		|
		*/
		'scopes'        => env('VISMA_CONNECT_SCOPES', 'openid profile email tenants address'),

		/*
		|--------------------------------------------------------------------------
		| Base URLs
		|--------------------------------------------------------------------------
		|
		| Base URLs for OAuth requests. Generally you do NOT want to modify these, but
		| rather switch environment variable.
		|
		*/
		'base_urls'     => [
			'staging'    => 'https://connect.identity.stagaws.visma.com',
			'production' => 'https://connect.visma.com',
		],
	],

	'api' => [
		/*
		|--------------------------------------------------------------------------
		| API Version
		|--------------------------------------------------------------------------
		|
		| Specify default API version used for api calls.
		|
		*/
		'version'   => 'v1.0',

		/*
		|--------------------------------------------------------------------------
		| Base URLs
		|--------------------------------------------------------------------------
		|
		| Base URLs for API requests. Generally you do NOT want to modify these, but
		| rather switch environment variable.
		|
		*/
		'base_urls' => [
			'staging'    => 'https://public-api.connect.identity.stagaws.visma.com',
			'production' => 'https://public-api.connect.visma.com',
		],

		/*
		|--------------------------------------------------------------------------
		| Default Scopes
		|--------------------------------------------------------------------------
		|
		| Which scopes to request
		|
		*/
		'scopes'    => [
			'publicapi:application:features:create',
			'publicapi:application:features:delete',
			'publicapi:application:features:read',
			'publicapi:application:features:update',
			'publicapi:application:read',
			'publicapi:application:update',
			'publicapi:tenant:application:create',
			'publicapi:tenant:application:delete',
			'publicapi:tenant:application:features:read',
			'publicapi:tenant:application:features:update',
			'publicapi:tenant:application:read',
			'publicapi:tenant:application:update',
			'publicapi:tenant:create',
			'publicapi:tenant:delete',
			'publicapi:tenant:read',
			'publicapi:tenant:update',
			'publicapi:tenant:user:read',
			'publicapi:tenant:user:update',
			'publicapi:user:allowemailchange',
			'publicapi:user:create',
			'publicapi:user:delete',
			'publicapi:user:read',
			'publicapi:user:resume',
			'publicapi:user:suspend',
			'publicapi:user:update',
			'publicapi:tenant:userapplicationroles:update',
			'publicapi:tenant:userapplicationroles:read',
		],
	],
];

