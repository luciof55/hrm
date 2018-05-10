<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Google\GoogleClient;
use Illuminate\Support\Facades\Log;

class SecurityController extends Controller
{
	protected $googleClient;
	protected $serviceDrive;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Google\GoogleClient $googleClient) {
		$this->googleClient = $googleClient;
		try {
			$this->serviceDrive = $this->googleClient->make('Drive');
			Log::debug('SecurityController - Drive Created!!!!');
			
        } catch (UnknownServiceException $exception) {
			Log::debug('Error building singleton Google_Service_Drive');
		}
        $this->middleware('auth');
    }

	public function authorizeCallback(Request $request) {
		$sourceUrl = $request->get('sourceUrl');
		if (is_null($sourceUrl)) {
			$sourceUrl = $request->session()->get('sourceUrl', '/security');
		}
		$request->session()->forget('sourceUrl');
		if (null == $request->input('code')) {
			Log::debug('No authorized');
			return redirect($sourceUrl)->with('unauthorized', 'This action is unauthorized!');
		} else {
			$this->googleClient->setAuthCode($request->input('code'), $request->user()->name);
			return redirect($sourceUrl);
		}
	}
	
	public function authorizeInit(Request $request) {
		$authUrl = $this->getAuthorizationUrl();
		$request->session()->put('sourceUrl', $request->input('sourceUrl'));
		return redirect()->away(filter_var($authUrl, FILTER_SANITIZE_URL));
	}
	
	public function revokeToken(Request $request) {
		$revokeResult = $this->googleClient->revokeToken($request->user()->name);
		$redirectTo = '/security';
		
		if (null !== $request->input('sourceUrl')) {
			$redirectTo = $request->input('sourceUrl');
		}
		
		if ($revokeResult) {
			return redirect($redirectTo)->with('statusSuccess', 'Successfully Revoked!');
		} else {
			return redirect($redirectTo)->with('statusError', 'Error while revoking!');
		}
	}
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
		$collection = collect([]);
		if ($request->get('googleAuthorize')) { 
			$optParams = array('pageSize' => 10, 'fields' => 'nextPageToken, files(id, name)');
			$results = $this->serviceDrive->files->listFiles($optParams);
			$collection->put('results', $results);
		}
		$collection->put('AppName', $this->googleClient->getClient()->getLibraryVersion());
		return view('admin.security', $collection->all());
    }
	
	protected function getAuthorizationUrl() {
		// Request authorization from the user.
		return $this->googleClient->getAuthUrl();
	}
}