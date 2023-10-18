<header class="header">
    <div class="head-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-12 my-lg-0 my-2">
                    <ul class="head-contact-left">
                        <li>
                            <i class="fa fa-phone"></i>
                            {{ $settings->company_phone }}
                        </li>

                    </ul>
                </div>
                <div class="col-lg-8 col-12 my-lg-0 my-2">
                    <ul class="head-contact-right">
                        <li class="location-search mb-3">
                            <span class="mr-1"> @lang('front.location')</span>
                            <div class="location-dropdown">
                                <div id="scrollable-dropdown-menu" class="input-wrap">
                                    <i class="fa fa-map-marker"></i>
                                    <select id="location" class="select2" name="location">
                                        @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="language-drop mb-3">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle text-capitalize" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i> @lang('front.language')
                                </a>
                                <div class="dropdown-menu">
                                    @forelse ($languages as $language)
                                    <a class="dropdown-item" data-lang-code="{{ $language->language_code }}"
                                        href="javascript:;">{{ $language->language_name }}</a>
                                    @empty
                                    <a class="dropdown-item active" href="javascript:;" data-lang-code="en">English</a>
                                    @endforelse
                                </div>
                            </div>
                        </li>

                        <li class="mb-3">
                            @if($user)
                            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <div class="dropdown add-items">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">{{ $user->name }}<span class="fa fa-caret-down"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fa fa-user"></i> @lang('front.myAccount')</a>
                                        <a class="dropdown-item" href="javascript:;" onclick="logoutUser(event)">
                                            <i class="fa fa-sign-out mr-2"> </i>@lang('app.logout')</a>
                                    </div>
                                </div>
                            </form>
                            @else
                            <a href="{{ route('login') }}">
                                <i class="fa fa-user mr-2"> </i>@lang('app.signIn')
                            </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="topbar">
        <div class="container">
            <div class="row h-center">
                <div class="col-lg-5 col-md-3 col-12">
                    <div class="logo">
                        <a href="{{ route('front.index') }}">
                            <img src="{{ $frontThemeSettings->logo_url }}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-9 col-12">
                    <ul class="d-flex h-center justify-content-md-end py-3 ml-md-5 ml-0">
                        <li class="search-form">
                            <form id="searchForm" action="{{ route('front.searchServices') }}" method="GET">
                                <span class="input-wrap">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="form-control" name="search_term" id="search_term"
                                        placeholder="@lang('front.searchHere')" autocomplete="none">
                                </span>
                                <button type="submit" class="submit btn btn-custom br-0 btn-dark w-100">
                                    @lang('front.search')</button>
                            </form>
                        </li>
                        <li title="@lang('front.cart')" class="top-cart">
                            <a href="{{ route('front.cartPage') }}">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="cart-badge">{{ $productsCount }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Deal Modal -->
<div id="mymodal">

</div>

@push('footer-script')
<script>
        $(document).ready(function(){
            loadLocationModal();
        });

        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        function loadLocationModal()
        {
            $('.select2').select2();

            if (localStorage.getItem('location') == null)
            {
                let locations_html = '';
                $.easyAjax({
                    url: '{{ route('front.get-all-locations') }}',
                    type: 'GET',
                    success: function (response)
                    {
                        if (response.locations.length > 0) {
                            response.locations.forEach(location => {
                                    locations_html += `<a class="search-tags" data-location-id="${location.id}">${location.name}</a>`
                            });
                        }
                        $('.locationPlaces').html(locations_html);
                        $('#myModal').modal('show');
                    }
                });
            }

            $('body').on('click', '.search-tags', function () {

                let locationId = $(this).data('location-id');

                $('#location.select2').val(locationId);
                localStorage.setItem('location', locationId);

                newDealModal(locationId);
                location.reload();
            });

            function newDealModal(locationId) {

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

        if ((loc =localStorage.getItem('location'))) {

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
                        newDealModal(loc);
                    }, 2000);
                }
            }

            if (localStorage.getItem('location')) {
                $('#location').val(localStorage.getItem('location')).trigger('change');
            }

            $('#location.select2').on('change', function()
            {
                localStorage.setItem('location', $(this).val());

                if (localStorage.getItem('location') !== '' && location.protocol+'//'+location.hostname+location.pathname == '{{ route('front.searchServices') }}') {
                    $('#searchForm').submit();
                }

                var url = '{{ route('front.clearProduct') }}';
                $.easyAjax({
                    url: url,
                    type: 'POST',
                    data: {_token: $("meta[name='csrf-token']").attr('content')},
                });

                if (localStorage.getItem('location') !== '' && location.href == '{{ route('front.index').'/' }}')
                {
                    loadReleventData(1);
                }
            });

            let searchParams = new URLSearchParams(window.location.search);
            if (searchParams.has('search_term')) {
                $('#search_term').val(searchParams.get('search_term'));
            }

            setActiveClassToLanguage();
        };

        function loadReleventData(page) {

            if(localStorage.getItem('location')) {
                locaion = localStorage.getItem('location');
            }

            var category = '0';
            var url = '{{ route('front.index') }}?page='+page+'&location='+locaion+'&category='+category;

            $.get(url, function(response){
                $('.change-category').html(response.themeOneCategoryView);

                $('#all_services').html(response.view);

                if(response.deal_count === 0)
                {
                    $('#deals_section').hide()
                } else{
                    $('#all_deals').html(response.html); $('#deals_section').show();
                }

                $('html, body').animate({
                    scrollTop: $(".categories").offset().top
                }, 1000);

            });
        }

        function logoutUser(e) {
            e.preventDefault();
            $('#logoutForm').submit();
        }

        function setActiveClassToLanguage() {
            // language switcher
            if ('{{ \Cookie::has('appointo_language_code') }}') {
                $('.language-drop .dropdown-item').filter(function () {
                    return $(this).data('lang-code') === '{{ \Cookie::get('appointo_language_code') }}'
                }).addClass('active');
            }
            else {
                $('.language-drop .dropdown-item').filter(function () {
                    return $(this).data('lang-code') === '{{ $settings->locale }}'
                }).addClass('active');
            }
        }

        $('#searchForm').on('submit', function (e) {
            var searchTerm = $('#search_term').val();

            if (searchTerm.length == 0) {
                return false;
            }

            $("<input />").attr("type", "hidden")
                .attr("name", "location")
                .attr("value", localStorage.getItem('location'))
                .appendTo("#searchForm");
        });

        $('.language-drop .dropdown-item').click(function () {
            let code = $(this).data('lang-code');

            let url = '{{ route('front.changeLanguage', ':code') }}';
            url = url.replace(':code', code);

            if (!$(this).hasClass('active')) {
                $.easyAjax({
                    url: url,
                    type: 'POST',
                    container: 'body',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                            setActiveClassToLanguage();
                        }
                    }
                })
            }
        });

        // add items to cart
        $('body').on('click', '.add-to-cart, .update-cart, .grab-deal', function ()
        {


            // alert($("input[name=qty]").val()); return false;


            let type = $(this).data('type');
            let unique_id = $(this).data('unique-id');
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            let service_type = $(this).data('service-type');
            let token = $("meta[name='csrf-token']").attr('content');
            let quantity = $("input[name=qty]").val() ? $("input[name=qty]").val() : null;

            if(type == 'deal')
            {
                var max_order = $(this).data('max-order');
            }

            var data = {id, type, price, name, unique_id, max_order, service_type, quantity, _token: $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                blockUI: false,
                disableButton: true,
                defaultTimeout: '1000',
                success: function (response) {
                    if(response.result=='fail' || response.result=='typeerror')
                    {
                        swal({
                            title: "@lang('front.buttons.clearCart')?",
                            text: response.message,
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete)
                            {
                                var url = '{{ route('front.deleteProduct', ':id') }}';
                                url = url.replace(':id', 'all');

                                $.easyAjax({
                                    url: url,
                                    type: 'POST',
                                    data: {_token: $("meta[name='csrf-token']").attr('content')},
                                    redirect: false,
                                    blockUI: false,
                                    disableButton: true,
                                    success: function (response) {
                                        if (response.status == 'success') {
                                            $.easyAjax({
                                                url: '{{ route('front.addOrUpdateProduct') }}',
                                                type: 'POST',
                                                data: data,
                                                blockUI: false,
                                                success: function (response) {
                                                    $('.cart-badge').text(response.productsCount);
                                                }
                                            })
                                        }
                                    }
                                })
                            }
                        });
                    }
                    $('.cart-badge').text(response.productsCount);

                    if (response.productsCount > 0) {
                        $('.add').toggleClass('hide');
                        $('.update').toggleClass('hide');
                    }
                }
            })
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
                loadLocationModal();
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
                                    locations_html += `<a class="search-tags" data-location-id="${location.id}">${location.name}</a>`
                            });
                        }
                        $('.locationPlaces').html(locations_html);
                        $('#myModal').modal('show');
                    }
                });
        }
</script>
@endif

@endpush
