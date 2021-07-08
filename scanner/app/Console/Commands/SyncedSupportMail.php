<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ImapHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Model\Setting\SubscriberForwardBccDetail;
use App\Model\Support\SupportTicket;
use App\Model\Support\ReplyEmail;
use App\Model\Support\TicketReplyEmail;
use App\Model\Support\ReplyEmailAttachment;
use App\Model\SubscriberInvitees;
use App\Helpers\SupportEmailHelper;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Support\SupportTicketController;
use DB;
use App\Model\Chat\Thread;
use App\Helpers\CustomLog;
use App\Http\Controllers\Social\Google\ApiController;

class SyncedSupportMail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:syncedEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The console command description.
     *
     * @var string
     */
    private $attachments_dir = 'public/attachments/';

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
     * @return mixed  uF]3$]g2DDlP
     */
    public function handle()
    {

        //DB::enableQueryLog();
        $supportDetails_all = SubscriberForwardBccDetail::where('mail_type', 'support')->get();
        $SupportTicketController = new SupportTicketController();
        foreach ($supportDetails_all as $key_sub => $supportDetails) {

            $connection_to = '{' . $supportDetails->incoming_host . ':' . $supportDetails->imap_port . '/imap/ssl}INBOX';
            $mail_username = $supportDetails->mail_username;
            $mail_password = Crypt::decryptString($supportDetails->mail_password);
            // Log::info('connect - ' . $connection_to . ' username - ' . $mail_username . ' pwd - ' . $mail_password);
            $imap = new ImapHelper();
            $connection_result = $imap->connect($connection_to, $mail_username, $mail_password);
            if ($connection_result !== true) {
                echo $connection_result; //Error message!
                exit;
            }
            $messages = $imap->setLimit(10)->getMessages('text', 'desc'); // Return array of messages. Second parameter is for type of sort desc|asc
            // Log::info($messages);

            if ($messages) {
                foreach ($messages as $mail) {
                    //  Log::info($mail);
                    $cc_contacts_send = array();
                    ///check if email already consider
                    $checkTicketData = SupportTicket::where('incomingMsgId', $mail['message_id'])->first();
                    if (!$checkTicketData) {
                        $cc = '';
                        foreach ($mail['cc'] as $key => $value) {
                            if (isset($value['name'])) {
                                $cc .= ' ' . $value['name'] . ' ' . $value['address'];

                                $cc_contacts_send[] = array(
                                    array('address' => $value['address'], 'name' => $value['name'])
                                );
                            }
                        }

                        $to_address = '';
                        $to_name = '';
                        foreach ($mail['to'] as $key => $from) {
                            $to_address .= ',' . $from['address'];
                            if (!empty($from['name'])) {
                                $to_name .= ',' . $from['name'];
                            }
                        }

                        //save reply emails 
                        // check reply by references else by subject and make sure ticket status should not be closed
                        $ticket_id = '';
                        if ($mail['references'] && $mail['references'] != 0) {  ///check ticket by reference
                            $references = explode(' ', $mail['references']);
                            $ticket_id = (SupportTicket::whereIn('emailMsgId', $references)->first()) ? SupportTicket::whereIn('emailMsgId',  $references)->first()->id : '';
                        } else {
                            if (strpos($mail['subject'], 'Re') !== false) {  ///check ticket by re in subject
                                ////check subject 
                                $sub = explode(": ", $mail['subject']);
                                if (isset($sub[1])) {
                                    $ticket_id = (SupportTicket::where('subject', $sub[1])->first()) ? SupportTicket::where('subject', $sub[1])->first()->id : '';
                                }
                            }
                        }
                        // CustomLog::LOG('support mail info', $mail);
                        // checkif contact has already an open ticket 
                        $subscriber_invitees = DB::table('subscriber_invitees')->where(['email' => $mail['from'][0]['address']])->where('subscriber_id', $supportDetails->subscriber_id)->where('table_type', 2)->first();
                        if ($subscriber_invitees) {
                            $contact_id = $subscriber_invitees->id;
                            // $OldTicket = SupportTicket::where('contact_id', $contactId)->where('status', '!=', '3')->orderBy('id', 'desc')->first();
                            // if ($OldTicket) {
                            //     $ticket_id = $OldTicket->id;
                            // }
                        }

                        // CustomLog::LOG('support mail contact id ', $contact_id);
                        //if ticket id exist and ticket is not closed then add reply
                        if ($ticket_id && SupportTicket::where('contact_id', $contact_id)->where('status', '!=', '3')->orderBy('id', 'desc')->exists()) {
                            // $subscriber_invitees = DB::table('subscriber_invitees')->where(['email' => $mail['from'][0]['address']])->where('subscriber_id', $supportDetails->subscriber_id)->where('table_type', 2)->pluck('id');
                            // $contact_id = isset($subscriber_invitees[0]) ? $subscriber_invitees[0] : '';

                            $msgBodyFilter = $SupportTicketController->strip_reply_string_from_email($mail['message']);
                            $email_array = [
                                'ticket_id'      => $ticket_id,
                                'customer_id'    => $contact_id,
                                'subject'        => $mail['subject'],
                                'message_id'     => $mail['message_id'],
                                'message_number' => $mail['message_number'],
                                'uid'            => $mail['uid'],
                                'references'     => $mail['references'],
                                'in_reply_to'    => $mail['in_reply_to'],
                                'message'        => $msgBodyFilter[0],
                                'body_reply'     => isset($msgBodyFilter[1]) ? $msgBodyFilter[1] : '',
                                'to_address'     => $to_address,
                                'to_name'        => $to_name,
                                'from_address'   => $mail['from'][0]['address'],
                                'from_name'      => $mail['from'][0]['name'],
                            ];


                            $checkmsgid = TicketReplyEmail::where('message_id', $mail['message_id'])->first();
                            if (!$checkmsgid) {
                                $saveEmail = TicketReplyEmail::create($email_array);
                                $supportTicketData = SupportTicket::where('id', $email_array['ticket_id'])->first();
                                $inboxReplyData = [
                                    'subscriber_id'     => $supportTicketData->subscriber_id,
                                    'ticket_id'         => $supportTicketData->ticket_id,
                                    'emailMsgId'        => $saveEmail->message_id,
                                    'contact_id'        => $supportTicketData->contact_id,
                                    'department_id'     => $supportTicketData->department_id,
                                    'subject'           => $saveEmail->subject,
                                    'auto_email_body'   => '',
                                    'priority'          => '',
                                    'discription'       => '',
                                    'category'          => '',
                                    'assignee'          => 1, //Auto
                                    'type'              => 2, //Auto By Email
                                    'routingData'       => ['assignee_id' => 0, 'teammate_ids' => []],
                                    'emailBody'         => $saveEmail->message,
                                    'attachment'        => [],
                                    'from_address'      => $saveEmail->from_address,
                                    'to_address'        => $saveEmail->to_address,
                                    'to_customer_email' => '',
                                    'cc_email'          => '',
                                ];
                                if ($saveEmail) {

                                    foreach ($mail['attachments'] as $key_a => $attachment) {
                                        $storage_path = 'attachment' . '/' . 'Email' . '/' . 'sub_' . $supportDetails->subscriber_id . '/' . date('Y_m') . '/in/';
                                        $this->saveAttachment($supportDetails->subscriber_id, $attachment, $storage_path);
                                        $arraysAttach = ['replyEmail_id' => $saveEmail->id, 'image' => $storage_path . $attachment, 'type' => 1];
                                        $inboxReplyData['attachment'][] = $arraysAttach;
                                        ReplyEmailAttachment::create($arraysAttach);
                                    }
                                    $unreadSet = $imap->markMessageSeen($mail['message_number'], $mail['uid']);
                                }
                                // Log::info('ticket inboxReplyData data');
                                // Log::info($inboxReplyData);

                                $threadModel = new Thread();
                                $threadModel->incomingTicketmessageConversation($inboxReplyData);
                            }
                            //status change to open

                            $SupportTicketController->updateStatusTicket($ticket_id, 1);
                        } else {
                            //check subscriber if found then continue
                            if ($subscriber = $this->getSubscriber($mail['to'])) {
                                //check subscriber invitee if not create new
                                $apiController = new ApiController();
                                $contact_id = $apiController->getContactId($subscriber->id, $subscriber->parent_id, $mail['from'][0]['address'], $mail['from'][0]['address'], 'Ticket');
                                $subscriber_invitees = SubscriberInvitees::find($contact_id);
                                // if ($subscriber_invitees = SubscriberInvitees::where(['subscriber_id' => $subscriber->parent_id, 'table_type' => 2, 'is_deleted' => true, 'email' => $mail['from'][0]['address']])->first()) {
                                //     $subscriber_invitees->update(['is_deleted' => false]);
                                // } else {
                                //     $subscriber_invitees = DB::table('subscriber_invitees')->where(['email' => $mail['from'][0]['address']])->where('subscriber_id', $supportDetails->subscriber_id)->where('table_type', 2)->first();
                                //     if (!$subscriber_invitees) {
                                //         $sub_array = [
                                //             'subscriber_id' => $subscriber->parent_id,
                                //             'agentname'     => $mail['from'][0]['address'],
                                //             'displayname'   => $mail['from'][0]['name'],
                                //             'table_type'    => 2,
                                //             'email'         => $mail['from'][0]['address'],
                                //         ];
                                //         $subscriber_invitees = SubscriberInvitees::create($sub_array);
                                //     }
                                // }

                                $checkTicketData = SupportTicket::where('incomingMsgId', $mail['message_id'])->first();
                                if (!$checkTicketData && $EmailContent = ReplyEmail::where(['subscriber_id' => $supportDetails->subscriber_id, 'is_forwarding_address' => true])->first()) {
                                    if (!$EmailContent) {
                                        $EmailContent['email_content'] = 'Ticket id : [TICKET_ID]';
                                    } else {
                                        $EmailContent = $EmailContent->toArray();
                                    }
                                    $newTicketId = uniqid('SUPPORT');

                                    $token = array(
                                        'TICKET_ID' => $newTicketId,
                                    );
                                    $pattern = '[%s]';
                                    foreach ($token as $key => $val) {
                                        $varMap[sprintf($pattern, $key)] = $val;
                                    }
                                    $emailContent = strtr($EmailContent['email_content'], $varMap);
                                    $newTicket = SupportTicket::create([
                                        'user_id'           => $subscriber->id,
                                        'subscriber_id'     => $subscriber->parent_id,
                                        'subject'           => $mail['subject'],
                                        'discription'       => $mail['message'],
                                        'ticket_message'    => $emailContent,
                                        'assignee'          => 1,
                                        'ticket_id'         => $newTicketId,
                                        /* 'priority' =>1,
                                              'category' => 1, */
                                        'contact_id'        => $contact_id,
                                        'status'            => 1,
                                        'emailBody'         => $mail['message'],
                                        'cc_email'          => $cc,
                                        'from_address'      => $mail['from'][0]['address'],
                                        'to_address'        => str_replace(",", "", $to_address),
                                        'to_customer_email' => $subscriber_invitees->email,
                                        'incomingMsgId'     => $mail['message_id']
                                    ]);

                                    if ($newTicket) {
                                        $attachment_image = array();
                                        foreach ($mail['attachments'] as $key_a => $attachment) {
                                            $storage_path = 'attachment' . '/' . 'Email' . '/' . 'sub_' . $supportDetails->subscriber_id . '/' . date('Y_m') . '/in/';
                                            $this->saveAttachment($supportDetails->subscriber_id, $attachment, $storage_path);
                                            $arraysAttach = ['replyEmail_id' => $newTicket->id, 'image' => $storage_path . $attachment, 'type' => 2];
                                            $attachment_image[] = url('/') . '/' . $storage_path . $attachment;
                                            ReplyEmailAttachment::create($arraysAttach);
                                        }
                                        $unreadSet = $imap->markMessageSeen($mail['message_number'], $mail['uid']);

                                        // send email to contact
                                        $contact_email = $subscriber_invitees->email;

                                        $supportDetail = SubscriberForwardBccDetail::where(['subscriber_id' => $subscriber->parent_id, 'mail_type' => 'support'])->first();

                                        if ($contact_email && $EmailContent) {
                                            $attachments = array();
                                            foreach ($mail['attachments'] as $key => $value) {
                                                $attachments[] = array('file_path' => 'attachments/Email/sub_' . $subscriber->parent_id . '/' . date('Y_m') . '/in/' . $value, 'file_name' => $value);
                                            }

                                            $header_design_json = json_decode($EmailContent['header_design_json'], true);

                                            $messageReplyContent = [
                                                array('name' => $mail['from'][0]['address'], 'time' => date("d-m-Y h:i:s a", strtotime($mail['date'])), 'message' => $mail['message']),
                                                array('name' => $subscriber->name, 'time' => date("d-m-Y h:i:s a", time()), 'message' => $emailContent),
                                            ];

                                            $email_content = $SupportTicketController->designEmailContent($header_design_json, $messageReplyContent);
                                            // CustomLog::LOG('email_content from command', $email_content);
                                            $supportEmailHelper = new SupportEmailHelper();
                                            $email_id = $supportEmailHelper->sendSupportMail($supportDetail, [array('address' => $contact_email)], $mail['subject'], $email_content, $attachments, $cc_contacts_send);
                                            // CustomLog::LOG('email_id from command', $email_id);
                                            $updatemsgid = SupportTicket::where('id', $newTicket->id)->update(['emailMsgId' => $email_id]);
                                        }

                                        ///get assignees
                                        $thread = array(
                                            'subscriber_id'   => $subscriber->parent_id,
                                            'visitor_contact' => $subscriber_invitees->cell_phone,
                                            'contact_id'      => $subscriber_invitees->id,
                                            'text'            => $mail['message'],
                                            'chat_type'       => '4',
                                            'channel'         => '4',
                                            'ticket_id'       => $newTicket->id
                                        );

                                        $assigneeData = $SupportTicketController->checkForRouting($thread);



                                        ///Remaining fields 
                                        $newTicket->type = 2; //1 for manual
                                        $newTicket->auto_email_body = $emailContent;
                                        $newTicket->routingData = $assigneeData; // array('assignee_id'=> 1,'teammate_ids'=>array('2','3'));
                                        ///for auto 
                                        $newTicket->attachment = $attachment_image;
                                        //Log::info('ticket Already there  ' . $mail['message_id']);
                                    }

                                    //  Log::info($newTicket);
                                    ///Ticket send to thread 
                                    // $newTicket has all the data related to ticket

                                    $threadModel = new Thread();
                                    $threadModel->incomingTicketmessageConversation($newTicket);
                                } else {
                                    //Log::info('New Ticket generation off ');
                                }
                            }
                        }
                        ///end save reply emails 

                        foreach ($mail['to'] as $key => $from) {
                            if (isset($from['address']) && $mail_username == $from['address']) {
                                $to_address = $from['address'];
                                // Log::info($to_address);
                                $contact_email = $mail['from'][0]['address'];
                                $subscriber_invitees = DB::table('subscriber_invitees')->where(['subscriber_id' => $supportDetails->subscriber_id, 'email' => $contact_email, 'table_type' => 2])->pluck('id');
                                $contact_id = isset($subscriber_invitees[0]) ? $subscriber_invitees[0] : '';

                                if ($teamMemberDetails = SupportTicket::where(['contact_id' => $contact_id])->first()) {
                                    $imap->markMessageSeen($mail['message_number'], $mail['uid']);
                                } else {
                                    $deleted = $imap->deleteMessage($mail['message_number'], $mail['uid']);
                                    // Log::info('mark delete ' . $deleted . ' message_id' . $mail->message_id);
                                }
                            }
                        }
                    }
                }
            }
        }

        // Log::info(DB::getQueryLog());
        $this->info('successfully synced message from support email');
    }

    public function saveAttachment($subscriber_id, $file, $storage_path)
    {
        $source_file_path = base_path() . '/' . $this->attachments_dir . $file;
        // if (file_exists($source_file_path))

        $destination = public_path() . '/' . $storage_path . $file;
        // Log::info('source - ' . $source_file_path . 'destination - ' . $storage_path);
        $directoryPath = public_path() . '/' . $storage_path;
        //check if the directory exists
        if (!File::isDirectory($directoryPath)) {
            //make the directory because it doesn't exists
            File::makeDirectory($directoryPath, 0777, true);
            // File::makeDirectory(public_path() . '/' . $storage_path, 0777, true);
        }
        File::move($source_file_path, $destination);
        return true;
    }

    //function to check subscriber             
    public function getSubscriber($array)
    {
        foreach ($array as $key => $from) {
            $get = User::select('users.*', 'subscriber_forward_bcc_details.mail_username')
                ->where('subscriber_forward_bcc_details.mail_username', $from['address'])
                ->join('subscriber_forward_bcc_details', 'subscriber_forward_bcc_details.subscriber_id', 'users.id')
                ->first();
            if ($get) {
                return $get;
            }
        }
        return false;
    }
}
