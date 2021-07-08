@extends('layouts.auth-app')

@section('content')
<div class="row flex-column login-main-wrapper">
    <header class="pt-3">
        <div class="container-fluid py-4 mw-1400">
            <div class="row align-items-center mx-0">
                <div class="col-auto rig-logo">
                    <a href="/"><img src="{{ asset('/images/ngagge-logo.png') }}" alt=""></a>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid mw-1400 mt-5 center-box-wrap">
        <div class="row">
            <div class="col mw-450 mx-auto">
                <h2 class="fs-48 fw-600 mb-4 pb-2 mt-5 text-center">Reset Password</h2>
                <div class="reset-inner-wrp">
                    <div class="reset-content-section pt-0">
                        <div class="panel-body">
                            @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            @endif

                            <form id="forResetPassword" class="form-horizontal form-app-default" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-4">
                                    <label for="" class="fw-600 fs-16">Email address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                    <span class="fw-600 text-danger mt-2">{{ $errors->first('email') }}</span>
                                    @endif                         
                                </div>
                                <div class="form-group rest-btn">                         
                                    <button type="submit" class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3">
                                        Send reset instructions
                                    </button>                           
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
