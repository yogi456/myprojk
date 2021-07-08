<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


use App\Model\SubscriberWebsite;
use App\Model\SubscriberInvitees;
use Carbon\Carbon;


class SubscriberEmailQueueCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriber:QueueMailReminder';

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
       $this->SendToChatCodeInstall();
       //die;
   // DB::enableQueryLog();   
   $invited= SubscriberInvitees::select('subscriber_id','user_id','email','agentname','teammates_invited','created_at')
           ->where('user_id','!=',0)
           ->where('teammates_invited',0)
           ->where('subscriber_id','!=',1)
           //->whereRaw('DATEDIFF(CURRENT_TIMESTAMP(),created_at)',3)
           ->whereDate('created_at','=' ,Carbon::now()->subDays(3)->setTime(0, 0, 0)->toDateTimeString())
           ->orderby('update_at')
           ->get();
 //dd($invited);
   
        if($invited){
             foreach($invited as $invitee){
                 $already_added=DB::table('subscriber_reminder_email_queue')->where('subscriber_id',$invitee->subscriber_id)->where('user_id',$invitee->user_id)->where('type','=',"Teammate")->first();
                // dd($already_added);
                 if($already_added==null){
                 DB::table('subscriber_reminder_email_queue')->insert([
                            'subscriber_id' =>$invitee->subscriber_id, 
                            'user_id'=>$invitee->user_id,
                            'email'=>$invitee->email,
                            'agentname'=>$invitee->agentname,
                            'subject'=>'Reminder to invite teammate',
                            'type'=>'TEAMMATE',
                            'is_sent'=>0,
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now(),
                         ]);
                 }
         }


        
         
            }
        }
   
   
   
   public function SendToChatCodeInstall(){
       
        DB::enableQueryLog();
        $code=DB::table('subscriber_invitees as s1')->select('s2.added','s2.status','s1.subscriber_id','s1.user_id','s1.email','s1.agentname','s1.created_at')->
                    leftJoin('subscriber_website as s2', 's1.subscriber_id', '=', 's2.subscriber_id')->
                    where('s2.added', 0)->
                    where('s2.status',1)->
                    where('s1.subscriber_id','!=',1)->
                    where('s1.user_id','!=',0)->
                   //whereraw('DATEDIFF(CURRENT_TIMESTAMP(),s1.created_at)', 2)-> 
                    whereDate('s1.created_at',Carbon::now()->subDays(2)->setTime(0, 0, 0)->toDateTimeString())->
                   groupby('s1.subscriber_id')-> orderBy('s1.created_at')->get();
        //print_r($code);
        
      // dd(DB::getQueryLog());
         if($code){
             
                    foreach($code as $code){
                         $already_added=DB::table('subscriber_reminder_email_queue')->where('subscriber_id',$code->subscriber_id)->where('user_id',$code->user_id)->where('type','=',"Chatcode")->first();
                       // dd($already_added);
                         if($already_added==null){
                         DB::table('subscriber_reminder_email_queue')->insert([
                            'subscriber_id' =>$code->subscriber_id, 
                            'user_id'=>$code->user_id,
                            'email'=>$code->email,
                            'agentname'=>$code->agentname,
                            'subject'=>'Reminder to install chat code on your website',
                            'type'=>'CHATCODE',
                            'is_sent'=>0,
                            'created_at'=>Carbon::now(),                       
                            'updated_at'=>Carbon::now(),
                             ]);
                  
                      
                    }
                  }
                    
        }
    }
   
}
