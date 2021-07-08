<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Model\SubscriberInvitees;
use App\Model\CustomAttributes\CustomAttributeValue;
use App\Model\Website;
use App\Model\Company;
use Log;
use DB;

class addNggageCustomDataCorn extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superadmin:patrondata';

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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //Log::info('Cron Job Started');
        // your logic 
        //$client = SubscriberInvitees::where('subscriber_id',1)->where('table_type',2)->where('contact_id','!=','')->where('email_token','')->orderBy('update_at')->first();
        $client = DB::table('subscriber_invitees as s1')->select('s1.id', 's1.user_id', 's1.contact_id', 's1.timezone', 's1.update_at')->
            join('subscriber_invitees AS s2', 's2.subscriber_id', '=', 's1.contact_id')->
            where('s1.user_id', '!=', 1)->
            where('s1.is_deleted', '!=', 1)->
            orderBy('s1.update_at')->
            first();



        if ($client) {

            // to fetch data
            $subscriber_id = $client->contact_id;
            // store against user
            $user_id = $client->id;
            // echo 'subscrber id: '.$subscriber_id.' contact id: '.$user_id;     
            //Log::info('contact id: '.$user_id);
            // 
            //timezone update in contact
            $subs_TZ = SubscriberInvitees::select('timezone')->where('subscriber_id', $subscriber_id)->where("subscriber_id", '!=', 1)->first();
            if ($subs_TZ) {
                if ($subs_TZ->timezone !== $client->timezone) {
                    $this->addtz($user_id, $subs_TZ->timezone);
                }
            }
            //features update in contact
            $subs_int_features = DB::table('subscriber_company_details')->select('company_name', 'interested_features', 'industry', 'country', 'num_of_employees')->where('subscriber_id', '=', $subscriber_id)->where("subscriber_id", '!=', 1)->first();
            if ($subs_int_features) {
                //echo 'subscrber id: '.$subscriber_id.' contact id: '.$user_id;
                if ($subs_int_features->company_name) {
                    $this->clientCompany($user_id, $subs_int_features->company_name);
                }
                $this->features($user_id, $subs_int_features->interested_features);
                $this->clientIndustry($user_id, $subs_int_features->industry);
                $this->countryName($user_id, $subs_int_features->country);
                $this->numOfEmp($user_id, $subs_int_features->num_of_employees);
            }
            //website update in contact    
            $sub_web = Website::select('website_url', 'added')->where('subscriber_id', $subscriber_id)->first();
            if ($sub_web) {
                $this->companyWebsiteUrl($user_id, $sub_web->website_url);
                if ($sub_web->added == 1) {
                    $this->chatCodeInstall($user_id);
                }
            }
            //no. of website added in contacts     
            $sub_web1 = Website::where('subscriber_id', $subscriber_id)->get();
            if ($sub_web1) {
                $sub_web1->count();
                $this->totalWebsiteAdded($user_id, $sub_web1->count());
            }
            //invite send by contacts      
            $invtiees = SubscriberInvitees::where('subscriber_id', $subscriber_id)->where('user_id', '!=', $subscriber_id)->where("subscriber_id", '!=', 1)->first();
            if ($invtiees) {
                $this->inviteTeammate($user_id);
            }
            //update contact datetime        
            $update = SubscriberInvitees::find($user_id);

            $update->update_at = date("Y-m-d H:i:s");
            $update->save();
        }
        // Log::info('Cron Job Ended');      
    }

    public function chatCodeInstall($id) {

        CustomAttributeValue::firstOrCreate(
            ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_chat_code'],
            ['feild_type_code' => 'sdt_true_false', 'feild_value' => 'TRUE']
        );
        CustomAttributeValue::firstOrCreate(
            ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_chat'],
            ['feild_type_code' => 'sdt_true_false', 'feild_value' => 'TRUE']
        );
    }

    public function inviteTeammate($id) {
        //$website= Website::select('website_url')->where('subscriber_id',$id)->first();
        $addASContactCustomValue = CustomAttributeValue::firstOrCreate(
                ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_invitee_request'],
                ['feild_type_code' => 'sdt_true_false', 'feild_value' => 'TRUE']
        );
    }

    public function addtz($id, $tz) {
        if ($tz) {
            $update = SubscriberInvitees::where('id', $id)->update(['timezone' => $tz]);
            $contacttzupdate = Company::where('contact_id', $id)->where('subscriber_id', 1)->update(['timezone' => $tz]);
        } else {
            echo "Error: Timezone not found in subscriber / teammate.";
        }
    }

    public function features($id, $features) {
        //print_r($features);
        if ($features) {
            foreach (json_decode($features) as $fi) {
                // echo $fi->name.'<--------->'.strtoupper($fi->status);
                if ($fi->status) {
                    $status = 'TRUE';
                } else {
                    $status = 'FALSE';
                }
                if ($fi->name == "Live Chat") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_chat'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Bots") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_bots'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "WhatsApp") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_whatsapp'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "SMS Messaging") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_sms_msg'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Facebook Messenger") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_facebook'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "CRM") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_crm'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Marketing Automation") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_cust_features_market_auto'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Tickets") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_tickets'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Knowledgebase Tools") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_knowledgebase_tools'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Video Marketing") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_features_video_marketing'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
                if ($fi->name == "Team messaging") {
                    CustomAttributeValue::firstOrCreate(
                        ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_team_messaging'],
                        ['feild_type_code' => 'sdt_true_false', 'feild_value' => $status]
                    );
                }
            }
        } else {
            echo "Error:user not registerd properly.";
        }
    }

    public function clientCompany($id, $cname) {
        CustomAttributeValue::updateOrCreate(
            ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_company_name'],
            ['feild_type_code' => 'sdt_text', 'feild_value' => $cname]
        );
    }

    // Store custom field industry

    public function clientIndustry($id, $industryid) {
        $industryName = DB::table('industry_dropdown')->select('industry')->where('id', $industryid)->first();
        if ($industryName !== null) {
            CustomAttributeValue::updateOrCreate(
                ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_company_industry'],
                ['feild_type_code' => 'sdt_text', 'feild_value' => $industryName->industry]
            );
        }
    }

    public function countryName($id, $countryId) {

        $country = DB::table('countries')->select('name')->where('id', $countryId)->first();
        if ($country !== null) {
            //echo $country->name;
            CustomAttributeValue::updateOrCreate(
                ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_country_name'],
                ['feild_type_code' => 'sdt_text', 'feild_value' => $country->name]
            );
        }
    }

    public function numOfEmp($id, $num_of_employeeId) {
        $num_emp = DB::table('employee_numbers')->select('no_of_emp')->where('id', $num_of_employeeId)->first();
        if ($num_emp !== null) {
            CustomAttributeValue::updateOrCreate(
                ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_no_of_employee'],
                ['feild_type_code' => 'sdt_text', 'feild_value' => $num_emp->no_of_emp]
            );
        }
    }

    public function companyWebsiteUrl($id, $url) {
        CustomAttributeValue::updateOrCreate(
            ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_company_website'],
            ['feild_type_code' => 'sdt_text', 'feild_value' => $url]
        );
    }

    public function totalWebsiteAdded($id, $total) {

        CustomAttributeValue::updateOrCreate(
            ['subscriber_id' => 1, 'subscriber_invitee_id' => $id, 'label_code' => 'super_custom_company_website_no'],
            ['feild_type_code' => 'sdt_number', 'feild_value' => $total]
        );
    }

}
