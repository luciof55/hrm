<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\RoleRepository;
use App\Rules\ForeignKeyRule;

class RoleController extends BaseController
{
	/**
     * Get a validator for an incoming role request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Role create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:roles',
        ]);
    }
	
	/**
     * Get a validator for an incoming role request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute Role update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:roles,name,'.$data['id'],
        ]);
    }
	
	/**
     * Get a validator for an incoming role request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_delete(array $data)
    {
		Log::info('Execute Role delete validator.');
        Log::info('ID: '.$data['id']);
		return Validator::make($data, [
			'id' => [new ForeignKeyRule($this->repository, $data),],
		]);
    }
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\RoleRepository $repository)
    {
		$this->repository = $repository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'roles';
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
		return 'RoleController';
	}

}
