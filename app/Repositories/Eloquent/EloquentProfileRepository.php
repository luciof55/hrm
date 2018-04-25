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
}
