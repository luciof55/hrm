<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Google\GoogleClient;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UpsalesController;

class AdministrationController extends UpsalesController
{	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {	
        $this->middleware('auth');
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$collection = collect([]);
		
		return view('administration.administration', $collection->all());
    }
}
