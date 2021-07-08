<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
        <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
        <title class="notranslate">Instant, Free Customer Communication Platform | Ngagge</title>

        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/jquery.mCustomScrollbar.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/style.default.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/jquery.mytour.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/jquery.jscrollpane.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/cropper.min.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/main2.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
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
            .goog-te-menu2{background-color: red !important;}
        </style>
        <script src="<?php echo e(asset('js/Sortable.min.js')); ?>"></script>
    </head>

    <body id="app-layout" class="<?php echo ((isset(Auth::user()->onboardingGetStarted) && Auth::user()->onboardingGetStarted == 1) ? 'start-intro' : ''); ?> template-<?php echo e(collect(\Request::segments())->implode('-')); ?>">
        <div id="app">
            <?php echo $__env->make('sidebar.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <main class="page home-page">
                <?php echo $__env->make('partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="container-fluid">
                    <div>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
                <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </main>
            <loader :is-visible="isLoading"></loader>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="<?php echo e(url('')); ?>" />

        <?php echo $__env->yieldContent('page-related-js'); ?>

        <script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/jquery.mousewheel.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/jquery.jscrollpane.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/jquery.mCustomScrollbar.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/custom.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/html2canvas.min.js')); ?>" type="text/javascript"></script>
        <?php if (Auth::user()->id == '2') { ?>
            <script src="<?php echo e(asset('js/intro.min.js')); ?>"></script>
            <script src="<?php echo e(asset('js/introjs-custom.js')); ?>" type="text/javascript"></script>
        <?php } else { ?>
            <script src="<?php echo e(asset('js/introjs-fixes.js')); ?>" type="text/javascript"></script>
        <?php } ?>
        <?php echo $__env->yieldContent('wistia_js'); ?>
        <script type="text/javascript">
$(document).ready(function () {
    console.log("this is blade");
});
        </script>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en',
                    includedLanguages: 'en,nl,fr,pt,es,de,it',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                    autoDisplay: true
                }, 'google_translate_element');
            }
            $('document').ready(function () {
                $('body').on("click", '#google_translate_element', function () {
                    setTimeout(() => {
                        $("iframe").contents().find('.goog-te-menu2').css({
                            'width': '100%',
                            'height': '100%',
                            'border': 'none',
                            'box-sizing':'border-box'
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
                    },300);
                });
            });
        </script>

        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!--        <div class="row" style="position: absolute;bottom: 0;right: 5rem;height: 5rem;width: 9rem;z-index: 99999;background: transparent;">
            <div class="col-12">
                <div id="google_translate_element"></div>
            </div>
        </div>-->

        <audio id="chatAudio">
            <source src="<?php echo e(asset('audio/notify.mp3')); ?>" type="audio/mpeg">
        </audio>
        <?php echo $__env->make('layouts.internalchatcode', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </body>

</html>