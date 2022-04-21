<?php

namespace Rackbeat\VismaConnect\Exceptions\Responses;

class ThrottledException extends BadResponseException
{
	protected $code = 429;
}