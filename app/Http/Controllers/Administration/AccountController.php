<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UpsalesBaseController;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Http\MiddleWare\OwnerAuthorize;

class AccountController extends UpsalesBaseController
{

	protected $userRepository;
	
	/**
     * Get a validator for an incoming Account request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Account create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:accounts',
			'url' => 'bail|required|string|max:150|unique:accounts',
			'notes' => 'bail|nullable|string|max:1024',
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
		Log::info('Execute Account update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:accounts,name,'.$data['id'],
			'url' => 'bail|required|string|max:150|unique:accounts,url,'.$data['id'],
			'notes' => 'bail|nullable|string|max:1024',
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
	}
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Administration\AccountRepository $repository, \App\Repositories\Contracts\UserRepository $userRepository)
    {
		$this->userRepository = $userRepository;
		$this->repository = $repository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'accounts';
	}
	
	public function getRouteGroup() {
		return 'administration.';
	}
	
	public function postProcessCommand(Request $request, $command) {
		$command->name = $request->old('name');
		$command->url = $request->old('url');
	}
	
	public function postEditProcessCommand(Request $request, $command) {
		if (!empty($request->old('name'))) {
			$command->name = $request->old('name');
		}
		
		if (!empty($request->old('url'))) {
			$command->url = $request->old('url');
		}
	}
	
	public function getControllerName() {
		return 'Administration\AccountController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}

}
