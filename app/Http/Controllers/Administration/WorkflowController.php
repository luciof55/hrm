<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\Workflow;
use App\Model\Administration\Account;
use App\Model\Gondola\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UpsalesBaseController;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Repositories\Contracts\Gondola\CategoryRepository;

class WorkflowController extends UpsalesBaseController
{
	protected $transitionRepository;
	protected $accountRepository;
	protected $categoryRepository;
	
	protected function getValidateStoreData(\Illuminate\Http\Request $request) {
		$data = $request->all();
		$workflow = $this->getCommand($request);
		return array_add($data, 'auxTransitions', $workflow->getAllTransitions());
	}
	
	/**
     * Get a validator for an incoming Workflow request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Workflow create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:workflows',
			'auxTransitions' => [function($attribute, $value, $fail) {
				if ($value->isEmpty()) {
					return $fail('Debe agregar al menos una entrevista');
				}
			}],
        ]);
    }
	
	protected function getValidateUpdateData(\Illuminate\Http\Request $request) {
		return $this->getValidateStoreData($request);
	}
	
	/**
     * Get a validator for an incoming workflow request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute Workflow update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:workflows,name,'.$data['id'],
			'auxTransitions' => [function($attribute, $value, $fail) {
				if ($value->isEmpty()) {
					return $fail('Debe agregar al menos una entrevista');
				}
			}],
        ]);
    }
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		$accounts = $this->accountRepository->select(['id', 'name']);
		$select_account = collect([]);
		foreach ($accounts as $account) {
			$select_account->put($account->id, $account->name);
		}
		$collection->put('accounts', $select_account);
		
		$categories = $this->categoryRepository->select(['id', 'name']);
		$select_categories = collect([]);
		foreach ($categories as $category) {
			$select_categories->put($category->id, $category->name);
		}
		$collection->put('categories', $select_categories);
		
		
		if ($request->session()->has($this->getCommandKey())) {
			$workflow = $request->session()->get($this->getCommandKey(), null);
		} else {
			$workflow = $collection->get('command');
		}
		
		$tablePage = $request->input('tablePage');
		if (isset($workflow)) {
			$transitions = $this->paginate($workflow->getAllTransitions()->sort(), 5, $tablePage);
			$collection->put('transitions', $transitions);
			if (isset($workflow->id)) {			
				$actionView = action($this->getControllerName().'@show', $workflow->id);
				$collection->put('actionView', $actionView);
			}
		}
		if (!empty($tablePage)) {
			$pages = $this->getPages(5, count($workflow->getAllTransitions()));
			if ($tablePage > $pages) {
				$tablePage = $pages;
			}
		};
		$collection->put('tablePage', $tablePage);

		$actionAddTransition = action($this->getControllerName().'@addTransition');
		$collection->put('actionAddTransition', $actionAddTransition);
		
		$actionRemoveTransition = action($this->getControllerName().'@removeTransition');
		$collection->put('actionRemoveTransition', $actionRemoveTransition);
		
		$actionLoadTransition = action($this->getControllerName().'@loadTransition');
		$collection->put('actionLoadTransition', $actionLoadTransition);
		
		$actionGetTransitions = action($this->getControllerName().'@getTransitions');
		$collection->put('actionGetTransitions', $actionGetTransitions);
		
		$activeTab = $request->input('activeTab');
		
		if (isset($activeTab)) {
			$collection->put('activeTab', $activeTab);
		} else {
			$collection->put('activeTab', 'main');
		}
		
		$request->session()->put($this->getCommandKey(), $workflow);
	}
	
	protected function paginate($items, $perPage = 5, $page = null, $options = []) {
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		$lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
		return $lap;
	}
	
	protected function getCommandKey() {
		return 'command_workflow_key';
	}
	
	/**
     * Create command object.
     *
     * @param  \Illuminate\Http\Request  $request
     */
	protected function getCommand(\Illuminate\Http\Request $request, $id = null) {
		$workflow = parent::getCommand($request, $id);
		if (isset($id)) {
			foreach ($workflow->transitions as $transition) {
				$transition->loadMissing('workflow', 'account', 'category');
			}
		}
		return $workflow;
	}
	
	protected function storeCommand(\Illuminate\Http\Request $request) {
		$workflow = $this->getCommand($request);
		$workflow->fill($request->all());
		$workflow->save();
		foreach ($workflow->getAllTransitions() as $transition) {
			$workflow->transitions()->save($transition);
		}
		
		return $workflow;
	}
	
	protected function updateCommand(\Illuminate\Http\Request $request, $id) {
		$workflow = $this->getCommand($request);
		$workflow->fill($request->all());
		
		$currentTransitions = collect([]);
		foreach ($workflow->transitions as $transition) {
			$currentTransitions->put($transition->getTransitionKey(), $transition);
		}
		
		$toDelete = $currentTransitions->diffKeys($workflow->getAllTransitions());
		
		$workflow->save();
		
		foreach ($toDelete->values() as $transition) {
			$transition->delete();
		}
		
		foreach ($workflow->getAllTransitions() as $transition) {
			$workflow->transitions()->save($transition);
		}
		
		return $workflow;
	}
	
	protected function getPaginationLinks($transitions, $page) {
		Log::info('getPaginationLinks - Page: '. $page);
		$view = $transitions->links('vendor.pagination.bootstrap-4', ['paginationFunction' => 'workflowInstance.paginateTransitions']);
		//Log::info('getPaginationLinks - utf8_encode: '. utf8_encode($view));
		$json_array = array('html_content'=>utf8_encode($view));
		//Log::info('getPaginationLinks - View: '. json_encode($json_array));
		return json_encode($json_array);
	}
	
	protected function getTransitionsTable($workflow, $page) {
		$transitions = $workflow->getAllTransitions()->sort()->values();
		//Log::info('Page: '. $page);
		if ($page > 0) {			
			$slice = $this->getItemsPages($transitions, 5, $page - 1);
			$collection = collect([]);
			foreach ($slice as $transition) {
				Log::info($transition->category->name);
				$collection->push(['keyName' => $transition->getTransitionKey(), 'anio' => $transition->anio, 'empresa' => $transition->account->name, 'puesto' => $transition->category->name]);
			}
			
			$transitions = $this->paginate($workflow->getAllTransitions()->sort(), 5, $page);
			
			return response()->json([
				'status' => 'ok',
				'table_page' => $page,
				'key' => 'keyName',
				'urlRemove' => action($this->getControllerName().'@removeTransition'),
				'urlLoad' => action($this->getControllerName().'@loadTransition'),
				'paginationLinks' => $this->getPaginationLinks($transitions, $page),
				'list' => $collection->toJson()
			]);
		} else {
			return response()->json([
				'status' => 'error',
				'message' => 'Se ha producido un error'
			]);
		}
	}
	
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
	
	public function index(\Illuminate\Http\Request $request, $message = null) {
		$request->session()->forget($this->getCommandKey());
		return parent::index($request, $message);
	}
	
	public function getTransitions(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' getTransitions.');
		$workflow = $this->getCommand($request);
		$tablePage = $request->input('tablePage');
		if (!empty($tablePage)) {
			$pages = $this->getPages(5, count($workflow->getAllTransitions()));
			if ($pages == 0) {
				$tablePage = 1;
			} else {
				if ($tablePage > $pages) {
					$tablePage = $pages;
				}
			}
		} else {
			$tablePage = 1;
		}
		return $this->getTransitionsTable($workflow, $tablePage);
	}
	
	public function removeTransition(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' removeTransition.');
		$workflow = $this->getCommand($request);
		Log::info('***********************');
		Log::info('$transitionName: '.$request->input('transitionName'));
		$transition = $workflow->removeTransition($request->input('transitionName'));
		Log::info('***********************');
		if (is_null($transition)) {
			return response()->json([
				'status' => 'error',
				'message' => 'La transición no se eliminó'
			]);
		} else {
			$request->session()->put($this->getCommandKey(), $workflow);
			$tablePage = $request->input('tablePage');
			if (!empty($tablePage)) {
				$pages = $this->getPages(5, count($workflow->getAllTransitions()));
				if ($pages == 0) {
					$tablePage = 1;
				} else {
					if ($tablePage > $pages) {
						$tablePage = $pages;
					}
				}
			} else {
				$tablePage = 1;
			}
			return $this->getTransitionsTable($workflow, $tablePage);
		}
	}
	
	public function addTransition(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' addTranstion.');

		$workflow = $this->getCommand($request);
		
		$transition = $workflow->getEntrevistaByAnioAndEmpresa($request->input('transition-anio'), $request->input('transition-account_id'));
		
		if (is_null($transition)) {
			$transition = $this->transitionRepository->getInstance();
		}
		
		$category = Category::find($request->input('transition-category_id'));
		$transition->category()->associate($category);
		
		
		$transition->fill(['anio' => $request->input('transition-anio'), 'zonas' => $request->input('transition-zonas'), 'comentarios' => $request->input('transition-comentarios')]);
		
		if (is_null($transition->account())) {
			$account = Account::find($request->input('transition-account_id'));
			$transition->account()->associate($account);
		}
		
		if (is_null($transition->workflow())) {
			$transition->workflow()->associate($workflow);
		}
	
		$workflow->addTransition($transition);
		Log::info('addTranstion Transition: ' . $transition);
		
		$request->session()->put($this->getCommandKey(), $workflow);
		$page = $this->getItemPage(5, $workflow->getAllTransitions()->sort(), $transition->getTransitionKey());
		return $this->getTransitionsTable($workflow, $page);
		// } else {
			// return response()->json([
				// 'status' => 'error',
				// 'message' => 'La entrevista ya se encuentra creada'
			// ]);
		// }
		
	}
	
	public function loadTransition(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' loadTransition.');
		$workflow = $this->getCommand($request);
		Log::info('***********************');
		Log::info('$transitionName: '.$request->input('transitionName'));
		$transition = $workflow->getEntrevistaByKey($request->input('transitionName'));
		Log::info('***********************');
		if (is_null($transition)) {
			return response()->json([
				'status' => 'error',
				'message' => 'La transición no se encuentra'
			]);
		} else {
			$request->session()->put($this->getCommandKey(), $workflow);
			
			return response()->json([
				'status' => 'ok',
				'key' => $transition->getTransitionKey(),
				'transition' => $transition
			]);
		}
	}
	
	public function getPageSize() {
		return 10;
	}
	
	public function getRouteResource() {
		return 'workflows';
	}
	
	public function getRouteGroup() {
		return 'administration.';
	}
	
	public function postProcessCommand(Request $request, $command) {
		$command->name = $request->old('name');
	}
	
	public function postEditProcessCommand(Request $request, $command) {
	}
	
	public function getControllerName() {
		return 'Administration\WorkflowController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}
}