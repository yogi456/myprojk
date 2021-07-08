<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
            *{margin: 0;border: 0;padding:0;}
            body{font-family: 'Open Sans', sans-serif;}
            .email-footer{text-align: center;margin-top: 10px;padding-top: 10px;border-top:1px solid #ccc;display: block;}
            .email-footer a{color: #999;padding: 0;text-decoration: none;line-height: 13px;font-size: 13px;display: inline-block;}
        </style>
    </head>
    <body style="font-family: 'Open Sans', sans-serif;font-size: 16px;">
        <div id="wrapper" style="max-width: 600px;margin: 20px auto; padding: 30px 15px;">
            <header class="email-header">
                <a href="{{url('/')}}" target="_blank">
                    <img class="logo" src="{{url('/')}}/img/logo.png" alt="logo" style="max-width: 175px;margin-bottom: 15px;">
                </a>
            </header>
            <div class="email-content">
                <p style="margin-bottom: 16px;">Hi Irefill Admin, </p>
                    <p style="margin-bottom: 16px;">You have a contact request details are below </p>

               
                  <p style="margin-bottom: 16px;"><strong>Name : </strong><br/> {{$name}}</p>
                  <p style="margin-bottom: 16px;"><strong>Email : </strong><br/> {{$email}}</p>
                           <p style="margin-bottom: 16px;"><strong>Subject : </strong><br/> {{$subject}}</p>
                  <p style="margin-bottom: 16px;"><strong>Message : </strong><br/> {{$msg}}</p>

                
            </div>
            <div class="email-footer">
                <a href="{{url('/')}}" target="_blank">
                    <img class="logo" src="{{url('/')}}/img/logo.png" alt="logo" style="max-height: 25px;">
                </a>
            </div>
        </div>
    </body>
</html>






