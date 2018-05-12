<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\BusinessRecordState;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Contracts\Administration\BusinessRecordStateRepository;
use Illuminate\Support\Facades\Log;

class EloquentBusinessRecordStateRepository extends EloquentBaseRepository implements BusinessRecordStateRepository
{
    public function entity()
    {
        return BusinessRecordState::class;
    }
	
	public function getInstance() {
		return new BusinessRecordState();
	}
	
	protected function softDeleteCascade($businessRecordState) {
		
	}
	
	public function canDelete($businessRecordState) {
		return true;
	}
	
	public function canRestore($businessRecordState) {
		Log::info('EloquentBusinessRecordStateRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		return $result;
	}
}