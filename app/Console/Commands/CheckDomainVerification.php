<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Model\Website;
use App\Model\Setting\SubscriberWebsiteAssignedEmail;
use App\Http\Controllers\Settings\Email\AddressSelectionController;
use App\Http\Controllers\Playbook\CompanyEmailController;
use Illuminate\Support\Facades\Log;
use App\Helpers\CompanyEmailHelper;
use App\User;
use Config;

class CheckDomainVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playbook:check-spf-dkim-verification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check for domain spf and dkim verification if verify send email to teammate';

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
        $purchasedDomainData = Website::where('is_branding', true)->get();
        if ($purchasedDomainData) {
            $companyEmailController = new CompanyEmailController();
            $addressSelectionController = new AddressSelectionController();
            $selector = Config::get('constants.company_mail.selector');
            $selector_number = Config::get('constants.company_mail.selector_number');
            foreach ($purchasedDomainData as $key => $website) {
                // Log::info($website);
                $website_url = $addressSelectionController->getHost($website->website_url);
                $fetchSPFData = $companyEmailController->fetchSPF($website_url, $companyEmailController->match_domain_with);
                $fetchDKIMData = $companyEmailController->fetchDKIM($website_url, $selector, $selector_number);
                // $fetchDKIMData2 = $companyEmailController->fetchDKIM($website_url, 'p', 2);
                // Log::info($fetchSPFData);
                // Log::info($fetchDKIMData);
                if ($fetchSPFData['is_added'] == true && ($fetchDKIMData['is_added'] == true)) {
                    // $this->info('spf and dkim verified');
                    $this->sendVerifyLink($website, $companyEmailController, $selector . $selector_number);
                    Website::find($website->id)->update(['is_spf' => true, 'is_dkim' => true]);
                } else {
                    if ($fetchSPFData['is_added'] == false) {
                        Website::find($website->id)->update(['is_spf' => false]);
                        $this->sendSpfOrDkimFailNotification($website, $selector . $selector_number, $website->website_url, 'SPF');
                    }

                    if ($fetchDKIMData['is_added'] == false) {
                        Website::find($website->id)->update(['is_dkim' => false]);
                        $this->sendSpfOrDkimFailNotification($website, $selector . $selector_number, $website->website_url, 'DKIM');
                    }
                }
            }
        }
    }
    /**
     * send verification link to teammate
     */
    public function sendVerifyLink($website, $companyEmailHelper, $selector)
    {

        $subscriberWebsiteAssignedEmail = SubscriberWebsiteAssignedEmail::where([
            'subscriber_id' => $website->subscriber_id,
            'website_id'    => $website->id,
            'status'        => 'unverified'
        ])->get();

        if ($subscriberWebsiteAssignedEmail) {
            $companyEmailController = new CompanyEmailController();
            foreach ($subscriberWebsiteAssignedEmail as $key => $value) {
                $companyEmailController->sendVerificationEmail($value, $selector);
            }
        }
        SubscriberWebsiteAssignedEmail::where([
            'subscriber_id' => $website->subscriber_id,
            'website_id'    => $website->id,
            'status'        => 'spf_or_dkim_failed'
        ])->update(['status' => 'active']);
    }
    /**
     * if spf or dkim fails admin should be notify by email
     */
    public function sendSpfOrDkimFailNotification($website, $selector, $domain_name, $type)
    {

        $subscriberWebsiteAssignedEmail = SubscriberWebsiteAssignedEmail::where([
            'subscriber_id' => $website->subscriber_id,
            'website_id'    => $website->id,
            'status'        => 'active'
        ])->get();

        if ($subscriberWebsiteAssignedEmail) {
            $companyEmailController = new CompanyEmailController();
            foreach ($subscriberWebsiteAssignedEmail as $key => $value) {
                $companyEmailController->sendSPFOrDKIMFailedEmail($value, $domain_name, $type);
            }
        }
        SubscriberWebsiteAssignedEmail::where([
            'subscriber_id' => $website->subscriber_id,
            'website_id'    => $website->id,
            'status'        => 'active'
        ])->update(['status' => 'spf_or_dkim_failed']);
    }
}
