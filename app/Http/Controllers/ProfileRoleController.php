<?php

namespace App\Http\Controllers;

use App\Model\ProfileRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProfileRoleRepository;
use App\Repositories\Contracts\ProfileRepository;
use App\Repositories\Contracts\RoleRepository;
use App\Rules\MultipleUniqueRule;

class ProfileRoleController extends BaseController
{
	protected $profileRepository;
	protected $roleRepository;
		
	/**
     * Get a validator for an incoming profilerole request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute ProfileRole create validator.');
        return Validator::make($data, [
            'role_id' => 'bail|required',
			'profile_id' => 'bail|required', 
			'profile_id' => new MultipleUniqueRule($this->repository, $data),
        ]);
    }
	
	/**
     * Get a validator for an incoming profilerole request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute ProfileRole update validator.');
    }
	
	/**
     * Get a validator for an incoming profilerole request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_delete(array $data)
    {
		Log::info('Execute ProfileRole delete validator.');
    }
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		$profiles = $this->profileRepository->select(['id', 'name']);
		$roles = $this->roleRepository->select(['id', 'name']);
		
		$select_profile = collect([]);
		foreach ($profiles as $profile) {
			$select_profile->put($profile->id, $profile->name);
		}
		$collection->put('profiles', $select_profile);
		
		$select_role = collect([]);
		foreach ($roles as $role) {
			$select_role->put($role->id, $role->name);
		}
		$collection->put('roles', $select_role);
	}
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\ProfileRoleRepository $repository, \App\Repositories\Contracts\ProfileRepository $profileRepository, \App\Repositories\Contracts\RoleRepository $roleRepository)
    {
		$this->repository = $repository;
		$this->profileRepository = $profileRepository;
		$this->roleRepository = $roleRepository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'profilesroles';
	}
	
	public function postProcessCommand(\Illuminate\Http\Request $request, $command) {
	}
	
	public function postEditProcessCommand(\Illuminate\Http\Request $request, $command) {
	}
	
	public function getControllerName() {
		return 'ProfileRoleController';
	}

}
