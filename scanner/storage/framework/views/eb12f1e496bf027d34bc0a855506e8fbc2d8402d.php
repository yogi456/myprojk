<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <style>
            @import  url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
            *{margin: 0;border: 0;padding:0;}
            body{font-family: 'Open Sans', sans-serif;}
            .email-footer{text-align: center;margin-top: 10px;padding-top: 10px;border-top:1px solid #ccc;display: block;}
            .email-footer a{color: #999;padding: 0;text-decoration: none;line-height: 13px;font-size: 13px;display: inline-block;vertical-align: top;margin: 5px 0 0;}
            .email-footer .f-logo{border-right: 1px solid #ccc;padding-right: 15px;line-height: 1;margin: 0 15px 0 0;}
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
                <p style="margin-bottom: 16px;">Dear <span style='text-transform:capitalize;'><?php echo e($agent_name); ?></span>,</p>
                <p style="margin-bottom: 16px;">You've been invited to join Ngagge by <?php echo e($invited_by_name); ?>.</p>
                <p style="margin-bottom: 16px;">Use your 'To' Email address above as your login email address. </p>
                <div style="margin-bottom: 16px;">
                    <a style='background-color:#181818;border-radius: 4px;padding: 10px 25px;display: inline-block;color:#ffffff;font-size:16px;text-decoration:none;text-align:center;' href="<?php echo e(url('/inviteesetup/'.$email_token)); ?>">
                        Activate your account now
                    </a>
                </div>
                <p style="margin-bottom: 20px;">Your Ngagge Team</p>
            </div>
            <div class="email-footer">
                <a class="f-logo" href="<?php echo e(url('/')); ?>" target="_blank">
                    <img class="logo" src="https://www.ngagge.com/assets/img/ngagge-logo.png" alt="logo" style="max-height: 25px;">
                </a>
                <a href="<?php echo e($url_unsubcribe); ?>">unsubscribe</a>
            </div>
        </div>
    </body>
</html>


