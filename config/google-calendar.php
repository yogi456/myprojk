<?php
return [
    /*
     * Path to the json file containing the credentials.
     */
    'service_account_credentials_json' => storage_path('app/'),
//    'service_account_credentials_json' => storage_path(Auth::user()->cal_file),
    /*
     *  The id of the Google Calendar that will be used by default.
     */
//    'calendar_id' => env('096.aditya@gmail.com'),
    'calendar_id' => env('CALENDAR_ID', ''),
];