<?php $__env->startSection('content'); ?>
<div class="login-page-new d-flex flex-column" >
    <div class="login-main-wrapper">
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-6 login-wrap-left d-flex flex-column">
                    <div class="w-100">
                        <div class="mw-560 mx-auto">
                            <a class="login-logo" href="#"><img src="<?php echo e(asset('/images/ngagge-logo.png')); ?>" alt=""/></a>
                        </div>
                        <div class="mw-560 mx-auto login-part-content mb-login">
                            <div class="text-center mb-5">
                                <h2 class=" fs-48 fw-700">
                                    <?php
                                    $ap = array("Glad you're back", "Welcome back", "Hi. Welcome back");
                                    echo $ap[array_rand($ap)];
                                    ?>
                                </h2>                           
                            </div>
                            <div class="">
                                <form id="formAppLogin" class="form-horizontal fs-16 mw-450 mx-auto"  role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="form-group">
                                        <label for="" class="fw-600 fs-16">Email</label>
                                        <span><?php //print_r($errors);                                                                    ?></span>
                                        <input type="email" name="email" id="email" class="form-control fs-16" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="fw-600 fs-16">Password</label>
                                        <input type="password" name="password" id="password" class="form-control fs-16" required>
                                        <input id="oqtzoffset" type="hidden" name="oqtzoffset" value="" >
                                        <input id="currenttimezonedata" type="hidden" name="currenttimezonedata" value="" >
                                    </div>
                                    <div class="form-group row ml-0">
                                        <!--                                    <div class="col-auto pl-0 d-flex">
                                                                                <label class="custom-checkbox">
                                                                                    <input type="checkbox" name="remember">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                                <input type="checkbox" class="form-check-input" id="">
                                                                                <label class="form-check-label pl-3 fs-16" for="remember">Keep me signed in</label>
                                                                            </div>-->
                                        <div class="col-auto px-0">
                                            <a class="btn-link text-black fs-16" href="<?php echo e(url('password/reset')); ?>"><u>Forgot Your Password?</u></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $massage = $errors->first('email');
                                        if ($massage == 'The email has already been taken.') {
                                            ?>
                                                                    <!--   <span class="text-danger text-center w-100">An account already exists with this email address</span> -->
                                        <?php } else { ?>
                                            <span class="text-danger text-center w-100"><?php echo e($errors->first('email')); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3">Sign In  </button>
                                    </div>
                                    <div class="form-group text-center seperator">
                                        <span class="or-seperator fs-16">
                                            Or
                                        </span>
                                    </div>


                                    <div class="form-group mb-2" >
                                        <!--                                        <a class="btn-link d-flex align-items-center btn-sign-w-google text-center py-0" data-target="#signINNUPWithGoogleModal" data-toggle="modal">
                                                                                    <img src="<?php echo e(asset('/images/btn_google_dark_normal_ios@3x.png')); ?>" alt='google' style="max-height: 58px;margin: -3px;" />
                                                                                    <span class="flex-grow-1">Sign in with Google</span>
                                                                                </a>-->
                                        <a class="btn-link d-flex align-items-center btn-sign-w-google text-center py-0" href="<?php echo e(url('auth/google')); ?>" class="btn btn-block btn-sign-w-google text-black text-center py-2" >
                                            <img src="<?php echo e(asset('/images/btn_google_dark_normal_ios@3x.png')); ?>" alt='google' style="max-height: 58px;" />
                                            <span class="flex-grow-1">Sign in with <label class="notranslate">Google</label></span>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <p class="text-center for-mobile d-none">
                                <a class="link-show-lr" href="#">Don't have an account? Register</a>
                            </p>
                        </div>
                        <div class="mw-560 mx-auto login-part-content mb-register">
                            <div class="text-center mb-5">
                                <h2 class=" fs-48 fw-700">
                                    <?php
                                    $ap = array("Register");
                                    echo $ap[array_rand($ap)];
                                    ?>
                                </h2>                           
                            </div>
                            <div class="">
                                <form action="<?php echo e(url('signup')); ?>" methods="POST" id='formSignupHeader1'>
                                    <div class="form-group">
                                        <label for="" class="fw-600 fs-16">Email</label>
                                        <input type="email" class="form-control" name="email_signup" id="inputPassword2" placeholder="Your email address">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3" >Free-Forever, Sign up now!</button>
                                    </div>
                                    <!--                                    <div class="form-group d-flex">
                                                                            <input type="email" class="form-control" name="email_signup" id="inputPassword2" placeholder="Your email address">
                                                                        </div>
                                                                        <button type="submit" class="btn bg-dgray text-white" >Free-Forever, Sign up now!</button>-->
                                    <?php
                                    $massage = $errors->first('email_signup');
                                    if ($massage == 'The email has already been taken.') {
                                        // echo 'An account already exists with this email address'
                                        ?>
                                        <span class="text-danger text-center w-100">An account already exists with this email address</span>
                                    <?php } else { ?>
                                        <span class="text-danger text-center w-100"><?php echo e($errors->first('email_signup')); ?></span> 
                                    <?php } ?>
                                </form>
                            </div>
                            <p class="text-center for-mobile d-none">
                                <a class="link-show-lr" href="#">Already have an account? Login</a>
                            </p>
                        </div>
                    </div>
                    <div class="mt-auto text-center fs-13">
                        <p class="m-0"><span class="app-title notranslate">ngagge</span> &copy; 2013-2020, all rights reserved.</p>
                        <div class="mt-1 mb-4">
                            <a class="d-inline-block lh-1 pr-3 border-right border-black" href="https://www.ngagge.com/terms" target="_blank">Terms of Service</a>
                            <a class="d-inline-block lh-1 pl-3" href="https://www.ngagge.com/terms" target="_blank">Privacy Policy</a>
                        </div>
                    </div>
                </div>
                <div class="col-6 login-wrap-right">
                    <div class="row flex-wrap">
                        <div class="col-auto mx-auto" style="color: red">
                            <form action="<?php echo e(url('signup')); ?>" methods="POST" id='formSignupHeader' class="form-inline justify-content-center">
                                <div class="form-group d-flex">
                                    <input type="email" class="form-control" name="email_signup" id="inputPassword2" placeholder="Your email address">
                                </div>
                                <button type="submit" class="btn bg-dgray text-white" >Free-Forever, Sign up now!</button>
                                <?php
                                $massage = $errors->first('email_signup');
                                if ($massage == 'The email has already been taken.') {
                                    // echo 'An account already exists with this email address'
                                    ?>
                                    <span class="text-danger text-center w-100">An account already exists with this email address</span>
                                <?php } else { ?>
                                    <span class="text-danger text-center w-100"><?php echo e($errors->first('email_signup')); ?></span> 
                                <?php } ?>
                            </form>
                        </div>
                        <div class="mw-750 mx-auto login-part-content">
                            <div class="col-12 text-center mb-5 px-0">
                                <h2 class=" fs-48 fw-700">
                                    <?php
                                    $a = array("Add-Ons drive growth", "Add-Ons increase sales", "Add-Ons generate more profit", "Add-Ons leverage <span class='app-title notranslate'>ngagge</span>", "Add-Ons multiply conversions", "Add-Ons save cost");
                                    echo $a[array_rand($a)];
                                    ?>
                                </h2>
                            </div>
                            <div class="row">
                                <?php
                                $oq = array('one', 'two', 'three', 'four', 'five', 'six', 'seven');
                                $rand_oq = array_rand($oq, 4);
                                $oqTemp[0] = $oq[$rand_oq[0]];
                                $oqTemp[1] = $oq[$rand_oq[1]];
                                $oqTemp[2] = $oq[$rand_oq[2]];
                                $oqTemp[3] = $oq[$rand_oq[3]];
                                ?>

                                <?php if (in_array('one', $oqTemp)) { ?>
                                    <div class="col-6 addons-feature-single d-flex flex-column">
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/addon-feature-icon-2.png')); ?>" alt='addon-feature-icon-2'/>
                                                <h1 class="m-0 fw-600">Hire Our Chat Agents</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">Save up to 95% in personnel expense, increase business by 40%.</p>
                                                            <p class="fw-700 mt-4">As low as $1 / hour</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('two', $oqTemp)) { ?>
                                    <div class="col-6 addons-feature-single d-flex flex-column" >
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/addon-feature-icon-3.png')); ?>" alt='addon-feature-icon-3'/>
                                                <h1 class="m-0 fw-600">SMS Messaging</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">Open rates 98% vs email 20% !<br/>Response rates 45% vs email 6% !</p>
                                                            <p class="fw-700 mt-4">Best rate less than 1 cent / message</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('three', $oqTemp)) { ?>
                                    <div class="col-6 addons-feature-single d-flex flex-column">
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/addon-feature-icon-4.png')); ?>" alt='addon-feature-icon-4'/>
                                                <h1 class="m-0 fw-600">Replace Branding</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">Increase brand awareness by replacing our brand with yours.</p>
                                                            <p class="fw-700 mt-4">$15 /mo or $144 / year 25% saving</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('four', $oqTemp)) { ?>
                                    <div class="col-6 addons-feature-single d-flex flex-column" >
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/addon-feature-icon-5.png')); ?>" alt='addon-feature-icon-5'/>
                                                <h1 class="m-0 fw-600">Agent Training</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">Get a leg up on your competition with agent training.</p>
                                                            <p class="fw-700 mt-4">Contact us</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('five', $oqTemp)) { ?>
                                    <div class="col-6 addons-feature-single d-flex flex-column">
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/addon-feature-icon-6.png')); ?>" alt='addon-feature-icon-6'/>
                                                <h1 class="m-0 fw-600">Programming</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p class="">Modify a feature, or use our REST API to meet your company's needs.</p>
                                                            <p class="fw-700 mt-4">Contact us</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('six', $oqTemp)) { ?>
                                    <div class="col-6 addons-feature-single d-flex flex-column"s>
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/icon-mv.png')); ?>" alt='addon-feature-icon-6'/>
                                                <h1 class="m-0 fw-600">Video Production</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">            
                                                            <p class="">Explainer, tutorial, demo and product videos as well as custom animated GIFs.</p> 
                                                            <p class="fw-700 text-left mt-3 pt-1 d-flex">
                                                                <a href="https://viddeo.io/video-production" target="_blank">From $69</a>
                                                            </p>
                                                        </div>                             
                                                    </div> 
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (in_array('seven', $oqTemp)) { ?>

                                    <div class="col-6 addons-feature-single d-flex flex-column">
                                        <div class="height-inner p-4">
                                            <div class="h-wrapper mb-3 d-flex align-items-center">
                                                <img class="mr-3" src="<?php echo e(asset('/images/icon-bot.png')); ?>" alt='addon-feature-icon-6'/>
                                                <h1 class="mt-3 fw-600">Build-a-Bot Help</h1>
                                            </div>
                                            <div class="mh-250">
                                                <div class="inner-section ">
                                                    <div class="row">
                                                        <div class="col-12">            
                                                            <p class="">DIY with our easy to use bot builder or save time and have us do it for you.</p> 
                                                            <p class="fw-700 text-left mt-3 pt-1 ">Contact us</p>
                                                        </div>                             
                                                    </div> 
                                                </div>    
                                            </div>
                                            <div class="addons-feature-footer">
                                                <a class=" btn-link btn text-blue p-0 mr-2 fs-16 fw-400" href="javascript:void(0);">Learn more </a>
                                            </div>  
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="signINNUPWithGoogleModal" role="dialog" aria-labelledby="signINNUPWithGoogleModal" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-middle mw-450">
        <div class="modal-content p-5">
            <div class="modal-body">
                <div class="p-5">
                    <form class="" name="" action="" method="post">
                        <div class="form-group row mb-0">
                            <label  class="col-12 col-form-label modal-delete-text">This feature is currently subject to approval by Google. If you’re a Google developer, please proceed. </label>
                            <div class="col-12 mt-4">
                                <a class="btn-link d-flex align-items-center btn-sign-w-google text-center py-0" href="<?php echo e(url('auth/google')); ?>" class="btn btn-block btn-sign-w-google text-black text-center py-2" >
                                    <img src="<?php echo e(asset('/images/btn_google_dark_normal_ios@3x.png')); ?>" alt='google' style="max-height: 58px;" />
                                    <span class="flex-grow-1">Sign in with Google</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#oqtzoffset").val(new Date().getTimezoneOffset());
		var timeZonedata =  Intl.DateTimeFormat().resolvedOptions().timeZone; 
		$("#currenttimezonedata").val(timeZonedata);
        $('.link-show-lr').click(function(ev){
            ev.preventDefault();
            $('.login-wrap-left').toggleClass('mb-register-show');
        });
    });
	
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth-app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>