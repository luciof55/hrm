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
		
		$entity = 'workflows';
		$collection->put('entity', $entity);
		
		$actionCreate = 'administration.workflows.create';
		$collection->put('actionCreate', $actionCreate);
		$actionEdit = action('Administration\WorkflowController@index').'/|id|/edit/';
		$collection->put('actionEdit', $actionEdit);
		
		$page = $request->input('page');
		
		
		$collectionFilterAttributes = collect([]);
		$collectionFilter = collect([]);
		$this->processRequestFilters($request, $this->repository->getInstance()->getFilterAttributes(), $collectionFilterAttributes, $collectionFilter);
		$collection->put('filters', $collectionFilterAttributes);
		
		$orders = collect([]);
		$orders->put('updated_at', 'updated_at'); 
		
		$query = $this->repository->getInstance()->join('transitions', 'workflows.id', '=', 'transitions.workflow_id')->select('workflows.*')->distinct();
		
		if (isset($collectionFilter) && $collectionFilter->isNotEmpty()) {
			$totalItems = $this->repository->countWithTrashed($query, $collectionFilter);
		} else {
			$totalItems = $this->repository->countWithTrashed(null, $collectionFilter);
		}
		
		if (!blank($page)) {
			Log::info('getPages '. ceil($totalItems / 6));
			$pages = ceil($totalItems / 6);
			if ($page > $pages) {
				$page = $pages;
			}
		};
		
		if (isset($collectionFilter) && $collectionFilter->isNotEmpty()) {
			$resultMessage = "Comerciales encontrados";
			$list = $this->repository->paginateWithTrashed($query, 6, $orders, $collectionFilter, $page);
		} else {
			$resultMessage = 'Últimos Comerciales';
			$list = $this->repository->paginateWithTrashed(null, 6, $orders, $collectionFilter, $page);
		}
		
		$collection->put('list', $list);
		Log::info('TT : ' . $list->total());
		
		$collection->put('page', $page);
		
		$collection->put('resultMessage', $resultMessage);
		
		$accounts = $this->accountRepository->select(['id', 'name']);
		$select_account = collect([]);
		foreach ($accounts as $account) {
			$select_account->put($account->id, $account->name);
		}
		$collection->put('accounts', $select_account);
		
		$entrevistadoOptions = collect([]);
		$entrevistadoOptions->put(1, 'Si');
		$entrevistadoOptions->put(0, 'No');
		$collection->put('entrevistadoOptions', $entrevistadoOptions);
		
		return view('comerciales.main', $collection->all());
	}
	
	protected function processRequestFilters($request, $filterAttributes, $collectionFilterAttributes, $collectionFilter) {
		if (!empty($filterAttributes)) {
			Log::info('*****Hay Filtros');
			foreach ($filterAttributes as $attribute) {
				$attributeAux = str_replace(".", "-", $attribute);
				Log::info('*****KEY');
				Log::info($attributeAux);
				if (!blank($request->input($attributeAux.'_filter'))) {
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
