<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Model\Social\SocialUser;
use App\Model\Social\PlaybookEmailQueue;
use App\Model\SmsPlaybook\SmsContact;
use Log;
use App\Http\Controllers\Social\Google\ApiController;

class SendPlaybookEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playbook:sent-playbook-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message whose status in_queue';

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
        $current_time = time();
        $playbookEmailQueue = PlaybookEmailQueue::where('message_status', 'in_queue')
            ->where('email_send_on', '<=', $current_time)
            // ->take(50)
            ->get();
        // Log::info($current_time);
        $apiController = new ApiController();
        foreach ($playbookEmailQueue as $key => $playbookEmail) {
            $smsContact = SmsContact::where(['playbook_id' => $playbookEmail->playbook_id, 'playbook_type' => 'EMAIL'])
                ->whereRaw('JSON_CONTAINS(contact_ids, \'[' . $playbookEmail->contact_id . ']\')')
                ->first();
            // Log::info($smsContact);
            if ($smsContact) {
                // $user = User::find($playbookEmail->user_id);
                // if ($user->email_message_sent_count < 450)
                $apiController->sendPlaybookMsgViaGmail($playbookEmail);
            } else {
                PlaybookEmailQueue::find($playbookEmail->id)->update([
                    'send_status_code' =>   403,
                    'retry_count '     => ($playbookEmail->retry_count + 1),
                    'message_status'   =>   'not_in_segment'
                ]);
            }
        }
    }
}
