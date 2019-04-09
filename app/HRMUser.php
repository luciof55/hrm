<?php

namespace App;

class HRMUser extends User
{

	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'email', 'password', 'profile_id', 'ldap_login'
	];

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
