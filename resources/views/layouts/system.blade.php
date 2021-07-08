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
        <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ url('/css/style.default.css')}}">
        <link rel="stylesheet" href="{{ url('/css/jquery.mytour.css')}}">
        <link rel="stylesheet" href="{{ url('/css/jquery.jscrollpane.css')}}">
        <link rel="stylesheet" href="{{ url('/css/cropper.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <script src='https://unpkg.com/sortablejs@1.4.2'></script>
<!--        <script src="https://js.stripe.com/v3/"></script>-->
    </head>
    <body id="app-layout"  class="<?php echo ((isset(Auth::user()->onboardingGetStarted) && Auth::user()->onboardingGetStarted == 1) ? 'start-intro' : ''); ?> template-{{ collect(\Request::segments())->implode('-') }}">
        <div id="app">
            @include('sidebar.sidebar')
            <main class="page home-page">
                @include('partials.header')
                <div class="container-fluid h-100" >                
                    <main class="chat-layout-wrapper system-layout-wrapper "> 
                        <div class="row flex-nowrap border-bottom h-100">
                            <aside class="collaboration-left-holder mr-5 pt-4 ">
                                <div class="console-head-row pt-0 mb-0 pt-2 pl-4 pr-5 border-bottom pb-1">
                                    <div class="col-12 px-0">
                                        <ul id="myTabOptions" data-index="1" class="nav nav-tabs m-0 site-main-tabs">
                                            <li class='d-flex align-items-center'><a href="#" class="text-black fs-20 px-3 py-1 fw-600">System</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class='list-unstyled mt-3 pt-2'>
                                    <li class="list-item">
                                        <div class="dropdown" >
                                            <button type="button" class="btn dropdown-toggle  text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown" >
                                                <span class="sm-link-text">Company</span>
                                            </button>
                                            <div class="dropdown-menu pos-stt">
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=profile')}}"><span class="sm-link-text">Profile</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=departments')}}"><span class="sm-link-text">Departments</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=websites')}}"><span class="sm-link-text">Websites</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=prod_serv')}}"><span class="sm-link-text">Product/Service</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=role_permission')}}"><span class="sm-link-text">Roles & Permissions</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=teammates')}}"><span class="sm-link-text">Teammates</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('company?sub=payment_process')}}"><span class="sm-link-text">Payment Processing</span></a>
                                            </div>                                
                                        </div>
                                    </li>
                                    <li class="list-item"><a class="sm-link" href="{{url('notifications')}}"><span class="sm-link-text text-dgray">Notification</span></a></li>
<!--                                    <li class="list-item">
                                        <div class="dropdown" >
                                            <button type="button" class="btn dropdown-toggle  text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown" >
                                                <span class="sm-link-text">Email</span>
                                            </button>
                                            <div class="dropdown-menu pos-stt">
                                                <a class="dropdown-item sm-link" href="{{url('ticket-email?sub=address_selection')}}"><span class="sm-link-text">Address Selection</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('ticket-email?sub=auto_response')}}"><span class="sm-link-text">Auto Response</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('ticket-email?sub=shared')}}"><span class="sm-link-text">Forward Email</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('ticket-email?sub=transfer')}}"><span class="sm-link-text">Transfer</span></a>
                                            </div>                                
                                        </div>
                                    </li>
                                    <li class="list-item">
                                        <div class="dropdown" >
                                            <button type="button" class="btn dropdown-toggle  text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown" >
                                                <span class="sm-link-text">Facebook</span>
                                            </button>
                                            <div class="dropdown-menu pos-stt">
                                                <a class="dropdown-item sm-link" href="{{url('facebook?sub=messenger')}}"><span class="sm-link-text">Messenger</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('facebook?sub=ads-account')}}"><span class="sm-link-text">Ads</span></a>
                                            </div>                                
                                        </div>
                                    </li>-->
                                    <li class="list-item">
                                        <div class="dropdown" >
                                            <button type="button" class="btn dropdown-toggle  text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown" >
                                                <span class="sm-link-text">Security</span>
                                            </button>
                                            <div class="dropdown-menu pos-stt">
                                                <a class="dropdown-item sm-link" href="{{url('settings?sub=login')}}"><span class="sm-link-text">Login</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('settings?sub=password')}}"><span class="sm-link-text">Password</span></a>
                                                <a class="dropdown-item sm-link" href="{{url('settings?sub=data')}}"><span class="sm-link-text">Data</span></a>
                                            </div>                                
                                        </div>
                                    </li>
                                    <li class="list-item"><a class="sm-link" href="{{url('features')}}"><span class="sm-link-text text-dgray" >Feature Display</span></a></li>
                                </ul>
                            </aside>
                            <div class="flex-grow-1 px-3">
                                @yield('content')
                            </div>
                        </div>
                    </main>
                </div>
                @include('partials.footer')
            </main>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="{{asset('js/manifest.js')}}"></script>
        <script src="{{asset('js/vendor.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
        <script src="{{asset('js/split.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/cropper.min.js')}}"></script>
        <script src="{{asset('js/jquery-cropper.min.js')}}"></script>
        <script src="{{ asset('js/html2canvas.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.mousewheel.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.jscrollpane.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/custom-cropper.js') }}" type="text/javascript"></script>
        @yield('wistia_js')
        <?php if (Auth::user()->id == '1') { ?>
            <script src="{{ asset('js/intro.min.js') }}"></script>
            <script src="{{ asset('js/introjs-custom.js') }}" type="text/javascript"></script>
        <?php } else { ?>
            <script src="{{ asset('js/introjs-fixes.js') }}" type="text/javascript"></script>
        <?php } ?>
            
        <script type="text/javascript">
$(document).ready(function () {
    $('.btn.dropdown-toggle').click(function () {
        $('.aside-dd-show').removeClass('aside-dd-show');
    });
});
        </script>
    </body>
</html>
