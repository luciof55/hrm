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
	
	protected function softDeleteCascade($account) {
		if ($account->contacts->isNotEmpty()) {
			foreach($account->contacts as $contact) {
				$contact->delete();
			}
		}
	}
	
	public function canDelete($account) {
		return $account->contacts->isEmpty() && $account->canDelete();
	}
	
	public function canRestore($account) {
		Log::info('EloquentAccountRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($account, 'canRestore')) {
			$result->put('status', $account->canRestore());
		}
		
		if ($result->get('status') && $account->user->trashed()) {
			$result->put('message', "El usuario de la cuenta está deshabilitado. Cambie de usuario o habilite el usuario: ".$account->user->name."'");
			$result->put('status', false);
		}
		
		return $result;
	}
}