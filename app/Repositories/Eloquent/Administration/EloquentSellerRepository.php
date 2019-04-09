<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Seller;
use App\Repositories\Contracts\Administration\SellerRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentSellerRepository extends EloquentBaseRepository implements SellerRepository
{
    public function entity()
    {
        return Seller::class;
    }
	
	public function getInstance() {
		return new Seller();
	}
	
	public function canDelete($seller) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		return $result;
	}
	
	public function canRestore($seller) {
		Log::info('EloquentSellerRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		return $result;
	}
}
