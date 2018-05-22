<?php

namespace App\Mail;

use App\Model\Administration\BusinessRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BusinessRecordGenerated extends Mailable
{
    use Queueable, SerializesModels;
	
	public $businessRecord;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(App\Model\Administration\BusinessRecord $businessRecord)
    {
        $this->businessRecord = $businessRecord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
        return $this->markdown('emails.businessrecords.geneated');
    }
}
