<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Account;
use App\Repositories\Contracts\Administration\AccountRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EloquentAccountRepository extends EloquentBaseRepository implements AccountRepository
{
    public function entity()
    {
        return Account::class;
    }
	
	public function getInstance() {
		return new Account();
	}
	
	protected function softDeleteCascade($account) {
		$account->delete();
	}
	
	public function canDelete($account) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if ($account->contacts->isNotEmpty() || !$account->canDelete()) {
			$result->put('message', "Existen contactos relacionados, no se puede eliminar");
			$result->put('status', false);
		}
		
		if ($account->businessRecords->isNotEmpty() || !$account->canDelete()) {
			$result->put('message', "Existen potenciales relacionados, no se puede eliminar");
			$result->put('status', false);
		}
		
		return $result;
	}
	
	public function canRestore($account) {
		Log::info('EloquentAccountRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($account, 'canRestore')) {
			$result->put('status', $account->canRestore());
		}
		
		return $result;
	}
}