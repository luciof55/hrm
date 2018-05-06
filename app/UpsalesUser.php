<?php

namespace App;

class UpsalesUser extends User
{

	protected $table = 'users';
	
    public function accounts() {
		return $this->hasMany('App\Model\Administration\Account', 'user_id');
	}
}
