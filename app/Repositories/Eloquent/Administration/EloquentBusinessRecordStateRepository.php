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
	
	public function canDelete($businessRecordState) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if ($businessRecordState->businessRecords->isNotEmpty() || !$businessRecordState->canDelete()) {
			$result->put('message', "Existen potenciales relacionados, no se puede eliminar");
			$result->put('status', false);
		}
		
		if ($businessRecordState->initialWorkflows->isNotEmpty() || $businessRecordState->finalWorkflows->isNotEmpty() || !$businessRecordState->canDelete()) {
			$result->put('message', "Existen Workflows relacionados, no se puede eliminar");
			$result->put('status', false);
		}
		
		return $result;
	}
	
	public function canRestore($businessRecordState) {
		Log::info('EloquentBusinessRecordStateRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		return $result;
	}
}