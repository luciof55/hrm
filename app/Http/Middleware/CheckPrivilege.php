<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckPrivilege
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $resourceKey)
    {
		Log::info('CheckPrivilege - Handle - Path: '.$request->path());
		Log::info('CheckPrivilege - Handle - Resource: '.$resourceKey);
		// if (strrpos($request->path(), '/') > 0) {
			// $path = substr($request->path(), strrpos($request->path(), '/') + 1);
		// } else {
			// $path = $request->path();
		// }
		// Log::info('CheckPrivilege - handle: '.$path);
        if (! $request->user()->hasResourceAccess($resourceKey)) {
			 return redirect('/')->with('status', 'This action is unauthorized!');
        }

        return $next($request);
    }

}