<?php

namespace App\Repositories\Eloquent;

use App\Resource;
use App\Repositories\Contracts\ResourceRepository;

class EloquentResourceRepository extends EloquentBaseRepository implements ResourceRepository
{
    public function entity()
    {
        return Resource::class;
    }
	
	public function getInstance() {
		return new \App\Resource();
	}
}