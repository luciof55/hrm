<?php

namespace App\Repositories\Eloquent;

use App\HRMUser;
use App\Repositories\Contracts\HRMUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EloquentHRMUserRepository extends EloquentUserRepository implements HRMUserRepository
{
	public function entity()
    {
        return HRMUser::class;
    }
	
	public function getInstance() {
		return new HRMUser();
	}
	
	public function canDelete($command) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if ($command->accounts->isNotEmpty() || $command->contacts->isNotEmpty() || !$command->canDelete()) {
			$result->put('message', "Existen cuentas/contactos relacionados, no se puede eliminar");
			$result->put('status', false);
		}
		
		return $result;
	}
}