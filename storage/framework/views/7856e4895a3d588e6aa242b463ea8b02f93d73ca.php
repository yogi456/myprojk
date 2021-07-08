<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <style>
            @import  url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
            *{margin: 0;border: 0;padding:0;}
            body{font-family: 'Open Sans', sans-serif;}
            .email-footer{text-align: center;margin-top: 10px;padding-top: 10px;border-top:1px solid #ccc;}
            .email-footer a{color: #999;padding: 0 10px;text-decoration: none;line-height: 13px;font-size: 13px;}
        </style>
    </head>

    <body style="font-family: 'Open Sans', sans-serif;font-size: 15px;">
        <div id="wrapper" style="max-width: 480px;margin: 20px auto;">
            <header class="email-header">
                <img class="logo" src="https://www.ngagge.com/assets/img/ngagge-logo.png" alt="logo" style="max-width: 175px;margin-bottom: 15px;">
            </header>
            <div class="email-content">
                <p style="margin-bottom: 16px;">Dear <?php echo e($first_name); ?>,</p>
                <p style="margin-bottom: 16px;">Invite staff members who will act as chat agents, operate your help center, collaborate, and more to join Ngagge.</p>
                <p style="margin-bottom: 16px;">
                    <a href="<?php echo e(url('company?sub=teammates')); ?>" style='background: linear-gradient(to left, #e66512,#f79352 ) !important;color: #fff !important; padding: 8px; width: 400px; display: inline-block; margin-top: 15px; text-align: center; font-size: 20px; max-width: 400px;'>Invite colleagues now !</a>
                </p>
                <p style="margin-bottom: 25px;">Your Ngagge team.</p>
            </div>
            <footer class="email-footer" style="text-align:center;margin-top:10px;padding-top:10px;border-top:1px solid #ccc;display: flex;justify-content: center;align-items: center;">
                <a href="#" style="color: #999;padding: 0 10px;text-decoration: none;line-height: 13px;font-size: 13px;">
                    <img class="logo" src="https://www.ngagge.com/assets/img/ngagge-logo.png" alt="logo" style="max-height: 25px;">
                </a>
                <a href="#" style="border-left: 1px solid #ccc;color: #999;padding: 0 10px;text-decoration: none;line-height: 13px;font-size: 13px;">unsubscribe</a>
            </footer>
        </div>
    </body>
</html>