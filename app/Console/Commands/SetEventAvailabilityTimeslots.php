<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Model\AvailabilityEvent;
use App\Model\Availability;
use DB;

class SetEventAvailabilityTimeslots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:set-available-timeslots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduling events mantain two months availablity of timeslots';

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
        $cronInfo = DB::table('booking_datetimes_manage_cron')->where(['cron_current_date' => date('Y-m-d')])->first();
        if(!(isset($cronInfo->id) && $cronInfo->id)){
            DB::table('booking_datetimes_manage_cron')->insert(['cron_offset' => 0, 'cron_current_date' => date('Y-m-d'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            $cronInfo = DB::table('booking_datetimes_manage_cron')->where(['cron_current_date' => date('Y-m-d')])->first();
        }
        if (isset($cronInfo->id) && $cronInfo->id) {
            $users = Availability::with(['user_detail' => function ($q) {
                        $q->where('status', 1);
                        $q->select('id','status');
                    }])
                    ->select('id','user_id')->skip(1 * $cronInfo->cron_offset)->take(1)->get()->toArray();
            $av = new AvailabilityEvent();
            if (count($users) > 0) {
                foreach ($users as $key => $value) {
                    if($value['user_detail']['status'] == 1){
                        $this->info('running cron for user id = '.$value['user_id']);
                        $av->setTimeslotCronUpdate($value['user_id']);
                    }
                }
                $newOffset = $cronInfo->cron_offset + 1;
                DB::table('booking_datetimes_manage_cron')->where(['id' => $cronInfo->id])->update(['cron_offset' => $newOffset, 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
    }
}
