<?php

namespace App\Model\Administration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class Seller extends Model
{
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'id', 'telefono', 'entrevistado'
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
    protected $filterAttributes = ['name', 'entrevistado', 'interviews.anio', 'interviews.account_id', 'interviews.zonas'];
	
	protected $auxInterviews;
	
	protected $auxRemoveFiles;
	
	protected function initAuxInterviews() {
		Log::info('**********initAuxInterviews');
		$this->auxInterviews = collect([]);
		foreach ($this->interviews as $interview) {
			Log::info('++++++++++++++++++Adding...');
			$this->auxInterviews->put($interview->getInterviewKey(), $interview);
		}
	}
	
	public function getEntrevistaByKey($key) {
		if (!isset($this->auxInterviews)) {
			$this->initAuxInterviews();
		}
		
		if (Arr::has($this->auxInterviews, $key)) {
			return Arr::get($this->auxInterviews, $key);
		}
		
		return null;
	}
	
	public function getEntrevistaByAnioAndEmpresa($anio, $empresa) {
		if (!isset($this->auxInterviews)) {
			$this->initAuxInterviews();
		}
		
		foreach ($this->auxInterviews as $interview) {
			if ($interview->anio == $anio && $interview->account_id == $empresa) {
				return $interview;
			}
		}
	}
	
	public function getAllInterviews() {
		Log::info('-------getAllInterviews');
		if (isset($this->auxInterviews)) {
			Log::info('Está seteado');
			return $this->auxInterviews;
		} else {
			$this->initAuxInterviews();
		}
		return $this->auxInterviews;
	}
	
	public function addInterview($interview) {
		if (!isset($this->auxInterviews)) {
			$this->auxInterviews = collect([]);
		}
		
		$this->auxInterviews->put($interview->getInterviewKey(), $interview);
		
		return $interview->getInterviewKey();
	}
	
	public function removeInterview($interviewName) {
		if (isset($this->auxInterviews)) {
			if (Arr::has($this->auxInterviews, $interviewName)) {
				$interview = $this->auxInterviews->pull($interviewName);
				if (isset($interview)) {
					$interview->seller()->dissociate($this);
					return $interview;
				} else {
					Log::info('Nulo interview');
					return null;
				}
			} else {
				Log::info('Key not found: '.$interviewName);
			return null;
			}
		} else {
			Log::info('Nulo auxInterviews');
			return null;
		}
	}
	
	public function getFilesToRemove() {
		if (!isset($this->auxRemoveFiles)) {
			$this->auxRemoveFiles = collect([]);
		}
		return $this->auxRemoveFiles;
	}
	
	public function removeFile() {
		if (!isset($this->auxRemoveFiles)) {
			$this->auxRemoveFiles = collect([]);
		}
		
		if (!blank($this->files)) {
			$file = $this->files->pull(0);
			$file->seller()->dissociate();
			$this->auxRemoveFiles->put($file->id, $file);
		}
	}
	
	public function interviews() {
		return $this->hasMany('App\Model\Administration\Interview');
	}
	
	public function files() {
		return $this->hasMany('App\Model\Administration\File');
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