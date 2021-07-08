<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <style>
            @import  url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
            *{margin: 0;border: 0;padding:0;}
            body{font-family: 'Open Sans', sans-serif;}
            .email-footer{text-align: center;margin-top: 10px;padding-top: 10px;border-top:1px solid #ccc;display: block;}
            .email-footer a{color: #999;padding: 0;text-decoration: none;line-height: 13px;font-size: 13px;display: inline-block;}
        </style>
    </head>
    <body style="font-family: 'Open Sans', sans-serif;font-size: 16px;">
        <div id="wrapper" style="max-width: 480px;margin: 20px auto;">
            <header class="email-header">
                <a href="<?php echo e(url('/')); ?>" target="_blank">
                    <img class="logo" src="https://www.ngagge.com/assets/img/ngagge-logo.png" alt="logo" style="max-width: 175px;margin-bottom: 15px;">
                </a>
            </header>
            <div class="email-content">
                <p style="margin-bottom: 16px;">Hi <?php echo e($first_name); ?>, </p>
                <p style="margin-bottom: 16px;">Thank you for subscribing to Ngagge.</p>
                <p style="margin-bottom: 16px;">I am Darla, your customer success Professional at Ngagge, and I'm thrilled to have you on board! </p>
                <p style="margin-bottom: 16px;">Using 25+ free tools offered by <strong>ngagge</strong>, you are just a few minutes away from,</p>
                <ul style="margin-left: 15px;">
                    <li style="margin-bottom: 16px;"><strong>Generating more leads</strong>.  Add live chat/ bots on your website, connect social media channels, mange leads through a single inbox and use automated CRM to drive successful campaigns.</li>
                    <li style="margin-bottom: 16px;"><strong>Increasing sales conversions</strong>. Convert visitors into customers through email automation, powerful CRM, deals and more.</li>
                    <li style="margin-bottom: 16px;"><strong>Managing contacts more efficiently</strong>. Organize, track and build relationships through ngagge's powerful CRM</li>
                    <li style="margin-bottom: 16px;"><strong>Providing better customer service</strong>. Leverage best practices from pre-defined bots, single inbox with prior conversation history from all channels, ticketing system, scheduling events, tasks and more</li>
                </ul>
                <p style="margin-bottom: 16px;">Let us know which individual or combination of these goals you are interested in, and we can show you the fastest and easiest way to get started.</p>
                <p style="margin-bottom: 16px;">Book a meeting with a specialist at <a href="https://calendly.com/prashant-s/ngagge-walkthrough-15mins" target="_blank">https://calendly.com/prashant-s/ngagge-walkthrough-15mins</a> or chat with our 24/7 support assistants on <a href="www.ngagge.com" target="_blank">www.ngagge.com</a>.</p>
                <p style="margin-bottom: 16px;">Look forward to helping you grow faster while saving staff time and expense with the world's only free-forever customer engagement software offering 25+ free tools.</p>
                <p style="margin-bottom: 20px;">Thank you</p>
                <div style="margin-bottom: 16px;">
                    <img class="logo" src="https://app.ngagge.com/images/darla-200x.png" alt="logo" style="max-height: 90px;float: left;"/>
                    <div style="margin: 10px 0 0 15px;float: left;">
                        <p style="margin-bottom: 8px;font-size: 18px;">Darla J</p>
                        <p>Success Professional</p>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <p style="margin-bottom: 25px;">P.S. <a href="https://www.ngagge.com/overview-enterprise" target="_blank" style='color: #0f60ab; text-decoration: underline;'>Watch this short video</a> to learn more about Ngagge, <a href='<?php echo e(url('/get-started')); ?>'  target="_blank" style='color: #0f60ab; text-decoration: underline;'>get started </a>, or <a href="https://www.ngagge.com"  target="_blank" style='color: #0f60ab; text-decoration: underline;'>chat with us </a> if you need a quick answer.</p>
            </div>
            <div class="email-footer">
                <a href="<?php echo e(url('/')); ?>" target="_blank">
                    <img class="logo" src="https://www.ngagge.com/assets/img/ngagge-logo.png" alt="logo" style="max-height: 25px;">
                </a>
            </div>
        </div>
    </body>
</html>
