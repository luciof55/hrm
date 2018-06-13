<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UpsalesBaseController;
use App\Repositories\Contracts\Administration\BusinessRecordState;

class WorkflowController extends UpsalesBaseController
{
	protected $businessRecordStateRepository;
	protected $transitionRepository;
	
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
			'initial_state_id' => 'bail|required',
			'final_state_id' => 'bail|required',
			'auxTransitions' => [function($attribute, $value, $fail) {
				if ($value->isEmpty()) {
					return $fail('Debe agregar al menos una transición');
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
			'initial_state_id' => 'bail|required',
			'final_state_id' => 'bail|required',
			'auxTransitions' => [function($attribute, $value, $fail) {
				if ($value->isEmpty()) {
					return $fail('Debe agregar al menos una transición');
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
		$states = $this->businessRecordStateRepository->select(['id', 'name']);
		$select_state = collect([]);
		foreach ($states as $state) {
			$select_state->put($state->id, $state->name);
		}
		$collection->put('states', $select_state);
		
		
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
				$transition->loadMissing('workflow', 'fromState', 'toState');
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
			$currentTransitions->put(strtolower($transition->name), $transition);
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
				//Log::info($transition);
				$collection->push(['keyName' => $transition->getCleanName(), 'name' => $transition->name, 'fromState' => $transition->fromState->name, 'toState' => $transition->toState->name]);
			}
			
			$transitions = $this->paginate($workflow->getAllTransitions()->sort(), 5, $page);
			
			return response()->json([
				'status' => 'ok',
				'table_page' => $page,
				'key' => 'keyName',
				'urlRemove' => action($this->getControllerName().'@removeTransition'),
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
    public function __construct(\App\Repositories\Contracts\Administration\WorkflowRepository $repository, \App\Repositories\Contracts\Administration\BusinessRecordStateRepository $businessRecordStateRepository,
	\App\Repositories\Contracts\Administration\TransitionRepository $transitionRepository) {
		
		$this->repository = $repository;
		$this->businessRecordStateRepository = $businessRecordStateRepository;
		$this->transitionRepository = $transitionRepository;
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
		//Log::info('$transitionName: '.$request->input('deleteTransitionName'));
		$transition = $workflow->removeTransition($request->input('deleteTransitionName'));
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
		if ($request->input('transition-from_state_id') != $request->input('transition-to_state_id')) {
		
			$workflow = $this->getCommand($request);
			
			if (is_null($workflow->getTransitionByState($request->input('transition-from_state_id'), $request->input('transition-to_state_id')))) {
				$transition = $this->transitionRepository->getInstance();
				$fromBusinessRecordState = $this->businessRecordStateRepository->find($request->input('transition-from_state_id'));
				$toBusinessRecordState = $this->businessRecordStateRepository->find($request->input('transition-to_state_id'));
				$transition->fill(['name' => $request->input('transition-name'), 'workflow_id' => $workflow->id, 'from_state_id' => $fromBusinessRecordState->id, 'to_state_id' => $toBusinessRecordState->id]);
			
				$workflow->addTransition($transition);
				$request->session()->put($this->getCommandKey(), $workflow);
				$page = $this->getItemPage(5, $workflow->getAllTransitions()->sort(), strtolower($transition->name));
				return $this->getTransitionsTable($workflow, $page);
			} else {
				return response()->json([
					'status' => 'error',
					'message' => 'La transición ya se encuentra creada'
				]);
			}
		} else {
				return response()->json([
					'status' => 'error',
					'message' => 'Estado desde es igual a estado hasta'
				]);
		}
	}
	
	public function getPageSize() {
		return 5;
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
		// if (!empty($request->old('name'))) {
			// $command->name = $request->old('name');
		// }
		//$command->name = $request->input('name');
	}
	
	public function getControllerName() {
		return 'Administration\WorkflowController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}
}