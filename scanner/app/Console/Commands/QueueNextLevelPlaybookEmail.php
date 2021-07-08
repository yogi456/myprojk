<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\EmailPlaybook\EmailPlaybook;
use App\Model\EmailPlaybook\SubEmailPlaybook;
use App\Model\SmsPlaybook\SmsContact;
use App\Http\Controllers\Playbook\MessageController;
use App\Model\Segment\SegmentContactsModel;
use Log;

class QueueNextLevelPlaybookEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:next-level-playbook-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'queue next level playbook email message';

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
        $currentTime = time();
        $emailPlaybook = EmailPlaybook::where('msgscheduled', 'Activated')
                                        ->where('message_total_level', '>', 0)
                                        ->where('last_message_sent_at', '<=', $currentTime)
                                        ->get();
        if($emailPlaybook){
            foreach ($emailPlaybook as $key => $playbook) {
                // $this->queueEmailMsg($playbook);
            }
        }
    }

    /**
     * queue playbook next level email message for  the segment contacts
     */
    protected function queueEmailMsg($playbook) {
        // $currentTime = time();
        $subEmailPlaybook = SubEmailPlaybook::where([
            'playbook_email_id'     => $playbook->id,
            'message_level'    => $playbook->message_sent_level
            ])
            // ->where('message_sent_at', '<=', $currentTime)
            ->first();
        
        $messageController = new MessageController();

        if ($subEmailPlaybook && isset($playbook->last_message_sent_at)) {
            $smsContact = SmsContact::where(['playbook_id'=> $playbook->id, 'playbook_type' => 'EMAIL'])->first();
            
            $last_message_sent_at = $playbook->last_message_sent_at;
            $format = 'Y-m-d H:i';
            // send next message on next schedule days
            if ($subEmailPlaybook->sendemailafter) {
                $date = date($format, $last_message_sent_at);
                $last_message_sent_at = strtotime($date."+ $subEmailPlaybook->sendemailafter days");
            }

            // skip message on weekend
            if($playbook->sendingon_weekdays_only > 0)
            {
                $addDays = $messageController->isWeekend($last_message_sent_at);
                if($addDays > 0){
                    $date = date($format, $last_message_sent_at);
                    $last_message_sent_at = strtotime($date."+ $addDays days");
                }
            }

            // set message time 
            if($playbook->adTime)
            {               
                $date = date('Y-m-d', $last_message_sent_at);
                $last_message_sent_at = strtotime($date.' '.$playbook->adTime);
            }

            // get all contact ids whose created date is less than playbook activated date
            // remove these ids from actual contacts ids
            // $contact_ids = json_decode($smsContact->contact_ids, true);
            // $playbook_activated_at = $playbook->playbook_activated_at;
            // $playbook_activated_at = date('Y-m-d H:i:s', $playbook_activated_at);
            // $playbookContactDetails = SegmentContactsModel::select('subscriber_invitee_id')
            //                                             ->whereIn('subscriber_invitee_id', $contact_ids)
            //                                             ->where('created_at', '>=', $playbook_activated_at)
            //                                             ->get();
            // $new_contact_ids = []; 
            
            // if (count($playbookContactDetails) > 0) {
            //     // Log::info('segment new contact added '.print_r($playbookContactDetails, true));
            //     foreach ($playbookContactDetails as  $value) {
            //         // Log::info('value in loop '.$value);
            //         $new_contact_ids[] = $value->subscriber_invitee_id;
            //         if (in_array($value->subscriber_invitee_id, $contact_ids)) {
            //             if (($key = array_search($value->subscriber_invitee_id, $contact_ids)) !== false) {
            //                 unset($contact_ids[$key]);
            //               }
            //               $contact_ids = array_values($contact_ids);
            //         }
            //     }
            // }

            // get all contact details
            $contactDetails = $messageController->getContact($contact_ids);
            // add message on queue
            if ($contactDetails) {
            $messageController->addMessageOnQueue($playbook->user_id, $contactDetails, $subEmailPlaybook, $last_message_sent_at);
            }
        }
        
    }
}
