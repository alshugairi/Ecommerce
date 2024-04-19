@extends('auth.layouts.app')
@section('title','Sign In')
@section('content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>{{ __('share.site_name') }}</a>
            </div>
            <div class="card-body">
                <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('share.email') }}</label>
                        <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
                        @enderror
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">{{ __('share.password') }}</label>
                            <a href="auth-forgot-password-basic.html">
                                <small>{{ __('share.forgot_password') }}</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
                                   placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                   aria-describedby="password">
{{--                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>--}}
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me" />
                            <label class="form-check-label" for="remember-me"> {{ __('share.remember_me') }} </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">{{ __('share.login') }}</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
@endsection

