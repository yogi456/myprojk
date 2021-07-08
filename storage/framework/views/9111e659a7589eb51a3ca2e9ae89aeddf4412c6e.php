<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <style>
            @import  url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
            *{margin: 0;border: 0;padding:0;}
            body{font-family: 'Open Sans', sans-serif;}
            .email-footer{text-align: center;margin-top: 10px;padding-top: 10px;border-top:1px solid #ccc;display: block;}
            .email-footer a{color: #999;padding: 0 10px;text-decoration: none;line-height: 13px;font-size: 13px;display: inline-block;margin: 5px 0 0;vertical-align: top;}
            .email-footer img{margin: 0;border: 0;padding: 0 15px 0 0;min-height: 25px;max-height: 25px;border-right: 1px solid #ccc;}
            .eml-title{font-size: 36px;}
            @media(max-width:440px){
                .eml-title{font-size: 24px;}
            }
        </style>
    </head>
    <body style="font-family: 'Open Sans', sans-serif;font-size: 15px;">        
        <div style="text-align: center;background: #eee;padding:20px 10px;font-family: 'Open-sans',sans-serif;">
            <img src="<?php echo e(url('images/ngagge-logo.png')); ?>" style="height: 60px;" alt=""/>
            <div class="" style="margin:20px 0;padding:30px 20px;background: #fff;">
                <h2 class="eml-title" style="">Just one more step!</h2>
                <p style="margin: 15px 0;">Click the button below to complete your <span class="app-title">ngagge</span> registration</p>
                <a href="<?php echo e(url('/verify-email/'.$string)); ?>" style="background: #181818;color:#fff;padding: 20px 50px;display: inline-block;border-radius: 4px;">Activate your account</a>
            </div>
            <div style="font-size: 12px;line-height: 18px;color: #999;margin-bottom: 15px;">
                <p style="margin: 0;">&copy; 2013-2020 <span class="app-title">ngagge</span>, All Right Reserved</p>
                <p style="margin: 0;">6231 PGA Blvd, Palm Beach Gardens, FL 33418</p>
            </div>
            <div class="email-footer" >
                <img src="<?php echo e(url('images/ngagge-logo.png')); ?>"  alt=""/> 
                <a href="<?php echo e($url_unsubcribe); ?>" style="">unsubscribe</a>
            </div>
        </div>
    </body>
</html>
