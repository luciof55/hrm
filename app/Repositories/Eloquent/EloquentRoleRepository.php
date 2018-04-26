<?php

namespace App\Repositories\Eloquent;

use App\Role;
use App\Repositories\Contracts\RoleRepository;

class EloquentRoleRepository extends EloquentBaseRepository implements RoleRepository
{
    public function entity()
    {
        return Role::class;
    }
	
	public function getInstance() {
		return new \App\Role();
	}
	
	protected function softDeleteCascade($role) {
		if ($role->profilesroles->isNotEmpty()) {
			foreach($role->profilesroles as $profileRole) {
				$profileRole->delete();
			}
		}
		
		if ($role->privileges->isNotEmpty()) {
			foreach($role->privileges as $privilege) {
				$privilege->delete();
			}
		}
	}
}