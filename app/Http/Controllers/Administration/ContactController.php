<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\HRMBaseController;
use App\Repositories\Contracts\Administration\ContactRepository;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Repositories\Contracts\UserRepository;

class ContactController extends HRMBaseController
{

	protected $userRepository;
	protected $accountRepository;
	
	/**
     * Get a validator for an incoming Contact request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Contact create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:contacts',
			'email' => 'bail|required|string|max:150|unique:contacts',
			'user_id' => 'bail|required',
			'account_id' => 'bail|required',
        ]);
    }
	
	/**
     * Get a validator for an incoming contact request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute Contact update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:contacts,name,'.$data['id'],
			'email' => 'bail|required|string|max:150|unique:contacts,email,'.$data['id'],
			'user_id' => 'bail|required',
			'account_id' => 'bail|required',
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
		
		$select_user = collect([]);
		foreach ($users as $user) {
			$select_user->put($user->id, $user->name);
		}
		$collection->put('users', $select_user);
		
		$accounts = $this->accountRepository->select(['id', 'name']);
		
		$select_account = collect([]);
		foreach ($accounts as $account) {
			$select_account->put($account->id, $account->name);
		}
		$collection->put('accounts', $select_account);
	}
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Administration\ContactRepository $repository, \App\Repositories\Contracts\UserRepository $userRepository, \App\Repositories\Contracts\Administration\AccountRepository $accountRepository)
    {
		$this->userRepository = $userRepository;
		$this->repository = $repository;
		$this->accountRepository = $accountRepository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'contacts';
	}
	
	public function getRouteGroup() {
		return 'administration.';
	}
	
	public function postProcessCommand(Request $request, $command) {
		$command->name = $request->old('name');
		$command->email = $request->old('email');
		$command->phone = $request->old('phone');
		$command->position = $request->old('position');
	}
	
	public function postEditProcessCommand(Request $request, $command) {
		if (!empty($request->old('name'))) {
			$command->name = $request->old('name');
		}
		
		if (!empty($request->old('email'))) {
			$command->email = $request->old('email');
		}
		
		if (!empty($request->old('phone'))) {
			$command->phone = $request->old('phone');
		}
		
		if (!empty($request->old('position'))) {
			$command->position = $request->old('position');
		}
	}
	
	public function getControllerName() {
		return 'Administration\ContactController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}

}
