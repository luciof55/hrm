<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
		return view('contact');
    }
	
	public function process_contact(Request $request)
	{
		$data = $request->validate(['email' => 'required|max:255', 'message' => 'required|max:255']);
		return view('contact', ['alertSuccess' => $data['message']]);
	}
}