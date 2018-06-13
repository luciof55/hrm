<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Administration\BusinessRecordController;

class HomeController extends BusinessRecordController
{
	protected $googleClient;
	protected $serviceDrive;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 public function __construct(\App\Repositories\Contracts\Administration\BusinessRecordRepository $repository, \App\Repositories\Contracts\UserRepository $userRepository, \App\Repositories\Contracts\Administration\AccountRepository $accountRepository, \App\Repositories\Contracts\Administration\BusinessRecordStateRepository $businessRecordStateRepository, \App\Google\GoogleClient $googleClient, \App\Repositories\Contracts\Administration\WorkflowRepository $workflowRepository) {
		
		$this->userRepository = $userRepository;
		$this->repository = $repository;
		$this->accountRepository = $accountRepository;
		$this->businessRecordStateRepository = $businessRecordStateRepository;
		$this->workflowRepository = $workflowRepository;
        
		$this->googleClient = $googleClient;
		try {
			$this->serviceDrive = $this->googleClient->make('Drive');
			Log::info('SecurityController - Drive Created!!!!');
        } catch (UnknownServiceException $exception) {
			Log::info('Error building singleton Google_Service_Drive');
		}
        $this->middleware('auth');
    }
	
	public function getIndexView() {
		return 'welcome';
	}
	
	/**
     * Add reference data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $collection
     */
	protected function referenceData(\Illuminate\Http\Request $request, \Illuminate\Support\Collection $collection) {
		parent::referenceData($request, $collection);
		
		if ($request->get('googleAuthorize')) { 
			$optParams = array('pageSize' => 10, 'fields' => 'nextPageToken, files(id, name)');
			$results = $this->serviceDrive->files->listFiles($optParams);
			$collection->put('results', $results);
		}
		$collection->put('AppName', $this->googleClient->getClient()->getLibraryVersion());
		
		if ($request->has('columnOrder')) {
			$collection->put('columnOrder', $request->input('columnOrder'));
		}
	}
	
	public function getEditView() {
		return 'potencials.details';
	}
	
	public function getControllerName() {
		return 'HomeController';
	}
	
	public function getRouteGroup() {
		return '';
	}
}
