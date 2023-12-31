@extends('layouts-new.auth')

@section('content')
<style>
    .userDetailInput {
        width: 85%;
        float: left;
    }
    .userDetailSpan {
        width: 15%;
        height: 46px;
        padding: 0.375rem 0.75rem;
    }
</style>

<section class="login-wrap bg-secondary">
    <div class="container">
        <div class="row">
            <div class="l-w-box bg-white">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissable mb-5" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{ session('status') }}
                    </div>
                @endif
                <img src="{{ $frontThemeSettings->logo_url }}" alt="Appointo" class="mb-5 mx-auto d-block" />

                <h5 class="text-center">@lang('app.resetPassword')</h5>
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="form-group my-30 rounded">
                        <input type="email" name="email" id="email" class="userDetailInput form-control f-13 {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="@lang('app.email')" required>
                        <span class="input-group-text border-0 bg-secondary userDetailSpan" id="basic-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-envelope text-light" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
                            </svg>
                        </span>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback text-left pt-2" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="primary-btn btn-lg btn f-15 w-100">
                            @lang('app.sendPassResetLink')
                        </button>
                    </div>
                    <div class="mt-3 f-12">
                        <a href="{{ route('login') }}" class="text-dark">
                            <i class="las la-home f-18 mr-2"></i> @lang('app.signIn')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
