<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'workflow_id', 'from_state_id', 'to_state_id', 'from_state', 'to_state',
    ];
	
	/**
     * The attributes uses to sort.
     *
     * @var array
     */
    protected $orderAttributes = ['name',];

	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['name',];
	
	public function getCleanName() {
		$string = str_replace(' ', '-', $this->name); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return strtolower($string); //return to lower
	}
	
	public function workflow() {
		 return $this->belongsTo('App\Model\Administration\Workflow')->withTrashed();
	}
	
	public function fromState() {
		 return $this->belongsTo('App\Model\Administration\BusinessRecordState', 'from_state_id')->withTrashed();
	}
	
	public function toState() {
		 return $this->belongsTo('App\Model\Administration\BusinessRecordState', 'to_state_id')->withTrashed();
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
		return false;
	}
}