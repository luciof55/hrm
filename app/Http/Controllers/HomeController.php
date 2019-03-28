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
	
	public function index(\Illuminate\Http\Request $request) {
		$collection = collect([]);
		
		$countComerciales = $this->repository->countWithTrashed();
		$collection->put('countComerciales', $countComerciales);
		
		$entity = 'workflows';
		$collection->put('entity', $entity);
		
		$actionCreate = 'administration.workflows.create';
		$collection->put('actionCreate', $actionCreate);
		$actionEdit = action('Administration\WorkflowController@index').'/|id|/edit/';
		$collection->put('actionEdit', $actionEdit);
		
		$page = $request->input('page');
		$collection->put('page', $page);
		
		$collectionFilterAttributes = collect([]);
		$collectionFilter = collect([]);
		$this->processRequestFilters($request, $this->repository->getInstance()->getFilterAttributes(), $collectionFilterAttributes, $collectionFilter);
		$collection->put('filters', $collectionFilterAttributes);
		
		$orders = collect([]);
		$orders->put('created_at', 'created_at'); 
		
		$query = $this->repository->getInstance()->join('transitions', 'workflows.id', '=', 'transitions.workflow_id')->select('workflows.*')->distinct();
		
		if (isset($collectionFilter) && $collectionFilter->isNotEmpty()) {
			$resultMessage = "Comerciales encontrados";
			$collection->put('list', $this->repository->paginateWithTrashed($query, 6, $orders, $collectionFilter, $page));
		} else {
			$resultMessage = 'Últimos Comerciales';
			$collection->put('list', $this->repository->paginateWithTrashed(null, 6, $orders, $collectionFilter, $page));
		}
		
		$collection->put('resultMessage', $resultMessage);
		
		$accounts = $this->accountRepository->select(['id', 'name']);
		$select_account = collect([]);
		foreach ($accounts as $account) {
			$select_account->put($account->id, $account->name);
		}
		$collection->put('accounts', $select_account);
		
		return view('comerciales.main', $collection->all());
	}
	
	protected function processRequestFilters($request, $filterAttributes, $collectionFilterAttributes, $collectionFilter) {
		if (!empty($filterAttributes)) {
			Log::debug('*****Hay Filtros');
			foreach ($filterAttributes as $attribute) {
				$attributeAux = str_replace(".", "-", $attribute);
				Log::debug('*****KEY');
				Log::debug($attributeAux);
				if (!empty($request->input($attributeAux.'_filter'))) {
					Log::info('****Hay Valor');
					if (isset ($collectionFilter)) {
						$collectionFilter->put($attribute, $request->input($attributeAux.'_filter'));
					}
				} 
				$collectionFilterAttributes->put($attributeAux.'_filter', $request->input($attributeAux.'_filter'));
			}
		}
	}
}
