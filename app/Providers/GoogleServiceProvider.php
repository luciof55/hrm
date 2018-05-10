<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Google\GoogleClient;
use Google_Service_Books;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function GoogleServiceProvider()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		Log::debug('GoogleServiceProvider - register');
		$this->mergeConfigFrom(__DIR__.'/../../config/google.php', 'google');
		Log::debug($this->app['config']['google']);
        $this->app->singleton('App\Google\GoogleClient', function ($app) {
			Log::debug('GoogleServiceProvider - singleton');
            return new GoogleClient($app['config']['google']);
        });
    }
	
	/**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['App\Google\GoogleClient'];
    }
}
