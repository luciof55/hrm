<?php

namespace App\Http\Controllers\Gondola;

use App\Model\Gondola\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UpsalesBaseController;

class CategoryController extends UpsalesBaseController
{
	
	/**
     * Get a validator for an incoming Category request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Category create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:categories',
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
		Log::info('Execute Category update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:categories,name,'.$data['id'],
        ]);
    }
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		
	}
	
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Gondola\CategoryRepository $repository) {
		$this->repository = $repository;
        $this->middleware('auth');
    }
	
	public function getPageSize() {
		return 7;
	}
	
	public function getRouteResource() {
		return 'categories';
	}
	
	public function getRouteGroup() {
		return 'main.';
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
		return 'Gondola\CategoryController';
	}
	
	public function getViewBase() {
		return 'gondola.';
	}
}