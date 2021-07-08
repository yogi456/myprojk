<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
        <title class="notranslate">Free-forever live chat, bots, CRM software + 25 free tools</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ url('/css/style.default.css')}}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
   

        <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/grapes/grapesjs-preset-webpage.min.css') }}">
        <script src="//feather.aviary.com/imaging/v3/editor.js"></script>
        <script src="https://static.filestackapi.com/v3/filestack-0.1.10.js"></script>
        <script src="https://unpkg.com/grapesjs"></script>
        <script src="{{asset('js/grapes/grapesjs-preset-webpage.min.js')}}"></script>

        <style>
            body,
            html {
                height: 100%;
                margin: 0;
            }
        </style>

    </head>
    <body id="app-layout"  class="<?php echo ((isset(Auth::user()->onboardingGetStarted) && Auth::user()->onboardingGetStarted == 1) ? 'start-intro' : ''); ?> template-{{ collect(\Request::segments())->implode('-') }}">
        @section('sidebar')
        @include('sidebar.sidebar')
        <div class="page home-page" >
            <!--@include('partials.header')-->
            <div class="container-fluid px-0" id="gjs" style="height:0px; overflow:hidden">
                @yield('content')
            </div>
            <!--@include('partials.footer')-->
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />
        <script src="{{asset('js/app.js')}}"></script>
        <script type="text/javascript">
var editor = grapesjs.init({
    height: '100%',
    showOffsets: 1,
    noticeOnUnload: 0,
    storageManager: {autoload: 0},
    container: '#gjs',
    fromElement: true,

    plugins: ['gjs-preset-webpage'],
    pluginsOpts: {
        'gjs-preset-webpage': {}
    }
});
        </script>
    </body>
</html>
