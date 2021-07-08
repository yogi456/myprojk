<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Freechat247live</title>
        <script src='https://meet.jit.si/external_api.js'></script>
    </head>
    <body>       
        <div id="app">
            <p>
                Test Jitsi
            </p>
            <div id="meet">
                
            </div>
        </div>
        <script type="text/javascript">
            const domain = 'meet.jit.si';
            const options = {
                roomName: 'JitsiMeetAPIExample',
                width: 700,
                height: 700,
                parentNode: document.querySelector('#meet')
            };
            const api = new JitsiMeetExternalAPI(domain, options);
        </script>
    </body>
</html>
