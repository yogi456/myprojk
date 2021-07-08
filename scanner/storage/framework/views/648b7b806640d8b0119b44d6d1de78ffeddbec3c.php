<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
    <title>Free-forever live chat, bots, CRM software + 25 free tools</title>
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

<body id="app-layout">
    <?php echo $__env->yieldContent('content'); ?>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,nl,fr,pt,es,de,it',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: true
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <div class="row" style="position: absolute;bottom: 0;/* left: 0; */right: 5rem;height: 5rem;width: 9rem;z-index: 99999;background: transparent;">
        <div class="col-12">
            <div id="google_translate_element"></div>
        </div>
    </div>

</body>

</html>