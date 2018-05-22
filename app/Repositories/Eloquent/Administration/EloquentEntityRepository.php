<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Entity;
use App\Repositories\Contracts\Administration\EntityRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentEntityRepository extends EloquentBaseRepository implements EntityRepository
{
    public function entity()
    {
        return Entity::class;
    }
	
	public function getInstance() {
		return new Entity();
	}
}
