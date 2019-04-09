<?php

namespace App\Repositories\Eloquent\Gondola;

use App\Model\Gondola\Category;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Contracts\Gondola\CategoryRepository;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use League\Csv\Statement;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    public function entity()
    {
        return Category::class;
    }
	
	public function getInstance() {
		return new Category();
	}
	
	public function canDelete($account) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if ($account->interviews->isNotEmpty() || !$account->canDelete()) {
			$result->put('message', "Existen entrevistas relacionadas, no se puede eliminar el puesto.");
			$result->put('status', false);
		}
		
		return $result;
	}
	
	public function canRestore($category) {
		Log::info('EloquentCategoryRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($category, 'canRestore')) {
			$result->put('status', $category->canRestore());
		}
		return $result;
	}
}