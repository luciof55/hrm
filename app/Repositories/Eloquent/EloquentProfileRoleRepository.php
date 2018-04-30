<?php

namespace App\Repositories\Eloquent;

use App\Model\ProfileRole;
use App\Repositories\Contracts\ProfileRoleRepository;
use Illuminate\Support\Facades\Log;

class EloquentProfileRoleRepository extends EloquentBaseRepository implements ProfileRoleRepository
{
    public function entity()
    {
        return ProfileRole::class;
    }
	
	public function getInstance() {
		return new ProfileRole();
	}
	
	public function paginateWithTrashed($query = null, $paginate = null, $orderAttributes = null, $filterAttributes = null, $page = null)
    {
		Log::info('EloquentProfileRoleRepository -> paginateWithTrashed.');
		$query = $this->entity->with(['profile', 'role']);
		return $this->getWithTrashed($query, $paginate, $orderAttributes, $filterAttributes, $page);
	}
}