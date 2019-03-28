<?php

namespace App\Model\Administration;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use Notifiable;
	use SoftDeletes;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'industry', 'url', 'notes'
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	
	/**
     * The attributes uses to sort.
     *
     * @var array
     */
    protected $orderAttributes = ['name'];
	
	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['name',];
	
	public function contacts() {
		 return $this->hasMany('App\Model\Administration\Contact')->withTrashed();
	}
	
	public function businessRecords() {
		return $this->hasMany('App\Model\Administration\BusinessRecord')->withTrashed();
	}
	
	public function canDelete() {
		return true;
	}
	
	public function getOrderAttributes() {
		return $this->orderAttributes;
	}
	
	public function getFilterAttributes() {
		return $this->filterAttributes;
	}
	public function isSoftDelete() {
		return true;
	}
	
	public function delete() {
		if ($this->contacts->isNotEmpty()) {
			foreach($this->contacts as $contact) {
				$contact->delete();
			}
		}
		
		if ($this->businessRecords->isNotEmpty()) {
			foreach($this->businessRecords as $businessRecord) {
				$businessRecord->delete();
			}
		}
		
		parent::delete();
	}
}
