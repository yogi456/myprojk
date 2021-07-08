<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="We supply a suite of free instant communication and collaboration features for increasing new business, generating new products and services, encouraging loyalty, and reducing costs">
        <title class="notranslate">Free-forever live chat, bots, CRM software + 25 free tools</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

        <!-- CSRF Stuff -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

        <script src="{{url('/js/tether.min.js') }}" type="text/javascript"></script>
        <script src="{{url('/js/bootstrap.min.js') }}" type="text/javascript"></script>

        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ url('/css/style.default.css')}}">
        <link rel="stylesheet" href="{{ url('/css/main.css')}}">
        <link rel="stylesheet" href="{{ url('/css/main2.css')}}">


        <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">

    </head>
    <body id="app-layout">



        <?php
        //$uri =  $_SERVER['REQUEST_URI']; 
        if (isset($_REQUEST['redid'])) {
            $param = $_REQUEST['redid'];
        }

        if ($_SERVER['REQUEST_URI'] != '/freechatlive/login' || !isset($_SERVER['REQUEST_URI'])) {
            ?>


            <div class=" registration-page p-0" id="app">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 registration-head">

                        </div>

                        <div class="col-12 align-items-center  registration-mid p-0 bg-light">
                            <div class="row rig-row-head justify-content-between bg-white">
                                <div class="container">
                                    <div class="col-sm-9 mx-auto">
                                        <div class="row">
                                            <div class="col rig-logo">
                                                <img style="height: 50px;" src="{{ url('/images/logo-full.png')}}" alt="" />
                                            </div>
                                            <div class="col step-wrap">
                                                <ul class="list-inline step-list float-right">
                                                    <?php if ($_SERVER['REQUEST_URI'] == '/freechatlive/register') { ?>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                    <?php } ?>
                                                    <?php if (isset($param)) { ?>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                    <?php } ?>
                                                    <?php if ($_SERVER['REQUEST_URI'] == '/chatapp.freechat247live.com/step2') { ?>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                    <?php } ?>
                                                    <?php if ($_SERVER['REQUEST_URI'] == '/chatapp.freechat247live.com/step3') { ?>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                    <?php } ?>
                                                    <?php if ($_SERVER['REQUEST_URI'] == '/chatapp.freechat247live.com/step4') { ?>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5a.png')}}" alt=""></li>
                                                    <?php } ?>
                                                    <?php if ($_SERVER['REQUEST_URI'] == '/chatapp.freechat247live.com/step5') { ?>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                        <li ><img src="{{ url('/images/hourglass-5.png')}}" alt=""></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        @yield('content')

                        <!-- JavaScripts -->
                        <?php if ($_SERVER['REQUEST_URI'] != '/freechatlive/login' || !isset($_SERVER['REQUEST_URI'])) { ?>
                        </div>
                        <div class="col-12 align-self-center footer mt-auto">
                            <footer class="">
                                <p class="copy-right text-center">Ngagge © 2020  <a href="" class="text-blue"> Terms</a> <a href="" class="text-blue"> Privacy</a></p>
                            </footer>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>
       
    </body>
</html>
