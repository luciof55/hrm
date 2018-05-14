<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\BusinessRecord;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Contracts\Administration\BusinessRecordRepository;
use Illuminate\Support\Facades\Log;

class EloquentBusinessRecordRepository extends EloquentBaseRepository implements BusinessRecordRepository
{
    public function entity()
    {
        return BusinessRecord::class;
    }
	
	public function getInstance() {
		return new BusinessRecord();
	}
	
	public function canRestore($businessRecordState) {
		Log::info('EloquentBusinessRecordRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($businessRecordState, 'canRestore')) {
			$result->put('status', $businessRecordState->canRestore());
		}
		
		if ($result->get('status') && $businessRecordState->account->trashed()) {
			$result->put('message', "La cuenta está deshabilitada. Cambie de cuenta o habilite la misma: '".$businessRecordState->account->name."'");
			$result->put('status', false);
		}
		
		if ($result->get('status') && $businessRecordState->comercial->trashed()) {
			$result->put('message', "El comercial está deshabilitado. Cambie de comercial o habilite el mismo: '".$businessRecordState->comercial->name."'");
			$result->put('status', false);
		}
		
		if ($result->get('status') && $businessRecordState->leader->trashed()) {
			$result->put('message', "El líder está deshabilitado. Cambie de líder o habilite el mismo: '".$businessRecordState->leader->name."'");
			$result->put('status', false);
		}
		
		return $result;
	}
}