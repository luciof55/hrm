<?php

namespace App\Repositories\Eloquent;

use App\UpsalesUser;
use App\Repositories\Contracts\UpsalesUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EloquentUpsalesUserRepository extends EloquentUserRepository implements UpsalesUserRepository
{
	public function entity()
    {
        return UpsalesUser::class;
    }
	
	public function getInstance() {
		return new UpsalesUser();
	}
	
	public function canDelete($command) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if ($command->accounts->isNotEmpty() || $command->contacts->isNotEmpty() || !$command->canDelete()) {
			$result->put('message', "Existen datos relacionados, no se puede eliminar");
			$result->put('status', false);
		}
		
		return $result;
	}
}