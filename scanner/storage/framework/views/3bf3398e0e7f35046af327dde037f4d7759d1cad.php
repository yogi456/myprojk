<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
        <title class="notranslate">Free-forever live chat, bots, CRM software + 25 free tools</title>
        <link rel="stylesheet" href="<?php echo e(asset('/css/app.css')); ?>">
        <!--        <link rel="stylesheet" href="<?php echo e(asset('/css/bootstrap.min.css')); ?>">-->
        <link rel="stylesheet" href="<?php echo e(asset('/css/style.default.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('/css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/main2.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
        <script src="<?php echo e(asset('/js/jquery-2.2.3.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/tether.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('/js/bootstrap.min.js')); ?>" type="text/javascript"></script>

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
        </style>

    </head>

    <body id="app-layout" class="auth-layout">
        <?php echo $__env->yieldContent('content'); ?>

        <script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,nl,fr,pt,es,de,it,es',
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
            $("iframe.goog-te-menu-frame").contents().find('head').append(`<style>
                                *{box-sizing:border-box;}
                                .goog-te-menu2 a[class*="goog-te-menu2-item"]{}
                                .goog-te-menu2 a[class*="goog-te-menu2-item"] .text{font-weight:normal;color:#181818;font-size:14px;}
                                .goog-te-menu2-item div, .goog-te-menu2-item-selected div{padding:6px 8px;}
                            .goog-te-menu2-item:hover > div,
                            .goog-te-menu2-item-selected > div{background-color:#edf3f7 !important;}
                            </style>`);
        }, 300);
    });
});
        </script>

        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

        <div style="position: fixed;bottom: 13px;right: 20px;width: 180px;z-index: 99999;background: transparent;">
            <div id="google_translate_element"></div>
        </div>

    </body>

</html>