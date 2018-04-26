<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProfileRepository;
use App\Rules\ForeignKeyRule;

class ProfileController extends BaseController
{
	/**
     * Get a validator for an incoming profile request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Profile create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:profiles',
        ]);
    }
	
	/**
     * Get a validator for an incoming profile request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute Profile update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:profiles,name,'.$data['id'],
        ]);
    }
	
	/**
     * Get a validator for an incoming profile request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_delete(array $data)
    {
		Log::info('Execute Profile delete validator.');
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
    public function __construct(\App\Repositories\Contracts\ProfileRepository $repository)
    {
		$this->repository = $repository;
        $this->middleware('guest');
    }
	
	public function getPageSize() {
		return 5;
	}
	
	public function getRouteResource() {
		return 'profiles';
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
		return 'ProfileController';
	}
}
