<?php

namespace App;

class UpsalesUser extends User
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

	public function comercialBusinessRecords() {
		 return $this->hasMany('App\Model\Administration\BusinessRecord', 'comercial_id')->withTrashed();
	}

	public function leaderBusinessRecords() {
		 return $this->hasMany('App\Model\Administration\BusinessRecord', 'leader_id')->withTrashed();
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

		if ($this->comercialBusinessRecords->isNotEmpty()) {
			foreach($this->comercialBusinessRecords as $comercialBusinessRecord) {
				$comercialBusinessRecord->delete();
			}
		}

		if ($this->leaderBusinessRecords->isNotEmpty()) {
			foreach($this->leaderBusinessRecords as $leaderBusinessRecord) {
				$leaderBusinessRecord->delete();
			}
		}

		parent::delete();
	}
}
