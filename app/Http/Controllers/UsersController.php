<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Contracts\Encryption\DecryptException;
use PHPMailer\PHPMailer\PHPMailer;
use DB;
use App\Helpers\CustomMailHelper;
use Illuminate\Session\Store;
use Illuminate\Support\Str;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Model\Company;
use App\Model\SubscriberWebsite;
use App\Model\Inviteuser;
use App\Model\SBCategories;
use App\User;
use App\Category;
use App\Industry;
use App\Employee;
use App\Model\UserMeta;
use App\Model\WebsiteHelpCenter;
use App\Model\SubscriberEventSubjects;
use App\Model\Country;
use App\Model\Thread as ClbThread;
use App\Model\ThreadUsers;
use App\Model\SubscriberInvitees;
use App\Model\Timezone;
use App\Model\SubscriberCompanyDetails;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use App\Model\UserLoginLogs;
use Cartalyst\Stripe\Stripe;
use App\Model\Chat\ApiInfo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Model\Chat\Thread;
use Response;
use Validator;
use Redirect as Redirects;
use Mail;
use App\Mail\RegisterEmail;
use App\Model\ChatSchedulingPlan;
use App\Model\Utility;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\Role\RolesPermissionsController;
use App\Model\Role\Role;
use App\Model\ChatRouting;
use App\Http\Controllers\SmsRoutingController;
use App\Model\Setting\SubscriberForwardBccDetail;
use App\Model\Website;
use App\Helpers\Cpanel\CpanelApi;
use File;
use App\Model\EmailPlaybook\PlaybookUnsubscribe;
use App\Model\EmailPlaybook\EmailPlaybook;
use App\Model\Addon\SmsCurrentDetailsModel;
use App\Model\Social\SocialUser;
use Illuminate\Support\Facades\Crypt;
use App\Model\EmailSignature;
use App\Model\Segment\SegmentModel;
use App\Http\Controllers\SegmentController;
use App\Model\Segment\SegmentAplicableFilterTableModel;
use App\Model\Support\SupportTicket;
use App\Model\Bots\Bots;
use App\Http\Controllers\Bots\BotActionController;
use App\Model\Social\PlaybookEmailQueue;
use App\Model\CustomAttributes\CustomAttributeValue;
use App\Model\Support\TicketCategory;
use Config;
use App\Helpers\CustomLog;

class UsersController extends Controller
{

    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function signup(Request $request)
    {
        $rules = array(
            'email_signup' => 'required|email|unique:users,email',
        );
        $data = array('email_signup' => $request->email_signup);
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            if ($request->email_signup != '') {
                $verify = $this->checkVerifyEmail($request->email_signup);
                if ($verify !== 0) {
                    return Redirects::to('confirm/' . $verify);
                } else {
                    return Redirects::to('login')
                        ->withErrors($validator)
                        ->withInput();
                }
            } else {
                return Redirects::to('login')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            return view('pages.user.signup', ['emailid' => $request->email_signup]);
        }
    }
    public function checkVerifyEmail($email)
    {
        $verify = User::where('email', $email)->first();
        //print_r($verify);
        if ($verify->emailVerifyString) {
            return $verify->parent_id;
        } else {
            return 0;
        }
    }

    public function RegisterEmail(Request $request)
    {
        session()->put('track_new_subscriber', 'step 0');
        session()->put('device_type', $request->input('device_type'));
        session()->save();

        ///check password
        if (preg_match("/[a-zA-Z]/", $request->password) && preg_match("/[^a-zA-Z\d]/", $request->password) && strlen($request->password) > 7) {
        } else {
            $errormsg = "Must be at least 8 characters, include at least one upper, lower case letter and one special character.";
            $response = ['status' => 0, 'errormsg' => $errormsg, 'email_id' => $request->email_id];
            return Response::json($response);
        }

        $generateID = $this->random_num(9, true);

        $path = public_path('images/subscriber/' . $generateID);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        File::copy(public_path('images/subscriber/avatar.jpg'), public_path('images/subscriber/' . $generateID . '/' . $generateID . '.jpg'));


        $exp = explode(" ", $request->name);
        $registerdata = new User();
        $registerdata->name = $request->name;
        $registerdata->displayName = $exp[0];
        $registerdata->email = $request->email_id;
        $registerdata->password = Hash::make($request->password);
        $registerdata->unhash_password = '######'; //$request->password;
        $registerdata->generated_id = $generateID;
        $registerdata->avtar = $generateID . '.jpg';
        //        $registerdata->role_id = 1;
        $registerdata->status = 0;
        $registerdata->signup_step = 0;
        $registerdata->emailVerifyString = $this->getUniqueString();
        $registervalue = $registerdata->save();

        $subscriberinv = new SubscriberInvitees();
        $subscriberinv->agentname = $request->name;
        $subscriberinv->displayname = $exp[0];
        $subscriberinv->email = $request->email_id;
        $subscriberinv->subscriber_id = $registerdata->id;
        $subscriberinv->user_id = $registerdata->id;
        $subscriberinv->avatar =  $generateID . '.jpg';
        $subscriberinv->table_type = 1;
        $subscriberinv->created_at =  Carbon::now();
        $subscriberinv->update_at = Carbon::now();
        $subscriberinv->save();

        if ($registervalue != '') {
            $this->saveOtherDependencies($registerdata->id);
            //save default segment
            $this->InsertDefaultSegments($registerdata);
            $receiverAddress = $request->email_id;
            $userId = Crypt::encrypt($subscriberinv->id);
            Mail::send('pages.user.emails', ['userid' => $registerdata->id, 'url_unsubcribe' => url('unsubscribe/' . $userId), 'string' => $registerdata->emailVerifyString], function ($message) use ($receiverAddress) {
                $message->to($receiverAddress)->subject("Activate your account")->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            $response = ['status' => 1, 'msg' => "successfully", 'user_id' => $registerdata->id, 'email_id' => $request->email_id, 'string' => $registerdata->emailVerifyString];
            return Response::json($response);
        }
    }

    public function rgconfirm($userid)
    {
        $user = User::where('id', $userid)->first();
        return view('pages.user.confirm', ['userid' => $userid, 'email' => $user->email]);
    }

    public function Resendemail($userid)
    {
        $userId = Crypt::encrypt($userid);
        $getuserdata = User::where('id', $userid)->first();
        if ($getuserdata->id != '' && $getuserdata->emailVerifyString != '') {
            $receiverAddress = $getuserdata->email;
            Mail::send('pages.user.emails', ['userid' => $userid, 'url_unsubcribe' => url('unsubscribe/' . $userId), 'string' => $getuserdata
                ->emailVerifyString], function ($message) use ($receiverAddress) {
                $message->to($receiverAddress)->subject("Activate your account")
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });


            $response = ['status' => 1, 'msg' => "successfully."];
            return response()->json($response);
        } else {
            $response = ['status' => 500];
            return response()->json($response);
        }
    }
    public function unsubscribe($strid)
    {
        // echo Crypt::decryptString($strid); die;
        return view('user.unsubscribe', ['userid' => $strid]);
    }

    public function PlaybookUnsubscribe(Request $request)
    {

        $v = Validator::make($request->all(), [
            'customerid' => 'required',
            'reason' => 'required',
        ]);

        if ($v->fails()) {
            $errr = json_decode($v->errors());
            $err = '';
            foreach ($errr as $key => $value) {
                $value[0] =  str_replace(".", "", $value[0]);
                $err .= $value[0] . ', ';
            }
            echo  json_encode(array('status' => 500, 'data' => $err));
            die;
        }

        $datas = $request->except('file', '_token');
        $record = explode('-', decrypt($datas['customerid']));
        $emailer = '';
        $p_id = NULL;

        $checkunsubscribe = PlaybookUnsubscribe::where('customer_id', $record[0])->first();
        if ($checkunsubscribe) {
            echo  json_encode(array('status' => 500, 'data' => 'Already Unsubscribed'));
            die;
        }
        if (isset($record[1])) {
            $subs_invitee = SubscriberInvitees::where('id', $record[0])->first();
            $subs_invitee->email_playbook_unsusbcribe = date('Y-m-d H:i:s');
            $subs_invitee->email_unsusbcribe_status = 1;
            $subs_invitee->save();
            $emailer = 'PLAYBOOK';
            $p_id = $record[1];
            $subs_invitee = SubscriberInvitees::where('id', $record[0])->first();
            $subs_invitee->email_playbook_unsusbcribe = date('Y-m-d H:i:s');
            $subs_invitee->save();
            $unsubscribe = EmailPlaybook::where('id', $record[1])->first();

            $removeInQueues = PlaybookEmailQueue::where('contact_id', $record[0])->where('message_status', 'in_queue')->update(['message_status' => 'unsubscribed']);



            if ($unsubscribe->unsubscribe == '')
                $count = 0;
            else
                $count = $unsubscribe->unsubscribe;

            $unsubscribe->unsubscribe = $count + 1;
            $unsubscribe->save();
        } else {
            $emailer = 'NGSGGE';

            $subs_invitee = SubscriberInvitees::where('id', $record[0])->first();
            $subs_invitee->email_playbook_unsusbcribe = date('Y-m-d H:i:s');
            $subs_invitee->save();
        }
        //DB::enableQueryLog();
        $add = PlaybookUnsubscribe::create(['customer_id' => $record[0], 'playbook_id' => $p_id, 'reason' => $datas['reason'], 'email_type' => $emailer]);
        if ($add) {
            echo  json_encode(array('status' => 200, 'data' => ' Unsubscribed successfully'));
        } else {
            echo  json_encode(array('status' => 500, 'data' => 'Error in Unsubscribe'));
        }
    }

    public function saveOtherDependencies($subscriberId)
    {
        $currentDatetime = Utility::getUTCCurrentDateTime();
        $roleModel = new RolesPermissionsController();
        $roleModel->setDefaultRole($subscriberId);
        $roleModel->setDefaultPermission($subscriberId);
        $roleData = Role::where('subscriber_id', $subscriberId)->where('role_slug', 'subscriber')->first();
        $systemRoleId = $roleData->id;
        $user = User::where('id', $subscriberId)->update([
            'system_role_id' => $systemRoleId,
            'parent_id' => $subscriberId
        ]);
        SubscriberInvitees::where(['subscriber_id' => $subscriberId, 'user_id' => $subscriberId])->update([
            'system_role' => $systemRoleId
        ]);

        DB::table("invitee_table_field")->insert([
            'subscriber_id' => $subscriberId,
            'invitee_id' => 1,
            'name' => 1,
            'display_name' => 1,
            'email' => 1,
            'cell_phone' => 0,
            'role' => 1,
            'login_status' => 0,
            'max_chats' => 0,
            'timezone' => 0,
            'department' => 0,
            'default_view' => 0,
            'email_transcript' => 0,
            'status' => 1,
            'is_activated' => 1,
            'created_at' => 0,
            'updated_at' => 0,
            'avatar' => 1,
            'system_role' => 1,
            /* 'shift'            => 0, */
            'lead_score' => 1,
        ]);

        $defaultConversationTypes = array(
            array('name' => 'Sales Support', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'Other Support', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'Complaint', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'Website Issue', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'Sales Issue', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'Positive Feedback', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'Other', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
            array('name' => 'No Response', 'status' => 1, 'subscriber_id' => $subscriberId, 'is_deletable' => 1),
        );
        DB::table('subscriber_ticket_tag')->insert($defaultConversationTypes);

        $allTag = DB::table('subscriber_ticket_tag')->where(['subscriber_id' => $subscriberId])->get();
        $defaultConversationTypesDrag = [];
        foreach ($allTag as $key => $value) {
            $defaultConversationTypesDrag[] = ["canMove" => true, "hide" => false, "id" => $value->id, "name" => $value->name, "deletable" => 1, "sortable" => true];
        }
        $defaultConversationTypesDragData = ['subscriber_id' => $subscriberId, "column_thead" => json_encode($defaultConversationTypesDrag)];
        DB::table('manage_status_draggable')->insert($defaultConversationTypesDragData);

        $settingsConHub = [
            "actions" => [
                ["id" => "agentTransfer", "name" => "Agent transfer", "value" => true],
                ["id" => "agentCollaboration", "name" => "Agent collaboration", "value" => true],
                ["id" => "visitorBan", "name" => "Ban visitor", "value" => true],
                ["id" => "ticketcreate", "name" => "Create ticket", "value" => true],
                ["id" => "createTicket", "name" => "Create email", "value" => true],
                ["id" => "createNote", "name" => "Create note", "value" => true],
                ["id" => "createSMS", "name" => "Create SMS message", "value" => true],
                ["id" => "rateChat", "name" => "Rate chat", "value" => true],
                ["id" => "scheduleEvent", "name" => "Schedule event", "value" => true],
                ["id" => "scheduleTask", "name" => "Schedule task", "value" => true],
                ["id" => "engageSpecialOffer", "name" => "Send product sheets", "value" => true],
                ["id" => "shareTranscript", "name" => "Share transcript", "value" => true],
                ["id" => "engageKnowledgebase", "name" => "Use knowledgebase", "value" => true],
                ["id" => "engageScript", "name" => "Use script", "value" => true],
                ["id" => "engageShortcuts", "name" => "Use shortcuts", "value" => true],
                ["id" => "engageVedioConference", "name" => "Use video conference", "value" => true]
            ],
            "typingPeek" => true,
            "audioAlert" => [
                "newChat" => true,
                "chatResponse" => true,
                "newEmail" => true,
                "emailResponse" => true,
                "newSms" => true,
                "smsResponse" => true,
                "newMessenger" => true,
                "messengerResponse" => true,
                "newTicket" => true,
                "ticketResponse" => true,
            ],
            "inactiveConversations" => [
                "chatInactiveIn" => ["valueOq" => "5", "dropdown" => "1", "minutes" => "5"],
                "emailInactiveIn" => ["valueOq" => "2", "dropdown" => "3", "minutes" => "2880"],
                "smsInactiveIn" => ["valueOq" => "3", "dropdown" => "2", "minutes" => "180"],
                "messengerInactiveIn" => ["valueOq" => "3", "dropdown" => "2", "minutes" => "180"],
                "ticketInactiveIn" => ["valueOq" => "3", "dropdown" => "2", "minutes" => "180"] // dropdown => 1 => 'minutes', 2 => 'Hours', 3 => 'Days'
            ],
            "wallpaperArray" => [
                [
                    "img_url" => "",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-1.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-2.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-3.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-4.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-5.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-7.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-8.png",
                    "selected" => false
                ]
            ],
            "wallpaperOpacity" => ['isActive' => false, 'value' => ''],
            "windowPanels" => "1", // 1 => 'Single', 2 => 'Double'
            "sendButtonType" => true,
        ];
        $settingsConHubData = ["subscriber_id" => $subscriberId, "user_id" => $subscriberId, "actions" => serialize(json_encode($settingsConHub)), "updated_on" => $currentDatetime];
        DB::table('conversations_show_hide_actions')->insert($settingsConHubData);
    }

    public function saveInviteeOtherDependencies($subscriberId, $userId)
    {
        $currentDatetime = Utility::getUTCCurrentDateTime();

        $settingsConHub = [
            "actions" => [
                ["id" => "agentTransfer", "name" => "Agent transfer", "value" => true],
                ["id" => "agentCollaboration", "name" => "Agent collaboration", "value" => true],
                ["id" => "visitorBan", "name" => "Ban visitor", "value" => true],
                ["id" => "ticketcreate", "name" => "Create ticket", "value" => true],
                ["id" => "createTicket", "name" => "Create email", "value" => true],
                ["id" => "createNote", "name" => "Create note", "value" => true],
                ["id" => "createSMS", "name" => "Create SMS message", "value" => true],
                ["id" => "rateChat", "name" => "Rate chat", "value" => true],
                ["id" => "scheduleEvent", "name" => "Schedule event", "value" => true],
                ["id" => "scheduleTask", "name" => "Schedule task", "value" => true],
                ["id" => "engageSpecialOffer", "name" => "Send product sheets", "value" => true],
                ["id" => "shareTranscript", "name" => "Share transcript", "value" => true],
                ["id" => "engageKnowledgebase", "name" => "Use knowledgebase", "value" => true],
                ["id" => "engageScript", "name" => "Use script", "value" => true],
                ["id" => "engageShortcuts", "name" => "Use shortcuts", "value" => true],
                ["id" => "engageVedioConference", "name" => "Use video conference", "value" => true]
            ],
            "typingPeek" => true,
            "audioAlert" => [
                "newChat" => true,
                "chatResponse" => true,
                "newEmail" => true,
                "emailResponse" => true,
                "newSms" => true,
                "smsResponse" => true,
                "newMessenger" => true,
                "messengerResponse" => true,
                "newTicket" => true,
                "ticketResponse" => true,
            ],
            "inactiveConversations" => [
                "chatInactiveIn" => ["valueOq" => "5", "dropdown" => "1", "minutes" => "5"],
                "emailInactiveIn" => ["valueOq" => "2", "dropdown" => "3", "minutes" => "2880"],
                "smsInactiveIn" => ["valueOq" => "3", "dropdown" => "2", "minutes" => "180"],
                "messengerInactiveIn" => ["valueOq" => "3", "dropdown" => "2", "minutes" => "180"],
                "ticketInactiveIn" => ["valueOq" => "3", "dropdown" => "2", "minutes" => "180"] // dropdown => 1 => 'minutes', 2 => 'Hours', 3 => 'Days'
            ],
            "wallpaperArray" => [
                [
                    "img_url" => "",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-1.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-2.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-3.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-4.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-5.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-7.png",
                    "selected" => false
                ],
                [
                    "img_url" => "images/pattern-8.png",
                    "selected" => false
                ]
            ],
            "wallpaperOpacity" => ['isActive' => false, 'value' => ''],
            "windowPanels" => "1", // 1 => 'Single', 2 => 'Double'
            "sendButtonType" => true,
        ];
        $settingsConHubData = ["subscriber_id" => $subscriberId, "user_id" => $userId, "actions" => serialize(json_encode($settingsConHub)), "updated_on" => $currentDatetime];
        DB::table('conversations_show_hide_actions')->insert($settingsConHubData);
    }

    public function Verifyemail($string)
    {
        $userdata = User::where('emailVerifyString', $string)->first();
        $status_email = true;
        if (!$userdata) {
            $message = 'We have not any user for that data.';

            $status_email = false;
            $userid = '';
        } else {

            if ($userdata->status == 1) {
                $message = 'Your email has been already verified.';
                $status_email = false;
            } else {

                $user = User::where('emailVerifyString', $string)->update(['status' => 1, 'signup_step' => 1, 'emailVerifyString' => null, 'email_veify_at' => date('Y-m-d H:i:s')]);
                // set status and is_activated true for subscriber
                DB::table('subscriber_invitees')->where(['subscriber_id' => $userdata->id, 'user_id' => $userdata->id,])
                    ->update(['status' => 1, 'is_activated' => 1, 'status_on_login' => 1, 'login_default_view' => 1, 'maxchat' => 0,]);
                $message = 'Your email has been verified successfully.';
                $status_email = true;
                //create contact as super-admin
                $subscriber = SubscriberInvitees::where('subscriber_id', 1)->where('email', $userdata->email)->first();
                if ($subscriber) {
                    if ($subscriber->is_deleted) {
                        $subscriber->is_deleted = 0;
                    }
                    $subscriber->contact_id = $userdata->id;
                    $subscriber->agentname = $userdata->name;
                    $subscriber->displayname = $userdata->displayname;
                    $subscriber->save();
                    $this->addCustomfieldValue($subscriber->id, $type = "Subscriber");
                } else {
                    $add_contact = DB::table('subscriber_invitees')->insertGetId([
                        'agentname' => $userdata->name,
                        'displayname' => $userdata->displayname,
                        'email' => $userdata->email,
                        'subscriber_id' => 1,
                        'user_id' => 0,
                        'contact_id' => $userdata->id,
                        'table_type' => 2,
                        'created_at' => Carbon::now(),
                        'update_at' => Carbon::now()
                    ]);
                    // dd($add_contact);
                    $this->addCustomfieldValue($add_contact, $type = "Subscriber");
                }
                //auto login for other steps
                $this->autologin($userdata->id);
                return redirect('chat-feature/' . $userdata->id);
            }

            $userid = $userdata->id;
        }

        return view('pages.user.email-confirm', ['userid' => $userid, 'message' => $message, 'status' => $status_email]);
    }

    public function chatFeature($userid)
    {
        /* $userData = User::where('id', $userid)->first();
          if(!isset($userData->id)){
          echo 'Unauthorized access';
          exit;
          }
          if($userData->signup_step >= 5){
          echo 'This link is expired. Thank you.';
          exit;
          } else {
          $user = User::where('id', $userid)->update([
          'status' => 1,
          'signup_step' => 2
          ]);
          return view('pages.user.register-step1', ['userid' => $userid, 'step' => 1]);
          }
         */

        if (!$this->checklogin()) {
            return redirect('login/');
        }

        if (!$this->checkActiveUser($userid)) {
            return redirect('confirm/' . $userid);
        }
        $userdetails = User::where('id', $userid)->first();
        $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();
        if ($company &&  $userdetails->signup_step >= 4) {
            return redirect('reports?sub=features');
        }

        /*    $checkstep = $this->checksteps($userid,'2');
          if(!$checkstep['status']){
          return redirect($checkstep['url']);
          } */

        return view('pages.user.register-step1', ['userid' => $userid, 'signup_step' => 1]);
    }

    public function getIndustryEmp(Request $request)
    {
        $industry = Industry::all();
        $employee = Employee::all();
        $response = ['status' => 1, 'industry' => $industry, 'employee' => $employee];
        return response()->json($response);
    }

    public function chatFeatureType(Request $request)
    {
        session()->put('track_new_subscriber', 'step 1');
        session()->put('device_type', $request->input('device_type'));
        session()->save();

        $currentDatetime = Utility::getUTCCurrentDateTime();
        $company = SubscriberCompanyDetails::where('subscriber_id', $request->user_id)
            ->first();
        $getInviteeDetails = SubscriberInvitees::where('user_id', $request->user_id)->first();
        if ($company) {
            SubscriberCompanyDetails::where('subscriber_id', $request->user_id)
                ->update(['company_name' => $request->company_name, 'num_of_employees' => $request->employee_name, 'industry' => $request->industries_name, 'contact_id' => $getInviteeDetails->id,]);
            // check website existance if already exist then send email to system admin
            if ($websiteDetail = SubscriberWebsite::where(['website_url' => $request->website_name])->where('subscriber_id', '<>', $request->user_id)->first()) {
                $user = User::find($websiteDetail->subscriber_id);
                $this->sendDuplicateWebsiteRemainderMail($websiteDetail, $user);
            }
            $web = SubscriberWebsite::where('subscriber_id', $request->user_id)
                ->first();
            if ($web) {
                SubscriberWebsite::where('subscriber_id', $request->user_id)
                    ->update(['website_url' => strtolower(trim($request->website_name))]);
            } else {
                SubscriberWebsite::create(['subscriber_id' => $request->user_id, 'website_url' => strtolower(trim($request->website_name)), 'status' => 1, 'created_at' => $currentDatetime, 'created_by' => $request->user_id, 'updated_at' => $currentDatetime, 'updated_by' => $request->user_id]);
            }
            $subweb = SubscriberWebsite::where('subscriber_id', $request->user_id)
                ->first();
            $this->defaultBot();

            $response = ['status' => 1, 'msg' => "successfully", 'detail_id' => $company->id, 'web_id' => $subweb->id];
            return Response::json($response);
        } else {
            $registerdata = new SubscriberCompanyDetails();
            $registerdata->company_name = $request->company_name;
            $registerdata->num_of_employees = $request->employee_name;
            $registerdata->industry = $request->industries_name;
            $registerdata->subscriber_id = $request->user_id;
            $registerdata->contact_id = $getInviteeDetails->id;
            $registerdata->save();
            $subscriberinv = new SubscriberWebsite();
            $subscriberinv->website_url = $request->website_name;
            $subscriberinv->subscriber_id = $request->user_id;
            $subscriberinv->created_at = $currentDatetime;
            $subscriberinv->created_by = $request->user_id;
            $subscriberinv->updated_at = $currentDatetime;
            $subscriberinv->updated_by = $request->user_id;
            $subscriberinv->status = 1;
            $subscriberinv->save();

            $user = User::where('id', $request->user_id)
                ->update(['signup_step' => 2]);

            $this->defaultBot();

            $response = ['status' => 1, 'msg' => "successfully", 'detail_id' => $registerdata->id, 'web_id' => $subscriberinv->id];
            return Response::json($response);
        }
    }

    public function getRegisterDetails($userid)
    {
        $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();
        $website = SubscriberWebsite::where('subscriber_id', $userid)->first();
        if ($company) {
            $response = ['status' => 1, 'company' => $company, 'website' => $website];
            return Response::json($response);
        }
    }

    public function getActivity($userid, $detailid, $websiteid)
    {
        if (!$this->checklogin()) {
            return redirect('login/');
        }

        if (!$this->checkActiveUser($userid)) {
            return redirect('confirm/' . $userid);
        }

        $checkstep = $this->checksteps($userid, '2');
        if (!$checkstep['status']) {
            return redirect($checkstep['url']);
        }

        $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();
        $userdetails = User::where('id', $userid)->first();
        if ($company->timezone != '' && $userdetails->signup_step >= 4) {
            return redirect('reports?sub=features');
        }

        return view('pages.user.register-step2', ['userid' => $userid, 'detailid' => $detailid, 'web_id' => $websiteid, 'signup_step' => 2]);
    }


    public function getTimezoneregister(Request $request)
    {
        $getimezone = Timezone::where('status', 1)->get();
        $getcountry_us = Country::where('id', 231)->first();

        $getcountry_other = Country::where('id', '!=', 231)->get();
        $getcountry[] = $getcountry_us;
        foreach ($getcountry_other as $key => $value) {
            $getcountry[] = $value;
        }
        $response = ['status' => 1, 'gettime' => $getimezone, 'country' => $getcountry];
        return response()->json($response);
    }


    /*
    public function chatHelpus(Request $request) {

        $usertable = User::where('id', $request->u_id)->first();
        $currentDatetime = Utility::getUTCCurrentDateTime();
        $registerdata = SubscriberCompanyDetails::where('id', $request->d_id)->update([
            'timezone' => $request->time_zone,
            'country' => $request->country_name,
            'audience' => $request->audience
        ]);
        $user = User::where('id', $request->u_id)->update([
            'signup_step' => 3
        ]);
        $response = ['status' => 1, 'msg' => "successfully"];
        return Response::json($response);
    }*/


    public function chatHelpus(Request $request)
    {
        session()->put('track_new_subscriber', 'step 2');
        session()->put('device_type', $request->input('device_type'));
        session()->save();

        $usertable = User::where('id', $request->u_id)->first();
        //$company = SubscriberCompanyDetails::where('subscriber_id', $request->user_id)->first();

        $currentDatetime = Utility::getUTCCurrentDateTime();
        $registerdata = SubscriberCompanyDetails::where('id', $request->d_id)->update([
            'timezone' => $request->time_zone,
            'country'  => $request->country_name,
            'audience' => $request->audience
        ]);
        $data = array(
            ['name' => 'Mon', 'day' => '1', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Tue', 'day' => '2', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Wed', 'day' => '3', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Thu', 'day' => '4', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Fri', 'day' => '5', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Sat', 'day' => '6', 'from' => "", 'to' => "", 'from_time' => "", 'to_time' => ""],
            ['name' => 'Sun', 'day' => '7', 'from' => "", 'to' => "", 'from_time' => "", 'to_time' => ""]
        );
        $cplan = ChatSchedulingPlan::where('subscriber_id', $request->u_id)->first();
        if ($cplan) {
            $cplan->subscriber_id = $request->u_id;
            $cplan->name = "Default";
            $cplan->created_at = $currentDatetime;
            $cplan->updated_at = $currentDatetime;
            $cplan->created_by = $request->u_id;
            $cplan->updated_by = $request->u_id;
            $cplan->timezone = $request->time_zone;
            $cplan->time_table = serialize(json_encode($data));
            $cplan->website_id = $request->web_id;
            $cplan->is_defalut = 1;
            $cplan->save();
        } else {
            $chatplan = new ChatSchedulingPlan();
            $chatplan->subscriber_id = $request->u_id;
            $chatplan->name = "Default";
            $chatplan->created_at = $currentDatetime;
            $chatplan->updated_at = $currentDatetime;
            $chatplan->created_by = $request->u_id;
            $chatplan->updated_by = $request->u_id;
            $chatplan->timezone = $request->time_zone;
            $chatplan->time_table = serialize(json_encode($data));
            $chatplan->website_id = $request->web_id;
            $chatplan->is_defalut = 1;
            $chatplan->save();
        }
        $crouting = ChatRouting::where('subscriber_id', $request->u_id)->where('website_id', $request->web_id)->first();
        if ($crouting) {

            $crouting->subscriber_id  = $request->u_id;
            $crouting->website_id     = $request->web_id;
            $crouting->webpage         = NULL;
            $crouting->type           = 1;
            $crouting->transfer_if_no_response_in = NULL;
            $crouting->status                     = 1;
            $crouting->channel                    = 1;
            $crouting->is_default                 = 1;
            $crouting->created_by                 = $request->u_id;
            $crouting->created_at                 = $currentDatetime;
            $crouting->updated_by                 = $request->u_id;
            $crouting->updated_at                 = $currentDatetime;
            $crouting->save();
        } else {

            ChatRouting::create([
                'subscriber_id'              => $request->u_id,
                'website_id'                 => $request->web_id,
                'webpage'                    => NULL,
                'type'                       => 1,
                'transfer_if_no_response_in' => NULL,
                'status'                     => 1,
                'channel'                    => 1,
                'is_default'                 => 1,
                'created_by'                 => $request->u_id,
                'created_at'                 => $currentDatetime,
                'updated_by'                 => $request->u_id,
                'updated_at'                 => $currentDatetime,
            ]);
        }


        //create chat routing for ticket 
        $smsRoutingController = new SmsRoutingController();
        $smsRoutingController->createRouting($usertable, 4);

        $ChatComponentJsonDataUrl = base_path("resources/assets/js/ChatComponentJsonData.json");
        $ChatComponentJsonData = file_get_contents($ChatComponentJsonDataUrl);
        $ChatComponentJsonData = json_decode($ChatComponentJsonData);
        $windowsFormsList = array(
            'forms'                        => array(
                array('name' => "Prechat", "display_name" => "Pre Chat", "default_img" => "images/cwft-icon-1.png", "hover_img" => "images/prechat-sample.png", 'multiple' => false, 'id' => 1, 'isSelected' => false, 'component' => 'Prechat', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                /*array('name' => "Offline", "display_name" => "Non-Bus Hrs", "default_img" => "images/cwft-icon-9.png", "hover_img" => "images/offline-sample.png", 'multiple' => false, 'id' => 2, 'isSelected' => false, 'component' => 'Offline', 'saved' => true, 'formData' => $ChatComponentJsonData->all_window->Offline, 'tempFormData' => null),*/
                array('name' => "Announcements", "display_name" => "News", "default_img" => "images/cwft-icon-6.png", "hover_img" => "images/news-sample.jpg", 'multiple' => false, 'id' => 3, 'isSelected' => false, 'component' => 'Announcements', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Blog", "display_name" => "Blog", "default_img" => "images/cwft-icon-5.png", "hover_img" => "images/blog-sample.png", 'multiple' => false, 'id' => 4, 'isSelected' => false, 'component' => 'Blog', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "E-book", "display_name" => "E-book", "default_img" => "images/cwft-icon-8.png", "hover_img" => "images/ebook-sample.png", 'multiple' => false, 'id' => 5, 'isSelected' => false, 'component' => 'Ebook', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Search", "display_name" => "Search", "default_img" => "images/cwft-icon-2.png", "hover_img" => "images/search-sample.png", 'multiple' => false, 'id' => 6, 'isSelected' => false, 'component' => 'Search', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "FreeTrial", "display_name" => "Free Trial", "default_img" => "images/cwft-icon-4.png", "hover_img" => "images/freetrail-sample.jpg", 'multiple' => false, 'id' => 7, 'isSelected' => false, 'component' => 'FreeTrial', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                //                array('name' => "Webinar", "display_name" => "Webinar", "default_img" => "images/cwft-icon-10.png", "hover_img" => "images/webinar-sample.jpg", 'multiple' => false, 'id' => 8, 'isSelected' => false, 'component' => 'Webinar', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Employeement", "display_name" => "Jobs", "default_img" => "images/cwft-icon-7.png", "hover_img" => "images/jobs-sample.jpg", 'multiple' => false, 'id' => 9, 'isSelected' => false, 'component' => 'Employeement', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Subscribe", "display_name" => "Subscribe", "default_img" => "images/cwft-icon-12.png", "hover_img" => "images/subscribe-sample.jpg", 'multiple' => false, 'id' => 10, 'isSelected' => false, 'component' => 'Subscribe', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Demo", "display_name" => "Demo", "default_img" => "images/cwft-icon-3.png", "hover_img" => "images/demo-sample.jpg", 'multiple' => false, 'id' => 11, 'isSelected' => false, 'component' => 'Demo', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                //                array('name' => "Feedback", "display_name" => "Feedback", "default_img" => "images/cwft-icon-11.png", "hover_img" => "images/feedback-sample.jpg", 'multiple' => false, 'id' => 12, 'isSelected' => false, 'component' => 'Feedback', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                //                array('name' => "Promotion", "display_name" => "Promotion", "default_img" => "images/cwft-icon-13.png", "hover_img" => "images/blog-sample.png", 'multiple' => false, 'id' => 13, 'isSelected' => false, 'component' => 'Promotion', 'saved' => false, 'formData' => null, 'tempFormData' => null)
            ),
            'sorting_order_prechat_window' => array(),
            'sorting_order_offline_window' => array(2),
            'tempFormData'                 => null
        );

        $subs_theam_entity =  DB::table('subscriber_theme_entity')->where('subscriber_id', $request->u_id)->where('subscriber_website_id', $request->web_id)->first();
        if ($subs_theam_entity) {
            DB::table('subscriber_theme_entity')->where('subscriber_id', $request->u_id)->where('subscriber_website_id', $request->web_id)
                ->update([
                    'subscriber_id'         => $request->u_id,
                    'theme_name'            => "Default",
                    'subscriber_website_id' => $request->web_id,
                    'status'                => 1
                ]);
        } else {

            $insert = DB::table('subscriber_theme_entity')
                ->insertGetId([
                    'subscriber_id'         => $request->u_id,
                    'theme_name'            => "Default",
                    'subscriber_website_id' => $request->web_id,
                    'status'                => 1
                ]);


            if ($insert) {
                $webid = $request->web_id;
                $subscriberId = $request->u_id;
                $datas = $ChatComponentJsonData->all_window;
                $sub_website = SubscriberWebsite::where(['id' => $webid, 'is_branding' => 1])->get()->toArray();
                if (count($sub_website) > 0) {
                    $sub = SubscriberWebsite::where('id', $webid)->with('buttonWindowDesign')->first();
                    $window_data = json_decode($sub->buttonWindowDesign['all_window']);
                    $datas->WindowFooterText =  ($window_data->WindowFooterText) ? $window_data->WindowFooterText : '';
                    $datas->FooterTextColore->hex = ($window_data->FooterTextColore->hex) ? $window_data->FooterTextColore->hex : '';;
                    $datas->BrandingType =  ($window_data->BrandingType) ? $window_data->BrandingType : '';
                    $datas->WindowFooterLogo = ($window_data->WindowFooterLogo) ? $window_data->WindowFooterLogo : '';
                    $datas->chatWindowLink   = ($window_data->chatWindowLink) ? $window_data->chatWindowLink : '';;
                }
                DB::table('subscriber_website')
                    ->where('id', $webid)
                    ->update([
                        'active_theme_id' => $insert,
                        'added'           => 0
                    ]);


                //            if ($request->window) {
                DB::table('button_window_design')
                    ->insert([
                        'subscriber_id'             => $subscriberId,
                        'theme_id'                  => $insert,
                        'online_button'             => json_encode($ChatComponentJsonData->online_button),
                        'all_window'                => json_encode($datas),
                        'windows_forms_list'        => json_encode($windowsFormsList),
                        'windows_sorted_forms_list' => json_encode($windowsFormsList),
                        'created_by'                => $subscriberId,
                        'created_at'                => $currentDatetime,
                        'updated_by'                => $subscriberId,
                        'updated_at'                => $currentDatetime
                    ]);
            }
        }

        SubscriberInvitees::where(['subscriber_id' => $request->u_id, 'user_id' => $request->u_id])->update([
            'timezone' => $request->time_zone
        ]);
        $user = User::where('id', $request->u_id)->update([
            'signup_step' => 3
        ]);
        $category = array(
            ['status' => 1, 'name' => 'News', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Getting Started', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Best Practices', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Billing', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Reports', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Settings', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
        );

        Category::insert($category);
        WebsiteHelpCenter::create([
            'status'            => 1,
            'logo'            => "",
            'header_color'      => '#3B4DAD',
            'header_text_color' => '#fff',
            'header_text'       => 'Knowledgebase | Help Center',
            'website_id'        => $request->web_id,
            'subscriber_id'     => $request->u_id,
            'pagetype'          => 2,
            'footerType'        => 2,
        ]);
        $eventSubject = array(
            ['subscriber_id' => $request->u_id, 'name' => 'Demo', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'name' => 'Sales', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'name' => 'Marketing', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'name' => 'Support', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime]
        );
        SubscriberEventSubjects::insert($eventSubject);
        $suggestionCat = array(
            ['subscriber_id' => $request->u_id, 'title' => 'Sales', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'Marketing', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'Support', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'Products', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'Services', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'Productivity', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'R&D', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'IT', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'HR', 'created_at' => $currentDatetime, 'status' => 1],
            ['subscriber_id' => $request->u_id, 'title' => 'Finance', 'created_at' => $currentDatetime, 'status' => 1]
        );
        SBCategories::insert($suggestionCat);
        $ticketCat = array(
            ['name' => 'Billing', 'subscriber_id' => $request->u_id, 'added_by' => $request->u_id, 'is_delete' => 0, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['name' => 'Website Issue', 'subscriber_id' => $request->u_id, 'added_by' => $request->u_id, 'is_delete' => 0, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['name' => 'Application Issue', 'subscriber_id' => $request->u_id, 'added_by' => $request->u_id, 'is_delete' => 0, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['name' => 'Returns/Cancellation', 'subscriber_id' => $request->u_id, 'added_by' => $request->u_id, 'is_delete' => 0, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['name' => 'Delivery issue', 'subscriber_id' => $request->u_id, 'added_by' => $request->u_id, 'is_delete' => 0, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['name' => 'Exchange', 'subscriber_id' => $request->u_id, 'added_by' => $request->u_id, 'is_delete' => 0, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
        );
        TicketCategory::insert($ticketCat);
        $defaultThread = array(
            ['subscriber_id' => $request->u_id, 'title' => 'Announcements', 'group_type' => 1, 'has_many_users' => 1, 'created_at' => $currentDatetime, 'created_by' => $request->u_id, 'updated_at' => $currentDatetime, 'updated_by' => $request->u_id],
            ['subscriber_id' => $request->u_id, 'title' => 'Townhall', 'group_type' => 1, 'has_many_users' => 1, 'created_at' => $currentDatetime, 'created_by' => $request->u_id, 'updated_at' => $currentDatetime, 'updated_by' => $request->u_id],
        );
        ClbThread::insert($defaultThread);
        $thread1 = ClbThread::where('subscriber_id', $request->u_id)->where('group_type', 1)->where('title', 'Announcements')->first();
        $thread2 = ClbThread::where('subscriber_id', $request->u_id)->where('group_type', 1)->where('title', 'Townhall')->first();
        $threadUser = array(
            ['user_id' => $request->u_id, 'thread_id' => $thread1->id, 'is_active' => 1, 'is_creator' => 1, 'created_at' => $currentDatetime],
            ['user_id' => $request->u_id, 'thread_id' => $thread2->id, 'is_active' => 1, 'is_creator' => 1, 'created_at' => $currentDatetime],
        );
        ThreadUsers::insert($threadUser);

        $response = ['status' => 1, 'msg' => "successfully"];
        return Response::json($response);
    }
    public function deleteInformationFeature(Request $request)
    {

        DB::table('subscriber_theme_entity')->where('subscriber_id', $request->u_id)->where('subscriber_website_id', $request->web_id)->delete();
        return 1;
    }
    public function chatHelpusData()
    {
        $registerdata = SubscriberCompanyDetails::where('subscriber_id', Auth::user()->id)->first();
        return response()->json($registerdata);
    }


    public function getChatHelpUs(Request $request)
    {
        $companyData = SubscriberCompanyDetails::where('id', $request->d_id)->first();
        if ($companyData) {
            $response = ['status' => 1, 'record' => $companyData];
            return Response::json($response);
        } else {
            $response = ['status' => 0, 'msg' => 'No record found.'];
            return Response::json($response);
        }
    }

    public function getFeatureInt($userid, $detailid, $websiteid)
    {
        if (!$this->checklogin()) {
            return redirect('login/');
        }
        if (!$this->checkActiveUser($userid)) {
            return redirect('confirm/' . $userid);
        }

        $checkstep = $this->checksteps($userid, '3');
        if (!$checkstep['status']) {
            return redirect($checkstep['url']);
        }
        $subweb = SubscriberWebsite::where('subscriber_id', $userid)->first();

        $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();
        $userdetails = User::where('id', $userid)->first();
        if ($company->interested_features != '' && $userdetails->signup_step >= 4) {
            return redirect('reports?sub=features');
        }

        return view('pages.user.register-step3', ['userid' => $userid, 'detailid' => $detailid, 'websiteid' => $subweb->id, 'signup_step' => 3, 'step' => 3]);
    }
    public function interrested_feature_getdata()
    {

        $registerdata = SubscriberCompanyDetails::where('subscriber_id', Auth::user()->parent_id)->first();
        if ($registerdata)
            echo $registerdata->interested_features;
    }

    public function featureInterrested(Request $request)
    {
        $getuserid = User::where('id', $request->u_id)
            ->get();
        $register = json_encode($request->features);
        $registerdata = SubscriberCompanyDetails::where('id', $request->d_id)
            ->update(['interested_features' => $register]);

        $user = User::where('id', $request->u_id)
            ->update(['signup_step' => 4]);

        Auth::loginUsingId($request->u_id);
        UserLoginLogs::Create(['subscriber_id' => $request->u_id, 'user_id' => $request->u_id, 'login_time' => date('Y-m-d H:i:s'), 'logout_time' => date('Y-m-d H:i:s'), 'login_status' => 1,]);
        
        session()->put('track_new_subscriber', 'step 3');
        session()->put('device_type', $request->input('device_type'));
        session()->save();

        $website_url = '';
        $websiteData  = Website::where('subscriber_id', Auth::user()->parent_id)->first();
        if ($websiteData) {
            if (isset($websiteData->website_url)) {
                $website_url = $this->getHost($websiteData->website_url);
            }
            $forward_bcc_email = $this->getSupportEmail($websiteData->subscriber_id, $website_url);
        }
        $company_name = SubscriberCompanyDetails::select("company_name")->where('id', $request->d_id)->first();
        $userId = Crypt::encrypt(Auth::user()->parent_id);
        $email_to = $getuserid[0]->email;
        $subject = "Great to have $company_name->company_name with us, PLUS a quick question";
        //         Mail::send('emails.teammate.welcome', ['first_name' => $getuserid[0]->first_name,'url_unsubcribe'=>url('unsubscribe/'.$userId), 'company_name' => $company_name->company_name], function ($message) use ($email_to, $subject) {
        //            $message->to($email_to)->subject($subject);
        //        });

        ////mail sent by php mailer 
        $msg = view('emails.teammate.welcome', ['first_name' => $getuserid[0]->name]);
        $custom = new CustomMailHelper();
        $send = $custom->send($email_to, $subject, $msg);
        if ($send) {
            $response = ['status' => 1, 'msg' => 'login successfully'];
            return Response::json($response);
        }
    }

    public function getHost($Address)
    {
        $parseUrl = parse_url(trim($Address));
        return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2)));
    }


    public function getSupportEmail($subscriber_id = 2, $website_url)
    {
        $response = array(
            'support_email'     => '',
        );
        $subscriberForwardDetails =  SubscriberForwardBccDetail::where(['subscriber_id' => $subscriber_id, 'mail_type' => 'support'])->first();
        if (!$subscriberForwardDetails) {

            $cpanelApi = new CpanelApi();
            if (Website::where(['website_url' => $website_url])->exists())
                $website_url = $website_url . $subscriber_id;
            $result = $cpanelApi->createSubscriberSupportEmail($website_url);
            if ($result['status'] == true) {
                $result_fwd = $result['data']['support'];
                $subscriberForwardDetails = SubscriberForwardBccDetail::create(
                    [
                        'subscriber_id' => $subscriber_id,
                        'imap_port'     => $result_fwd['settings']['ssl']['incoming_server']['ports']['imap'],
                        'incoming_host' => $result_fwd['settings']['ssl']['incoming_server']['url'],
                        'mail_username' => $result_fwd['email'],
                        'mail_password' => Crypt::encryptString($result_fwd['password']),
                        'mail_type'     => 'support',
                        'last_synced'   => time()
                    ]
                );
            }
        }

        if ($subscriberForwardDetails) {
            $response['support_email'] = $subscriberForwardDetails->mail_username;
        }


        return $response;
    }


    /*
    public function featureInterrested(Request $request) {
        $currentDatetime = Utility::getUTCCurrentDateTime();
        $companyData = SubscriberCompanyDetails::where('id', $request->d_id)->first();
        $getuserid = User::where('id', $request->u_id)
                ->get();
        $register = json_encode($request->features);
        $registerdata = SubscriberCompanyDetails::where('id', $request->d_id)
                ->update(['interested_features' => $register]);
        $user = User::where('id', $request->u_id)
                ->update(['signup_step' => 4]);

        Auth::loginUsingId($request->u_id);
        $data = array(
            ['name' => 'Mon', 'day' => '1', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Tue', 'day' => '2', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Wed', 'day' => '3', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Thu', 'day' => '4', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Fri', 'day' => '5', 'from' => "18", 'to' => "36", 'from_time' => "08:30 AM", 'to_time' => "05:30 PM"],
            ['name' => 'Sat', 'day' => '6', 'from' => "", 'to' => "", 'from_time' => "", 'to_time' => ""],
            ['name' => 'Sun', 'day' => '7', 'from' => "", 'to' => "", 'from_time' => "", 'to_time' => ""]
        );
        $chatplan = new ChatSchedulingPlan();
        $chatplan->subscriber_id = $request->u_id;
        $chatplan->name = "Default";
        $chatplan->created_at = $currentDatetime;
        $chatplan->updated_at = $currentDatetime;
        $chatplan->created_by = $request->u_id;
        $chatplan->updated_by = $request->u_id;
        $chatplan->timezone = $companyData->timezone;
        $chatplan->time_table = serialize(json_encode($data));
        $chatplan->website_id = $request->web_id;
        $chatplan->is_defalut = 1;
        $chatplan->save();

        ChatRouting::create([
            'subscriber_id' => $request->u_id,
            'website_id' => $request->web_id,
            'webpage' => NULL,
            'type' => 1,
            'transfer_if_no_response_in' => NULL,
            'status' => 1,
            'channel' => 1,
            'is_default' => 1,
            'created_by' => $request->u_id,
            'created_at' => $currentDatetime,
            'updated_by' => $request->u_id,
            'updated_at' => $currentDatetime,
        ]);

        $ChatComponentJsonDataUrl = base_path("resources/assets/js/ChatComponentJsonData.json");
        $ChatComponentJsonData = file_get_contents($ChatComponentJsonDataUrl);
        $ChatComponentJsonData = json_decode($ChatComponentJsonData);
        $windowsFormsList = array(
            'forms' => array(
                array('name' => "Prechat", "display_name" => "Pre Chat", "default_img" => "images/cwft-icon-1.png", "hover_img" => "images/prechat-sample.png", 'multiple' => false, 'id' => 1, 'isSelected' => false, 'component' => 'Prechat', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Offline", "display_name" => "Non-Bus Hrs", "default_img" => "images/cwft-icon-9.png", "hover_img" => "images/offline-sample.png", 'multiple' => false, 'id' => 2, 'isSelected' => false, 'component' => 'Offline', 'saved' => true, 'formData' => $ChatComponentJsonData->all_window->Offline, 'tempFormData' => null),
                array('name' => "Announcements", "display_name" => "News", "default_img" => "images/cwft-icon-6.png", "hover_img" => "images/news-sample.jpg", 'multiple' => false, 'id' => 3, 'isSelected' => false, 'component' => 'Announcements', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Blog", "display_name" => "Blog", "default_img" => "images/cwft-icon-5.png", "hover_img" => "images/blog-sample.png", 'multiple' => false, 'id' => 4, 'isSelected' => false, 'component' => 'Blog', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "E-book", "display_name" => "E-book", "default_img" => "images/cwft-icon-8.png", "hover_img" => "images/ebook-sample.png", 'multiple' => false, 'id' => 5, 'isSelected' => false, 'component' => 'Ebook', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Search", "display_name" => "Search", "default_img" => "images/cwft-icon-2.png", "hover_img" => "images/search-sample.png", 'multiple' => false, 'id' => 6, 'isSelected' => false, 'component' => 'Search', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "FreeTrial", "display_name" => "Free Trial", "default_img" => "images/cwft-icon-4.png", "hover_img" => "images/freetrail-sample.jpg", 'multiple' => false, 'id' => 7, 'isSelected' => false, 'component' => 'FreeTrial', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                //                array('name' => "Webinar", "display_name" => "Webinar", "default_img" => "images/cwft-icon-10.png", "hover_img" => "images/webinar-sample.jpg", 'multiple' => false, 'id' => 8, 'isSelected' => false, 'component' => 'Webinar', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Employeement", "display_name" => "Jobs", "default_img" => "images/cwft-icon-7.png", "hover_img" => "images/jobs-sample.jpg", 'multiple' => false, 'id' => 9, 'isSelected' => false, 'component' => 'Employeement', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Subscribe", "display_name" => "Subscribe", "default_img" => "images/cwft-icon-12.png", "hover_img" => "images/subscribe-sample.jpg", 'multiple' => false, 'id' => 10, 'isSelected' => false, 'component' => 'Subscribe', 'saved' => false, 'formData' => null, 'tempFormData' => null),
                array('name' => "Demo", "display_name" => "Demo", "default_img" => "images/cwft-icon-3.png", "hover_img" => "images/demo-sample.jpg", 'multiple' => false, 'id' => 11, 'isSelected' => false, 'component' => 'Demo', 'saved' => false, 'formData' => null, 'tempFormData' => null),
            //                array('name' => "Feedback", "display_name" => "Feedback", "default_img" => "images/cwft-icon-11.png", "hover_img" => "images/feedback-sample.jpg", 'multiple' => false, 'id' => 12, 'isSelected' => false, 'component' => 'Feedback', 'saved' => false, 'formData' => null, 'tempFormData' => null),
            //                array('name' => "Promotion", "display_name" => "Promotion", "default_img" => "images/cwft-icon-13.png", "hover_img" => "images/blog-sample.png", 'multiple' => false, 'id' => 13, 'isSelected' => false, 'component' => 'Promotion', 'saved' => false, 'formData' => null, 'tempFormData' => null)
            ),
            'sorting_order_prechat_window' => array(),
            'sorting_order_offline_window' => array(2),
            'tempFormData' => null
        );


        $insert = DB::table('subscriber_theme_entity')
                ->insertGetId([
            'subscriber_id' => $request->u_id,
            'theme_name' => "Default",
            'subscriber_website_id' => $request->web_id,
            'status' => 1
        if ($insert) {
            $webid = $request->web_id;
            $subscriberId = $request->u_id;
            $datas = $ChatComponentJsonData->all_window;
            $sub_website = SubscriberWebsite::where(['id' => $webid, 'is_branding' => 1])->get()->toArray();
            if (count($sub_website) > 0) {
                $sub = SubscriberWebsite::where('id', $webid)->with('buttonWindowDesign')->first();
                $window_data = json_decode($sub->buttonWindowDesign['all_window']);
                $datas['WindowFooterText'] = $window_data->WindowFooterText;
                $datas['FooterTextColore']['hex'] = $window_data->FooterTextColore->hex;
                $datas['BrandingType'] = $window_data->BrandingType;
                $datas['WindowFooterLogo'] = $window_data->WindowFooterLogo;
                $datas['chatWindowLink'] = $window_data->chatWindowLink;
            }
            DB::table('subscriber_website')
                    ->where('id', $webid)
                    ->update([
                        'active_theme_id' => $insert,
                        'added' => 0
            ]);
            //            if ($request->window) {
            DB::table('button_window_design')
                    ->insert([
                        'subscriber_id' => $subscriberId,
                        'theme_id' => $insert,
                        'online_button' => json_encode($ChatComponentJsonData->online_button),
                        'all_window' => json_encode($datas),
                        'windows_forms_list' => json_encode($windowsFormsList),
                        'windows_sorted_forms_list' => json_encode($windowsFormsList),
                        'created_by' => $subscriberId,
                        'created_at' => $currentDatetime,
                        'updated_by' => $subscriberId,
                        'updated_at' => $currentDatetime
            ]);
            //            }
        }

        SubscriberInvitees::where(['subscriber_id' => $request->u_id, 'user_id' => $request->u_id])->update([
            'timezone' => $companyData->timezone
        ]);
        $category = array(
            ['status' => 1, 'name' => 'News', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Getting Started', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Best Practices', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Inbox', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Monitoring', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Routing', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Channels', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Playbooks', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Contacts (CRM)', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Scheduling', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Tickets', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Knowledgebase', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Collaboration', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Reports', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['status' => 1, 'name' => 'Settings', 'subscriber_id' => $request->u_id, 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
        );
        Category::insert($category);
        WebsiteHelpCenter::create([
            'status' => 1,
            'header_color' => '#352B31',
            'header_text_color' => '#fff',
            'header_text' => 'Knowledgebase | Help Center',
            'website_id' => $request->web_id,
            'subscriber_id' => $request->u_id,
            'pagetype' => 2,
        ]);
        $eventSubject = array(
            ['subscriber_id' => $request->u_id, 'name' => 'Demo', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'name' => 'Sales', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'name' => 'Marketing', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'name' => 'Support', 'created_at' => $currentDatetime, 'updated_at' => $currentDatetime]
        );
        SubscriberEventSubjects::insert($eventSubject);
        $suggestionCat = array(
            ['subscriber_id' => $request->u_id, 'title' => 'Sales', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Marketing', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Customer Services', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Products', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Services', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Productivity', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'R&D', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'IT', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'HR', 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Finance', 'created_at' => $currentDatetime]
        );
        SBCategories::insert($suggestionCat);
        $defaultThread = array(
            ['subscriber_id' => $request->u_id, 'title' => 'Announcements', 'group_type' => 1, 'has_many_users' => 1, 'created_at' => $currentDatetime],
            ['subscriber_id' => $request->u_id, 'title' => 'Townhall', 'group_type' => 1, 'has_many_users' => 1, 'created_at' => $currentDatetime],
        );
        ClbThread::insert($defaultThread);
        $thread1 = ClbThread::where('subscriber_id', $request->u_id)->where('group_type', 1)->where('title', 'Announcements')->first();
        $thread2 = ClbThread::where('subscriber_id', $request->u_id)->where('group_type', 1)->where('title', 'Townhall')->first();
        $threadUser = array(
            ['user_id' => $request->u_id, 'thread_id' => $thread1->id, 'is_active' => 1, 'is_creator' => 1, 'created_at' => $currentDatetime],
            ['user_id' => $request->u_id, 'thread_id' => $thread2->id, 'is_active' => 1, 'is_creator' => 1, 'created_at' => $currentDatetime],
        );
        ThreadUsers::insert($threadUser);
        UserLoginLogs::Create(['subscriber_id' => $request->u_id, 'user_id' => $request->u_id, 'login_time' => date('Y-m-d H:i:s'), 'logout_time' => date('Y-m-d H:i:s'), 'login_status' => 1,]);
        $response = ['status' => 1, 'msg' => 'login successfully'];
        return Response::json($response);
    }
*/
    public function getStartTour($userid, $detailid)
    {
        $checkstep = $this->checksteps($userid, '4');
        if (!$checkstep['status']) {
            return redirect($checkstep['url']);
        }
        return view('start_tour', ['userid' => $userid, 'detailid' => $detailid]);
    }

    public function getStartConfigure()
    {
        return view('get_started');
    }

    public function StatusInsert()
    {
        $lastId = session()->get('UserId');
        $data = array(
            array('name' => 'Employment Lead', 'status' => 1, 'subscriber_id' => $lastId, 'is_deletable' => 0),
            array('name' => 'Sales Lead', 'status' => 1, 'subscriber_id' => $lastId, 'is_deletable' => 0),
            array('name' => 'Lost Sale', 'status' => 1, 'subscriber_id' => $lastId, 'is_deletable' => 0),
            array('name' => 'Customer/Subscriber', 'status' => 1, 'subscriber_id' => $lastId, 'is_deletable' => 0),
            array('name' => 'Employee', 'status' => 1, 'subscriber_id' => $lastId, 'is_deletable' => 0),
            array('name' => 'Other', 'status' => 1, 'subscriber_id' => $lastId, 'is_deletable' => 0),
        );
        DB::table('subscriber_ticket_tag')->insert($data);
    }

    public function colaborationDefaultInsertAdmin()
    {
        $lastId = session()->get('UserId');
        $data = array(
            array('subscriber_id' => $lastId, 'title' => 'Announcements', 'group_type' => 1),
            array('subscriber_id' => $lastId, 'title' => 'Townhall', 'group_type' => 1),
        );
        $isArr = array();
        foreach ($data as $val) {
            $isArr[] = DB::table('clb_threads')->insertGetId($val);
        }
        $datathreaduser = array(
            array('user_id' => $lastId, 'thread_id' => $isArr[0], 'is_active' => 1, 'is_starred' => 0, 'is_creator' => 0),
            array('user_id' => $lastId, 'thread_id' => $isArr[1], 'is_active' => 1, 'is_starred' => 0, 'is_creator' => 0),
        );
        DB::table('clb_thread_users')->insert($datathreaduser);
    }

    public function colaborationDefaultInsertUser($lastId)
    {


        $results = DB::table('users')
            ->join('clb_threads', 'clb_threads.subscriber_id', '=', 'users.parent_id')
            ->select('clb_threads.id as threadid')
            ->whereIn('clb_threads.title', ['Announcements', 'Townhall'])
            ->where('users.id', $lastId)->get();

        foreach ($results as $key => $val) {
            DB::table('clb_thread_users')->insert(
                [
                    'user_id' => $lastId,
                    'thread_id' => $val->threadid,
                    'is_active' => 1,
                    'is_starred' => 0,
                    'is_creator' => 0
                ]
            );
        }
    }

    public function SourceInsert()
    {
        $lastId = session()->get('UserId');

        $data = array(
            array('name' => 'Offline Form', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Support Email', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Website Form', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Chat', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'TIcket Add', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Contact Import', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Phone', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Contact Add', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Install Code', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Remove branding', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Hire our agents', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
            array('name' => 'Hire our programmers', 'status' => 1, 'sort_order' => 2, 'subscriber_id' => $lastId),
        );
        DB::table('subscriber_ticket_source')->insert($data);
    }

    public function getstipecust(Request $get)
    {

        $stripe = Stripe::make(Config::get('constants.stripe_connect.STRIPE_SECRET'));

        $customer = $stripe->customers()->create([
            'email' => 'john@doe.com',
            'description' => 'test custmr 2',
        ]);

        $customers = $stripe->customers()->all();
        echo "<pre>";
        print_r($customers);
        exit;
    }

    public function articleSearch(Request $request)
    {


        $subscriberId = $request->subid;
        $results = DB::table('knowledgebase_article')
            ->where('knowledgebase_article.subscriber_id', $subscriberId)
            ->where('knowledgebase_article.visibility', 1)
            ->where('knowledgebase_article.article', 'like', '%' . $request->searchkey . '%')
            ->get();

        if (count($results) == 0) {

            $getKey = $insert = DB::table('article_not_found_keywords')->where('keyword', $request->searchkey)->first();
            if (count($getKey) > 0) {
                $insert = DB::table('article_not_found_keywords')
                    ->where('id', $getKey->id)
                    ->update([
                        'count' => $getKey->count + 1
                    ]);
            } else {
                $insert = DB::table('article_not_found_keywords')
                    ->insert([
                        'keyword' => $request->searchkey,
                        'count' => 1
                    ]);
            }
        }
        $returnData = array();

        $categoryCountArr = array();

        $visiblity = array(1 => 'Public', 2 => 'Internal', 3 => 'Draft');

        $queryData = DB::table('knowledgebase_article')
            ->join('knowledgebase_article_category', 'knowledgebase_article_category.id', '=', 'knowledgebase_article.category')
            ->select(DB::raw('knowledgebase_article.category as category_id,knowledgebase_article_category.name,count(knowledgebase_article.category) as categoryCount'))
            ->where('knowledgebase_article.subscriber_id', $subscriberId)
            ->where('knowledgebase_article.visibility', 1)
            ->where('knowledgebase_article.article', 'like', '%' . $request->searchkey . '%')
            ->groupBy('knowledgebase_article.category')
            ->get();

        //      dd(DB::getQueryLog());
        //        exit;

        $usedCatID = array();
        foreach ($queryData as $data) {
            $usedCatID[] = ($data->category_id);
            $categoryCountArr[] = $data->name;
        }
        if (!empty($usedCatID)) {
            $useCatList = implode(", ", $usedCatID);
            $queryData1 = DB::select(DB::raw("select * from `knowledgebase_article_category` where `knowledgebase_article_category`.`id` not in ($useCatList) and knowledgebase_article_category.subscriber_id = $subscriberId"));
        } else {
            $queryData1 = DB::select(DB::raw("select * from `knowledgebase_article_category` where  `knowledgebase_article_category`.`subscriber_id` = $subscriberId"));
        }
        foreach ($queryData1 as $data) {
            $categoryCountArr[] = $data->name;
        }
        $catlist = DB::table('knowledgebase_article_category')
            ->where('knowledgebase_article_category.subscriber_id', $subscriberId)
            ->get();

        $returnData['category_count'] = $categoryCountArr;
        $returnData['catlist'] = $catlist;
        $returnData['cattype'] = 'all';
        $keyNames = array();
        foreach ($results as $result) {
            $keyNames = array();
            if (strpos($result->keywords, ',') !== false) {
                $keyid = explode(', ', $result->keywords);
            } else {
                $keyid = array();
                $keyid[] = $result->keywords;
            }
            foreach ($keyid as $kname) {
                $savedkeys = DB::table('knowledgebase_article_keywords')
                    ->where('knowledgebase_article_keywords.id', $kname)
                    ->first();
                //$keyNames[] = $savedkeys->name;
            }

            $returnData['category_list'][] = array('article_id' => $result->article_id, 'category_id' => $result->category, 'category' => $this->getCategoryName($result->category), 'title' => $result->title, 'visibility_id' => $result->visibility, 'visibility' => $visiblity[$result->visibility], 'created' => date('m-d-Y', strtotime($result->created_at)), 'last_updated' => date('m-d-Y', strtotime($result->updated_at)), 'keywords_id' => $result->keywords, 'keywords' => $keyNames, 'article' => $this->mb_stripos_all($result->article, $request->searchkey));
        }
        echo json_encode($returnData);
        exit;
    }

    public function mb_stripos_all($haystack, $needle)
    {
        $strArray = explode('.', strip_tags($haystack));
        $matched = array();
        foreach ($strArray as $key => $val) {
            if (strpos($val, $needle) !== false) {
                $repl = str_replace($needle, "<span class='highlight'>$needle</span>", $val);
                $matched[] = $repl;
            }
        }
        return $matched;
    }

    public function articleByLink($key)
    {
        $subscriberId = $this->FindIdByKey($key);
        $results = DB::table('knowledgebase_article')
            ->where('knowledgebase_article.subscriber_id', $subscriberId)
            ->where('knowledgebase_article.visibility', 1)
            ->get();

        $returnData = array();

        $categoryCountArr = array();

        $visiblity = array(1 => 'Public', 2 => 'Internal', 3 => 'Draft');

        $queryData = DB::table('knowledgebase_article')
            ->join('knowledgebase_article_category', 'knowledgebase_article_category.id', '=', 'knowledgebase_article.category')
            ->select(DB::raw('knowledgebase_article.category as category_id,knowledgebase_article_category.name,count(knowledgebase_article.category) as categoryCount'))
            ->where('knowledgebase_article.subscriber_id', $subscriberId)
            ->where('knowledgebase_article.visibility', 1)
            ->groupBy('knowledgebase_article.category')
            ->get();


        //      dd(DB::getQueryLog());
        //        exit;

        $usedCatID = array();
        foreach ($queryData as $data) {
            $usedCatID[] = ($data->category_id);
            $categoryCountArr[] = $data->name;
        }
        if (!empty($usedCatID)) {
            $useCatList = implode(", ", $usedCatID);
            $queryData1 = DB::select(DB::raw("select * from `knowledgebase_article_category` where `knowledgebase_article_category`.`id` not in ($useCatList) and knowledgebase_article_category.subscriber_id = $subscriberId"));
        } else {
            $queryData1 = DB::select(DB::raw("select * from `knowledgebase_article_category` where  `knowledgebase_article_category`.`subscriber_id` = $subscriberId"));
        }
        foreach ($queryData1 as $data) {
            $categoryCountArr[] = $data->name;
        }


        $returnData['category_count'] = $categoryCountArr;
        $returnData['cattype'] = 'all';
        $keyNames = array();
        foreach ($results as $result) {
            //            $keyNames = array();
            //            if (strpos($result->keywords, ',') !== false) {
            //                $keyid = explode(', ', $result->keywords);
            //            } else {
            //                $keyid = array();
            //                $keyid[] = $result->keywords;
            //            }
            //            foreach ($keyid as $kname) {
            //                $savedkeys = DB::table('knowledgebase_article_keywords')
            //                        ->where('knowledgebase_article_keywords.id', $kname)
            //                        ->first();
            //                //$keyNames[] = $savedkeys->name;
            //            }
            $catexp = explode(',', $result->category);
            foreach ($catexp as $k => $v) {
                $returnData['category_list'][] = array('article_id' => $result->article_id, 'category_id' => $result->category, 'category' => $this->getCategoryName($v), 'title' => $result->title, 'visibility_id' => $result->visibility, 'visibility' => $visiblity[$result->visibility], 'created' => date('m-d-Y', strtotime($result->created_at)), 'last_updated' => date('m-d-Y', strtotime($result->updated_at)), 'article' => $result->article);
            }
        }
        return view('/articlelink1', ['data' => json_encode($returnData), 'subid' => $subscriberId]);
    }

    public function getCategoryColumn(Request $request)
    {

        $subscriberId = 2;

        $ifexist = DB::table('kb_category_row_manage')
            ->where('subscriber_id', $subscriberId)
            ->first();

        if ($ifexist) {
            echo json_encode($ifexist->column_thead);
        } else {
            // echo "else";
            echo "0";
        }
        exit;
    }

    public function draggable(Request $get)
    {
        return view('draggabletable');
    }

    public function getCurrentLoggedInUser()
    {
        $logedinUser = Auth::user();
        //        echo Auth::user()->toJson();
        $registerdata = SubscriberCompanyDetails::where('subscriber_id', Auth::user()->parent_id)->first();
        $data = array(
            'id' => $logedinUser->id,
            'name' => $logedinUser->name,
            'avtar' => $logedinUser->avtar,
            'displayName' => $logedinUser->displayName,
            'is_available' => $logedinUser->is_available,
            'generated_id' => $logedinUser->generated_id,
            'role_id' => $logedinUser->role_id,
            'email' => $logedinUser->email,
            'user_role' => array('subscriber_id' => $logedinUser->user_role->subscriber_id, 'role_slug' => $logedinUser->user_role->role_slug),
            'subscriber_detail' => array('generated_id' => $logedinUser->subscriber_detail['generated_id']),
            'company_details' => $registerdata

        );

        if ($registerdata) {
            $country = DB::table('countries')->where('id', $registerdata->country)->first();
            if ($country) {
                $data['country_code'] = '+' . $country->phonecode;
                $data['country_code_id'] = $registerdata->country;
            }
        }
        $myJSON = json_encode($data);

        echo ($myJSON);
        exit;
    }

    public function getCurrentUserComany()
    {
        $loginUser = Auth::user();
        $loginUserId = $loginUser->id;
        $subscriberId = $loginUser['subscriber_detail']['id'];
        $company = SubscriberCompanyDetails::where('subscriber_id', $subscriberId)->first();
        if ($company) {
            $response = ['status' => 1, 'record' => $company];
            return response()->json($response);
        } else {
            $response = ['status' => 0, 'msg' => 'No record found.'];
            return response()->json($response);
        }
    }

    public function random_num($size)
    {

        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }
        $length = $size - 2;
        $key = '';
        $keys = range(0, 9);
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        $random_string = $alpha_key . $key;

        $checkunique = User::where('generated_id', $random_string)->first();
        if ($checkunique) {
            $this->random_num(9);
        }

        return $random_string;
    }

    public function mailsend(Request $request)
    {
        ini_set("SMTP", "ssl://smtp.gmail.com");
        ini_set("smtp_port", "465");
        ini_set('max_execution_time', '-1');
        $to = 'suryathesunshine89@gmail.com';
        $subject = 'Hello from XAMPP!';
        $message = 'This is a test';
        $headers = "From: squares.red2015@gmail.com\r\n";
        if (mail($to, $subject, $message, $headers)) {
            echo "SUCCESS";
        } else {
            echo "ERROR";
        }
    }

    public function deletecpanelemail(Request $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        $ip = '216.194.167.97'; // Need to Change.
        $account = "poster19"; // Need to Change.
        $domain = "freechat247live.com"; // Need to Change.
        $account_pass = "K85X4zm.1234"; // Need to Change.
        $xmlapi = new XmlapiController($ip);
        $xmlapi->password_auth($account, $account_pass);
        $xmlapi->set_output('json');
        $xmlapi->set_port('2083'); // Need to Change.
        $xmlapi->set_debug(1);


        $data = json_decode($xmlapi->api2_query("redsquares", "Email", "listpops", array(
            'regex' => '@freechat247live.com',
        )));


        $count = 0;
        foreach ($data->cpanelresult->data as $key => $val) {
            if ($val->email == 's.seeberg@freechat247live.com') {
                continue;
            }
            if ($val->email == 'care@freechat247live.com') {
                continue;
            }
            if ($val->email == 'demo@freechat247live.com') {
                continue;
            }
            if ($val->email == 'brand@freechat247live.com') {
                continue;
            }
            if ($val->email == 'code@freechat247live.com') {
                continue;
            }

            $count++;
            if ($count >= 150) {
                echo $count . "email deleted";
                exit;
            }

            $abc = str_replace('@freechat247live.com', '', $val->email);
            $delete_email_address = json_decode($xmlapi->api2_query("redsquares", 'Email', 'delpop', array(
                'domain' => $domain,
                'email' => $abc,
            )));
        }
    }

    public function ChekMailCronJob(Request $request)
    {
        ob_start();
        // $subscriberId = Auth::user()->id;
        $CpanelEmail = DB::table('subscriber_support_email')
            ->leftJoin('users', 'subscriber_support_email.subscriber_id', '=', 'users.id')
            ->select('subscriber_support_email.emailid as tickerEmail', 'users.id as ticketuser')
            ->get();

        // $CpanelEmail = array();
        $results = array();
        foreach ($CpanelEmail as $r) {

            ini_set("max_execution_time", 360);

            /* connect to server */
            $hostname = '{freechat247live.com:143/novalidate-cert}INBOX';
            $username = $r->tickerEmail;
            $password = '123456';

            /* try to connect */
            $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to domain:' . imap_last_error());

            /* grab emails */
            $emails = imap_search($inbox, 'UNSEEN');

            /* if emails are returned, cycle through eachÃ¢â‚¬Â¦ */
            if ($emails) {

                $output = "";

                /* put the newest emails on top */
                //            rsort($emails);
                $NumberOfEmail = imap_num_msg($inbox);
                /* for every emailÃ¢â‚¬Â¦ */
                foreach ($emails as $key => $email_number) {
                    $senderFname = '';
                    $senderLname = '';
                    $header = imap_header($inbox, $email_number); // get first mails header
                    $senderemail = $header->from[0]->mailbox . '@' . $header->from[0]->host;
                    $sendername = $header->from[0]->personal;
                    if (strpos($sendername, ' ')) {
                        $nameAr = explode(' ', $sendername);
                        $senderFname = $nameAr[0];
                        $senderLname = $nameAr[1];
                    } else {
                        $senderFname = $sendername;
                    }


                    $overview = imap_fetch_overview($inbox, $email_number, 1);
                    $mes = imap_fetchbody($inbox, $email_number, 1);
                    $subject = $overview[0]->subject;
                    $message = strip_tags($mes);
                    $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
                    preg_match_all($pattern, $message, $matches);


                    $subscriberNO = DB::table('users')
                        ->where('id', $r->ticketuser)
                        ->first();
                    $generateID = $this->random_num(6);
                    $ip = '216.194.167.97'; // Need to Change.
                    $account = "poster19"; // Need to Change.
                    $domain = "freechat247live.com"; // Need to Change.
                    $account_pass = "K85X4zm.1234"; // Need to Change.

                    $xmlapi = new XmlapiController($ip);
                    $xmlapi->password_auth($account, $account_pass);
                    $xmlapi->set_output('json');
                    $xmlapi->set_port('2083'); // Need to Change.
                    $xmlapi->set_debug(1);
                    $emailbyforward = $subscriberNO->generated_id . '_' . $overview[0]->uid . $generateID . "@freechat247live.com";
                    $data = json_decode($xmlapi->api2_query("redsquares", "Email", "addpop", array('domain' => $domain, 'email' => $emailbyforward, 'password' => '123456', 'quota' => '200')), true);

                    //                    mail('response2shiv@gmail.com', 'new cpanel email created - ' . $emailbyforward, 'this is notification message');


                    if (isset($data['cpanelresult']['data'][0]['result']) && $data['cpanelresult']['data'][0]['result']) {
                        //
                        //
                        $insertGetId = DB::table('chat_ticket')
                            ->insertGetId([
                                'subscriber_id' => $r->ticketuser,
                                'subject' => $overview[0]->subject,
                                'ticket_no' => $generateID . $overview[0]->uid,
                                'cpanel_email_id' => $emailbyforward,
                                'cpanel_email_password' => '123456',
                                'message' => $message,
                                'source' => 2
                            ]);
                        $data = array(
                            'id' => 1,
                            'm_type' => 'visitor',
                            'created_at' => date('Y-m-d H:i:s'),
                            'visitor_name' => $senderFname,
                            'subject' => $subject,
                            'message' => $message
                        );
                        $threadModel = new Thread();
                        $jmessage[] = $threadModel->message(2, $data);



                        $thread = Thread::create([
                            'subscriber_id' => $r->ticketuser,
                            'visitor_firstname' => $senderFname,
                            'visitor_lastname' => $senderLname,
                            'visitor_email' => $senderemail,
                            'visitor_product_and_services' => 0,
                            'visitor_location' => '',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'agent_id' => 0,
                            'agent_name' => '',
                            'visitor_typing_message' => '',
                            'agent_typing_message' => '',
                            'is_visitor_typing' => 0,
                            'is_agent_typing' => 0,
                            'lastpingagent' => 1,
                            'lastpingvisitor' => 1,
                            'messageCount' => count($jmessage),
                            'messages' => serialize(json_encode($jmessage)),
                            'thread_status' => 1,
                            'chat_type' => 2,
                        ]);
                    }
                }
            } else {
                echo json_encode(array('status' => 'fail', 'message' => "No Unseen email found"));
                exit;
            }
        }
        imap_close($inbox);
    }

    public function InsertTicketInThread(Request $request)
    {
    }

    public function showArticlePage($articleid)
    {

        $data = Input::all();


        $results = DB::table('knowledgebase_article')
            ->where('article_id', $articleid)
            ->first();
        //         print_r($results);
        //         exit;
        $likes = $results->likes;
        $dislikes = $results->dislikes;
        if ($likes == 0) {

            $roudper = 0;
        } else {
            $percentage = ($likes / ($likes + $dislikes)) * 100;
            $roudper = round($percentage);
        }

        if (isset($data['search'])) {
            return view('articlepage', ['data' => json_encode($results), 'search' => $data['search'], 'percentage' => $roudper]);
        } else {
            return view('articlepage', ['data' => json_encode($results), 'percentage' => $roudper]);
        }
    }

    public function getRelatedArticle(Request $get)
    {

        $keywords = explode(',', $get->keywords);

        $knowledgebase = array();
        $subq = "";
        $i = 0;
        foreach ($keywords as $key => $val) {

            if ($i == 0) {
                $i++;
                $subq .= "  FIND_IN_SET('" . $val . "',keywords)";
            } else {
                $subq .= " OR FIND_IN_SET('" . $val . "',keywords)";
            }
        }
        //  DB::enableQueryLog();
        $knowledgebase = DB::select("SELECT * FROM `knowledgebase_article` WHERE 1=1 AND ($subq)");
        //        SELECT * FROM `knowledgebase_article` WHERE 1 = 1 FIND_IN_SET('60', keywords) OR FIND_IN_SET('61', keywords)
        //    dd(DB::getQueryLog());
        echo json_encode($knowledgebase);
        exit;
    }

    public function articleLikeDislike(Request $get)
    {
        $actiontype = 1;
        $article_id = $get->article_id;
        if ($get->like) {
            $likes = $get->like;
            DB::table('knowledgebase_article')
                ->where('article_id', $article_id)
                ->update([
                    'likes' => $likes,
                ]);
            $actiontype = 1;
        }
        if ($get->dislike) {
            $dislikes = $get->dislike;
            DB::table('knowledgebase_article')
                ->where('article_id', $article_id)
                ->update([
                    'dislikes' => $dislikes,
                ]);
            $actiontype = 2;
        }
        if ($get->satisfy) {
            $satisfy = $get->satisfy;
            DB::table('knowledgebase_article')
                ->where('article_id', $article_id)
                ->update([
                    'satisfy' => $satisfy,
                ]);
            $actiontype = 3;
        }


        $knowlegArtViewLog = [
            'article_id'     =>    $article_id,
            'action'         =>    $actiontype,
            'source'         =>    1,
            'created_at'     =>    date('Y-m-d H:s:a'),
        ];
        DB::table('knowledgebase_article_view_log')->insert($knowlegArtViewLog);
        $articles = DB::table('knowledgebase_article')
            ->where('article_id', $article_id)
            ->first();

        echo json_encode($articles);
        exit;
    }

    public function getStep1(Request $get)
    {
        $redId = $_REQUEST['redid'];

        $results = DB::table('users')->where('redirect_key', $redId)->first();


        if ($results) {
            session()->put('UserId', $results->id);
            session()->put('name', $results->name);
            session()->put('email', $results->email);
            session()->put('password', $results->unhash_password);
            session()->save();
            return view('pages.user.register-step1');
        }
    }

    public function checkUserEmail(Request $request)
    {

        if ($request->email != '') {
            $results = DB::table('users')->where('email', $request->email)->first();
            if ($results) {
                $fname = explode(' ', $results->name);
                $request->session()->put('emailval', $results->email);
                $request->session()->put('firstname', $fname[0]);
                $request->session()->put('validpass', 1);

                $request->session()->save();
                echo json_encode(array('status_code' => '1', 'fname' => $fname[0], 'emailval' => $results->email));
                exit;
            } else {
                echo json_encode(array('status_code' => '2'));
                exit;
            }
        } else {
            json_encode(array('status_code' => '3'));
            exit;
        }
        exit;
    }

    public function stepOneSave(Request $request)
    {

        $UserId = session()->get('UserId');
        $companyname = $request->companyname;
        $websiteaddress = $request->websiteaddress;
        $chatStatus = $request->chatStatus;
        $companyParentid = $request->companyParentid;


        if ($companyParentid) {
            $company = Company::where('id', $companyParentid)
                ->first()
                ->toArray();
            $update = DB::table('users')
                ->where('id', $UserId)
                ->update([
                    'parent_id' => $company['subscriber_id'],
                ]);
            $company_id = $company['id'];
        } else {
            $company_id = Company::create([
                'subscriber_id' => $UserId,
                'company_name' => $companyname,
                'chat_purpose' => $chatStatus,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 1,
            ])->id;
            // check website existance if already exist then send email to system admin
            if ($websiteDetail = SubscriberWebsite::where(['website_url' => $websiteaddress])->first()) {
                $user = User::find($websiteDetail->subscriber_id);
                $this->sendDuplicateWebsiteRemainderMail($websiteDetail, $user);
            }
            $website_id = SubscriberWebsite::create([
                'subscriber_id' => $UserId,
                'website_url' => $websiteaddress,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_by' => $UserId,
                'dkim_selector' => 'p1',
                'status' => 1,
            ])->id;

            DB::table("invitee_table_field")->insert([
                'subscriber_id' => $UserId,
                'invitee_id' => 1,
                'name' => 1,
                'display_name' => 1,
                'email' => 1,
                'system_role' => 1,
                'login_status' => 0,
                'max_chats' => 0,
                'timezone' => 0,
                'department' => 0,
                'default_view' => 0,
                // 'email_transcript' => 0,
                'status' => 1,
                'is_activated' => 1,
                'created_at' => 0,
                'updated_at' => 0,
                'avatar' => 1,
                'time_plan' => 0,
                'lead_score' => 1,
            ]);



            session()->put('company', $companyname);
            session()->put('websiteaddress', $websiteaddress);
            session()->put('chatStatus', $chatStatus);
        }

        $this->insertInInvitee($UserId);


        session()->put('company_id', $company_id);

        session()->save();

        if ($website_id) {
            echo "success";
        } else {
            echo '0';
        }

        exit;
    }

    public function insertInInvitee($UserId)
    {

        $getuser = DB::table('users')
            ->where('id', $UserId)
            ->first();
        $parentid = $getuser->parent_id;

        if ($getuser->parent_id == 0) {
            $parentid = $UserId;
        }
        $email_token = $this->random_num(9) . 'invite' . Carbon::now()->timestamp;

        $ins = DB::table('subscriber_invitees')
            ->insertGetId([
                'subscriber_id' => $parentid,
                'email_token' => $email_token,
                'agentname' => $getuser->name,
                'email' => $getuser->email,
                'user_id' => $UserId,
                'role_input' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s'),
                'displayname' => '',
                'cell_phone' => '',
                'timezone' => '',
                'status_on_login' => 1,
                'login_default_view' => 1,
                'maxchat' => 0,
                'avatar' => '',
                'status' => 1,
                'is_activated' => 1,
            ]);
    }

    public function step2Save(Request $request)
    {

        $UserId = session()->get('UserId');
        $Industry = $request->industry_input;
        $Employees = $request->emp_input;
        $Country = $request->country_input;
        $audience = $request->audience_radio;
        $timezone = $request->timezone;

        $step2 = Company::where('subscriber_id', $UserId)->update([
            'industry' => $Industry,
            'num_of_employees' => $Employees,
            'country' => $Country,
            'timezone' => $timezone,
            'audience' => $audience,
        ]);

        if ($step2) {
            session()->put('Industry', $Industry);
            session()->put('Employees', $Employees);
            session()->put('Country', $Country);
            session()->put('audience', $audience);
            session()->put('timezone', $timezone);
            session()->save();

            echo "success";
        } else {
            echo "not update";
        }
        exit;
    }

    public function getsession(Request $request)
    {

        $sesions = array();


        $sesions['UserId'] = session()->get('UserId');
        $sesions['email'] = session()->get('email');
        $sesions['company'] = session()->get('company');
        $sesions['websiteaddress'] = session()->get('websiteaddress');
        $sesions['name'] = session()->get('name');

        echo json_encode($sesions);
        exit;
    }

    public function addWebsiteRegister(Request $request)
    {
        $UserId = session()->get('UserId');
        // check website existance if already exist then send email to system admin
        if ($websiteDetail = SubscriberWebsite::where(['website_url' => $request->website])->first()) {
            $user = User::find($websiteDetail->subscriber_id);
            $this->sendDuplicateWebsiteRemainderMail($websiteDetail, $user);
        }
        $websiteQ = SubscriberWebsite::create([
            'subscriber_id' => $UserId,
            'website_url' => $request->website,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_by' => $UserId,
            'status' => 1,
        ])->id;
        if ($websiteQ) {
            //                  $all = Website::where('subscriber_id',$UserId)->get()->toArray();
            //                  print_r($all);
            echo "1";
        }
        exit;
    }

    public function getstep2(Request $request)
    {


        return view('pages.user.register-step2');
    }

    public function getIndustryCountryempoloyeeNumber()
    {
        $data = array();
        $industry_dropdown = DB::table('industry_dropdown')->get();
        $country = DB::table('countries')->get();
        $employee_numbers = DB::table('employee_numbers')->get();

        $data['industry'] = $industry_dropdown;
        $data['country'] = $country;
        $data['empnum'] = $employee_numbers;

        echo json_encode($data);
        exit;
    }

    public function getstep3(Request $request)
    {


        return view('pages.user.register-step3');
    }

    public function getRoles()
    {

        $roles = DB::table('user_role')->get();
        echo json_encode($roles);
        exit;
    }

    public function step3save(Request $request)
    {


        //        $generateID = $this->random_num(9);
        //        $email_token = $this->random_num(9) . 'invite' . Carbon::now()->timestamp;
        //        $redirectKey = Str::random(60) . time();
        //        $data = $request->rowsArr;
        //
        //        $lastId = session()->get('UserId');
        //        $count = 0;
        //        foreach ($data as $key => $val) {
        //
        //
        //            $ins = DB::table('subscriber_invitees')
        //                    ->insertGetId([
        //                'subscriber_id' => $lastId,
        //                'email_token' => $email_token,
        //                'agentname' => $val['agentname'],
        //                'email' => $val['email'],
        //                'role_input' => 3,
        //                'created_at' => date('Y-m-d H:i:s'),
        //                'update_at' => date('Y-m-d H:i:s'),
        //                'displayname' => '',
        //                'cell_phone' => '',
        //                'status_on_login' => '',
        //                'maxchat' => '',
        //                'update_at' => date('Y-m-d H:i:s'),
        //                'avatar' => '',
        //                'table_type' => 1
        //            ]);
        //
        //            $count++;
        //        }
        //        if ($count == count($data)) {

        echo "success";
        //        } else {
        //
        //            echo "0";
        //        }

        exit;
    }

    public function finalSave(Request $request)
    {
        //        $lastId = $_SESSION['UserId'];

        $lastId = session()->get('UserId');
        DB::table('ticket_table_fields')
            ->insert([
                'subscriber_id' => $lastId,
            ]);

        //status insert

        $this->SourceInsert($lastId);
        $this->StatusInsert($lastId);

        $role = DB::table('users')->where('id', $lastId)->first();
        if ($role->role_id == 1) {
            $this->colaborationDefaultInsertAdmin();
        } else {
            $this->colaborationDefaultInsertUser($lastId);
        }


        //        $fromEmail = $request->from_email;
        //        $footer_text = $request->email_footer_text;
        //        $footer_url = $request->email_footer_url;
        //        $chat_window_bottom = $request->name_of_chatwindow;
        //        if ($file = $request->hasFile('software_logo')) {
        //            $file = $request->file('software_logo');
        //            $fileName = $file->getClientOriginalName();
        //            $destinationPath = public_path() . '/images/';
        //            $file->move($destinationPath, $fileName);
        //        } else {
        //            return view();
        //        }
        //        $insert = DB::table('transcript_from_email')
        //                ->insert([
        //            'subscriber_id' => $lastId,
        //            'from_email' => $fromEmail,
        //            'email_footer_text' => $footer_text,
        //            'email_footer_url' => $footer_url,
        //            'name_of_chatwindow' => $chat_window_bottom,
        //            'software_logo' => $fileName,
        //            'created_at' => date('Y-m-d H:i:s'),
        //            'updated_at' => date('Y-m-d H:i:s')
        //        ]);
        //        if ($insert) {
        //            DB::table('ticket_table_fields')
        //                    ->insert([
        //                        'subscriber_id' => $lastId,
        //            ]);
        //            session()->put('fromEmail', $fromEmail);
        //            session()->put('footer_text', $footer_text);
        //            session()->put('footer_url', $footer_url);
        //            session()->put('chat_window_bottom', $chat_window_bottom);
        //            session()->save();
        //
        //            $mailLog = session('email');
        //            $pasLog = session('password');
        //            Auth::attempt(['email' => $mailLog, 'password' => $pasLog]);
        //            session()->forget('fromEmail');
        //            session()->forget('footer_text');
        //            session()->forget('footer_url');
        //            session()->forget('chat_window_bottom');
        //            session()->forget('roleEmail');
        //            session()->forget('roleId');
        //            session()->forget('Industry');
        //            session()->forget('Employees');
        //
        //            session()->forget('Country');
        //            session()->forget('audience');
        //            session()->forget('company');
        //            session()->forget('websiteaddress');
        //            session()->forget('chatStatus');


        return Redirect($this->url->to(''));
        //        }
    }

    public function logout()
    {
        if (Auth::user() !== null) {
            // check login status
           /* User::where('id', Auth::user()->id)->update([
                'is_logged_in' => '0',
                'is_available' => '2',
                'last_login_check' => DB::raw('CURRENT_TIMESTAMP')
            ]);*/

            //        User::where(DB::raw('UNIX_TIMESTAMP(`last_login_check`)'), '<', DB::raw('UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - 90'))->update([
            //            'is_logged_in' => '0',
            //        ]);

            /*$lastinsertedid = UserLoginLogs::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()->id;

            UserLoginLogs::where('id', $lastinsertedid)->update([
                'logout_time' => date('Y-m-d H:i:s'),
                'login_status' => 0,
            ]);*/

           // $google2Fa = new \App\Http\Controllers\Google2fa\Auth2fa();
          //  $google2Fa->logout2fa();
            // check login status
            auth()->logout();
        }
        // session()->flash('message', 'Some goodbye message');

        return redirect('/login');
    }

    public function changeUserAvailablityStatus()
    {
        $loginUser = Auth::user();
        $loginUserId = $loginUser->id;
        $subscriberId = $loginUser['subscriber_detail']['id'];
        $subscriberGeneratedId = $loginUser['subscriber_detail']['generated_id'];

        $loginUserData = User::where('id', $loginUserId)->first();
        if ($loginUserData->is_available == '1') {
            User::where('id', $loginUserId)->update([
                'is_available' => 2,
                'last_login_check' => DB::raw('CURRENT_TIMESTAMP')
            ]);

            DB::table('user_availablity_log')->insert(
                ['subscriber_id' => $subscriberId, 'user_id' => $loginUserId, 'is_available' => 2, 'created_at' => DB::raw('CURRENT_TIMESTAMP')]
            );
        } else if ($loginUserData->is_available == '2') {
            User::where('id', $loginUserId)->update([
                'is_available' => 1,
                'last_login_check' => DB::raw('CURRENT_TIMESTAMP')
            ]);

            DB::table('user_availablity_log')->insert(
                ['subscriber_id' => $subscriberId, 'user_id' => $loginUserId, 'is_available' => 1, 'created_at' => DB::raw('CURRENT_TIMESTAMP')]
            );
        }
        exit;
    }

    public function getRoleList()
    {
        $loginUser = Auth::user();
        $loginUserId = $loginUser->id;
        $subscriberId = $loginUser['subscriber_detail']['id'];

        $results = DB::table('roles')
            ->where('subscriber_id', $subscriberId)
            ->get();
        echo json_encode($results);
        exit;
    }

    public function getSkillList()
    {
        $authId = Auth::user()->id;
        $results = DB::table('user_skill')
            ->where('subscriber_id', $authId)
            ->get();
        echo json_encode($results);
        exit;
    }

    public function addSkill(Request $request)
    {
        $authId = Auth::user()->id;
        $insert = DB::table('user_skill')
            ->insertGetId([
                'subscriber_id' => $authId,
                'name' => $request->name
            ]);
        $results = DB::table('user_skill')
            ->where('id', $insert)
            ->first();
        if ($insert != '') {
            echo json_encode($results);
            exit;
        }
    }

    public function UpdateSkill(Request $request)
    {

        $update = DB::table('user_skill')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
            ]);
        if ($update) {
            echo "done";
        } else {
            echo "error";
        }
        exit;
    }

    public function DeleteSkill(Request $request)
    {
        DB::table('user_skill')
            ->where('id', '=', $request->id)
            ->delete();
        //        DB::table('chat_ticket')
        //                ->where('prodserve', '=', $request->id)
        //                ->delete();
        echo "deleted";
        exit;
    }

    public function FindIdByKey($key)
    {

        $uId = DB::table('users')
            ->where('generated_id', '=', $key)
            ->first();
        return $uId->id;
    }

    public function getArticleListGroupByArticle1(Request $request)
    {

        $tid = $request->userKey;

        $subscriberId = $this->FindIdByKey($tid);
        $filterVisiblityId = '';

        if (isset($request->filter)) {
            $results = DB::table('knowledgebase_article')
                ->join('knowledgebase_keyword_by_article', 'knowledgebase_keyword_by_article.article_id', '=', 'knowledgebase_article.article_id')
                ->select('knowledgebase_article.*', 'knowledgebase_keyword_by_article.category_id as cats')
                ->where('knowledgebase_article.subscriber_id', $subscriberId);

            if ($request->filter_visiblity) {
                $results = $results->where('knowledgebase_article.visibility', $request->filter_visiblity);
            }
            if ($request->cat) {
                $results = $results->whereRaw("find_in_set($request->cat,knowledgebase_article.category)");
            }

            $results = $results->groupBy('knowledgebase_article.article_id');
            $results = $results->get();
        } else {
            if (isset($request->show)) {

                $results = DB::table('knowledgebase_article')
                    ->join('knowledgebase_keyword_by_article', 'knowledgebase_keyword_by_article.article_id', '=', 'knowledgebase_article.article_id')
                    ->select('knowledgebase_article.*', 'knowledgebase_keyword_by_article.category_id as cats')
                    ->where('knowledgebase_article.subscriber_id', $subscriberId)
                    ->where('knowledgebase_article.visibility', '!=', 1)
                    ->get();
            } else {

                $results = DB::table('knowledgebase_article')
                    ->join('knowledgebase_keyword_by_article', 'knowledgebase_keyword_by_article.article_id', '=', 'knowledgebase_article.article_id')
                    ->select('knowledgebase_article.*', 'knowledgebase_keyword_by_article.category_id as cats')
                    ->where('knowledgebase_article.subscriber_id', $subscriberId)
                    ->where('knowledgebase_article.visibility', '!=', 3)
                    ->get();
            }
        }

        $returnData = array();

        $categoryCountArr = array();

        $visiblity = array(1 => 'Public', 2 => 'Internal', 3 => 'Draft');
        //  DB::enableQueryLog();
        // $queryData = array();
        if (isset($request->show)) {
            $queryData = DB::table('knowledgebase_article')
                ->join('knowledgebase_keyword_by_article', 'knowledgebase_keyword_by_article.article_id', '=', 'knowledgebase_article.article_id')
                ->join('knowledgebase_article_category', 'knowledgebase_article_category.id', '=', 'knowledgebase_keyword_by_article.category_id')
                ->select(DB::raw('knowledgebase_keyword_by_article.category_id as category_id,knowledgebase_article_category.name,count(knowledgebase_keyword_by_article.category_id) as categoryCount'))
                ->where('knowledgebase_article.subscriber_id', $subscriberId)
                ->where('knowledgebase_article.visibility', '!=', 1)
                ->groupBy('knowledgebase_keyword_by_article.category_id')
                ->get();
        } else {

            $queryData = DB::table('knowledgebase_article')
                ->join('knowledgebase_keyword_by_article', 'knowledgebase_keyword_by_article.article_id', '=', 'knowledgebase_article.article_id')
                ->join('knowledgebase_article_category', 'knowledgebase_article_category.id', '=', 'knowledgebase_keyword_by_article.category_id')
                ->select(DB::raw('knowledgebase_keyword_by_article.category_id as category_id,knowledgebase_article_category.name,count(knowledgebase_keyword_by_article.category_id) as categoryCount'))
                ->where('knowledgebase_article.subscriber_id', $subscriberId)
                ->where('knowledgebase_article.visibility', '!=', 3)
                ->groupBy('knowledgebase_keyword_by_article.category_id')
                ->get();
        }
        //      dd(DB::getQueryLog());
        //        exit;

        $usedCatID = array();
        foreach ($queryData as $data) {
            $usedCatID[] = ($data->category_id);
            $categoryCountArr[] = $data->name;
        }
        if (!empty($usedCatID)) {
            $useCatList = implode(",", $usedCatID);
            $queryData1 = DB::select(DB::raw("select * from `knowledgebase_article_category` where `knowledgebase_article_category`.`id` not in ($useCatList) and knowledgebase_article_category.subscriber_id = $subscriberId"));
        } else {
            $queryData1 = DB::select(DB::raw("select * from `knowledgebase_article_category` where  `knowledgebase_article_category`.`subscriber_id` = $subscriberId"));
        }
        foreach ($queryData1 as $data) {
            $categoryCountArr[] = $data->name;
        }


        $returnData['category_count'] = $categoryCountArr;
        $keyNames = array();
        foreach ($results as $result) {



            //            $keyNames = array();
            //            if (strpos($result->keywords, ',') !== false) {
            //                $keyid = explode(',', $result->keywords);
            //            } else {
            //                $keyid = array();
            //                $keyid[] = $result->keywords;
            //            }
            //            foreach ($keyid as $kname) {
            //                $savedkeys = DB::table('knowledgebase_article_keywords')
            //                        ->where('knowledgebase_article_keywords.id', $kname)
            //                        ->first();
            //                $keyNames[] = $savedkeys->name;
            //            }



            $returnData['category_list'][] = array('article_id' => $result->article_id, 'category_id' => $result->cats, 'category' => $this->getCategoryName($result->cats), 'title' => $result->title, 'visibility_id' => $result->visibility, 'visibility' => $visiblity[$result->visibility], 'created' => date('m-d-Y', strtotime($result->created_at)), 'last_updated' => date('m-d-Y', strtotime($result->updated_at)), 'keywords_id' => $result->keywords, 'article' => $result->article);
        }
        //        $returnData['articleUploadPath'] = url('images/articles/' . Auth::user()->generated_id);
        echo json_encode($returnData);
        exit;
    }

    public function getCategoryName($id)
    {

        $results = DB::table('knowledgebase_article_category')
            ->where('knowledgebase_article_category.id', $id)
            ->first();

        return $results->name;
    }

    public function getWebsiteHelpCenter(Request $request)
    {

        $results = DB::table('website_help_center')
            ->where('website_help_center.subscriber_id', $request->userKey)
            ->first();
        echo json_encode($results);
        exit;
    }

    public function getcompanyName(Request $request)
    {
        $subscriberId = $this->FindIdByKey($request->userKey);
        $results = DB::table('users')
            ->where('users.id', $subscriberId)
            ->first();

        echo json_encode($results);
        exit;
    }

    public function getCompanyList(Request $request)
    {

        $companyName = $request->companyname;
        //        $results = DB::table('users')
        //                ->select('company_name as name', 'id as comId')
        //                ->where('users.company_name', 'like', "$companyName%")
        //                ->where('users.parent_id', '=', 0)
        //                ->get();
        //
        //        echo json_encode($results);
        //        exit;
        $companies = Company::where('company_name', 'like', "$companyName%")
            ->select('company_name as name', 'id as comId')
            ->get();
        echo json_encode($companies);
        exit;
    }

    public function checkCompanyExist(Request $request)
    {

        $companyName = trim($request->companyname);
        $companies = Company::where('company_name', 'like', "$companyName")
            ->select('company_name as name', 'id as comId')
            ->first();
        echo json_encode($companies);
        exit;
    }

    public function subscribeAschatagent(Request $request)
    {

        $parentid = Company::where('id', $request->parentcompanyid)
            ->select('subscriber_id as parent_id')
            ->first();
        $lastId = session()->get('UserId');
        $update = User::where('id', $lastId)->update([
            'parent_id' => $parentid->parent_id,
            'role_id' => 3
        ]);
        if ($update) {

            $this->insertInInvitee($lastId);

            echo "success";
        } else {
            echo "error";
        }
        exit;
    }

    public function getGuest(Request $request)
    {

        $token = $request->token;
        //       exit;
        if ($token != '' && isset($token)) {
            $invite = Inviteuser::where('guestToken', $token)->first();


            return view('inviteguest', ['user' => $invite]);
            // return redirect("http://dev.local.com/chat/guest?token=$token");
        } else {

            echo "URL has No Token";
            exit;
        }
    }

    public function invitetoken(Request $request)
    {
        $token = $request->invitetoken;
        if (isset($token) && $token != '') {
            $invite = DB::table('subscriber_invitees')->where('email_token', $token)->where('status', 0)->first();
            $agfname = 'Agent';
            if ($invite && !(DB::table('users')->where('email', $invite->email)->exists())) {
                if ($invite->agentname != '') {
                    $agexp = explode(' ', $invite->agentname);
                    $agfname = $agexp[0];
                }
                return view('auth.invitepassword', ['inviteeId' => $invite->id], ['agentname' => ucfirst($agfname)]);
            } else {
                echo "Token is used";
                exit;
            }
            // return redirect("http://dev.local.com/chat/guest?token=$token");
        } else {

            echo "URL has No Token";
            exit;
        }
    }

    public function saveInviteeAsUser(Request $request)
    {

        $redirectKey = Str::random(60) . time();
        $generateID = $this->random_num(9);
        $password = $request->password;
        $confirm_password = $request->confirm_password;
        $inviteeId = $request->inviteeId;

        $agfname = 'Agent';
        $invite = DB::table('subscriber_invitees')->where('id', $inviteeId)->first();
        if ($invite) {
            if ($invite->agentname != '') {
                $agexp = explode(' ', $invite->agentname);
                $agfname = $agexp[0];
            }
        }

        if (preg_match("/[a-zA-Z]/", $request->password) && preg_match("/[^a-zA-Z\d]/", $request->password) && strlen($request->password) > 7) {
        } else {
            $errormsg = "Must be at least 8 characters, include at least one upper, lower case letter and one special character.";
            return view('auth.invitepassword', ['errormsg' => $errormsg, 'inviteeId' => $inviteeId], ['agentname' => ucfirst($agfname)]);
        }
        if ($password == $confirm_password) {

            $invite = DB::table('subscriber_invitees')->where('id', $inviteeId)->first();
            $parentdata = DB::table('subscriber_company_details')->where('subscriber_id', $invite->subscriber_id)->first();
            $parentUser = User::find($invite->subscriber_id);
            $avatar = $this->createDefaultAvatar($parentUser->generated_id, $generateID);

            $inviteeinserted = User::create([
                'parent_id'       => $invite->subscriber_id,
                'name'            => $invite->agentname,
                'displayName'     => $invite->displayname,
                'email'           => $invite->email,
                'password'        => bcrypt($password),
                'generated_id'    => $generateID,
                'avtar'           => $avatar['file_name'],

                'signup_step'     => 4,
                'system_role_id'  => $invite->system_role,
                'redirect_key'    => $redirectKey,
                'remember_token'  => Str::random(60)

            ]);
            $website_url = DB::table('subscriber_website')->where(['subscriber_id' => $invite->subscriber_id])->pluck('website_url');
            $this->createDefaultSignature($inviteeinserted, $parentdata->company_name, $website_url, $avatar['file_path']);

            $timezone = DB::table('subscriber_invitees')->where(['user_id' => $invite->subscriber_id])->pluck('timezone');
            $update = DB::table('subscriber_invitees')
                ->where('id', $inviteeId)
                ->update([
                    'avatar'           => $avatar['file_name'],
                    'status'       => 1,
                    'timezone' => isset($timezone[0]) ? $timezone[0] : 0,
                    'status_on_login' => 1,
                    'login_default_view' => 1,
                    'is_activated' => 1,
                    'maxchat' => 0,
                    'user_id'      => $inviteeinserted->id
                ]);
            //code for create teammate as contact
            $teammate = SubscriberInvitees::where('email', $invite->email)->where("subscriber_id", 1)->where('table_type', 2)->first();
            if ($teammate) {
                if ($teammate->is_deleted) {
                    $teammate->is_deleted = 0;
                }
                $teammate->contact_id = $inviteeinserted->id;
                $teammate->agentname = $invite->agentname;
                $teammate->displayname = $invite->$invite->displayname;
                $teammate->timezone = isset($timezone[0]) ? $timezone[0] : 0;
                $teammate->update_at = Carbon::now();
                $teammate->save();
                $this->addCustomfieldValue($teammate->id, $type = 'teammate');
            } else {
                $add_contact = DB::table('subscriber_invitees')->insertGetId([
                    'agentname' => $invite->agentname,
                    'displayname' => $invite->displayname,
                    'email' => $invite->email,
                    'subscriber_id' => 1,
                    'user_id' => 0,
                    'contact_id' => $inviteeinserted->id,
                    'table_type' => 2,
                    'timezone' => isset($timezone[0]) ? $timezone[0] : 0,
                    'created_at' => Carbon::now(),
                    'update_at' => Carbon::now()
                ]);
                $this->addCustomfieldValue($add_contact, $type = "Teammate");
            }

            $this->saveInviteeOtherDependencies($invite->subscriber_id, $inviteeinserted->id);

            $this->colaborationDefaultInsertUser($inviteeinserted->id);
            $this->InsertDefaultSegments($inviteeinserted);
            if ($update && $inviteeinserted) {
                $this->sendWelcomeEmail($invite, $parentdata);
            }
            Auth::loginUsingId($inviteeinserted->id);
            $this->manageFirstTimeLogin($inviteeinserted);

            $errormsg = "Registered succesfully";
            return Redirect($this->url->to('get-started'));
        } else {

            $errormsg = "Password and confirm password are not same";
            return view('auth.invitepassword', ['errormsg' => $errormsg, 'inviteeId' => $inviteeId], ['agentname' => ucfirst($agfname)]);
        }
    }

    public function addCustomfieldValue($id, $type)
    {
        $addASContactCustomValue = CustomAttributeValue::firstOrCreate(
            ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_user_type'],
            ['feild_type_code' => 'sdt_text', 'feild_value' => $type]

        );
    }
    /**
     * create default avatar
     * param subscriberGeneratedId, userGeneratedId
     */
    public function createDefaultAvatar($subscriberGeneratedId, $userGeneratedId)
    {
        $directoryPath = public_path('images/subscriber/') . $subscriberGeneratedId;
        if (!File::isDirectory($directoryPath)) {
            //make the directory because it doesn't exists
            File::makeDirectory($directoryPath, 0777, true);
        }
        File::copy(public_path('images/subscriber/avatar.jpg'), public_path('images/subscriber/' . $subscriberGeneratedId . '/' . $userGeneratedId . '.jpg'));
        return array('file_name' => $userGeneratedId . '.jpg', 'file_path' => url('images/subscriber/' . $subscriberGeneratedId . '/' . $userGeneratedId . '.jpg'));
    }
    /**
     * create default avatar
     * param subscriberGeneratedId, userGeneratedId
     */
    public function createDefaultSignature($userData, $company_name, $website_url, $defaultLogo)
    {
        $ticketSignSett = array(
            'signatureName' => NULL,
            'mainPhotoLoc' => 'Side',
            'mainPhotoType' => '50%',
            'mainPhotoAgent' => $defaultLogo,
            'fontSize' => '14',
            'mainPhotoDefault' =>
            array(
                'isActive' => false,
                'value' => '1',
            ),
            'name' =>
            array(
                'isActive' => true,
                'value' => $userData->name,
            ),
            'title' =>
            array(
                'isActive' => false,
                'value' => '',
            ),
            'phone' =>
            array(
                'isActive' => false,
                'value' => '',
            ),
            'mobile' =>
            array(
                'isActive' => false,
                'value' => '',
            ),
            'address' =>
            array(
                'isActive' => false,
                'value' => '',
            ),
            'company' =>
            array(
                'isActive' => true,
                'value' => $company_name,
            ),
            'website' =>
            array(
                'isActive' => true,
                'value' => isset($website_url[0]) ? $website_url[0] : 0,
            ),
            'logo' =>
            array(
                'isActive' => true,
                'imgSrc' => $defaultLogo,
            ),
            'linkColor' =>
            array(
                'isActive' => true,
                'value' =>
                array(
                    'hex' => '#d15223',
                ),
            ),
            'linePlacement' => 1,
            'schedule' =>
            array(
                'isActive' => false,
                'linkURL' => '',
            ),
            'chat' =>
            array(
                'isActive' => false,
                'linkURL' => '',
            ),
        );
        EmailSignature::create([
            'user_id'             => $userData->id,
            'subscriber_id'       => $userData->parent_id,
            'data'                => json_encode($ticketSignSett),
            'signature_image'     => $defaultLogo,
            'html_data'           => '<p></p>',
            'add_email_signature' => 1,
        ]);
    }


    public function manageFirstTimeLogin($user)
    {
        $featuresController = new FeaturesController();
        $featuresController->setDisplayFeature();

        UserLoginLogs::Create([
            'subscriber_id' => $user->parent_id,
            'user_id' => $user->id,
            'login_time' => date('Y-m-d H:i:s'),
            'logout_time' => date('Y-m-d H:i:s'),
            'login_status' => 1,
        ]);

        $subInvitee = SubscriberInvitees::where('user_id', $user->id)->first();

        DB::table('users')->where('id', $user->id)
            ->update([
                'login_count' => $user->login_count + 1,
                'is_logged_in' => 1,
                'is_available' => ((isset($subInvitee->status_on_login) && $subInvitee->status_on_login == 2) ? 2 : 1),
                'last_login_check' => DB::raw('CURRENT_TIMESTAMP')
            ]);

        DB::table('user_availablity_log')->insert([
            'subscriber_id' => $user->parent_id,
            'user_id' => $user->id, 'is_available' => ((isset($subInvitee->status_on_login) && $subInvitee->status_on_login == 2) ? 2 : 1),
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }

    public function InsertInviteUser(Request $data)
    {
        //    echo "<pre>";
        //    print_r($data->parent_id);
        //    exit;
        $generateID = $this->random_num(9);
        $redirectKey = Str::random(60) . time();
        if (isset($data->guestToken) && $data->guestToken != '' && isset($data->thread_id) && $data->thread_id != '' && isset($data->parent_id) && $data->parent_id != '') {
            $id = User::create([
                'parent_id' => $data->parent_id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'generated_id' => $generateID,
                'company_name' => "",
                'avtar' => "",
                'role_id' => 5,
                'website_address' => "",
                'chat_purpose' => "0",
                'redirect_key' => $redirectKey,
                'remember_token' => Str::random(60),
                'unhash_password' => '######' //$data['password']
            ]);
            $insthread = ThreadUsers::create([
                'user_id' => $id->id,
                'thread_id' => $data->thread_id,
                'is_starred' => 0,
                'is_creator' => 0,
            ]);

            if ($insthread && $id) {
                Inviteuser::where('guestToken', $data->guestToken)->update([
                    'status' => 1,
                ]);

                // Auth::attempt(['email' => $id->email, 'password' => $data['password']]);

                return Redirect($this->url->to(''));
            }
            //            }else{
            //
            //                echo "Thread is already used or not Matched";
            //                exit;
            //            }
        } else {

            echo "No guest Token";
            exit;
        }
    }

    public function sendWelcomeEmail($ivitee, $subs)
    {
        //print_r($subs);die;
        $email_to = $ivitee->email;
        $name = explode(' ', $ivitee->agentname);
        $first_name = $name[0];
        $userId = Crypt::encrypt($ivitee->id);
        $company_name = $subs->company_name;
        //  $subject = "Great to have $company_name with us, PLUS a //quick question";
        //        echo $htmlContent;
        /*Mail::send('emails.teammate.welcome', ['first_name' => $first_name, 'company_name' => $company_name], function ($message) use ($email_to, $subject) {
            $message->to($email_to)->subject($subject);
        });*/

        Mail::send('emails.teammate.welcome', ['first_name' => $first_name, 'url_unsubcribe' => url('unsubscribe/' . $userId), 'company_name' => $company_name], function ($message) use ($email_to) {
            $message->to($email_to)->subject("Welcome to Ngagge");
        });
    }

    public function getTimezoneList(Request $request)
    {

        $results = DB::table('timezone')->get()->toArray();
        echo json_encode($results);
        exit;
    }

    //    public function availablityStatus(Request $request) {
    //        $avl = $request->avl;
    //        if (isset($avl) && $avl != 0) {
    //            $update = User::where('id', Auth::user()->id)->update([
    //                'is_available' => $avl
    //            ]);
    //            if ($update) {
    //                if ($avl == 1) {
    //                    echo json_encode(array('status' => 'user is now available'));
    //                } elseif ($avl == 2) {
    //                    echo json_encode(array('status' => 'user is now away'));
    //                }
    //            } else {
    //                echo json_encode(array('status' => 'Mysql: Query fail.'));
    //            }
    //        } else {
    //            echo json_encode(array('status' => 'ajax request parameter avl is not correct.'));
    //        }
    //        exit;
    //    }

    public function paymentPage($token)
    {

        $tokenArr = explode('&', $token, 2);
        $amount = base64_decode($tokenArr[1]);



        if ($token == '') {
            echo "You dont have token";
            exit;
        }
        $user = User::where('generated_id', $tokenArr[0])->first();

        //        if ($user && count($user) > 0) {
        if ($user) {
            $data = ApiInfo::where('subscriber_id', $user->id)->first();

            //            if ($data && count($data) > 0) {
            if ($data) {
                return view('pages.payment.index', ['apis' => $data], ['amount' => $amount]);
            } else {
                echo "Your API information not available";
                exit;
            }
        } else {
            echo "You Are not applicable here";
            exit;
        }
    }

    public function payment()
    {

        return view('pages.payment.payment');
    }

    public function paymentTest(Request $request)
    {

        $data = ApiInfo::where('id', $request->api_id)->first();
        $stripe = Stripe::make($data->publish_api_key);
        try {
            $charge = $stripe->charges()->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'description' => 'Example charge',
                'source' => $request->stripeToken,
                'receipt_email' => 'suryathesunshine89@gmail.com',
            ]);
            if ($charge['outcome']['seller_message'] == 'Payment complete.') {
                print_r($charge);

                //                echo $charge['outcome']['seller_message'];
            }
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        }
    }

    public function paymentNow(Request $request)
    {

        $stripe = Stripe::make('sk_live_IAceRIj76MNdLWg2YXp4hS0U');
        try {
            $charge = $stripe->charges()->create([
                'amount' => 15,
                'currency' => 'usd',
                'description' => 'Chat247Live Service Charge',
                'source' => $request->stripeToken,
                'receipt_email' => 'sberg33@gmail.com',
            ]);
            if ($charge['outcome']['seller_message'] == 'Payment complete.') {
                //              return view('pages.payment.payment', ['messege' => "Payment Complete"]);
                header('Location: https://www.franchise.chat247live.com/chat247-payment?message=1');
                die();
                exit;
            } else {
                //                return view('pages.payment.payment', ['messege' => "Transaction Failed"]);
                header('Location: https://www.franchise.chat247live.com/chat247-payment?message=2');
                die();
                exit;
            }
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        }
    }

    public function paymentByClient(Request $request)
    {


        $user = ApiInfo::where('subscriber_id', $request->paymentid)->first();
        $stripe = Stripe::make($user->publish_api_key);
        try {
            $customer = $stripe->customers()->create([
                'email' => $request->email,
            ]);
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
            return Response::json(array(
                'success' => false,
                'errors' => [[$e->getMessage()]],
                'data' => []
            ), 422);
        }

        if ($customer['id']) {
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->expirymonth,
                        'cvc' => $request->cvcnumber,
                        'exp_year' => $request->expiryyear,
                    ],
                ]);

                $card = $stripe->cards()->create($customer['id'], $token['id']);
            } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            }
        }
        if ($token['id']) {

            try {
                $charge = $stripe->charges()->create([
                    'customer' => $customer['id'],
                    'currency' => 'USD',
                    'amount' => $request->paymentamount,
                    'capture' => true
                ]);
            } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            } catch (\Cartalyst\Stripe\Exception\NotFoundException $e) {
                return Response::json(array(
                    'success' => false,
                    'errors' => [[$e->getMessage()]],
                    'data' => []
                ), 422);
            }
        }
    }

    public function updateInsertSubscriberFeatures(Request $request)
    {

        $subscriberId = session()->get('UserId');
        $ifexist = DB::table('subscriber_feature')
            ->where('subscriber_id', $subscriberId)
            ->first();

        if ($ifexist) {
            $upt = DB::table('subscriber_feature')
                ->where('subscriber_id', $subscriberId)
                ->update([
                    'features_json' => json_encode($request->features),
                ]);
            if ($upt) {
                echo "updated";
            }
        } else {
            $ins = DB::table('subscriber_feature')
                ->insert([
                    'subscriber_id' => $subscriberId,
                    'features_json' => json_encode($request->features),
                ]);
            if ($ins) {

                echo "Inserted";
            }
        }
        exit;
    }

    public function getSubscriberFeatures(Request $request)
    {

        $subscriberId = session()->get('UserId');

        $ifexist = DB::table('subscriber_feature')
            ->where('subscriber_id', $subscriberId)
            ->first();

        if ($ifexist) {
            echo json_encode($ifexist->features_json);
        } else {
            echo "500";
        }
        exit;
    }

    public function explore()
    {
        return view('/reports');
    }

    public function checkActiveUser($userid)
    {
        $check = User::where('id', $userid)->where('status', 1)
            ->first();
        if (!$check) {
            return false;
        }
        return true;
    }

    public function checklogin()
    {
        if (!Auth::user()) {
            return false;
        }
        return true;
    }

    public function getUniqueString($strength = 64)
    {
        $input = 'abcdefghijklmnopqrstuvwxyz0123456789'; // only small chars and num
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        $checkunique = User::where('emailVerifyString', $random_string)->first();
        if ($checkunique) {
            $this->getUniqueString();
        }

        return $random_string;
    }

    protected function autologin($userid)
    {

        $user = User::find($userid);
        Auth::login($user);
        if ($user->parent_id == 0) {
            $user->parent_id = $user->id;
        }
        UserLoginLogs::Create(['subscriber_id' => $user->parent_id, 'user_id' => $user->id, 'login_time' => date('Y-m-d H:i:s'), 'logout_time' => date('Y-m-d H:i:s'), 'login_status' => 1,]);

        $subInvitee = SubscriberInvitees::where('user_id', $user->id)
            ->first();

        DB::table('users')
            ->where('id', $user->id)
            ->update(['login_count' => $user->login_count + 1, 'is_logged_in' => 1, 'is_available' => ((isset($subInvitee->status_on_login) && $subInvitee->status_on_login == 2) ? 2 : 1), 'last_login_check' => DB::raw('CURRENT_TIMESTAMP')]);

        DB::table('user_availablity_log')
            ->insert(['subscriber_id' => $user->parent_id, 'user_id' => $user->id, 'is_available' => ((isset($subInvitee->status_on_login) && $subInvitee->status_on_login == 2) ? 2 : 1), 'created_at' => DB::raw('CURRENT_TIMESTAMP')]);

        return true;
    }

    public function checksteps($userid, $step)
    {
        $formerStep = $step - 1;
        $user = User::find($userid);

        if ($user->signup_step > $formerStep) {
            $return['status'] = true;
        } else {
            $return['status'] = false;
            if ($user->signup_step == 1) {
                $return['url'] = 'chat-feature/' . $userid;
            }

            if ($user->signup_step == 2) { //help-us/{userid}/{detailid}/{websiteid}
                $web = SubscriberWebsite::where('subscriber_id', $userid)->first();
                $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();
                $return['url'] = 'help-us/' . $userid . '/' . $company->id . '/' . $web->id;
            }

            if ($user->signup_step == 3) { ///feature-interested/{userid}/{detailid}
                $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();
                $return['url'] = 'feature-interested/' . $userid . '/' . $company->id;
            }
        }
        return $return;
    }
    public function checkConfigurations()
    {
        $data = array();
        ///check profile   (upload image in user table)
        $userdata =  User::where('id', Auth::user()->id)->first();
        $subscriberInviteesData =  SubscriberInvitees::where('user_id', Auth::user()->id)->first();

        if ($userdata->avtar != '') {
            $exp = explode(".", $userdata->avtar);

            if (strlen($exp[0]) != 9) {

                $data['complete_profile'] = true;
            } else {

                $data['complete_profile'] = false;
            }
        } else {
            $data['complete_profile'] = false;
        }
        //check email (all teammates should be )
        $emailAddon = SocialUser::where('user_id', Auth::user()->id)->where('social_type', 'google')->first();
        if ($emailAddon) {
            $data['select_email'] = true;
        } else {
            $data['select_email'] = false;
        }

        //invite teammates 
        $teammates = SubscriberInvitees::where('subscriber_id', Auth::user()->parent_id)->where('user_id', '!=', Auth::user()->parent_id)->first();
        if ($teammates) {
            $data['teammates'] = true;
        } else {
            $data['teammates'] = false;
        }

        //check facebook 
        $facebook = SocialUser::where('subscriber_id', Auth::user()->parent_id)->where('social_type', 'facebook')->first();
        if ($facebook) {
            $data['fb_messanger'] = true;
        } else {
            $data['fb_messanger'] = false;
        }

        //check email 
        $emailplaybook = EmailPlaybook::where('subscriber_id', Auth::user()->parent_id)->first();
        if ($emailplaybook) {
            $data['email_playbook'] = true;
        } else {
            $data['email_playbook'] = false;
        }

        //add messaging
        $messaging = SmsCurrentDetailsModel::where('subscriber_id', Auth::user()->parent_id)->first();
        if ($messaging) {
            $data['sms_messaging'] = true;
        } else {
            $data['sms_messaging'] = false;
        }

        ///import contact 
        $contacts = SubscriberInvitees::where('subscriber_id', Auth::user()->parent_id)->where('source', 6)->first();
        if ($contacts) {
            $data['import_contacts'] = true;
        } else {
            $data['import_contacts'] = false;
        }


        ///import schedule 
        if ($userdata->calendar_access_token != '') {
            $data['schedule'] = true;
        } else {
            $data['schedule'] = false;
        }


        $data['chat_customization'] = $this->checkChatCustomization();
        if (Auth::user()->parent_id == Auth::user()->id) {
            $data['is_subscriber'] = true;
        } else {
            $data['is_subscriber'] = false;
        }

        $team_messaging = SubscriberInvitees::where('user_id', Auth::user()->id)->first();
        if ($team_messaging->team_messaging_checkmark == 1) {
            $data['team_messaging'] = true;
        } else {
            $data['team_messaging'] = false;
        }

        $SupportTicket = SupportTicket::where('subscriber_id', Auth::user()->parent_id)->first();
        if ($SupportTicket) {
            $data['ticket'] = true;
        } else {
            $data['ticket'] = false;
        }

        $article = DB::table('knowledgebase_article')->where('knowledgebase_article.subscriber_id', Auth::user()->parent_id)->first();
        if ($article) {
            $data['article'] = true;
        } else {
            $data['article'] = false;
        }

        if ($team_messaging->visual_tick_mark == 1) {
            $data['visual'] = true;
        } else {
            $data['visual'] = false;
        }


        return Response::json($data);
    }


    public function checkChatCustomization()
    {

        /*$data = DB::table('button_window_design')
            ->where('subscriber_id', Auth::user()->parent_id)
            ->get();
        foreach ($data as $key => $value) {

            $formlist = json_decode($value->windows_sorted_forms_list);

            //print_r($formlist);

            foreach ($formlist->forms as $keyf => $form) {

                if ($form->name != 'Offline') {

                    $formjson =  json_encode($form->formData);
                    $formarray = json_decode($formjson);

                    if ($formjson != 'null') {

                        return true;
                    }
                }
            }
        }
        return false;*/

        $results = DB::table('subscriber_website')
            ->join('users', 'subscriber_website.subscriber_id', '=', 'users.id')
            ->select('subscriber_website.*', 'users.name')
            ->where('subscriber_website.subscriber_id', Auth::user()->id)
            ->get();

        foreach ($results as $key => $value) {
            if ($value->added == 1) {
                return true;
            }
        }
        return false;
    }



    public function InsertDefaultSegments($data)
    {


        ////for sales Lead
        $segment = new SegmentModel();
        $segment->name = 'Leads';
        $segment->type = 1;
        $segment->sharing = 0;
        $segment->created_by = $data->id;
        $segment->use = 'Contact Filter';
        $segment->contacts = 0;
        $segment->playbooks = 0;
        $segment->segment_owner = $data->id;
        $segment->is_active = 1; // active a time of creation
        $segment->save();

        if ($segment) {

            DB::table('segment_applicable_filter_table')->insert([
                'segment_id'                     => $segment->id,
                'association'                    => NULL,
                'table_name'                     => 'subscriber_invitees',
                'segment_filter_type_code'       => 'visitor_status',
                'segment_filter_type_field_code' => 'is_equal_to_lat_status',
                'data'                           => json_encode(array('dropdown_latest_status' => 1)),
            ]);
            $seg = new SegmentController();
            // $seg->saveContactsWithSegment($segment);
        }

        /// for Customer
        $segment = new SegmentModel();
        $segment->name = 'Customer';
        $segment->type = 1;
        $segment->sharing = 0;
        $segment->created_by = $data->id;
        $segment->use = 'Contact Filter';
        $segment->contacts = 0;
        $segment->playbooks = 0;
        $segment->segment_owner = $data->id;
        $segment->is_active = 1; // active a time of creation
        $segment->save();

        if ($segment) {

            DB::table('segment_applicable_filter_table')->insert([
                'segment_id'                     => $segment->id,
                'association'                    => NULL,
                'table_name'                     => 'subscriber_invitees',
                'segment_filter_type_code'       => 'visitor_status',
                'segment_filter_type_field_code' => 'is_equal_to_lat_status',
                'data'                           => json_encode(array('dropdown_latest_status' => 3)),
            ]);

            $seg = new SegmentController();
            // $seg->saveContactsWithSegment($segment);

        }

        /// for My Assignee
        $segment = new SegmentModel();
        $segment->name = 'My Contacts';
        $segment->type = 1;
        $segment->sharing = 0;
        $segment->created_by = $data->id;
        $segment->use = 'Contact Filter';
        $segment->contacts = 0;
        $segment->playbooks = 0;
        $segment->segment_owner = $data->id;
        $segment->is_active = 1; // active a time of creation
        $segment->save();

        if ($segment) {

            DB::table('segment_applicable_filter_table')->insert([
                'segment_id'                     => $segment->id,
                'association'                    => NULL,
                'table_name'                     => 'subscriber_invitees',
                'segment_filter_type_code'       => 'assignee',
                'segment_filter_type_field_code' => 'is_equal_to_assignee',
                'data'                           => json_encode(array('dropdown_assignee' => $data->id)),
            ]);

            $seg = new SegmentController();
            //  $seg->saveContactsWithSegment($segment);

        }
    }

    public function GetStartedDefaultupdate(Request $request)
    {
        if ($request->action == 'post') {
            SubscriberInvitees::where('user_id', Auth::user()->id)->update(['login_getstarted_default' => $request->status]);
        }

        $dataInvitee = SubscriberInvitees::where('user_id', Auth::user()->id)->first();


        $default_view = array('reports?sub=features', 'reports?sub=features', 'conversation-hub', 'contact', 'collaboration');

        if (!$dataInvitee) {
            return   response(json_encode(array('status' => false, 'defaultView' => $default_view[$dataInvitee->login_default_view])));
        } else {
            return  response(json_encode(array('status' => $dataInvitee->login_getstarted_default, 'defaultView' => $default_view[$dataInvitee->login_default_view])));
        }
    }


    public  function setColaborationVisited(Request $request)
    {

        $checkedMark = SubscriberInvitees::where('user_id', Auth::user()->id)->update(['team_messaging_checkmark' => 1]);

        if ($checkedMark) {
            return   response(json_encode(array('status' => true)));
        } else {
            return   response(json_encode(array('status' => false)));
        }
    }

    public function setVisualTickMark(Request $request)
    {
        $checkedMark = SubscriberInvitees::where('user_id', Auth::user()->id)->update(['visual_tick_mark' => 1]);

        if ($checkedMark) {
            return   response(json_encode(array('status' => true)));
        } else {
            return   response(json_encode(array('status' => false)));
        }
    }

    /**
     * send duplicate website reminder to system admin
     */
    public function sendDuplicateWebsiteRemainderMail($websiteDetail, $user, $email_to = 'sonubackstage@gmail.com')
    {
        Mail::send('emails.system.website-remainder', ['websiteDetail' => $websiteDetail, 'user' => $user], function ($message) use ($email_to) {
            $message->to($email_to)->subject("Duplicate website url added");
        });
    }

    public function checkInvitee(Request $request)
    {

        $thread =  Thread::where('id', $request->threadId)->first();
        $invitees =  SubscriberInvitees::where(['email' => $thread->visitor_email, 'subscriber_id' => $thread->subscriber_id])->first();
        if ($invitees) {
            $isInvitee = true;
        } else {
            $isInvitee = false;
        }
        return   response(json_encode(array('isInvitee' => $isInvitee, 'invitees' => $invitees)));
    }

    public function defaultBot()
    {
        ///default website
        $website =  SubscriberWebsite::where('subscriber_id', Auth::user()->parent_id)->first();
        if ($website) {

            $create = [
                'name_template'     => "Non-Business Hours Bot",
                'dislay_with_json'  => '{"imageType":"1","imageColorType":"1","imageColor":{"hex":"#ffffff"},"imageContrast":"55","imageGradDir":"1","botNameEnabled":false,"botName":null}',
                'website_url_id'    => $website->id,
                'show_when_type'    => 'ALL',
                'show_when_json'    => '{"text":null}',
                'hide_when_type'    => 'EQUALS',
                'hide_when_json'    => '{"text":null}',
                'display_where'     => 'NEXT_TO_CHAT_BUTTON',
                'display_time'      => 'NON_BUSINESS_HOURS',
                'display_when_type' => 'SECONDS',
                'on_page_sec'       => 10,
                'on_page_scroll_percent' => 0,
                'bot_type'          => 'DEFAULT_NON_BUSINESS',
                'created_by'        => Auth::User()->id,
                'subscriber_id'     => Auth::User()->parent_id,
                'priority_integer'  => 1,
                'priority_text'     => 1,
                'is_active'         => 1
            ];

            $bots = Bots::create($create);
            $BotActionController = new BotActionController();
            $BotActionController->getBotChartFlowOrderInbox($bots->id);
        }
    }
    /**
     * updateGoogleTransLanguage
     */
    public function updateGoogleTransLanguage(Request $request)
    {
        $trans_lang = $request->get('trans_lang');
        $user = Auth::user();
        User::find($user->id)->update(['trans_lang' => $trans_lang]);
        // CustomLog::LOG('google trans lan request', $request);
        return response()->json(['status' => 'success', 'trans_lang' => $trans_lang]);
    }
    /**
     * updateGoogleTransLanguage
     */
    public function getGoogleTransLanguage(Request $request)
    {
        // $trans_lang = $request->get('trans_lang');
        $user = Auth::user();
        // CustomLog::LOG('google trans lan request', $request);
        return response()->json(['status' => 'success', 'trans_lang' => $user->trans_lang]);
    }
}
