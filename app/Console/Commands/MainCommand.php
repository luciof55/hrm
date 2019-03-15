<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;

class MainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'main:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update software version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Schedule $schedule)
    {
		Log::info('Main Command. Handle--------------------');
        Log::info('--------------------Main Command. Handle');
    }
}
