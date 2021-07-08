<!doctype html>
<html id="oq-active-win-desk" >
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/style.default.css')}}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/animate.min.css')}}">
        <!--<link rel="stylesheet" href="{{ asset('css/webiframe.css') }}">-->
        <style>
            html,body{
                max-height: none;overflow: auto;
            }
        </style>
    </head>
    <body class="link-visitor-wrap">
        <div id="app" class="min-w-0 overflow-auto">
            @yield('content')
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />
        <script src="{{asset('js/components/webiframe.js')}}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
        <script>
            var chatRefreshTimer = '';
            var iFrameResizer = {
                onMessage: function(message) {
                  alert(message, parentIFrame.getId());
                  console.log('On Child Iframe Window, Child Iframe "onMessage" callback function.');
                }
            }
        </script>
    </body>
</html>
