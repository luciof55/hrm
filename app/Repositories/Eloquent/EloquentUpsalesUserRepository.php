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
	
    protected function softDeleteCascade($command) {
		Log::info('EloquentUpsalesUserRepository - softDeleteCascade');
		if ($command->accounts->isNotEmpty()) {
			foreach($command->accounts as $account) {
				$account->delete();
			}
		}
		
		if ($account->contacts->isNotEmpty()) {
			foreach($account->contacts as $contact) {
				$contact->delete();
			}
		}
	}
	
	public function canDelete($command) {
		return $command->accounts->isEmpty() && $command->contacts->isEmpty() && $command->canDelete();
	}
}