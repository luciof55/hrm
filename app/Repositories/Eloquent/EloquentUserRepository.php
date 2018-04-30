<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\Auth;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function entity()
    {
        return User::class;
    }
	
	public function getInstance() {
		return new User();
	}
	
	public function updateSoftDelete($id) {
		
		if (Auth::guard()->check()) {
			$user_id = Auth::id();
			if ($user_id == $id) {
				return;
			}
		}
		
		return parent::updateSoftDelete($id);
	}
}