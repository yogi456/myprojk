
<!doctype html>
<html lang="{{ app()->getLocale() }}" style="overflow:visible;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Laravel Product App</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main3.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    </head>
    <body>
        <div class="vh-100 kb-page-wrapper" id="app">
            
            <scanner-qr></scanner-qr>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    </body>
</html>
