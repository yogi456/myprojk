<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Social\SocialUser;
use App\Model\Social\GmailAttachment;
use App\Http\Controllers\Social\Google\ApiController;

class GetGmailAttachment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:get-attachments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get gmail message attachments using gmail google api';

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
        $attachments = GmailAttachment::where(['is_downloaded' => false])->get();
        if ($attachments) {
            foreach ($attachments as  $value) {
                $socialUser = SocialUser::where('user_id', $value->user_id)->first();
                $apiController = new ApiController();
                $apiController->getAttachment($socialUser, $value);
            }
        }
    }
}
