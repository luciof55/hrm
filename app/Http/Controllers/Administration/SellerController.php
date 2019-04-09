<?php

namespace App\Http\Controllers\Administration;

use App\Model\Administration\Seller;
use App\Model\Administration\Account;
use App\Model\Administration\File as Archivo;
use App\Model\Gondola\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\HRMBaseController;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Repositories\Contracts\Gondola\CategoryRepository;

class SellerController extends HRMBaseController
{
	protected $interviewRepository;
	protected $accountRepository;
	protected $categoryRepository;
	
	protected function getValidateStoreData(\Illuminate\Http\Request $request) {
		$data = $request->all();
		$seller = $this->getCommand($request);
		return array_add($data, 'auxInterviews', $seller->getAllInterviews());
	}
	
	/**
     * Get a validator for an incoming Seller request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_create(array $data)
    {
		Log::info('Execute Seller create validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:sellers',
			'auxInterviews' => [function($attribute, $value, $fail) {
				if ($value->isEmpty()) {
					return $fail('Debe agregar al menos una entrevista');
				}
			}],
			'filename' => 'file|max:2048'
        ]);
    }
	
	protected function getValidateUpdateData(\Illuminate\Http\Request $request) {
		return $this->getValidateStoreData($request);
	}
	
	/**
     * Get a validator for an incoming seller request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data)
    {
		Log::info('Execute Seller update validator.');
        return Validator::make($data, [
            'name' => 'bail|required|string|max:150|unique:sellers,name,'.$data['id'],
			'auxInterviews' => [function($attribute, $value, $fail) {
				if ($value->isEmpty()) {
					return $fail('Debe agregar al menos una entrevista');
				}
			}],
			'filename' => 'file|max:2048'
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
		
		$entrevistadoOptions = collect([]);
		$entrevistadoOptions->put(1, 'Si');
		$entrevistadoOptions->put(0, 'No');
		$collection->put('entrevistadoOptions', $entrevistadoOptions);
		
		if ($request->session()->has($this->getCommandKey())) {
			$seller = $request->session()->get($this->getCommandKey(), null);
		} else {
			$seller = $collection->get('command');
		}
		
		if (!blank($request->input('tablePage'))) {
			$tablePage = $request->input('tablePage');
		} else {
			$tablePage = 1;
		}
		
		if (isset($seller)) {
			$interviews = $this->paginate($seller->getAllInterviews()->sort(), 5, $tablePage);
			$collection->put('interviews', $interviews);
			if (isset($seller->id)) {			
				$actionView = action($this->getControllerName().'@show', $seller->id);
				$collection->put('actionView', $actionView);
			}
		}
		if (!empty($tablePage) && isset($seller)) {
			$pages = $this->getPages(5, count($seller->getAllInterviews()));
			if ($tablePage > $pages) {
				$tablePage = $pages;
			}
		};
		
		$collection->put('tablePage', $tablePage);

		$actionAddInterview = action($this->getControllerName().'@addInterview');
		$collection->put('actionAddInterview', $actionAddInterview);
		
		$actionRemoveInterview = action($this->getControllerName().'@removeInterview');
		$collection->put('actionRemoveInterview', $actionRemoveInterview);
		
		$actionLoadInterview = action($this->getControllerName().'@loadInterview');
		$collection->put('actionLoadInterview', $actionLoadInterview);
		
		$actionGetInterviews = action($this->getControllerName().'@getInterviews');
		$collection->put('actionGetInterviews', $actionGetInterviews);
		
		$activeTab = $request->input('activeTab');
		
		if (isset($activeTab)) {
			$collection->put('activeTab', $activeTab);
		} else {
			$collection->put('activeTab', 'main');
		}
		
		$action_removefile = route('administration.sellers_removeFile');
		$collection->put('action_removefile', $action_removefile);
		
		$request->session()->put($this->getCommandKey(), $seller);
	}
	
	protected function getQuery(\Illuminate\Http\Request $request, $collectionOrder, $collectionFilter, $page) {
		$query = $this->repository->getInstance()->join('interviews', 'sellers.id', '=', 'interviews.seller_id')->select('sellers.*')->distinct()->withTrashed();
		return $query;
	}
	
	protected function paginate($items, $perPage = 5, $page = null, $options = []) {
		Log::info('PPPPPP paginate PPPPPPPPP');
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		Log::info('RESOLVED PAGINATOR PAGE: '.$page);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		$lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
		return $lap;
	}
	
	protected function getCommandKey() {
		return 'command_seller_key';
	}
	
	/**
     * Create command object.
     *
     * @param  \Illuminate\Http\Request  $request
     */
	protected function getCommand(\Illuminate\Http\Request $request, $id = null) {
		$seller = parent::getCommand($request, $id);
		if (isset($id)) {
			foreach ($seller->interviews as $interview) {
				$interview->loadMissing('seller', 'account', 'category');
			}
		}
		return $seller;
	}
	
	protected function storeCommand(\Illuminate\Http\Request $request) {
		$seller = $this->getCommand($request);
		$seller->fill($request->all());
		if ( ! $request->has('entrevistado')) {
			$seller->entrevistado = false;
		} else {
			$seller->entrevistado = true;
		}
		$seller->save();
		foreach ($seller->getAllInterviews() as $interview) {
			$seller->interviews()->save($interview);
		}
		if ($request->hasFile('filename') && $request->file('filename')->isValid()) {
			$file = $this->saveFile($request);
			if (isset($file)) {
				$file->seller()->associate($seller);
				$seller->files()->save($file);
			}
		} else {
			Log::info('No hay Filename o no es válido');
		}
		
		return $seller;
	}
	
	protected function updateCommand(\Illuminate\Http\Request $request, $id) {
		Log::info('**********************');
		Log::info($request->all());
		
		$seller = $this->getCommand($request);
		$seller->fill($request->all());
		
		if ( ! $request->has('entrevistado')) {
			$seller->entrevistado = false;
		} else {
			$seller->entrevistado = true;
		}
		
		$currentInterviews = collect([]);
		foreach ($seller->interviews as $interview) {
			$currentInterviews->put($interview->getInterviewKey(), $interview);
		}
		
		$toDelete = $currentInterviews->diffKeys($seller->getAllInterviews());
		
		if ($request->hasFile('filename') && $request->file('filename')->isValid()) {
			$file = $this->saveFile($request);
		} else {
			Log::info('No hay Filename o no es válido');
		}
		
		$seller->save();
		
		foreach ($toDelete->values() as $interview) {
			$interview->delete();
		}
		
		foreach ($seller->getAllInterviews() as $interview) {
			$seller->interviews()->save($interview);
		}
		
		if (isset($file)) {
			foreach ($seller->files as $fileToDelete) {
				Log::info('Deleting: ' . $fileToDelete->id);
				try {
					Storage::delete($fileToDelete->filename);
				} catch (Exception $e) {
					Log::error($e);
				}
				$fileToDelete->delete();
			}
			$file->seller()->associate($seller);
			$seller->files()->save($file);
		}
		
		foreach ($seller->getFilesToRemove() as $fileToDelete) {
			Log::info('Deleting: ' . $fileToDelete->id);
			try {
				Storage::delete($fileToDelete->filename);
			} catch (Exception $e) {
				Log::error($e);
			}
			$fileToDelete->delete();
		}
		
		$seller->save();
		
		return $seller;
	}
	
	protected function getPaginationLinks($interviews, $page) {
		Log::debug('getPaginationLinks - Page: '. $page);
		$view = $interviews->links('vendor.pagination.bootstrap-4', ['paginationFunction' => 'sellerInstance.paginateInterviews']);
		//Log::info('getPaginationLinks - utf8_encode: '. utf8_encode($view));
		$json_array = array('html_content'=>utf8_encode($view));
		//Log::info('getPaginationLinks - View: '. json_encode($json_array));
		return json_encode($json_array);
	}
	
	protected function getInterviewsTable($seller, $page) {
		$interviews = $seller->getAllInterviews()->sort()->values();
		Log::info('getInterviewsTable Page: '. $page);
		if ($page > 0) {			
			$slice = $this->getItemsPages($interviews, 5, $page - 1);
			$collection = collect([]);
			foreach ($slice as $interview) {
				Log::info($interview->category->name);
				$collection->push(['keyName' => $interview->getInterviewKey(), 'anio' => $interview->anio, 'empresa' => $interview->account->name, 'puesto' => $interview->category->name]);
			}
			
			$interviews = $this->paginate($seller->getAllInterviews()->sort(), 5, $page);
			
			return response()->json([
				'status' => 'ok',
				'table_page' => $page,
				'key' => 'keyName',
				'urlRemove' => action($this->getControllerName().'@removeInterview'),
				'urlLoad' => action($this->getControllerName().'@loadInterview'),
				'paginationLinks' => $this->getPaginationLinks($interviews, $page),
				'list' => $collection->toJson()
			]);
		} else {
			return response()->json([
				'status' => 'error',
				'message' => 'Se ha producido un error'
			]);
		}
	}
	
	protected function saveFile(\Illuminate\Http\Request $request) {
		Log::info('saveFile STAR');
		try {
			$dir = config('app.files_directory');
			$path = $request->filename->store($dir);
			$file = new Archivo;
			$file->filename = $path;
			$file->original_filename = $request->filename->getClientOriginalName();
			return $file;			
		} catch (Exception $e) {
			Log::error($e);
			return null;
		}
		
    }
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\Contracts\Administration\SellerRepository $repository,
	\App\Repositories\Contracts\Administration\InterviewRepository $interviewRepository,
	\App\Repositories\Contracts\Gondola\CategoryRepository $categoryRepository, \App\Repositories\Contracts\Administration\AccountRepository $accountRepository) {
		
		$this->repository = $repository;
		$this->interviewRepository = $interviewRepository;
		$this->categoryRepository = $categoryRepository;
		$this->accountRepository = $accountRepository;
        $this->middleware('auth');
    }
	
	public function index(\Illuminate\Http\Request $request, $message = null) {
		$request->session()->forget($this->getCommandKey());
		return parent::index($request, $message);
	}
	
	public function getInterviews(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' getInterviews.');
		$seller = $this->getCommand($request);
		$tablePage = $request->input('tablePage');
		if (!empty($tablePage)) {
			$pages = $this->getPages(5, count($seller->getAllInterviews()));
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
		return $this->getInterviewsTable($seller, $tablePage);
	}
	
	public function removeInterview(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' removeInterview.');
		$seller = $this->getCommand($request);
		Log::info('***********************');
		Log::info('$interviewName: '.$request->input('interviewName'));
		$interview = $seller->removeInterview($request->input('interviewName'));
		Log::info('***********************');
		if (is_null($interview)) {
			return response()->json([
				'status' => 'error',
				'message' => 'La transición no se eliminó'
			]);
		} else {
			$request->session()->put($this->getCommandKey(), $seller);
			$tablePage = $request->input('tablePage');
			if (!empty($tablePage)) {
				$pages = $this->getPages(5, count($seller->getAllInterviews()));
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
			return $this->getInterviewsTable($seller, $tablePage);
		}
	}
	
	public function addInterview(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' addInterview.');
	
		
		if (blank($request->input('interview-anio')) || blank($request->input('interview-zonas')) || blank($request->input('interview-account_id')) || blank($request->input('interview-category_id')) || blank($request->input('interview-comentarios'))) {
			return response()->json([
				'status' => 'error',
				'message' => 'Faltan cargar datos requeridos.'
			]);
		}
		
		$seller = $this->getCommand($request);
		
		$interview = $seller->getEntrevistaByAnioAndEmpresa($request->input('interview-anio'), $request->input('interview-account_id'));
		
		if (is_null($interview)) {
			$interview = $this->interviewRepository->getInstance();
		}
		
		$category = Category::find($request->input('interview-category_id'));
		$interview->category()->associate($category);
		
		
		$interview->fill(['anio' => $request->input('interview-anio'), 'zonas' => $request->input('interview-zonas'), 'comentarios' => $request->input('interview-comentarios')]);
		
		if (is_null($interview->account_id)) {
			$account = Account::find($request->input('interview-account_id'));
			$interview->account()->associate($account);
			$interview->fill(['account_id' => $request->input('interview-account_id')]);
		}
		
		if (is_null($interview->seller_id)) {
			$interview->seller()->associate($seller);
		}
	
		$seller->addInterview($interview);
		Log::info('addInterview Interview: ' . $interview);
		
		$request->session()->put($this->getCommandKey(), $seller);
		$page = $this->getItemPage(5, $seller->getAllInterviews()->sort(), $interview->getInterviewKey());
		return $this->getInterviewsTable($seller, $page);
		
	}
	
	public function loadInterview(\Illuminate\Http\Request $request) {
		$entity = $this->repository->entity();
		Log::info('Execute '. $entity.' loadInterview.');
		$seller = $this->getCommand($request);
		Log::info('***********************');
		Log::info('$interviewName: '.$request->input('interviewName'));
		$interview = $seller->getEntrevistaByKey($request->input('interviewName'));
		Log::info('***********************');
		if (is_null($interview)) {
			return response()->json([
				'status' => 'error',
				'message' => 'La transición no se encuentra'
			]);
		} else {
			$request->session()->put($this->getCommandKey(), $seller);
			
			return response()->json([
				'status' => 'ok',
				'key' => $interview->getInterviewKey(),
				'interview' => $interview
			]);
		}
	}
	
	public function download(\Illuminate\Http\Request $request) {
		$id = $request->input('id');
		$seller = $this->repository->find($id);
		if (isset($seller) && !blank($seller->files)) {
			$filename = $seller->files[0]->filename;
			$clientFilename = $seller->files[0]->original_filename;
			return Storage::download($filename, $clientFilename);
		}
		
	}
	
	public function removeFile(\Illuminate\Http\Request $request) {
		$seller = $this->getCommand($request);
		if (!blank($seller->files)) {
			$seller->removeFile();
			
			return response()->json([
				'status' => 'ok'
			]);
		} else {
			return response()->json([
				'status' => 'ok'
			]);
		}
	}
	
	public function getPageSize() {
		return 10;
	}
	
	public function getRouteResource() {
		return 'sellers';
	}
	
	public function getRouteGroup() {
		return 'administration.';
	}
	
	public function postProcessCommand(Request $request, $command) {
		$command->name = $request->old('name');
		$command->telefono = $request->old('telefono');
	}
	
	public function postEditProcessCommand(Request $request, $command) {
	}
	
	public function getControllerName() {
		return 'Administration\SellerController';
	}
	
	public function getViewBase() {
		return 'administration.';
	}
}