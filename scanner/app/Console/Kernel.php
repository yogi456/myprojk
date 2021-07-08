<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SyncGmailMessage::class,
        Commands\GetGmailMessageDetails::class,
        Commands\GetGmailAttachment::class,
        Commands\ProcessSmsQueue::class,
        Commands\ScheduledPlaybookActivator::class,
        Commands\EmailPlaybookActivator::class,
        Commands\SendPlaybookEmail::class,
        Commands\QueueNextLevelPlaybookEmail::class,
        Commands\CheckDomainVerification::class,
        Commands\SyncedCompanyMailDetails::class,
        Commands\RefreshEmailMessageSentCount::class,
        Commands\SyncedSupportMail::class,
        Commands\TrendalertCron::class,
        Commands\SendAlertfromTime::class,
        Commands\UpdateTrendalertResultCron::class,
        Commands\SetEventAvailabilityTimeslots::class,
        Commands\SyncTaskOverdue::class,
        Commands\DeleteInvitedAgents::class,
        Commands\CheckForBandwidthOrderStatus::class,
        Commands\addNggageCustomDataCorn::class,
        Commands\SubscriberEmailQueueCron::class,
        Commands\SubscriberReminderSendMail::class,
        Commands\SubscriberOnBoardMail::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // script execution time
        $time_start = microtime(true);

        $schedule->command('mail:synced-company-message-detail')->everyMinute();
        $schedule->command('gmail:get-message')->everyMinute();
        $schedule->command('gmail:get-message-details')->everyMinute();
        $schedule->command('gmail:get-attachments')->everyMinute();
        $schedule->command('playbook:playbook-activator')->everyMinute();
        $schedule->command('playbook:sent-playbook-email')->everyMinute();
        foreach (['00:30', '06:30', '12:30', '18:30'] as $time) {
            $schedule->command('playbook:check-spf-dkim-verification')->dailyAt($time);
        }
        // $schedule->command('playbook:check-spf-dkim-verification')->daily();
        $schedule->command('playbook:refresh-email-message-sent-count')->dailyAt('00:30');
        $schedule->command('cache:clear')->daily();
        $schedule->command('sms:syncronize')->everyMinute();
        $schedule->command('command:syncedEmail')->everyMinute();

        $schedule->command('alert:alert-log')->daily();
        ///$schedule->command('alert:sendemail-alert')->daily();
        $schedule->command('trendalert:update-alert-result')->hourly();
        $schedule->command('command:set-available-timeslots')->daily();
//        $schedule->command('command:sync-task-overdue')->daily();        
        $schedule->command('command:sync-task-overdue')->everyMinute();
        $schedule->command('command:delete-invited-agents')->daily();
        //Bandwidth number order status check
        //$schedule->command('order:check-status')->everyMinute();
        $schedule->command('superadmin:patrondata')->everyMinute();
        $schedule->command('subscriber:QueueMailReminder')->hourly();
        $schedule->command('Reminder:SubscribersMail')->everyMinute();
        $schedule->command('Reminder:SubscribersonBoardMail')->hourly();
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        // file_put_contents('kernel_exec_time.log', date('Y-m-d H:i:s') . ' Total Execution Time: ' . rtrim(sprintf('%.50f', $execution_time), '0') . ' Sec' . PHP_EOL, FILE_APPEND);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }

}
