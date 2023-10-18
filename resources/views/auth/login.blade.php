@extends('layouts.auth')

<style>
    .invalid-feedback {
        display: block !important;
    }
    .social span {
        margin-top: 8px;
        margin-right: 22px;
        font-size: 14px;
    }
    .social a i {
        font-size: 13px;
    }
</style>

@section('content')
    <span class="logo-box">
        <img src="{{ $frontThemeSettings->logo_url }}" alt="logo">
    </span>
    <h4 class="mb-30">@lang('app.signInToAccount')</h4>
    <form action="{{ route('login') }}" method="post">
        @csrf
        @if ($googleCaptchaSettings->status == 'active')
            <input type="hidden" name="recaptcha" id="recaptcha">
        @endif
        <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>
            <label for="email">@lang('app.email')</label>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            <label for="password">@lang('app.password')</label>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="centering v-center">
            <span class="mb-4">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">@lang('app.rememberMe')</label>
            </span>
            <span class="mb-4">
                <a href="{{ route('password.request') }}" class="c-theme"> @lang('app.forgotPassword')</a>
            </span>
        </div>
        @if ($googleCaptchaSettings->v2_status == 'active' && $googleCaptchaSettings->status == 'active')
            <div class="centering v-center mb-3">
                <div id="captcha_container"></div>
            </div>
        @endif
        @if ($errors->has('recaptcha'))
            <span class="invalid-feedback text-left mb-3" role="alert">
                <strong>{{ $errors->first('recaptcha') }}</strong>
            </span>
        @endif
        <div class="d-flex justify-content-between flex-wrap">
            <button type="submit" class="btn btn-custom btn-blue px-4">@lang('app.signIn')</button>
            <a href="{{ route('front.index') }}" class="btn btn-light btn-sm">@lang('front.navigation.backToHome')</a>
        </div>
    </form>
    <!-- /.social-auth-links -->
    @if($socialAuthSettings->google_status == 'active' || $socialAuthSettings->facebook_status == 'active')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
            <div class="social mt-4 d-flex">
                <span>@lang('front.or') @lang('app.signIn') @lang('app.using') :</span>
                @if($socialAuthSettings->facebook_status == 'active')
                    <a href="{{ route('social.login', 'facebook') }}" class="btn btn-facebook btn-primary mr-1 px-3" data-bs-toggle="tooltip" title="{{__('app.signIn')}} {{__('app.using')}} {{__('app.facebook')}}" onclick="window.location.href = facebook;" data-original-title="{{__('app.signIn')}} {{__('app.using')}} {{__('app.facebook')}}">
                        <i aria-hidden="true" class="fa fa-facebook"></i>
                    </a>
                @endif
                @if($socialAuthSettings->google_status == 'active')
                    <a href="{{ route('social.login', 'google') }}" class="btn btn-google btn-danger ml-1" data-bs-toggle="tooltip" title="{{__('app.signIn')}} {{__('app.using')}} {{__('app.google')}}" onclick="window.location.href = google;" data-original-title="{{__('app.signIn')}} {{__('app.using')}} {{__('app.google')}}">
                        <i aria-hidden="true" class="fa fa-google"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
<!-- /.social-auth-links -->
@endsection


@if ($googleCaptchaSettings->v2_status == 'active' && $googleCaptchaSettings->status == 'active')
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer></script>
    <script>
        var gcv3;
        var onloadCallback = function() {
                // Renders the HTML element with id 'captcha_container' as a reCAPTCHA widget.
                // The id of the reCAPTCHA widget is assigned to 'gcv3'.
                gcv3 = grecaptcha.render('captcha_container', {
                'sitekey' : '{{$googleCaptchaSettings->v2_site_key}}',
                'theme' : 'light',
                'callback' : function(response) {
                    if(response) {

                        document.getElementById('recaptcha').value = response;
                    }
                },
            });
        };
    </script>
@endif

@if ($googleCaptchaSettings->v3_status == 'active' && $googleCaptchaSettings->status == 'active')
    <script src="https://www.google.com/recaptcha/api.js?render={{ $googleCaptchaSettings->v3_site_key }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ $googleCaptchaSettings->v3_site_key }}', {action: 'contact'}).then(function(token) {
                if (token) {
                    document.getElementById('recaptcha').value = token;
                }
            });
        });
    </script>
@endif
