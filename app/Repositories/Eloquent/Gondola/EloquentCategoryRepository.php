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