<?php

namespace App\Repositories\Eloquent;

use App\Profile;
use App\Repositories\Contracts\ProfileRepository;

class EloquentProfileRepository extends EloquentBaseRepository implements ProfileRepository
{
    public function entity()
    {
        return Profile::class;
    }
	
	public function getInstance() {
		return new \App\Profile();
	}
	
	protected function softDeleteCascade($profile) {
		if ($profile->profilesroles->isNotEmpty()) {
			foreach($profile->profilesroles as $profileRole) {
				$profileRole->delete();
			}
		}
		
		if ($profile->users->isNotEmpty()) {
			foreach($profile->users as $user) {
				$user->delete();
			}
		}
	}
}
