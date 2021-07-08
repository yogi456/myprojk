@extends('layouts.app')

@section('content')

       <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Login/Register</h4>
              <h2></h2>
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="send-message">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
             Login
            </div>
          </div>
           <div class="col-md-2"></div>
          <div class="col-md-8">
             <form id="formAppLogin" class="form-horizontal fs-16 mw-450 mx-auto"  role="form" method="POST" action="{{ url('/login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="" class="fw-600 fs-16">Email</label>
                                        <span><?php //print_r($errors);                                                                    ?></span>
                                        <input type="email" name="email" id="email" class="form-control fs-16" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="fw-600 fs-16">Password</label>
                                        <input type="password" name="password" id="password" class="form-control fs-16" required>
                                        
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
                                      <!--   <div class="col-auto px-0">
                                            <a class="btn-link text-black fs-16" href="{{ url('password/reset') }}"><u>Forgot Your Password?</u></a>
                                        </div> -->
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $massage = $errors->first('email');
                                        if ($massage == 'The email has already been taken.') {
                                            ?>
                                                                    <!--   <span class="text-danger text-center w-100">An account already exists with this email address</span> -->
                                        <?php } else { ?>
                                            <span class="text-danger text-center w-100">{{$errors->first('email')}}</span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Sign In  </button>
                                    </div>
                                    <div class="form-group text-center seperator">
                                        <span class="or-seperator fs-16">
                                            Or
                                        </span>
                                    </div>

                                   <div class="form-group">
                                        <a  class="btn btn-primary" href="{{url('register')}}">Register From Here  </a>
                                    </div>
                                </form>
          </div>
          <div class="col-md-2">
       
          </div>
        </div>
      </div>
    </div>


 
      <script>


     
    </script>

@endsection
