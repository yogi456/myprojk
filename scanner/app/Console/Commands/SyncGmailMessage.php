<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Social\Google\AuthController;
use App\Http\Controllers\Social\Google\ApiController;
use App\Model\Social\SocialUser;
use Illuminate\Support\Facades\Log;

class SyncGmailMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:get-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get inbox messages from gmail';

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
        // get all user from db and get message details from gmail
        $apiController = new ApiController();

        $socialUser = SocialUser::where('status', 'active')->get();
        if (count($socialUser) > 0) {
            foreach ($socialUser as $key => $user) {
                // $token = $authController->refreshAccessToken($user->id);
                // Log::info($token);
                $getGmailData = $apiController->syncMessageFromGmail($user->user_id);
                // Log::info($getGmailData);
            }
        }
        $this->info('successfully synced message from gmail');
    }
}
