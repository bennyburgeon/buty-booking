@extends('layouts-new.auth')

<style>
    .invalid-feedback {
        display: block !important;
    }
    .btn-primary {
        color: #fff;
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }

    .btn-danger {
        color: #fff;
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
</style>

@section('content')

    <section class="login-wrap bg-secondary">
        <div class="container">
            <div class="row">
                <div class="l-w-box bg-white">
                    <img src="{{ $frontThemeSettings->logo_url }}" alt="Appointo" class="mb-5 mx-auto d-block" />
                    <h5 class="text-center">@lang('app.signInYourAccount')</h5>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        @if ($googleCaptchaSettings->status == 'active')
                            <input type="hidden" name="recaptcha" id="recaptcha">
                        @endif
                        <div class="input-group mt-30 rounded">
                            <input type="email"  name="email" id="email" class="form-control f-13 {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="@lang('app.email')" required>
                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-envelope text-light" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
                                </svg>
                            </span>
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback text-left" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <div class="input-group mb-2 rounded mt-30">
                            <input type="password" name="password" id="password" class="form-control f-13 {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="@lang('app.password')" required>
                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-lock text-light" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z" />
                                </svg>
                            </span>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <br>
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label f-12 mt-1 text-light cursor-pointer" for="remember">@lang('app.rememberMe')</label>
                            </div>
                            <div>
                                <a href="{{ route('password.request') }}" class="text-light f-12 text-capitalize ">@lang('app.forgotPassword')</a>
                            </div>
                        </div>
                        @if ($googleCaptchaSettings->v2_status == 'active' && $googleCaptchaSettings->status == 'active')
                            <div class="col-md-12 mt-3 ml-4">
                                <div id="captcha_container"></div>
                            </div>
                        @endif
                        @if ($errors->has('recaptcha'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('recaptcha') }}</strong>
                            </span>
                        @endif
                        <div>
                            <button type="submit" class="primary-btn btn-lg btn f-15 w-100 mt-30">
                                @lang('app.signIn')
                            </button>
                        </div>

                        <!-- /.social-auth-links -->
                        @if($socialAuthSettings->google_status == 'active' || $socialAuthSettings->facebook_status == 'active')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                                    <div class="social mb-16 mt-4 mb-3 d-flex justify-content-between align-items-center">
                                        @if($socialAuthSettings->facebook_status == 'active')
                                            <a href="{{ route('social.login', 'facebook') }}" class="btn btn-facebook btn-primary mr-1 px-3 d-flex justify-content-between align-items-center" style=" font-size: 14px; height: 46px;">
                                                @lang('app.signIn') @lang('with') @lang('app.facebook')</i>
                                            </a>
                                        @endif
                                        @if($socialAuthSettings->google_status == 'active')
                                            <a href="{{ route('social.login', 'google') }}" class="btn btn-google btn-danger ml-1 px-3 d-flex justify-content-between align-items-center" style=" font-size: 14px; height: 46px;">
                                               @lang('app.signIn') @lang('with') @lang('app.google')
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- /.social-auth-links -->
                    </form>
                </div>
            </div>
        </div>
    </section>

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
