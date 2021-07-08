
<!doctype html>
<html lang="{{ app()->getLocale() }}" style="overflow:visible;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Irefill</title>
        <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('css/templatemo-sixteen.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.css') }}">
      
    </head>
    <body>
        <div class="vh-100 kb-page-wrapper" id="app">
            
            <scanner-qr></scanner-qr>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />
        <script src="{{asset('js/app.js')}}"></script>
       
    </body>
</html>
