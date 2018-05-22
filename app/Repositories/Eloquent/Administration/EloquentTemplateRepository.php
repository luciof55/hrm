<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Template;
use App\Repositories\Contracts\Administration\TemplateRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentTemplateRepository extends EloquentBaseRepository implements TemplateRepository
{
    public function entity()
    {
        return Template::class;
    }
	
	public function getInstance() {
		return new Template();
	}
}
