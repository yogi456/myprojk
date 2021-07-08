<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Social\Google\AuthController;
use App\Http\Controllers\Social\Google\ApiController;
use App\Http\Controllers\Playbook\MessageController;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\User;
use App\Model\Social\SocialUser;
use App\Model\Social\GmailMessage;
use App\Model\Social\GmailMessageDetail;
use App\Model\Social\GmailAttachment;
use App\Model\Social\GmailMessageContact;
use App\Model\SubscriberInvitees;
use App\Model\EmailPlaybook\EmailPlaybook;
use App\Model\EmailPlaybook\PlabookAutoUnenrollOnReply;
use App\Model\Social\PlaybookEmailQueue;
use Illuminate\Support\Facades\Log;

class GetGmailMessageDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:get-message-details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get gmail message details using gmail google api';

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
        // get all user from db and get message details from gmail
        $authController = new AuthController();
        $apiController = new ApiController();

        $gmailMessage = GmailMessage::where('fetched', false)->get();
        if (count($gmailMessage) > 0) {
            foreach ($gmailMessage as $key => $message) {
                // $token = $authController->refreshAccessToken($message->user_id);
                // Log::info($token);
                $getGmailData = $this->getGmailMessageDetails($message->id, $message->gmail_message_id, $message->user_id);
                // Log::info($getGmailData);
            }
        }
        $this->info(count($gmailMessage) . ' messages details fetched successfully from gmail');
    }

    /**
     * get emails from gmail
     *
     * show email message details
     */
    public function getGmailMessageDetails($message_id, $gmail_message_id, $user_id)
    {
        $to_email_array = [];
        $from_email_array = [];
        $cc_email_array = [];
        $bcc_email_array = [];
        try {
            $gmailApiUrl = 'https://www.googleapis.com/gmail/v1/';
            $contactPersonId = 0;
            $user = User::where('id', $user_id)->first();
            if ($user && GmailMessageDetail::where('message_id', $message_id)->exists()) {
                $emailDetails = GmailMessageDetail::where('message_id', $message_id)->first();
            } else {
                $client = new Client(); //GuzzleHttp\Client
                $socialUser = SocialUser::where(['user_id' => $user['id'], 'subscriber_id' => $user['parent_id'], 'social_type' => 'google'])->first();
                $url = $gmailApiUrl . 'users/' . $socialUser->social_id . '/messages/' . $gmail_message_id;
                $api_response = $client->get($url,  [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $socialUser->access_token,
                        'Accept'        => 'application/json',
                    ],
                ]);

                $getMessage = $api_response->getBody()->getContents();
                $data = json_decode($getMessage, true);

                // file_put_contents('gmail_message_details_reply.log', PHP_EOL . print_r( $data,true) . PHP_EOL,FILE_APPEND);

                $emailDetails = new GmailMessageDetail();
                $emailDetails->user_id = $user->id;
                $emailDetails->subscriber_id = $user->parent_id;
                $emailDetails->message_id = $message_id;
                $emailDetails->gmail_message_id = $gmail_message_id;
                $emailDetails->message_accessibility = $socialUser->inbox_accessibility;

                $threadId = $data["threadId"];
                $messageHeader = $data["payload"]["headers"];

                $messageController = new MessageController();
                // Log::info($data['id']);
                $FOUND_BODY = $messageController->getMessageBody($data);
                $emailDetails->snippet = $FOUND_BODY ? $FOUND_BODY : $data['snippet'];

                if ($messageHeader) {
                    foreach ($messageHeader as $key => $value) {
                        switch ($value['name']) {
                            case 'To':
                                $emailDetails->to = $value['value'];
                                break;
                            case 'From':
                                $emailDetails->from = $value['value'];
                                break;
                            case 'Cc':
                                $emailDetails->cc = $value['value'];
                                break;
                            case 'Bcc':
                                $emailDetails->bcc = $value['value'];
                                break;
                            case 'Subject':
                                $emailDetails->subject = $value['value'];
                                break;
                            case 'Date':
                                $emailDetails->date = $value['value'];
                                break;
                            case 'Content-type':
                                $emailDetails->content_type = $value['value'];
                                break;
                            case 'Return-Path':
                                $return_path = $value['value'];
                                break;
                            case 'X-Failed-Recipients':
                                $x_failed_recipients = $value['value'];
                                break;
                            case 'Message-Id':
                                $emailDetails->reply_message_id = $value['value'];
                                break;
                            default:
                                // code...
                                break;
                        }
                    }
                }
                // if $x_failed_recipients found then write bounce functionality
                if (isset($x_failed_recipients)) {
                    // Log::info('x_failed_recipients found is ' . $x_failed_recipients . ' with threadId is ' . $threadId);
                    $playbookEmailQueue = PlaybookEmailQueue::where(['email_to' => $x_failed_recipients, 'thread_id' => $threadId])->first();
                    if ($playbookEmailQueue) {
                        $playbookEmailQueue->message_status = 'bounce';
                        $playbookEmailQueue->save();
                        // Log::info('playbook Id ' . $playbookEmailQueue->playbook_id);
                        EmailPlaybook::find($playbookEmailQueue->playbook_id)->increment('bounce', 1);
                        EmailPlaybook::find($playbookEmailQueue->playbook_id)->decrement('sent', 1);
                    }
                }
                // $emailDetails->contact_id = $contactPersonId;
                $emailDetails->save();

                // get contact id if exist
                if (isset($return_path)) {
                    // check for autoauenrollonreply
                    $this->autoauenrollonreply($threadId, $return_path);
                }
                // add from contact in db
                // add to contact in db
                $from_emails = explode(',', $emailDetails->from);
                foreach ($from_emails as $value) {
                    $from_email_array[] = $this->extractEmail($value);
                    $contactPersonId = $this->getContactId($message_id, $user->parent_id, $emailDetails->from, $user->id);
                    GmailMessageContact::create([
                        'gmail_message_details_id' => $emailDetails->id,
                        'contact_id'               => $contactPersonId,
                        'gmail_origin'             => 'from',
                        'table_mapped'             => 'gmail_message_details'
                    ]);
                }

                // add to contact in db
                $to_emails = explode(',', $emailDetails->to);
                foreach ($to_emails as $value) {
                    $to_email_array[] = $this->extractEmail($value);
                    $contactPersonId = $this->getContactId($message_id, $user->parent_id, $value, $user->id);
                    GmailMessageContact::create([
                        'gmail_message_details_id' => $emailDetails->id,
                        'contact_id'               => $contactPersonId,
                        'gmail_origin'             => 'to',
                        'table_mapped'             => 'gmail_message_details'
                    ]);
                }

                // add cc contact in db
                if ($emailDetails->cc) {
                    // Log::info('cc found ' . $emailDetails->cc);
                    $emails = explode(',', $emailDetails->cc);
                    foreach ($emails as $value) {
                        $cc_email_array[] = $this->extractEmail($value);
                        $contactPersonId = $this->getContactId($message_id, $user->parent_id, $value, $user->id);
                        GmailMessageContact::create([
                            'gmail_message_details_id' => $emailDetails->id,
                            'contact_id'               => $contactPersonId,
                            'gmail_origin'             => 'cc',
                            'table_mapped'             => 'gmail_message_details'
                        ]);
                    }
                }
                if ($emailDetails->bcc) {
                    $bcc_emails = explode(',', $emailDetails->bcc);
                    foreach ($bcc_emails as $value) {
                        $bcc_email_array[] = $this->extractEmail($value);
                        $contactPersonId = $this->getContactId($message_id, $user->parent_id, $value, $user->id);
                        GmailMessageContact::create([
                            'gmail_message_details_id' => $emailDetails->id,
                            'contact_id'               => $contactPersonId,
                            'gmail_origin'             => 'bcc',
                            'table_mapped'             => 'gmail_message_details'
                        ]);
                    }
                }
                $emailDetails->update(['to' => json_encode($to_email_array), 'from' => json_encode($from_email_array), 'cc' => json_encode($cc_email_array), 'bcc' => json_encode($bcc_email_array)]);
                // update message table to fetched = true
                GmailMessage::where('id', $message_id)->update(['contact_id' => $contactPersonId, 'fetched' => true]);

                // save attachment
                $mimeType = $data["payload"]["mimeType"];
                if ($mimeType == 'multipart/mixed') {
                    $parts = $data["payload"]['parts'];
                    if (count($parts) > 0) {
                        foreach ($parts as $key => $value) {
                            if ($value['filename']) {
                                $attachment = new GmailAttachment();
                                $attachment->user_id = $user->id;
                                $attachment->subscriber_id = $user->parent_id;
                                $attachment->contact_id = $contactPersonId;
                                $attachment->message_id = $message_id;
                                $attachment->gmail_message_id = $gmail_message_id;
                                $attachment->part_id = $value['partId'];
                                $attachment->mime_type = $value['mimeType'];
                                $attachment->file_name = $value['filename'];
                                $attachment->attachment_id = $value['body']['attachmentId'];
                                $attachment->save();
                            }
                        }
                    }
                }
            }
            $response = array(
                'code'  =>  200,
                'status' => 'success',
                'response' => $emailDetails
            );
            return response()->json($response);
            // } catch (GuzzleException $e) {
            //     // Log::info($e);
            //     $response = $e->getResponse();
            //     $code = $response->getStatusCode();
            //     $responseBodyAsString = $response->getBody()->getContents();
            //     $responseData = json_decode($responseBodyAsString, true);
            //     // $error = $responseData["error"];

            //     if ($code == 401) {
            //         $gmailAuthController = new AuthController();
            //         $gmailAuthController->refreshAccessToken($user_id);
            //         $this->getGmailMessageDetails($message_id, $gmail_message_id, $user_id);
            //     }

            //     $response = array(
            //         'code'  =>  $code,
            //         'status' => 'error',
            //         'response' => $e->getMessage()
            //     );
            //     return response()->json($response);
        } catch (\Exception $e) {
            // Log::info($e);
            if ($e->getCode() == 401) {
                $gmailAuthController = new AuthController();
                $gmailAuthController->refreshAccessToken($user_id);
                $this->getGmailMessageDetails($message_id, $gmail_message_id, $user_id);
            }
            $response = array(
                'code'  =>  $e->getCode(),
                'status' => 'error',
                'response' => $e->getMessage()
            );
            return response()->json($response);
        }
    }
    // get contact id if exist
    public function getContactId($message_id, $subscriber_id, $contactPersonEmailId, $user_id)
    {
        $contact_person_email = $this->getInbetweenStrings('<', '>', $contactPersonEmailId);
        $name  = $contact_person_email;
        $emailWIthName = explode('<', $contactPersonEmailId);
        // Log::info(print_r($emailWIthName, true));
        if (isset($emailWIthName[0])) {
            $name  = $emailWIthName[0];
        }

        // Log::info('message Id ' . $message_id . ' parent id ' . $subscriber_id . ' email ' . $contactPersonEmailId);
        // email is bounce then get X-Failed-Recipients
        if ($contact_person_email == 'mailer-daemon@googlemail.com') {
            return 0;
        }
        $subscriberInvitees = SubscriberInvitees::where([
            'subscriber_id' => $subscriber_id,
            'email' => $contact_person_email,
            'table_type'    => 2
        ])->first();
        if ($subscriberInvitees) {
            // GmailMessage::where('id', $message_id)->update(['contact_id' => $subscriberInvitees->id, 'fetched' => true]);
            return $subscriberInvitees->id;
        } else if ($contact_person_email) {
            //insert into db 
            $newContact = SubscriberInvitees::create(array(
                'subscriber_id' =>  $subscriber_id,
                'user_id'       =>  $user_id,
                'table_type'    =>  2,
                'assignee'      =>  $subscriber_id,
                'agentname'     =>  $name,
                'email'         =>  $contact_person_email
            ));
            return $newContact->id;
        }
    }
    // get substring between from to in php
    function getInbetweenStrings($start, $end, $content)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return $content;
    }

    public function autoauenrollonreply($threadId, $return_path)
    {
        $return_path_email = $this->getInbetweenStrings('<', '>', $return_path);
        // Log::info('sender email ' . $return_path_email . ' threadId ' . $threadId);
        $playbookEmailQueue = PlaybookEmailQueue::where(['email_to' => $return_path_email, 'thread_id' => $threadId])->first();
        if ($playbookEmailQueue) {

            $emailPlaybook = EmailPlaybook::find($playbookEmailQueue->playbook_id);
            if ($emailPlaybook && $emailPlaybook->autounrollonreply == 1) {
                PlabookAutoUnenrollOnReply::updateOrCreate([
                    'playbook_id'   => $playbookEmailQueue->playbook_id,
                    'contact_id'    => $playbookEmailQueue->contact_id,
                    'thread_id'     => $threadId,
                    'email'         => $return_path_email
                ]);
                PlaybookEmailQueue::where([
                    'playbook_id'   => $playbookEmailQueue->playbook_id,
                    'contact_id'    => $playbookEmailQueue->contact_id,
                    'message_status' => 'in_queue'
                ])->delete();
            }
        }
    }

    public function extractEmail($value)
    {
        $email = $this->getInbetweenStrings('<', '>', $value);
        $name  = $email;
        $emailWIthName = explode('<', $value);
        if (isset($emailWIthName[0])) {
            $name  = $emailWIthName[0];
        }
        return array('address' => $email, 'name' => $name);
    }
}
