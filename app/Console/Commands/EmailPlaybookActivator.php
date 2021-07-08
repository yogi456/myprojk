<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\EmailPlaybook\EmailPlaybook;
use App\Model\EmailPlaybook\SubEmailPlaybook;
use App\Model\SmsPlaybook\SmsContact;
use App\Http\Controllers\Playbook\MessageController;
use Log;
use App\Helpers\DateTimeHelper;

class EmailPlaybookActivator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:playbook-activator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all scheduled email playbooks and activate them';

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
        $emailScheduledPlaybook = EmailPlaybook::where('msgscheduled', 'Scheduled')->get();

        foreach ($emailScheduledPlaybook as $key => $playbook) {
            if ((int)$playbook->category_name > 0) {
                
                $format = 'Y-m-d H:i';
                $date_scheduled = $playbook->date_time . ' ' . $playbook->att;
                $current_date = $playbook->time_zone_id ? DateTimeHelper::GetDateTimeWithZone($playbook->time_zone_id, date($format), $format)->date : date($format);
                // get the datetime formatted in 
                $scheduled_date = date($format, strtotime($date_scheduled));
                // $scheduled_date = $playbook->time_zone_id ? DateTimeHelper::GetDateTimeWithZone($playbook->time_zone_id, $date_scheduled, $format)->date : date($format, strtotime($date_scheduled));
                //echo print_r($playbook->toArray(),true);
                
                // Log::info('original = ' . $date_scheduled . PHP_EOL);
                // Log::info('current date '.$current_date . ' scheduled date ' . $scheduled_date . PHP_EOL) ;
                if ($current_date > $scheduled_date) {
                    $playbook->msgscheduled = "Activated";
                    $playbook->playbook_activated_at = strtotime($scheduled_date);
                    $playbook->save();
                    $this->queueEmailMsg($playbook);
                    
                    // Log::info('Activated ' .$playbook->playbook_name);
                } else {
                    // Log::info('Cannot Activate ' .$playbook->playbook_name);
                }
            }
        }
    }
    /**
     * playbook is activated now queue the email to the contacts
     */
    protected function queueEmailMsg($playbook) {
        $smsContact = SmsContact::where(['playbook_id'=> $playbook->id, 'playbook_type' => 'EMAIL'])->first();
        $messageController = new MessageController();

        $messageController->prepareMessageForQueue($playbook->user_id, $playbook->id, json_decode($smsContact->contact_ids, true), $playbook->playbook_activated_at);

        // $subEmailPlaybook = SubEmailPlaybook::where([
        //     'playbook_email_id'     => $playbook->id,
        //     // 'message_level'    => $playbook->message_sent_level
        //     ])->get();
            
        // if ($subEmailPlaybook) {
        //     // get all contact details whose created date is less than playbook activated date
        //     $smsContact = SmsContact::where(['playbook_id'=> $playbook->id, 'playbook_type' => 'EMAIL'])->first();
        //     $contactDetails = $messageController->getContact(json_decode($smsContact->contact_ids, true));

        //     $playbook_activated_at = $playbook->playbook_activated_at;
        //     $format = 'Y-m-d H:i';
            
        //     foreach ($subEmailPlaybook as $value) {
        //         if ($value->message_level > 0) {
        //             // send next message on next schedule days
        //             if ($value->sendemailafter) {
        //                 $date = date($format, $playbook_activated_at);
        //                 $last_message_sent_at = strtotime($date."+ $value->sendemailafter days");
        //             }
                    
        //         }else {
        //             // set message time for email
        //             if(($value->message_level == 0) && ($playbook->include_email_1 == 1) && $playbook->adTime)
        //             {               
        //                 $date = date('Y-m-d', $playbook_activated_at);
        //                 $playbook_activated_at = strtotime($date.' '.$playbook->adTime);
        //             }
        //         }
        //         // skip message on weekend
        //         if($playbook->sendingon_weekdays_only > 0)
        //             {
        //                 $addDays = $messageController->isWeekend($playbook_activated_at);
        //                 if($addDays > 0){
        //                     $date = date($format, $playbook_activated_at);
        //                     $playbook_activated_at = strtotime($date."+ $addDays days");
        //                 }
        //             }
                
        //         // add message on queue
        //         $messageController->addMessageOnQueue($playbook->user_id, $contactDetails, $subEmailPlaybook, $playbook_activated_at);
        //     }           
        // }
    }
}
