<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\Contact;
use App\Repositories\Contracts\Administration\ContactRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentContactRepository extends EloquentBaseRepository implements ContactRepository
{
    public function entity()
    {
        return Contact::class;
    }
	
	public function getInstance() {
		return new Contact();
	}
	
	protected function softDeleteCascade($contact) {
		
	}
	
	public function canDelete($contact) {
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		return $result;
	}
	
	public function canRestore($contact) {
		Log::info('EloquentContactRepository - canRestore');
		$result = collect([]);
		$result->put('message', null);
		$result->put('status', true);
		
		if (method_exists($contact, 'canRestore')) {
			$result->put('status', $contact->canRestore());
		}
		
		if ($contact->user->trashed()) {
			$result->put('message', "El usuario del contacto está deshabilitado. Cambie de usuario o habilite el mismo: ".$contact->user->name."'");
			$result->put('status', false);
		}
		
		if ($contact->account->trashed()) {
			if (is_null($result->get('message'))) {
				$result->put('message', "La cuenta del contacto está deshabilitada. Cambie de cuenta o habilite la misma: ".$contact->account->name."'");
			} else {
				$message = $result->get('message') . "La cuenta del contacto está deshabilitada. Cambie de cuenta o habilite la misma: ".$contact->account->name."'";
				$result->put('message', $message);
			}
			
			$result->put('status', false);
		}
		
		return $result;
	}
}