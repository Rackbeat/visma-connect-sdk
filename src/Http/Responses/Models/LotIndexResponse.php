<?php

namespace Rackbeat\VismaConnect\Http\Responses\Models;
// todo use this
use Rackbeat\VismaConnect\Http\Responses\PaginatedIndexResponse;
use Rackbeat\VismaConnect\Models\Lot;

class LotIndexResponse extends PaginatedIndexResponse
{
	/** @var Lot[] */
	public array $items;
}