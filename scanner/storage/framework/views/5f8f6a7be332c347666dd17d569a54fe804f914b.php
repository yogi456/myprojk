<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" style="overflow:visible;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
        <title>Laravel Product App</title>
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/main2.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/main3.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    </head>
    <body>
        <div class="vh-100 kb-page-wrapper" id="app">
            <?php
            $art = $data;
            $sbid = $subid;
            ?>
            <arlicle-link articledata='<?php echo e($art); ?>' subid="<?php echo e($sbid); ?>"></arlicle-link>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="<?php echo e(url('')); ?>" />
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
        <script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>" type="text/javascript"></script>
    </body>
</html>
