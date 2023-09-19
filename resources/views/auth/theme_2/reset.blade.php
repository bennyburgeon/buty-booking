@extends('layouts-new.auth')

@section('content')

<section class="login-wrap bg-secondary">
    <div class="container">
        <div class="row">
            <div class="l-w-box bg-white">
                <img src="{{ $frontThemeSettings->logo_url }}" alt="Appointo" class="mb-5 mx-auto d-block" />
                <h5 class="text-center">@lang('app.resetPassword')</h5>
                <form action="{{ route('password.request') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group my-30 rounded">
                        <input type="email"  name="email" id="email" class="form-control f-13 {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="@lang('app.email')" required>
                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-envelope text-light" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
                            </svg>
                        </span>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <button type="submit" class="primary-btn btn-lg btn f-15 w-100 mt-30">
                            @lang('app.resetPassword')
                        </button>
                    </div>
                    <div class="mt-3 justify-content-between">
                        <a href="{{ route('front.index') }}" class="text-dark">
                            <i class="las la-home f-18 mr-2"></i> @lang('front.navigation.backToHome')
                        </a>
                        <a href="{{ route('front.login') }}" class="primary-btn btn-lg btn f-15 w-100 mt-30">
                            @lang('app.signIn')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
