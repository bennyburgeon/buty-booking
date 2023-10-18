<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='description' content='{{ $frontThemeSettings->seo_description}}' />
    <meta name='keywords' content='{{$frontThemeSettings->seo_keywords}}' />

    <title>{{ ucfirst($settings->company_name)}}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{$frontThemeSettings->favicon_url}}" type="image/x-icon" />
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/front-styles.css') }}">
    @stack('styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('front-assets/css/helper.css') }}">

    <style>
        :root {
            --primary-color: {{ $frontThemeSettings->primary_color }};
            --dark-primary-color: {{ $frontThemeSettings->primary_color }};
        }

        {!! $frontThemeSettings->custom_css !!}

        .header_location_modal {
            padding: 0px !important;
        }
        .locationPlaces .search-tags {
            padding: 11px 18px;
            text-align: center;
            font-size: 13px;
            color: #666;
            border: 1px solid #E0E0E0;
            border-radius: 30px;
            font-weight: 600;
            line-height: 1;
            display: inline-block;
            margin-right: 12px;
            margin-bottom: 18px;
            -webkit-transition: .3s;
            transition: .3s;
            cursor: pointer;
        }

        .locationPlaces .search-tags:hover {
            background-color: #00C1CF;
            border: 1px solid #00C1CF;
            color: #fff !important;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .btn-nearme {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #f1f1f1;
            color: #666;
            margin: 3px;
            text-transform: capitalize;
            font-size: 13px;
            padding: 9px 20px 9px 36px;
        }

        .searchbox {
            position: relative;
            max-width: 700px;
        }

    </style>
</head>


<body>

    @include('sections.header')

    @yield('content')

    @include('sections.footer')

    {{--Ajax Modal--}}
    <div class="modal fade modal-lg in" id="application-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> @lang('app.cancel')</button>
                    <button type="button" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

    <!-- Location Modal Start -->
    <div class="header_location_modal modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 0px !important" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" style="max-width: 100%;margin: 0;">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <h4>@lang('front.pickCity')</h4>
                <small class="text-muted">@lang('front.pickCityNote')</small>
                @if (!empty($googleMapAPIKey))
                    <div class="searchbox margin-top-xxl mb-5" id="buttonlocation">
                        <button class="btn btn-nearme " id="currentLocation" type="button">@lang('front.currentLocation')</button>
                    </div>
                @endif
                <div class="locationPlaces mt-2">
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Location Modal End -->


    <script src="{{ asset('assets/js/front-scripts.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('front/js/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true
            };
        });

        function makeSingular(time, type) {
            singular = '';
            plural = '';

            if (time == 1) {
                switch (type) {
                    case 'minutes':
                        singular = "@lang('app.minute')";
                        break;
                    case 'hours':
                        singular = "@lang('app.hour')";
                        break;
                    case 'days':
                        singular = "@lang('app.day')";
                        break;
                    default:
                        break;
                }
                return singular;
            }
            else {
                switch (type) {
                    case 'minutes':
                        plural = "@lang('app.minutes')";
                        break;
                    case 'hours':
                        plural = "@lang('app.hours')";
                        break;
                    case 'days':
                        plural = "@lang('app.days')";
                        break;
                    default:
                        break;
                }
                return plural;
            }
        }

        function goToPage(method, pageUrl, data = null) {
            var options = {
                url: pageUrl,
                type: method,
                // container: 'section.section'
                success: function (response) {
                    if (response.status !== 'fail') {
                        window.location.href = pageUrl
                    }
                },
                error: function(response){
                    var msgs = "@lang('messages.front.errors.atleastOneProduct')";
                    $.showToastr(msgs, 'error');
                }

            };

            if (data) {
                options.data = data
            }

            $.easyAjax(options)
        }

        var LightenColor = function(color, percent) {
            var num = parseInt(color.replace('#',''),16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                B = (num >> 8 & 0x00FF) + amt,
                G = (num & 0x0000FF) + amt;

            return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (B<255?B<1?0:B:255)*0x100 + (G<255?G<1?0:G:255)).toString(16).slice(1);
        };

        var DarkenColor = function(color, percent) {
            var num = parseInt(color.replace('#',''),16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) - amt,
                B = (num >> 8 & 0x00FF) - amt,
                G = (num & 0x0000FF) - amt;

            return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (B<255?B<1?0:B:255)*0x100 + (G<255?G<1?0:G:255)).toString(16).slice(1);
        };

        var primaryColor = getComputedStyle(document.documentElement)
            .getPropertyValue('--primary-color');

        document.documentElement.style.setProperty('--dark-primary-color', '#'+DarkenColor(primaryColor, 15));

    </script>

    @stack('footer-script')

</body>
</html>
