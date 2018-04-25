<?php

namespace App\Http\Controllers;

use App\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProfileRoleRepository;
use App\Repositories\Contracts\ResourceRepository;
use App\Repositories\Contracts\RoleRepository;
use App\Rules\MultipleUniqueRule;

class PrivilegeController extends BaseController
{
	protected $roleRepository;
	protected $resourceRepository;
		
	/**
     * Get a validator for an incoming Privilege request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Privilege create validator.');
        return Validator::make($data, [
            'role_id' => 'bail|required',
			'resource_id' => 'bail|required', 
			'resource_id' => new MultipleUniqueRule($this->repository, $data),
        ]);
    }
	
	/**
     * Get a validator for an incoming Privilege request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute Privilege update validator.');
    }
	
	/**
     * Get a validator for an incoming profilerole request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_delete(array $data)
    {
		Log::info('Execute Privilege delete validator.');
    }
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		$resources = $this->resourceRepository->select(['id', 'name']);
		$roles = $this->roleRepository->select(['id', 'name']);
		
		$select_resource = collect([]);
		foreach ($resources as $resource) {
			$select_resource->put($resource->id, $resource->name);
		}
		$collection->put('resources', $select_resource);
		
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
    public function __construct(\App\Repositories\Contracts\PrivilegeRepository $repository, \App\Repositories\Contracts\ResourceRepository $resourceRepository, \App\Repositories\Contracts\RoleRepository $roleRepository)
    {
		$this->repository = $repository;
		$this->resourceRepository = $resourceRepository;
		$this->roleRepository = $roleRepository;
        $this->middleware('guest');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'privileges';
	}
	
	public function postProcessCommand(\Illuminate\Http\Request $request, $command) {
	}
	
	public function postEditProcessCommand(\Illuminate\Http\Request $request, $command) {
	}
	
	public function getControllerName() {
		return 'PrivilegeController';
	}

}
