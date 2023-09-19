<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <title>{{ $pageTitle . ' | ' . $settings->company_name }}</title>
        <!-- SEO -->
        <meta name='description' content='{{ $frontThemeSettings->seo_description}}' />
        <meta name='keywords' content='{{$frontThemeSettings->seo_keywords}}' />

        <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon" />
        <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/css/main.css') }}">
        <!-- Bootstrap Icons CSS -->
        <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/vendor/Bootstrap/css/bootstrap-icons.css') }}">
        <!-- Icons8 CSS -->
        <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/vendor/css/line-awesome.min.css') }}">
        <!-- Select2 CSS -->

        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        
        <style>
            :root {
                --primary-color: {{ $frontThemeSettings->primary_color }};
                --dark-primary-color: {{ $frontThemeSettings->primary_color }};
            }

            {!! $frontThemeSettings->custom_css !!}
        </style>
    </head>
    <body class="login-body-wrapper">
        <div class="login-page">
            <div class="login-box">
                <div class="logo-login text-center">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    </body>
</html>
