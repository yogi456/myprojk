@extends('layouts.app')

@section('content')

       <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Register</h4>
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
             Register
            </div>
          </div>
           <div class="col-md-2"></div>
          <div class="col-md-8">
             
             <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Phone</label>
                                        <input type="number" name="phone" id="phone" class="form-control fs-16" required>

                                           @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                        
                                    </div>

                                     <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Gender</label>
                                        <select class="form-control" name="gender" id="gender" required="required"> 
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                      </select>
                                         
                                           @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                                    </div>


                                      <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Date Of Birth</label>
                                         <input name="dob"  type="text" class="form-control" id="dob" placeholder="YYYY-MM-DD" required="">
                                           @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                                    </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
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
