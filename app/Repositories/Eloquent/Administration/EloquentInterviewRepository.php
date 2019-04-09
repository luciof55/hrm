<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Interview;
use App\Repositories\Contracts\Administration\InterviewRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentInterviewRepository extends EloquentBaseRepository implements InterviewRepository
{
    public function entity()
    {
        return Interview::class;
    }
	
	public function getInstance() {
		return new Interview();
	}
}
