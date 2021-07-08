<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
    <title class="notranslate">Instant, Free Customer Communication Platform | Ngagge</title>

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
    <style type="text/css">
        /* To hide the suggestion box (the !important part is really important :) ) */

        #goog-gt-tt,
        .goog-te-balloon-frame {
            display: none !important;
        }

        .goog-text-highlight {
            background: none !important;
            box-shadow: none !important;
        }

        /* To hide the powered by */

        .goog-logo-link {
            display: none !important;
        }

        .goog-te-gadget {
            height: 28px !important;
            overflow: hidden;
        }

        /* To remove the top frame */

        body {
            top: 0 !important;
        }

        .goog-te-banner-frame {
            display: none !important;
        }

        .goog-te-menu2 {
            background-color: red !important;
        }
    </style>
    <script src="{{ asset('js/Sortable.min.js')}}"></script>
</head>

<body id="app-layout" class="<?php echo ((isset(Auth::user()->onboardingGetStarted) && Auth::user()->onboardingGetStarted == 1) ? 'start-intro' : ''); ?> template-{{ collect(\Request::segments())->implode('-') }}">
    <div id="app">
        @include('sidebar.sidebar')
        <main class="page home-page">
            @include('partials.header')
            <div class="container-fluid">
                <div>
                    @yield('content')
                </div>
            </div>
            @include('partials.footer')
        </main>
        <loader :is-visible="isLoading"></loader>
    </div>
    <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />

    @yield('page-related-js')

    <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.mousewheel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.jscrollpane.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.mCustomScrollbar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    <script src="{{asset('js/html2canvas.min.js')}}" type="text/javascript"></script>
    <?php if (Auth::user()->id == '2') { ?>
        <script src="{{ asset('js/intro.min.js') }}"></script>
        <script src="{{ asset('js/introjs-custom.js') }}" type="text/javascript"></script>
    <?php } else { ?>
        <script src="{{ asset('js/introjs-fixes.js') }}" type="text/javascript"></script>
    <?php } ?>
    @yield('wistia_js')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log("this is blade");
        });
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            translatePage();
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,nl,fr,pt,es,de,it,es',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: true
            }, 'google_translate_element');
        }
        $('document').ready(function() {
            $('body').on("click", '#google_translate_element', function() {
                setTimeout(() => {
                    $("iframe").contents().find('.goog-te-menu2').css({
                        'width': '100%',
                        'height': '100%',
                        'border': 'none',
                        'box-sizing': 'border-box'
                    });
                    $("iframe").contents().find('.goog-te-menu2 a[class*="goog-te-menu2-item"]').css({
                        'font-size': '16px',
                        'font-family': '"Roboto", sans-serif',
                        'color': '#181818',
                    });
                    $("iframe").contents().find('.goog-te-menu2 table').css({
                        'width': '100%'
                    });
                    $("iframe").contents().find('.goog-te-menu2 a[class*="goog-te-menu2-item"] .text').css({
                        'font-weight': 'normal',
                    });
                    $("iframe.goog-te-menu-frame").contents().find('head').append(`
                            <style>
                                *{box-sizing:border-box;}
                                .goog-te-menu2 a[class*="goog-te-menu2-item"]{}
                                .goog-te-menu2 a[class*="goog-te-menu2-item"] .text{font-weight:normal;color:#181818;font-size:14px;}
                                .goog-te-menu2-item div, .goog-te-menu2-item-selected div{padding:6px 8px;}
                                .goog-te-menu2-item:hover > div,.goog-te-menu2-item-selected > div{background-color:#edf3f7 !important;}
                            </style>
                        `);
                }, 300);
            });
        });

        $(document).ready(function() {
            checkChange();
        });
        var currentLang = "";

        function checkChange() {
            setTimeout(function() {
                readCookie('googtrans');
            }, 2000);
        }

        function readCookie(name) {
            var c = document.cookie.split('; '),
                cookies = {},
                i, C;

            for (i = c.length - 1; i >= 0; i--) {
                C = c[i].split('=');
                cookies[C[0]] = C[1];
            }

            currentLang = cookies[name];
            if (currentLang != cookies['selectedLang'])
                updateCookies(currentLang);
            checkChange();
        }

        function updateCookies(cookie) {
            // var cookieStr = cookie.split("/");
            // var trans_lang = cookieStr[cookieStr.length - 1];

            var trans_lang = cookie;
            $.ajax({
                type: "POST",
                url: 'update-google-trans-language',
                data: {
                    'trans_lang': trans_lang,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status == 'success') {
                        setCookie('selectedLang', data.trans_lang, 1);
                    }
                },
                failure: function(data) {
                    alert(data);
                }
            });
        }
        // 
        function translatePage() {
            $.ajax({
                type: "POST",
                url: 'get-google-trans-language',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status == 'success') {
                        setCookie('googtrans', data.trans_lang, 1);
                        setCookie('selectedLang', data.trans_lang, 1);
                    }
                },
                failure: function(data) {
                    alert(data);
                }
            });
        }

        function setCookie(key, value, expiry) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function checkGoogleDiv() {
            // console.log('checking');
            var elementExists = document.getElementById("google_translate_element");
            // console.log('element', elementExists);

            if (elementExists) {
                // console.log('exists ---- ');
                googleTranslateElementInit();

            } else {
                // console.log('does not exists');
                setTimeout(function() {
                    // console.log('fire timeout');
                    checkGoogleDiv();
                }, 500);
            }
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=checkGoogleDiv"></script>
    <!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->

    <!--        <div class="row" style="position: absolute;bottom: 0;right: 5rem;height: 5rem;width: 9rem;z-index: 99999;background: transparent;">
            <div class="col-12">
                <div id="google_translate_element"></div>
            </div>
        </div>-->

    <audio id="chatAudio">
        <source src="{{ asset('audio/notify.mp3') }}" type="audio/mpeg">
    </audio>
    @include('layouts.internalchatcode')
</body>

</html>