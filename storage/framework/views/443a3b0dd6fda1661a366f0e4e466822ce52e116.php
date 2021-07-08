
<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" style="overflow:visible;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
        <title>Irefill</title>
        <link rel="stylesheet" href="<?php echo e(asset('css/fontawesome.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/templatemo-sixteen.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/owl.css')); ?>">
           <link href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
           <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    </head>
    <body>
         <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="<?php echo e(url('home')); ?>" style="background-color: white; padding: 5px; border-radius: 7px;">
            <img src="<?php echo e(asset('img/logo.png')); ?>" style="max-width: 100px;" alt="">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="<?php echo e(url('home')); ?>">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li> 
             <!--  <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('concept')); ?>">Concept</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('about')); ?>">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('contact')); ?>">Contact Us</a>
              </li>

          <?php if(Auth::check()): ?>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('contact')); ?>"><?php echo e(Auth::user()->name); ?></a>
              </li>
                 <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('my-orders')); ?>">My Orders</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('logout')); ?>">Logout</a>
              </li>

          <?php else: ?>
          <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('login')); ?>">Login</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(url('register')); ?>">Register</a>
              </li>


          <?php endif; ?>



            </ul>
          </div>
        </div>
      </nav>
    </header>


          <?php echo $__env->yieldContent('content'); ?>
  
    <footer>
      <div class="" style="padding: 0;">
        <!-- <div class="row"  style="padding: 0;"> -->
          <!-- <div class="col-md-12"  style="padding: 0;"> -->
            <div class="inner-content" style="padding: 12px 30px;
    background: black;
    color: white;">
    <div class="row" style="padding:0">
    <div class="col-md-6" style="text-align:left;">
              <p style="color: white;">irefill Private Ltd Copyright@2021 irefill. </p>

              <p style="color: white;">All rights reserved <a rel="nofollow noopener" href="<?php echo e(url('/terms-conditions')); ?>" target="_blank">Terms & Conditions</a>
              <a rel="nofollow noopener" href="<?php echo e(url('/privacy-policy')); ?>" target="_blank">Privacy Policy</a>
              </p>
            </div>

            <div class="col-md-6"  style="text-align:right;">
           <p style="color:white">Follow us on socia media:</p>

      <ul class="social-icons">
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                      <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>

            </div>
            </div>
          <!-- </div> -->
        <!--   </div> -->
        </div>
      </div>
    </footer>

     <input type="hidden" id="appBaseUrl" name="app_base_url" value="<?php echo e(url('')); ?>" />
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Additional Scripts -->
    <script src="<?php echo e(asset('/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/owl.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/slick.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/isotope.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/accordions.js')); ?>"></script>


    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>


  </body>

</html>

                
               