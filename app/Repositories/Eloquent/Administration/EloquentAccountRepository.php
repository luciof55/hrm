<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Account;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentAccountRepository extends EloquentBaseRepository implements AccountRepository
{
    public function entity()
    {
        return Account::class;
    }
	
	public function getInstance() {
		return new Account();
	}
	
	protected function softDeleteCascade($Account) {
		
	}
	
	public function canDelete($command) {
		return true;
	}
	
	public function canRestore($command) {
		Log::info('EloquentAccountRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($command, 'canRestore')) {
			$result->put('status', $command->canRestore());
		}
		
		if ($result->get('status') && $command->user->trashed()) {
			$result->put('message', "El usuario de la cuenta está deshabilitado. Cambie de usuario o habilite el usuario: ".$command->user->name."'");
			$result->put('status', false);
		}
		
		return $result;
	}
}