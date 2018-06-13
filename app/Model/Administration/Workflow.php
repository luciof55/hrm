<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Workflow extends Model
{
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'initial_state_id', 'final_state_id',
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
    protected $orderAttributes = ['name',];

	/**
     * The attributes uses to filter.
     *
     * @var array
     */
    protected $filterAttributes = ['name',];
	
	protected $auxTransitions;
	
	protected function initAuxTransitions() {
		$this->auxTransitions = collect([]);
		foreach ($this->transitions as $transition) {
			$this->auxTransitions->put(strtolower($transition->name), $transition);
		}
	}
	
	public function getTransitionByState($fromStateId, $toStateId) {
		if (!isset($this->auxTransitions)) {
			$this->initAuxTransitions();
		}
		
		foreach ($this->auxTransitions as $transition) {
			if ($transition->from_state_id == $fromStateId && $transition->to_state_id == $toStateId) {
				return $transition;
			}
		}
		
		return null;
	}
	
	public function getAllTransitions() {
		if (isset($this->auxTransitions)) {
			return $this->auxTransitions;
		} else {
			$this->initAuxTransitions();
		}
		return $this->auxTransitions;
	}
	
	public function addTransition($transition) {
		if (!isset($this->auxTransitions)) {
			$this->auxTransitions = collect([]);
		}
		if (is_null($this->getTransitionByState($transition->from_state_id, $transition->to_state_id))) {
			$this->auxTransitions->put(strtolower($transition->name), $transition);
			return strtolower($transition->name);
		} else {
			return null;
		}
	}
	
	public function removeTransition($transitionName) {
		if (isset($this->auxTransitions)) {
			$transition = $this->auxTransitions->pull(strtolower($transitionName));
			if (isset($transition)) {
				$transition->workflow()->dissociate($this);
				return $transition;
			} else {
				Log::info('Nulo transition');
				return null;
			}
		} else {
			Log::info('Nulo auxTransitions');
			return null;
		}
	}
	
	public function initialState() {
		 return $this->belongsTo('App\Model\Administration\BusinessRecordState', 'initial_state_id')->withTrashed();
	}
	
	public function finalState() {
		 return $this->belongsTo('App\Model\Administration\BusinessRecordState', 'final_state_id')->withTrashed();
	}
	
	public function businessRecords() {
		return $this->hasMany('App\Model\Administration\BusinessRecord')->withTrashed();
	}
	
	public function transitions() {
		return $this->hasMany('App\Model\Administration\Transition');
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
}