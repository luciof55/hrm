<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class GoogleAuthorize
{
	protected $googleClient;
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Google\GoogleClient $googleClient) {
		$this->googleClient = $googleClient;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		Log::debug('GoogleAuthorize - Handle');
		Log::debug('GoogleAuthorize - Handle - Path: '.$request->path());
		Log::debug('GoogleAuthorize - Handle - Path: '.$request->path());
		Log::debug('GoogleAuthorize - Handle - getAuthorizeCallback: '.$this->googleClient->getAuthorizeCallback());
		Log::debug('GoogleAuthorize - Handle - getAuthorizeInit: '.$this->googleClient->getAuthorizeInit());
		
		if ($request->path() != $this->googleClient->getAuthorizeCallback() && $request->path() != $this->googleClient->getAuthorizeInit()) {
			$user = $request->user();
			$request->attributes->add(['sourceUrl' => $request->path()]);
			
			if (!is_null($request->user())) {
				if ($this->googleClient->generateAccessToken($request->user()->name) == null) {
					$request->attributes->add(['googleAuthorize' => false]);
					Log::debug('GoogleAuthorize - Handle - Not Authorized');
				} else {
					$request->attributes->add(['googleAuthorize' => true]);
					Log::debug('GoogleAuthorize - Handle - Authorized');
				}
			} else {
				$request->attributes->add(['googleAuthorize' => false]);
				Log::debug('GoogleAuthorize User is null');
			}
		}
        return $next($request);
    }

}