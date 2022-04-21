<?php

namespace Rackbeat\VismaConnect\Resources\Traits;

use Rackbeat\VismaConnect\Resources\BaseResource;

/**
 * @mixin BaseResource
 */
trait CanSearch
{
	public function search($queries, $limit = 20, $operator = 'AND')
	{
		return $this->get(null, null, array_merge($queries, ['limit' => $limit], count($queries) > 1 ? ['operator' => $operator] : []), 'search/'.trim(static::ENDPOINT_BASE, '/'));
	}
}