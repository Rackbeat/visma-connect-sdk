<?php

namespace Rackbeat\VismaConnect\Exceptions\Responses;

class UnauthorizedException extends BadResponseException
{
	protected $code = 401;
}