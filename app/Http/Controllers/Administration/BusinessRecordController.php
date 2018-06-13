<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\BusinessRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UpsalesBaseController;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\Administration\BusinessRecordState;
use App\Exports\BusinessRecordExport;
use \Maatwebsite\Excel\Excel;
use App\Events\BusinessRecordUpdateEvent;
use App\Events\BusinessRecordCreateEvent;

class BusinessRecordController extends UpsalesBaseController
{

	protected $userRepository;
	protected $accountRepository;
	protected $businessRecordStateRepository;
	protected $workflowRepository;
	
	/**
     * Get a validator for an incoming BusinessRecord request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute BusinessRecord create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:business_records',
			'management_tool' => 'bail|nullable|string|max:250',
			'repository' => 'bail|nullable|string|max:250',
			'notes' => 'bail|nullable|string|max:250',
			'account_id' => 'bail|required',
			'comercial_id' => 'bail|required',
        ]);
    }
	
	/**
     * Get a validator for an incoming businessRecord request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute BusinessRecord update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:business_records,name,'.$data['id'],
			'management_tool' => 'bail|nullable|string|max:250',
			'repository' => 'bail|nullable|string|max:250',
			'notes' => 'bail|nullable|string|max:250',
			'account_id' => 'bail|required',
			'comercial_id' => 'bail|required',
        ]);
    }
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		$users = $this->userRepository->select(['id', 'name']);
		
		$select_comercial = collect([]);
		foreach ($users as $user) {
			$select_comercial->put($user->id, $user->name);
		}
		$collection->put('comercials', $select_comercial);
		
		$select_leader = collect([]);
		foreach ($users as $user) {
			$select_leader->put($user->id, $user->name);
		}
		$collection->put('leaders', $select_leader);
		
		$accounts = $this->accountRepository->select(['id', 'name']);
		
		$select_account = collect([]);
		foreach ($accounts as $account) {
			$select_account->put($account->id, $account->name);
		}
		$collection->put('accounts', $select_account);
		
		$states = $this->businessRecordStateRepository->select(['id', 'name']);
		
		$select_state = collect([]);
		foreach ($states as $state) {
			$select_state->put($state->id, $state->name);
		}
		$collection->put('states', $select_state);
		
		$workflows = $this->workflowRepository->select(['id', 'name']);
		
		$select_workflow = collect([]);
		foreach ($workflows as $workflow) {
			$select_workflow->put($workflow->id, $workflow->name);
		}
		$collection->put('workflows', $select_workflow);
		
		$actionExcel = action($this->getIndexActionName()).'/|id|/excel/';
		$collection->put('actionExcel', $actionExcel);
	}
	
	protected function fireCreateEvent(\Illuminate\Http\Request $request, $command) {
		event(new BusinessRecordCreateEvent($command));
	}
	
	protected function fireUpdateEvent(\Illuminate\Http\Request $request, $command) {
		event(new BusinessRecordUpdateEvent($command));
	}
	
	protected function storeExcel($excel, $export, $name) {
		// Store on default disk
		$excel->store($export, 'ficha'.$name.'.xlsx', 'fichas', Excel::XLSX);
	}
	
	public function excel(\Illuminate\Http\Request $request, \Maatwebsite\Excel\Excel $excel) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' excel.');
		$url = substr($request->url(), 0, strrpos($request->url(), '/'));
		Log::info('Strip URL: '. $url);
		$id = substr($url, strrpos($url, '/') + 1);
		Log::info('ID: '. $id);
		$command = $this->repository->find($id);
		$export = new BusinessRecordExport($command);
		$this->storeExcel($excel, $export, $command->name);
		return $excel->download($export, 'ficha.xlsx');
	}
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Administration\BusinessRecordRepository $repository, \App\Repositories\Contracts\UserRepository $userRepository, \App\Repositories\Contracts\Administration\AccountRepository $accountRepository, \App\Repositories\Contracts\Administration\BusinessRecordStateRepository $businessRecordStateRepository, \App\Repositories\Contracts\Administration\WorkflowRepository $workflowRepository) {
		
		$this->userRepository = $userRepository;
		$this->repository = $repository;
		$this->accountRepository = $accountRepository;
		$this->businessRecordStateRepository = $businessRecordStateRepository;
		$this->workflowRepository = $workflowRepository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'businessrecords';
	}
	
	public function getRouteGroup() {
		return 'main.';
	}
	
	public function postProcessCommand(Request $request, $command) {
		$command->name = $request->old('name');
		$command->management_tool = $request->old('management_tool');
		$command->repository = $request->old('repository');
		$command->notes = $request->old('notes');
	}
	
	public function postEditProcessCommand(Request $request, $command) {
		if (!empty($request->old('name'))) {
			$command->name = $request->old('name');
		}
		
		if (!empty($request->old('management_tool'))) {
			$command->management_tool = $request->old('management_tool');
		}
		
		if (!empty($request->old('repository'))) {
			$command->repository = $request->old('repository');
		}
		
		if (!empty($request->old('notes'))) {
			$command->notes = $request->old('notes');
		}
	}
	
	public function getControllerName() {
		return 'Administration\BusinessRecordController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}
}