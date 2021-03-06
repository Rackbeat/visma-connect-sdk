<?php

namespace Rackbeat\VismaConnect\Http\Traits;

use Rackbeat\VismaConnect\Exceptions\Responses\NotFoundException;
use Rackbeat\VismaConnect\Exceptions\Responses\ServerException;
use Rackbeat\VismaConnect\Exceptions\Responses\ThrottledException;
use Rackbeat\VismaConnect\Exceptions\Responses\UnauthorizedException;
use Rackbeat\VismaConnect\Exceptions\Responses\ValidationErrorException;

trait HandlesErrorResponses
{
	protected function throwException( \GuzzleHttp\Exception\BadResponseException $exception )
	{
		// 5XX codes
		if ( $exception instanceof \GuzzleHttp\Exception\ServerException ) {
			throw new ServerException( $exception, $exception->getResponse()->getStatusCode(), $exception );
		}

		// 4XX codes
		switch ( $exception->getResponse()->getStatusCode() ) {
			case 401:
				throw new UnauthorizedException( $exception, 401, $exception );
			case 404:
				throw new NotFoundException( $exception, 404, $exception );
			case 422:
				throw new ValidationErrorException( $exception, 422, $exception );
			case 429:
				throw new ThrottledException( $exception, 429, $exception );
			default:
				throw $exception;
		}
	}
}