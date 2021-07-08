<?php

return array(
    'twillio'        => array(
        'sid'   => 'ACaa39af007c0ed6275a7bb17e48ce4593',
        'token' => 'ca57bffc31ab0457f3e7258398ad127e',
        'from'  => '+14155238886',
    ),
    'url_shortner'   => array(
        'domain' => 'http://local.f247l.com/'
    ),
    'facebook'       => array(
        'app_secret' => 'c1494b4cb87537a2d52bff67829d66d5',
        'app_id'     => '1070140646745511'
    ),
    'mail_chimp'       => array(
        'app_secret' => '5ad19bff817d2b67973816ae7be27f3dada928d3b0f0b5e8ec',
        'app_id'     => '785227019260'
    ),
    // keys for ipstack
    'ipstack'        => array(
        'key' => '8199e319c18cfdbaa2d730133abc1260',
        'url' => 'http://api.ipstack.com/'
    ),
    //keys for ipinfodb.com ip address api
    'ipinfodb'       => array(
        'key' => '1ade0eec6de005cfeedd12678aac3cbf4f47c120bbf83b3cc'
    ),
    // cpanel keys and important data
    'cpanel'         => array(
        'domain'                    => 'ngagge-mail.com',
        'username'                  => 'poster19',
        'port'                      => '2083',
        'token'                     => 'JSUOU4SD9G1DHB5YM8DTSQ4HAU0IA3YZ',
        'protocol'                  => 'https://',
        'email_prefix_concatinator' => '.',
        'settings'                  => array(
            'ssl'     => array(
                'incoming_server' => array(
                    'url'   => 'mail.ngagge-mail.com',
                    'ports' => array(
                        'imap' => 993,
                        'pop'  => 995
                    )
                ),
                'outgoing_server' => array(
                    'url'   => 'mail.ngagge-mail.com',
                    'ports' => array(
                        'smtp' => 465
                    )
                )
            ),
            'non-ssl' => array(
                'incoming_server' => array(
                    'url'   => 'mail.ngagge-mail.com',
                    'ports' => array(
                        'imap' => 143,
                        'pop'  => 110
                    )
                ),
                'outgoing_server' => array(
                    'url'   => 'mail.ngagge-mail.com',
                    'ports' => array(
                        'smtp' => 587
                    )
                )
            )
        )
    ),
    // bandwidth keys
    'bandwidth'      => array(
        'accountId'          => '5005233',
        // Account  Endpoint
        'account_baseUrl'    => '',
        'account_username'   => 'neeraj.daz@gmail.com',
        'account_password'   => 'It@bandwidth2',
        // sms endpoint
        'sms_baseUrl'        => '',
        'apiToken'           => '28ddc8e5f811fa307ddc10dd701ae9911b177de5d3434ade',
        'apiSecret'          => 'f97665088b26ee073e856513083ca427740bc2b0d8870133',
        'applicationId'      => 'fc1143a1-4cf6-46aa-85c1-f330f21ad844',
        'testModeSmsSending' => true // true messages would be saved locally 
    ),
    // calendrific keys
    'calendarific'   => array(
        'api_key' => 'c7b0773fd01077cca198346159e2c1d21b716fe0',
    ),
    // stripe keys for nggage.com
    'stripe'         => array(
        'STRIPE_KEY'    => 'pk_test_G0ry8n6XyEqoTC6qhuguTNlJ002dy7YBzr',
        'STRIPE_SECRET' => 'sk_test_TjIMEgHRQrQk7hCjrgoyYjvg00L8Q1EZ6u'
    ),
    // stripe keys for clients of  nggage.com
    'stripe_connect' => array(
        'STRIPE_KEY'    => 'ca_HKcBLj8MwmGin7zOWG6VwPDrE2mYXc2G',
        'STRIPE_SECRET' => 'sk_test_KbA0LvkGNKKUJpvfQ2drn37p00IXmrQQCY'
    ),
    'addonsto'       => array(
        'toaddress' => 'ankur247live@gmail.com',
    ),
    'gmail_connect'  => array(
        'google_api_key' => 'AIzaSyBXVj_1joBTp7HY-_ZkEZ4yV4o4t_S3dFA'
    ),
    'company_mail'   => array(
        'spf_text'          => 'ngagge-mail.com',
        'match_domain_with' => 'ngagge-mail.com',
        // to switch dkim chnage seector or selector number
        // dkim propagation will take 24-48 hours thats by we need second selector
        'selector'          => 'p',
        'selector_number'   => 1
    ),
    'phpmailsub' => array(
        'host' =>  'mail.racmart.com',
        'port' => '465',
        'encryption' => 'ssl',
        'username' => 'support@racmart.com',
        'password' => '(ac?w(6@p8({',
        'from'=>'info@racmart.com',
        'from_name'=>'Ngagge'
    ),
        
    
);
