<?php

namespace App\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Kernel;

class UpsalesKernel extends Kernel
{
    /**
     * Create a new HTTP kernel instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function __construct(Application $app, Router $router) {
		array_push($this->middlewareGroups['web'], \App\Http\Middleware\GoogleAuthorize::class);
		HttpKernel::__construct($app, $router);
    }
}
