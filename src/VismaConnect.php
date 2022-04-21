<?php

namespace Rackbeat\VismaConnect;

use Illuminate\Support\Facades\Facade;

class VismaConnect extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'VismaConnect'; }
}