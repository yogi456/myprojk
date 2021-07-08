<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshEmailMessageSentCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playbook:refresh-email-message-sent-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh email message sent count for all users';

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
        $affected = DB::table('users')->where('email_message_sent_count', '>', 0)->update(array('email_message_sent_count' => 0));
        $affected_domain = DB::table('subscriber_website')->where('company_email_sent_count', '>', 0)->update(array('company_email_sent_count' => 0));
    }
}
