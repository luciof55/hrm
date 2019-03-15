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
		
		$this->app->singleton(
			'App\Repositories\Contracts\UserRepository', 'App\Repositories\Eloquent\EloquentUpsalesUserRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\AccountRepository', 'App\Repositories\Eloquent\Administration\EloquentAccountRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\ContactRepository', 'App\Repositories\Eloquent\Administration\EloquentContactRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\BusinessRecordStateRepository', 'App\Repositories\Eloquent\Administration\EloquentBusinessRecordStateRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\BusinessRecordRepository', 'App\Repositories\Eloquent\Administration\EloquentBusinessRecordRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\WorkflowRepository', 'App\Repositories\Eloquent\Administration\EloquentWorkflowRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Administration\TransitionRepository', 'App\Repositories\Eloquent\Administration\EloquentTransitionRepository'
		);
		
		$this->app->singleton(
			'App\Repositories\Contracts\Gondola\CategoryRepository', 'App\Repositories\Eloquent\Gondola\EloquentCategoryRepository'
		);
    }
}
