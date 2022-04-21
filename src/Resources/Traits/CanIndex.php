<?php

namespace Rackbeat\VismaConnect\Resources\Traits;

use Rackbeat\VismaConnect\Http\Responses\IndexResponse;
use Rackbeat\VismaConnect\Http\Responses\PaginatedIndexResponse;
use Rackbeat\VismaConnect\Models\Model;
use Rackbeat\VismaConnect\Resources\BaseResource;

/**
 * @method PaginatedIndexResponse|IndexResponse get( $page = 1, $perPage = 20, array $query = [] )
 * @method IndexResponse all( array $query = [] )
 * @method Model first( array $query = [] )
 * @method boolean exists()
 * @mixin BaseResource
 */
trait CanIndex
{
}