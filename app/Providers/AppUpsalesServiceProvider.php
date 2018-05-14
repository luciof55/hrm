<?php

namespace App\Providers;

use App\Providers\AppServiceProvider;

class AppUpsalesServiceProvider extends AppServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		parent::register();
		
		$this->app->bind(
			'App\Repositories\Contracts\UserRepository', 'App\Repositories\Eloquent\EloquentUpsalesUserRepository'
		);
		
		$this->app->bind(
			'App\Repositories\Contracts\Administration\AccountRepository', 'App\Repositories\Eloquent\Administration\EloquentAccountRepository'
		);
		
		$this->app->bind(
			'App\Repositories\Contracts\Administration\ContactRepository', 'App\Repositories\Eloquent\Administration\EloquentContactRepository'
		);
		
		$this->app->bind(
			'App\Repositories\Contracts\Administration\BusinessRecordStateRepository', 'App\Repositories\Eloquent\Administration\EloquentBusinessRecordStateRepository'
		);
		
		$this->app->bind(
			'App\Repositories\Contracts\Administration\BusinessRecordRepository', 'App\Repositories\Eloquent\Administration\EloquentBusinessRecordRepository'
		);
    }
}
