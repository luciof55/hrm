<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Transition;
use App\Repositories\Contracts\Administration\TransitionRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentTransitionRepository extends EloquentBaseRepository implements TransitionRepository
{
    public function entity()
    {
        return Transition::class;
    }
	
	public function getInstance() {
		return new Transition();
	}
}
