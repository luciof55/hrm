<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class Workflow extends Model
{
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'telefono',
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
    protected $filterAttributes = ['name', 'transitions.anio', 'transitions.account_id', 'transitions.zonas'];
	
	protected $auxTransitions;
	
	protected function initAuxTransitions() {
		$this->auxTransitions = collect([]);
		foreach ($this->transitions as $transition) {
			$this->auxTransitions->put($transition->getTransitionKey(), $transition);
		}
	}
	
	public function getEntrevistaByKey($key) {
		if (!isset($this->auxTransitions)) {
			$this->initAuxTransitions();
		}
		
		if (Arr::has($this->auxTransitions, $key)) {
			return Arr::get($this->auxTransitions, $key);
		}
		
		return null;
	}
	
	public function getEntrevistaByAnioAndEmpresa($anio, $empresa) {
		if (!isset($this->auxTransitions)) {
			$this->initAuxTransitions();
		}
		
		foreach ($this->auxTransitions as $transition) {
			if ($transition->anio == $anio && $transition->account_id == $empresa) {
				return $transition;
			}
		}
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
		
		$this->auxTransitions->put($transition->getTransitionKey(), $transition);
		
		return $transition->getTransitionKey();
	}
	
	public function removeTransition($transitionName) {
		if (isset($this->auxTransitions)) {
			if (Arr::has($this->auxTransitions, $transitionName)) {
				$transition = $this->auxTransitions->pull($transitionName);
				if (isset($transition)) {
					$transition->workflow()->dissociate($this);
					return $transition;
				} else {
					Log::info('Nulo transition');
					return null;
				}
			} else {
				Log::info('Key not found: '.$transitionName);
			return null;
			}
		} else {
			Log::info('Nulo auxTransitions');
			return null;
		}
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