<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\SmsPlaybook\SmsPlaybook;

class ScheduledPlaybookActivator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playbook:playbook-activator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all scheduled playbooks and activate them';

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


        $scheduled_playbooks = SmsPlaybook::where('msgscheduled', 'Scheduled')
            ->where('is_active', 1)->get();
        $timezones = array(
            'MST' => 'America/Denver',
            'EST' => 'America/New_York',
            'PST' => 'America/Los_Angeles',
            'CST' => 'America/Chicago',
        );
        foreach ($scheduled_playbooks as $playbook) {
            if ((int) $playbook->category_name > 0) {

                $format = 'Y-m-d H:i';
                $date_scheduled = $playbook->date_time . ' ' . $playbook->att;
                $current_date = date($format);
                // get the datetime formatted in 
                $scheduled_date = date($format, strtotime($date_scheduled . ' ' . (isset($timezones[$playbook->time_zone_id]) ? $timezones[$playbook->time_zone_id] : '')));
                //echo print_r($playbook->toArray(),true);

                echo 'original = ' . $date_scheduled . PHP_EOL;
                echo $current_date . '  ' . $scheduled_date . PHP_EOL;
                if ($current_date > $scheduled_date) {
                    $playbook->msgscheduled = "Activated";
                    //$playbook->save();
                    if (strtolower($playbook->message_type) == strtolower('Standard')) {
                        $this->queueStanderdMsg($playbook);
                    }

                    echo 'Activate ' . $playbook->playbook_name;
                } else {
                    echo 'Cannot Activate ' . $playbook->playbook_name;
                }
                echo  PHP_EOL . PHP_EOL;
            }
        }
    }
    protected function queueStanderdMsg($playbook)
    {
        // playbook is activated now queue the messages to the contacts


    }
}
