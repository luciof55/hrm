<?php

namespace App\Providers;

use App\Providers\AppServiceProvider;

class AppHRMServiceProvider extends AppServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		parent::register();
		
		$this->app->singleton(
			'App\Repositories\Contracts\UserRepository', 'App\Repositories\Eloquent\EloquentHRMUserRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\AccountRepository', 'App\Repositories\Eloquent\Administration\EloquentAccountRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\ContactRepository', 'App\Repositories\Eloquent\Administration\EloquentContactRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\SellerRepository', 'App\Repositories\Eloquent\Administration\EloquentSellerRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\InterviewRepository', 'App\Repositories\Eloquent\Administration\EloquentInterviewRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Gondola\CategoryRepository', 'App\Repositories\Eloquent\Gondola\EloquentCategoryRepository'
		);
    }
}
