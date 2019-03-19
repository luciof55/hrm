<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Workflow;
use App\Repositories\Contracts\Administration\WorkflowRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentWorkflowRepository extends EloquentBaseRepository implements WorkflowRepository
{
    public function entity()
    {
        return Workflow::class;
    }
	
	public function getInstance() {
		return new Workflow();
	}
	
	public function canDelete($workflow) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
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
