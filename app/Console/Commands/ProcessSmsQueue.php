<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Bandwidth\BandwidthSmsQueue;
use App\Helpers\BandwidthHelper;
use App\Http\Controllers\Bandwidth;
use DB;
use App\Helpers\CustomLog;

//use DB;

class ProcessSmsQueue extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:syncronize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize the sms tasks for processing with bandwidth';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $date_now  = date('Y-m-d H:i:s');
        //file_put_contents("running.log",$date_now . PHP_EOL, FILE_APPEND);
        // take messages into consideration only which are max 3 days old to redce load on system
        //$max_old_entry_date = date('Y-m-d H:i:s', strtotime('-3 days'));
        // all sms which are not submitted to bandwidth
        //DB::connection()->enableQueryLog();
        $msg_queue = BandwidthSmsQueue::where('send_status_code', '!=', '202')
            ->where('scheduled_time', '<', $date_now)
            ->where('direction', '!=', 'in')
            ->where('direction', '!=', '')
            ->where('has_error', '!=', '1')
            ->where('is_msg_approved', '<', 2)
            ->where('retry_count', '<', 5)
            ->where('bandwidth_error_code', '')
            ->where('contact_id', '>', 0)
            ->get();
        //echo count($msg_queue).PHP_EOL;
        foreach ($msg_queue as $msg) {
            //CustomLog::LOG('SmsQueue', $msg);
            // submit message to bandwidth only if the user is approved or the message is approved
            if ($msg->is_sender_approved || $msg->is_msg_approved == 1) {
                //CustomLog::LOG('SmsQueue', $msg);
                //file_put_contents('console_sms_syncronize.log', print_r(json_encode($msg),true).PHP_EOL,FILE_APPEND);
                //file_put_contents("running.log",print_r(json_encode($msg),true) . PHP_EOL . PHP_EOL, FILE_APPEND);
                $bandwidthHelper  = new BandwidthHelper();
                $response         = $bandwidthHelper->submitMsgToBandwidth($msg);
                $msg->retry_count = (int) ($msg->retry_count + 1);
                $msg->save();
                //  echo 'Send'.PHP_EOL;
            }
        }
        //file_put_contents('console_sms_syncronize.log', print_r(DB::getQueryLog(), true), FILE_APPEND);
        echo 'executed handel';
        //echo $date_greater_than;
        //
        //echo 'test';
        //file_put_contents('C:\xampp\htdocs\playbook\public\cron.log', date('Y-m-d H:i:s') . PHP_EOL,FILE_APPEND);
        //echo 'done';
    }

}
