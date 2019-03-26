<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UpsalesController;

class HomeController extends UpsalesController
{
	protected $repository;
	protected $transitionRepository;
	protected $accountRepository;
	protected $categoryRepository;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Administration\WorkflowRepository $repository,
	\App\Repositories\Contracts\Administration\TransitionRepository $transitionRepository,
	\App\Repositories\Contracts\Gondola\CategoryRepository $categoryRepository, \App\Repositories\Contracts\Administration\AccountRepository $accountRepository) {
		
		$this->repository = $repository;
		$this->transitionRepository = $transitionRepository;
		$this->categoryRepository = $categoryRepository;
		$this->accountRepository = $accountRepository;
        $this->middleware('auth');
    }
	
	public function index() {
		$collection = collect([]);
		
		$countComerciales = $this->repository->countWithTrashed();
		$collection->put('countComerciales', $countComerciales);
		
		$orders = collect([]);
		$orders->put('created_at', 'created_at'); 
		$collection->put('list', $this->repository->paginateWithTrashed(null, 6, $orders, null, null));
		
		$entity = 'workflows';
		$collection->put('entity', $entity);
		
		$actionCreate = 'administration.workflows.create';
		$collection->put('actionCreate', $actionCreate);
		$actionEdit = action('Administration\WorkflowController@index').'/|id|/edit/';
		$collection->put('actionEdit', $actionEdit);
		
		return view('comerciales.main', $collection->all());
	}
}
