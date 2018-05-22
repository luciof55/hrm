<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BusinessRecordExport implements FromView
{
	protected $command;
	
	public function __construct($command) {
        $this->command = $command;
    }
	
	public function view(): View {
        return view('administration.businessrecords.export', [
            'command' => $this->command
        ]);
    }
}