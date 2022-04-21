<?php

namespace Rackbeat\VismaConnect\Exceptions\Responses;

class ValidationErrorException extends BadResponseException
{
	protected $code = 422;
}