<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use App\Helpers\CustomMailHelper;
use App\Model\SubscriberInvitees;
use Mail;

class SubscriberOnBoardMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reminder:SubscribersonBoardMail';

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
       $subscriber= SubscriberInvitees::select('subscriber_id','user_id','email','agentname','teammates_invited','created_at')
           ->where('user_id','!=',0)
           ->where('subscriber_id','!=',1)
           //->whereRaw('DATEDIFF(CURRENT_TIMESTAMP(),created_at)',3)
           ->whereDate('created_at','=' ,Carbon::now()->subDays(1)->setTime(0, 0, 0)->toDateTimeString())
           ->orderby('created_at')
           ->get();
   // dd($subscriber->user_id);       
     //dd(DB::getQueryLog()) ;
               if($subscriber){
                foreach($subscriber as $subscriber){
                 $already_added=DB::table('subscriber_reminder_email_queue')->where('subscriber_id',$subscriber->subscriber_id)->where('user_id',$subscriber->user_id)->where('type','=',"ONBOARDING")->first();
                // dd($already_added);
                 if($already_added==null){   
                $subject="Resources you need to help you get started";
                $mailreminder=DB::table('subscriber_reminder_email_queue')->insert([

                                "subscriber_id"=>$subscriber->subscriber_id,
                                "user_id"=>$subscriber->user_id,
                                "email"=>$subscriber->email,
                                "agentname"=>$subscriber->agentname,
                                "subject"=>$subject,
                                "type"=>"ONBOARDING",
                                "is_sent"=>0,
                                "created_at"=>Carbon::now(),
                                "updated_at"=>Carbon::now()

                            ]);
              }  

        }    
           
   }
    
}
}
