<?php

namespace App\Repositories\Eloquent\Administration;

use App\Model\Administration\MailNotification;
use App\Repositories\Contracts\Administration\MailNotificationRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Log;

class EloquentMailNotificationRepository extends EloquentBaseRepository implements MailNotificationRepository
{
    public function entity()
    {
        return MailNotification::class;
    }
	
	public function getInstance() {
		return new MailNotification();
	}
}
