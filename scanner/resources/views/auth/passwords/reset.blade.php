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
                            @if(!$link)
                            <span class="help-block">
                                <strong>Link Expired</strong>
                            </span>
                            @else
                            <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                                {{ csrf_field() }}                             


                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-4">
                                    <label for="email" class="fw-600 fs-16">E-Mail Address</label>
                                    <div class="col-12 px-0">
                                        <input id="email" type="email" class="form-control" readonly="readonly" name="email" value="{{ $email or old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                        <span class="fw-600 text-danger mt-2">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mb-4">
                                    <label for="password" class="fw-600 fs-16">Password</label>
                                    <div class="col-12 px-0">
                                        <input id="password" type="password" class="form-control" name="password" required>
                                        @if ($errors->has('password'))
                                        <span class="fw-600 text-danger mt-2">
                                            {{ $errors->first('password') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} mb-4">
                                    <label for="password-confirm" class="fw-600 fs-16">Confirm Password</label>
                                    <div class="col-12 px-0">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        @if ($errors->has('password_confirmation'))
                                        <span class="fw-600 text-danger mt-2">
                                            {{ $errors->first('password_confirmation') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group rest-btn">
                                    <button type="submit" class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3">
                                        Reset Password
                                    </button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
