<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use App\Helpers\CustomMailHelper;

class SubscriberReminderSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reminder:SubscribersMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        DB::enableQueryLog();
       $subscriber=DB::table('subscriber_reminder_email_queue')->where('is_sent',0)->orderby('created_at')->first();
   // print_r($subscriber);       
     //  dd(DB::getQueryLog()) ;
               if($subscriber){
                   if($subscriber->type=="CHATCODE"){
                        $userId=Crypt::encrypt($subscriber->user_id);
                        $subject=$subscriber->subject;
                        $msg=view('emails.teammate.chat-code-install',['first_name' => $subscriber->agentname,'url_unsubcribe'=>url('unsubscribe/'.$userId)]);
                        $custom1=new CustomMailHelper();
                        $send=$custom1->send($subscriber->email,$subject,$msg );
                         //$send=$custom1->registerSwiftMailer($subscriber->email,$subject,$msg);
                    if($send){
                            $subscriber=DB::table('subscriber_reminder_email_queue')->where('id',$subscriber->id)->update(['is_sent'=>1]);
                    }
                   }else if($subscriber->type=="ONBOARDING"){
                        $userId=Crypt::encrypt($subscriber->user_id);
                         $subject=$subscriber->subject;
                        $msg=view('emails.teammate.onbroading',['first_name' => $subscriber->agentname,'url_unsubcribe'=>url('unsubscribe/'.$userId)]);
                        $custom1=new CustomMailHelper();
                        $send=$custom1->send($subscriber->email,$subject,$msg );
                         //$send=$custom1->registerSwiftMailer($subscriber->email,$subject,$msg);
                    if($send){
                            $subscriber=DB::table('subscriber_reminder_email_queue')->where('id',$subscriber->id)->where("type","ONBOARDING")->update(['is_sent'=>1]);
                    }
                   }else{
                   $userId=Crypt::encrypt($subscriber->user_id);
                        $subject=$subscriber->subject;
                        $msg=view('emails.teammate.welcome1',['first_name' => $subscriber->agentname,'url_unsubcribe'=>url('unsubscribe/'.$userId)]);
                        $custom1=new CustomMailHelper();
                        $send=$custom1->send($subscriber->email,$subject,$msg );    
                       // $send=$custom1->registerSwiftMailer($subscriber->email,$subject,$msg);
                    if($send){
                           $sent= DB::table('subscriber_reminder_email_queue')->where('id','=',$subscriber->id)->update(['is_sent'=>1]);
                    }
               } 
           }
   }
    
}
