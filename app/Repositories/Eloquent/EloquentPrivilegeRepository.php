<?php

namespace App\Repositories\Eloquent;

use App\Privilege;
use App\Repositories\Contracts\PrivilegeRepository;
use Illuminate\Support\Facades\Log;

class EloquentPrivilegeRepository extends EloquentBaseRepository implements PrivilegeRepository
{
    public function entity()
    {
        return Privilege::class;
    }
	
	public function getInstance() {
		return new \App\Privilege();
	}
	
	public function paginateWithTrashed($query = null, $paginate = null, $orderAttributes = null, $filterAttributes = null, $page = null)
    {
		Log::info('EloquentPrivilegeRepository -> paginateWithTrashed.');
		$query = $this->entity->with(['role', 'resource']);
		return $this->getWithTrashed($query, $paginate, $orderAttributes, $filterAttributes, $page);
	}
}