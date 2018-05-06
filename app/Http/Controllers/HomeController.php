<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
	protected $googleClient;
	
	protected $serviceDrive;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Google\GoogleClient $googleClient)
    {
		$this->googleClient = $googleClient;
		
		$this->googleClient = $googleClient;
		
		try {
			$this->serviceDrive = $this->googleClient->make('Drive');
			Log::info('SecurityController - Drive Created!!!!');
			
        } catch (UnknownServiceException $exception) {
			Log::info('Error building singleton Google_Service_Drive');
		}
		
        $this->middleware('guest');
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$collection = collect([]);
		
		if (Auth::check()) { 
			if ($this->googleClient->generateAccessToken($request->user()->name) == null) {
				$request->session()->put('sourceUrl', '/home');
				$collection->put('authorize', false);
			} else {
				$optParams = array(
				  'pageSize' => 10,
				  'fields' => 'nextPageToken, files(id, name)'
				);
				$results = $this->serviceDrive->files->listFiles($optParams);
				
				$collection->put('results', $results);
				$collection->put('authorize', true);
			}
		} else {
			$collection->put('authorize', false);
		}
			
		$collection->put('AppName', $this->googleClient->getClient()->getLibraryVersion());
		
		return view('welcome', $collection->all());
    }
}
