@extends('layouts.auth-app')
@section('content')
<div class="login-page-new d-flex flex-column" >
    <header class="bg-white mt-0 py-5">
        <div class="container-fluid">
            <div class='row align-items-center'>
                <div class="col-auto">
                    <a class="login-logo" href="#"><img src="{{ asset('/images/ngagge-logo.png') }}" alt=""/></a>
                </div>
                <div class="col-auto ml-auto" style="color: red">
                    <form action="{{ url('signup')}}" methods="POST" id='formSignupHeader' class="form-inline" >
                        <div class="form-group d-flex">
                            <input type="text" class="form-control" name="email" id="inputPassword2" placeholder="Your email address">
                        </div>
                        <button type="submit" class="btn bg-dgray text-white" >Free-Forever, Sign up now!</button>
                    </form>
                    <?php
                    $massage = $errors->first('email');
                    if ($massage == 'The email has already been taken.') {
                          echo 'An account already exists with this email address'
                        ?>
                    <?php } else { ?>
                        <span class="text-danger">{{$errors->first('email')}}</span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>
    <div class="login-main-wrapper mt-5" >
        <div class="container-fluid">
            <div class="row ">
                <div class="col-5 pr-5 login-wrap-left">
                    <div class="text-center mb-5 mw-560 pr-5 pl-0 mr-5">
                        <h2 class=" fs-48 fw-700">
                            <?php
                            $ap = array("Glad you're back", "Welcome back", "Hi. Welcome back");
                            echo $ap[array_rand($ap)];
                            ?>
                        </h2>
                    </div>
                    <div class="mw-560 pr-5 mr-5">
                        <form id="formAppLogin" class="form-horizontal fs-16"  role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="" class="fw-600 fs-16">Email</label>
                                <span><?php //print_r($errors);                                                ?></span>
                                <input type="email" name="email" id="email" class="form-control fs-16" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="fw-600 fs-16">Password</label>
                                <input type="password" name="password" id="password" class="form-control fs-16" required>
                                <input id="oqtzoffset" type="hidden" name="oqtzoffset" value="" >
                            </div>
                            <div class="form-group row ml-0">
                                <div class="col-auto pl-0 d-flex">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                    <!--<input type="checkbox" class="form-check-input" id="">-->
                                    <label class="form-check-label pl-3 fs-16" for="remember">Keep me signed in</label>
                                </div>
                                <div class="col-auto ml-auto">
                                    <a class="btn-link text-black fs-16" href="{{ url('password/reset') }}"><u>Forgot Your Password?</u></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3">Sign In</button>
                            </div>
                            <div class="form-group text-center seperator">
                                <span class="or-seperator fs-16">
                                    Or
                                </span>
                            </div>
                            <div class="form-group" style="border: 2px solid black; border-radius: 5px">
                                <a class="btn-link text-black d-flex align-items-center justify-content-center py-2" href="{{ url('auth/google') }}" class="btn btn-block btn-sign-w-google text-black text-center py-2" >
                                    <span class="px-3 fs-16 lh-1-75">Sign in with<img class="ml-3" src="{{ asset('/images/google-icon-text.png') }}" alt='google'style="max-height: 36px;" /></span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-7 border-left pl-5  login-wrap-right">
                    <div class="row flex-wrap pl-5 ml-5">
                        <div class="col-12 text-center mb-5 px-0">
                            <h2 class=" fs-48 fw-700">
                                <?php
                                $a = array("Add-Ons drive growth", "Add-Ons increase sales", "Add-Ons generate more profit", "Add-Ons leverage Free Chat", "Add-Ons multiply conversions", "Add-Ons save cost");
                                echo $a[array_rand($a)];
                                ?>
                            </h2>
                        </div>
                        <div class="row">
                            <?php
                            $oq = array('one', 'two', 'three', 'four', 'five');
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
                                            <img class="mr-3" src="{{ asset('/images/addon-feature-icon-2.png') }}" alt='addon-feature-icon-2'/>
                                            <h1 class="m-0 fw-600">Hire Our Chat Agents</h1>
                                        </div>
                                        <div class="mh-250">
                                            <div class="inner-section ">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="">Save up to 95% in personnel expense + increase business by 40%+.</p>
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
                                            <img class="mr-3" src="{{ asset('/images/addon-feature-icon-3.png') }}" alt='addon-feature-icon-3'/>
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
                                            <img class="mr-3" src="{{ asset('/images/addon-feature-icon-4.png') }}" alt='addon-feature-icon-4'/>
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
                                            <img class="mr-3" src="{{ asset('/images/addon-feature-icon-5.png') }}" alt='addon-feature-icon-5'/>
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
                                            <img class="mr-3" src="{{ asset('/images/addon-feature-icon-6.png') }}" alt='addon-feature-icon-6'/>
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
                            <?php //if (in_array('six', $oqTemp)) {  ?>
                            <!--                                <div class="col-6 addons-feature-single d-flex flex-column">
                                                                <div class="height-inner p-4">
                                                                    <div class="h-wrapper text">
                                                                        <img src="{{ asset('/images/addon-feature-icon-7.png') }}" alt='addon-feature-icon-7'/>
                                                                        <h1 class="mt-3">Website Redesign</h1>
                                                                    </div>
                                                                    <div class="mh-250">
                                                                        <div class="inner-section ">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <p class="">We'll Include our custom features that let you grow faster and smarter.</p>
                                                                                    <p class="fw-700 text-right mt-4">Contact us</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>-->
                            <?php //}  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#oqtzoffset").val(new Date().getTimezoneOffset());
    });
</script>
@endsection