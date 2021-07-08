<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Model\Setting\SubscriberForwardBccDetail;
use App\Http\Controllers\Playbook\CompanyEmailController;

class SyncedCompanyMailDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:synced-company-message-detail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'synced-message-from-company-domain-forward-and-bcc';

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
        // DB::enableQueryLog();
        $subFwdBccDetail = '';
        $subFwdBccDetail = SubscriberForwardBccDetail::whereIn('mail_type', ['forward', 'bcc'])->get();
        // $subFwdBccDetail = SubscriberForwardBccDetail::whereIn('mail_type', ['forward'])->get();


        if ($subFwdBccDetail)
            foreach ($subFwdBccDetail as $key => $value) {
                $companyEmailController = new CompanyEmailController();
                // if ($value->getWebsiteCount() > 0 && $value->getWebsiteAssignedEmailCount() > 0)
                $companyEmailController->getCompanyMail($value);
            }
        // Log::info(DB::getQueryLog());
        $this->info('successfully synced message from company email');
    }
}
