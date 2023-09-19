<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ ucfirst($settings->company_name) }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name='description' content='{{ $frontThemeSettings->seo_description }}' />
    <meta name='keywords' content='{{ $frontThemeSettings->seo_keywords }}' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ $frontThemeSettings->favicon_url }}" type="image/x-icon" />
    <!-- Blade CSS -->
    @stack('styles')
    <!-- Template CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/css/main.css') }}">
    <!-- Bootstrap Icons CSS -->
    <link type="text/css" rel="stylesheet" media="all"
        href="{{ asset('front/vendor/Bootstrap/css/bootstrap-icons.css') }}">
    <!-- Icons8 CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/vendor/css/line-awesome.min.css') }}">
    <!-- Select2 CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/vendor/css/select2.min.css') }}">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ asset('front/vendor/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/css/owl.theme.default.min.css') }}">

    <link type="text/css" rel="stylesheet" href="{{ asset('front-assets/css/helper.css') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $frontThemeSettings->primary_color }};
            --dark-primary-color: {{ $frontThemeSettings->primary_color }};
        }

        {!! $frontThemeSettings->custom_css !!}
        /* Add css here... */

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
        .online
        {
            width: 15px;
            height: 15px;
            background-color: #01BF01;
            border-radius: 100%;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 99;
        }
    </style>

</head>

<body>

    <!-- Deal Modal -->
    <div id="mymodal">

    </div>
    @include('sections-new.header')

    @yield('content')

    @include('sections-new.footer')

    <!-- BANNER LOCATION MODAL START -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body text-center p-lg-5 p-md-5 p-3">
                    <h3 class="mb-3">@lang('front.pickCity')</h3>
                    <p class="f-14 text-muted">@lang('front.pickCityNote')</p>
                    @if (!empty($googleMapAPIKey))
                    <div class="searchbox margin-top-xxl mb-5" id="buttonlocation">
                        <button class="btn btn-nearme " id="currentLocation" type="button">@lang('front.currentLocation')</button>
                    </div>
                    @endif
                    <div class="location-places mt-2 mt-lg-2 mt-md-2">
                        @foreach ($locations as $location)
                            <a href="javascript:;" class="search-tags" data-id="{{ $location->id }}"
                                data-bs-dismiss="modal">{{ $location->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER LOCATION MODAL END -->


    <!-- JavaScript Bundle with Popper -->
    <script src="{{ asset('front/vendor/Bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Jquery -->
    <script src="{{ asset('front/vendor/js/jquery.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('front/vendor/js/select2.min.js') }}"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('front/vendor/js/owl.carousel.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('front/js/main.js') }}"></script>
    <!-- Helper JS -->
    <script src="{{ asset('front-assets/js/helper.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('front/js/sweetalert.min.js') }}"></script>

    <script>

        $(document).ready(function(){
            loadLocationModal();
        });

        function loadLocationModal() {
            // Show Location modal

            if (localStorage.getItem('location') == null) {
                $('#staticBackdrop').modal('show');
            } else {
                // set current location near searh box
                let locationId = localStorage.getItem('location');
                var url = '{{ route('front.location-name') }}?locId=' + locationId;
                $.get(url, function(response) {
                    $('.current-location').html(response.location_name);
                });
            }

        };

        loadData(1);

        function loadData(page) {
            let loc = localStorage.getItem('location');
            $.easyAjax({
                url: '{{ route('front.index') }}',
                type: 'GET',
                data: {
                    location: loc
                },
                container: '.section',
                blockUI: false,
                success: function(response) {
                    $('.change-category').each(function() {
                        $(this).html(response.themeTwoCategoryView);
                    });
                    $('#all_categories').html(response.view);

                    if (response.deal_count === 0) {
                        $('#deals_section').hide()
                    } else {
                        $('#all_deals').html(response.html);
                        $('#deals_section').show();
                    }
                }
            })
            if (loc != null) {

                let ad_deal = false;
                ad_deal = check_cookie_name('popup');

                $('body').on('click', function() {
                    $('#newDealModal').modal('hide');
                    document.cookie = "popup= deal_show";
                });
                function check_cookie_name(popup) {
                    var match = document.cookie.match(new RegExp('(^| )' + popup + '=([^;]+)'));
                    if (match) {
                        return true;
                    } else {
                        return false;
                    }
                }
                if (ad_deal == false) {
                    setTimeout(function() {
                        loadmodal(loc);
                    }, 2000);
                }
            }
        }
        // Location selection from modal
        $('body').on('click', '.search-tags', function() {
            let locationId = $(this).data('id');

            // set current location near searh box
            var url = '{{ route('front.location-name') }}?locId=' + locationId;
            $.get(url, function(response) {
                $('.current-location').html(response.location_name);
                localStorage.setItem('location', locationId);

                let currentUrl = $(location).attr("href");
                let cartUrl = "{{ route('front.index') }}/";

                if (currentUrl !== cartUrl) {
                    window.location.reload();

                } else {
                    loadData();

                }
            });

        });

        function loadmodal(locationId) {
            // console.log(locationId);
            var url = "{{ route('front.get-location') }}";
            $.easyAjax({
                url: url,
                type: 'GET',
                data: {
                    _token: $("meta[namgetLocatione='csrf-token']").attr('content'),
                    id: locationId
                },
                success: function(response) {
                    $('#mymodal').html(response.html);
                    $('#newDealModal').modal('show');
                }
            });
        }

        $('body').on('click', '.search-tags', function() {

            var url = '{{ route('front.clearProduct') }}';
            $.easyAjax({
                url: url,
                type: 'POST',
                data: {
                    _token: $("meta[name='csrf-token']").attr('content')
                },
            });
        });

        // get started
        $("#getStarted").on("click", function() {
            $("html").animate({
                scrollTop: 0
            }, 1000);
        });

        $(function() {
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true
            };
        });
    </script>
    @if (!empty($googleMapAPIKey))

    <script src="https://maps.googleapis.com/maps/api/js?key={{$googleMapAPIKey->google_map_api_key}}"></script>
    <script>

        $('body').on('click', '#currentLocation', function() {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude ;
                var lon = position.coords.longitude ;
                document.getElementById('buttonlocation').remove();
                displayLocation(lat,lon);

            },
            function(error) {
                if (error.code == error.PERMISSION_DENIED)
                document.getElementById('buttonlocation').remove();
                });
        });

        function displayLocation(latitude,longitude){
            var geocoder;
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(latitude, longitude);

            geocoder.geocode(
                {'latLng': latlng},
                function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            var add= results[0].formatted_address ;
                            var  value=add.split(",");

                            count=value.length;
                            country=value[count-1];
                            state=value[count-2];
                            city=value[count-3];
                            filterlocation(city , latitude , longitude);
                        }
                    }
                }
            );
        }

        function filterlocation(city , latitude , longitude){
            let locations_html = '';
            $.easyAjax({
                    url: '{{ route('front.match-locations') }}',
                    type: 'POST',
                    data: {
                     _token: '{{ csrf_token() }}',
                     city: city,
                     latitude: latitude,
                     longitude: longitude
                    },
                    success: function (response)
                    {
                        if (response.locations.length > 0) {
                            response.locations.forEach(location => {
                                    locations_html += `<a class="search-tags" data-id="${location.id}">${location.name}</a>`
                            });
                        }
                        $('.location-places').html(locations_html);
                        // $('#myModal').modal('show');
                    }
                });
        }
    </script>
    @endif


    @stack('footer-script')

</body>

</html>
