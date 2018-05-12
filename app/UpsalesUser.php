<?php

namespace App;

class UpsalesUser extends User
{

	protected $table = 'users';
	
    public function accounts() {
		return $this->hasMany('App\Model\Administration\Account', 'user_id');
	}
	
	public function contacts() {
		return $this->hasMany('App\Model\Administration\Contact', 'user_id');
	}
	
	public function delete() {
		if ($this->accounts->isNotEmpty()) {
			foreach($this->accounts as $account) {
				$account->delete();
			}
		}
		
		if ($this->contacts->isNotEmpty()) {
			foreach($this->contacts as $contact) {
				$contact->delete();
			}
		}
		
		parent::delete();
	}
}
