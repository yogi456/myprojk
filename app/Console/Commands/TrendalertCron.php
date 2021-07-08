<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TrendController;

///use Illuminate\Support\Facades\Log;

class TrendalertCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:alert-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert trend data according trend alert data';

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
    public function handle() {
		
        // get all user from db and get message details from gmail
        $obj = new TrendController();
		$obj->addNewAlertDataCron();
	
        ///$this->info('successfully trend alert');
    }
}
