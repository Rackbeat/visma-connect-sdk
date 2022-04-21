<?php

namespace Rackbeat\VismaConnect\Resources;

use Rackbeat\VismaConnect\Resources\Traits\CanCreate;
use Rackbeat\VismaConnect\Resources\Traits\CanDelete;
use Rackbeat\VismaConnect\Resources\Traits\CanFind;
use Rackbeat\VismaConnect\Resources\Traits\CanIndex;
use Rackbeat\VismaConnect\Resources\Traits\CanUpdate;

class CrudResource extends BaseResource
{
	use CanIndex, CanFind, CanCreate, CanUpdate, CanDelete;
}