<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\BusinessRecordState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UpsalesBaseController;
use App\Repositories\Contracts\Administration\BusinessRecordStateRepository;
use App\Enumeration\RecordStateType;

class BusinessRecordStateController extends UpsalesBaseController
{	
	/**
     * Get a validator for an incoming Account request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute BusinessRecordState create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:business_record_state',
			'closed_state' => 'bail|required',
        ]);
    }
	
	/**
     * Get a validator for an incoming account request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute BusinessRecordState update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:business_record_state,name,'.$data['id'],
			'closed_state' => 'bail|required',
        ]);
    }
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		$select_types = RecordStateType::getEnumTranslate();
		
		$collection->put('types', $select_types);
	}
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Administration\BusinessRecordStateRepository $repository)
    {
		$this->repository = $repository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'businessrecordstates';
	}
	
	public function getRouteGroup() {
		return 'administration.';
	}
	
	public function postProcessCommand(Request $request, $command) {
		$command->name = $request->old('name');
	}
	
	public function postEditProcessCommand(Request $request, $command) {
		if (!empty($request->old('name'))) {
			$command->name = $request->old('name');
		}
	}
	
	public function getControllerName() {
		return 'Administration\BusinessRecordStateController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}

}
