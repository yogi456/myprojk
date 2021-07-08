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
                <p style="margin-bottom: 16px;">I really appreciated your joining us at Ngagge.</p>
                <p style="margin-bottom: 16px;">With Ngagge you'll generate more revenue, provide better support, increase productivity, lower costs, improve customer experience and receive valuable feedback from your staff and customers.</p>
                <p style="margin-bottom: 16px;">Over the next several weeks, we'll be sending you a few more emails with tips to help you get maximum value from ngagge.</p>
                <p style="margin-bottom: 20px;">Thank you</p>
                <div style="margin-bottom: 16px;">
                    <img class="logo" src="https://dev.app.ngagge.com/images/darla-200x.png" alt="logo" style="max-height: 90px;float: left;"/>
                    <div style="margin: 10px 0 0 15px;float: left;">
                        <p style="margin-bottom: 8px;font-size: 18px;">Darla J</p>
                        <p>Success Professional</p>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <p style="margin-bottom: 25px;">P.S. If you haven't already, <a href="https://ngagge.wistia.com/medias/z42wvq9n8h" style='color: #0f60ab; text-decoration: underline;'>watch this short overview video</a> to discover all the benefits Ngagge has to offer, <span><a href='<?php echo e(url('/get-started')); ?>' style='color: #0f60ab; text-decoration: underline;'>get started </a></span>, or <span><a href='<?php echo e(url('/')); ?>' style='color: #0f60ab; text-decoration: underline;'>chat with us </a></span> if you need a quick answer.</p>
            </div>
            <div class="email-footer">
                <a href="<?php echo e(url('/')); ?>" target="_blank">
                    <img class="logo" src="https://www.ngagge.com/assets/img/ngagge-logo.png" alt="logo" style="max-height: 25px;">
                </a>
            </div>
        </div>
    </body>
</html>
