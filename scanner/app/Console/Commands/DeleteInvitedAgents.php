<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteInvitedAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delete-invited-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete invited agents if didnt accept invitation with in a week ';

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
    public function handle()
    {
        $this->info(Carbon::now()->subDays(7));
        $subscriber_invitees = DB::table('subscriber_invitees')->where(['table_type' => 1, 'user_id' => 0, 'is_activated' => 0])->whereDate('created_at','<=', Carbon::now()->subDays(7))->delete();
    }
}
