<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
        <title>Register - Ngagge</title>

        <script src="<?php echo e(asset('/js/jquery-2.2.3.min.js')); ?>"></script>

        <!-- CSRF Stuff -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <script>window.Laravel = {csrfToken: '<?php echo e(csrf_token()); ?>'}</script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo e(asset('/css/app.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/style.default.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/main2.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('/css/responsive.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('/css/animate.min.css')); ?>">


        <!--        <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">-->

    </head>
    <body id="app-layout">
        <?php
        //$uri =  $_SERVER['REQUEST_URI'];
        if (isset($_REQUEST['redid'])) {
            $param = $_REQUEST['redid'];
        }
        if ($_SERVER['REQUEST_URI'] != '/freechatlive/login' || !isset($_SERVER['REQUEST_URI'])) {
            ?>
            <div class="registration-page" id="app">
                <header class="pt-3">
                    <div class="container-fluid py-4 mw-1400">
                        <div class="row align-items-center">
                            <div class="col-auto rig-logo">
                                <a href="/">
                                    <img style="height: 50px;" src="<?php echo e(url('/images/logo-ngagge-lg.png')); ?>" alt="" />
                                </a>
                            </div>
                            <?php if(isset($signup_step)): ?>
                            <div class="col-auto ml-auto">
                                <span class="px-3 py-1 br-8 bg-black text-white fs-20 fw-600"><?php echo e(isset($signup_step)? $signup_step : '1'); ?> / 3</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="container-fluid mw-1400">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </main>
            </div>
        <?php } ?>
        <?php if ($_SERVER['REQUEST_URI'] != '/freechatlive/login' || !isset($_SERVER['REQUEST_URI'])) { ?>
            <div id="welcomePopup" role="dialog" aria-labelledby="welcomePopup" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog mw-500 modal-middle">
                    <div class="modal-content p-0">
                        <div class="modal-header pb-0 px-4 border-0 py-3 gradient-blue rounded-top">
                            <h3  class="modal-title text-white">Welcome</h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="fa fa-times fs-36 text-white" aria-hidden="true"></i></button>
                        </div>
                        <div class="modal-body pt-0 px-4 pb-4 gradient-grey ">
                            <div class="step-wrap px-3 py-4">
                                <div class="row justify-content-start">
                                    <div class="col px-4 mx-2">
                                        <div class="row">
                                            <div class="col-auto">
                                                <img class="br-4 border border-white p-1" src="<?php echo e(url('/images/1523344309.png')); ?>" width="54px">
                                                <span class="text-white mt-1 d-block text-center fs-12">Janye</span>
                                            </div>
                                            <div class="col bg-white p-0 ml-3 br-5">
                                                <p class="feature-para bg-white pos-rel text-black px-4 py-3 rounded fs-18 d-inline-block">Thanks for subscribing to Ngagge</p>
                                                <ul class="list-unstyled text-xdgray pb-3">
                                                    <li class="row mx-0 mb-2 justify-content-center">
                                                        <div class="col-auto">
                                                            <span class="d-inline-blok btn btn-primary px-3"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                                                        </div>
                                                        <div class=" col-auto align-self-center" style="min-width:120px;padding-left:10px">Get Started</div>
                                                    </li>
                                                    <li class="row mx-0 mb-2 justify-content-center">
                                                        <div class="col-auto">
                                                            <span class="d-inline-blok btn btn-success px-3"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                                                        </div>
                                                        <div class="col-auto align-self-center" style="min-width:120px;padding-left:10px">Take a tour</div>
                                                    </li>
                                                    <li class="row mx-0 mb-2 justify-content-center">
                                                        <div class="col-auto">
                                                            <span class="px-3 d-inline-blok btn btn-danger"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                                                        </div>
                                                        <div class="col-auto align-self-center" style="min-width:120px;padding-left:10px">View a tutorial</div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer rounded-bottom gradient-lgrey d-block px-3 py-2 m-0">
                            <button type="button" class="btn pull-left bg-transparent fs-36 mt-1 p-0"><i class="fa fa-eye-slash"></i></button>
                            <button type="button" class="border-0 bg-transparent pull-right fw-300 p-0" data-dismiss="modal" data-toggle="modal" data-target="#welcomeAlertPopup"><span class="px-3 py-2 border-gray d-block">Explore</span></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="welcomeAlertPopup" role="dialog" aria-labelledby="welcomeAlertPopup" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog mw-500 modal-middle">
                    <div class="modal-content p-0">
                        <div class="modal-header pb-0 px-4 border-0 py-3 gradient-blue rounded-top">
                            <h3  class="modal-title text-white">Alert</h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="fa fa-times fs-36 text-white" aria-hidden="true"></i></button>
                        </div>
                        <div class="modal-body pt-0 px-4 pb-4 gradient-grey ">
                            <div class="step-wrap px-3 py-4">
                                <div class="row justify-content-start">
                                    <div class="col px-4 mx-2">
                                        <div class="row">
                                            <div class="col-auto">
                                                <img class="br-4 border border-white p-1" src="<?php echo e(url('/images/1523344309.png')); ?>" width="54px">
                                                <span class="text-white mt-1 d-block text-center fs-12">Janye</span>
                                            </div>
                                            <div class="col bg-white p-0 ml-3 br-5">
                                                <p class="feature-para text-black px-4 pt-3 rounded fs-18 d-inline-block">Like to Explore? No Problem.</p>
                                                <p class="text-black px-4 pt-3 rounded fs-18 d-inline-block ">
                                                    When you're ready, click on the information icon at the top right and select  "Help" for access to tours, tutorials and other help options.
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer rounded-bottom gradient-lgrey d-block px-3 py-2 m-0">
                            <button type="button" class="btn pull-left bg-transparent fs-24 mt-1 p-0"><i class="fa fa-chevron-left text-lgray"></i></button>
                            <button type="button" class="border-0 bg-transparent pull-right fw-300 p-0" data-dismiss="modal"><span class="px-3 py-2 border-gray d-block">Explore</span></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="appBaseUrl" name="app_base_url" value="<?php echo e(url('')); ?>" />
        <?php } ?>
        <script src="<?php echo e(asset('js/app.js')); ?>"  type="text/javascript"></script>
        <script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/jquery.mousewheel.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/jquery.jscrollpane.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('/js/custom.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('js/intro.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/introjs-custom.js')); ?>" type="text/javascript"></script>
    </body>
</html>
