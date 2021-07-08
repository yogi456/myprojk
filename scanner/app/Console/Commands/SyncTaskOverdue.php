<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Utility;
use App\Model\Taks;

class SyncTaskOverdue extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync-task-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update tasks status of overdue for all subscribers.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $currentDate = Utility::getUTCCurrentDate();
        Taks::where('due_date', '<', $currentDate)->where('status', '=', 1)->update([
            'status' => 3
        ]);
        $this->info('successfully task due date updated.');
    }

}
