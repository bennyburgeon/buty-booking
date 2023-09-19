<!-- HEADER START -->
<style>
    .cart-badge {
    font-size: 14px;
    font-weight: 900;
    position: absolute;
    /* border: solid red; */
    border-radius: 60%;
    height: 14px;
    width: 8px;
    background:red;
    }

    .search-term {
        border: none;
        box-shadow: none;
        background-color: #f9f9fe;
        color: #1e1e1e;
        position: relative;
        padding: 0px 18px 0px;
        height: 46px;
    }
</style>

<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12 px-0">
                <nav class="navbar navbar-expand-lg py-lg-3 py-md-3 py-2 px-0">
                    <div class="container-fluid p-0">
                        <a class="navbar-brand position-relative" href="{{ route('front.index') }}"><img src="{{ $frontThemeSettings->logo_url }}"
                                alt="logo" /></a>

                        @if ($name == 'front.index')
                            <div class="collapse navbar-collapse justify-content-between" id="navbarTogglerDemo02">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mbl-menu menu-item ">
                                    <li class="nav-item d-block d-lg-none p-3 p-lg-0">
                                        <a class="navbar-brand position-relative" href="{{ route('front.index') }}"><img src="{{ $frontThemeSettings->logo_url }}" alt="logo" /></a>
                                    </li>
                                    <div class='change-category' style="display:inherit">
                                        @foreach ($categories as $category)
                                            @if($category->services()->count() > 0)
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="{{url($category->slug.'/services')}}">{{ ucWords($category->name) }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </div>
                                </ul>
                            </div>
                        @else
                            <div class=" collapse navbar-collapse justify-content-between" id="navbarTogglerDemo02">
                                <div class="d-none d-lg-flex d-md-none header-search-location rounded-pill grey-border ml-3 align-items-center w-75">
                                    <!-- LOCATION START -->
                                    <div class="b-b-location position-relative w-25 p-2">
                                        <a data-bs-toggle="modal" href="#staticBackdrop" class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                class="bi bi-geo-alt mr-2 text-red" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                            </svg>
                                            <span class="f-12 text-light current-location">Jaipur, India</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor"
                                                class="bi bi-chevron-down ms-auto text-light" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                            </svg>
                                        </a>
                                    </div>
                                    <!-- LOCATION END -->

                                    <!-- CATEGORY START -->
                                    <div class="b-b-location position-relative w-25 grey-border-left p-2">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle w-100 f-12 text-light" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                @lang('front.select') @lang('front.category')
                                            </a>
                                            <ul class="dropdown-menu grey-border change-category" aria-labelledby="dropdownMenuButton1">
                                                @foreach ($categories as $category)
                                                    @if($category->services()->count() > 0)
                                                        <li>
                                                            <a class="dropdown-item f-12" href="{{url($category->slug.'/services')}}>{{ ucWords($category->name) }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- CATEGORY END -->

                                    <!-- SEARCH START -->
                                    <div class="b-b-search d-flex align-items-center justify-content-between w-50 p-2 grey-border-left">
                                        <form id="searchForm" class="w-100" action="{{ route('front.searchServices') }}" method="GET">
                                            <div class="input-group border-0">
                                                <input type="text" name="search_term" id="search_term" class="form-control bg-white text-light f-12 pr-0 search-term"
                                                    placeholder="@lang('front.frontSearch')..." aria-label="Recipient's username"
                                                    aria-describedby="basic-addon2">
                                                <button type="submit" class="input-group-text bg-white pr-0 border-0 pl-5" id="basic-addon2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                                        class="bi bi-search text-primary" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- SEARCH END -->
                                </div>
                                <div class="d-block d-lg-none">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mbl-menu">
                                        <li class="nav-item d-block d-lg-none p-3 p-lg-0">
                                            <a class="navbar-brand position-relative" href="{{ route('front.index') }}"><img src="{{ $frontThemeSettings->logo_url }}"
                                                alt="Appointo" /></a>
                                        </li>
                                        <div class='change-category' style="display:inherit">
                                            @foreach ($categories as $category)
                                                @if($category->services()->count() > 0)
                                                    <li class="nav-item p-3 p-lg-0">
                                                        <a class="nav-link active" aria-current="page" href="{{url($category->slug.'/services')}}">{{ ucWords($category->name) }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="header-right-wrap d-flex">
                            <div class="d-flex header-right">
                                @if($user)
                                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <div class="dropdown pr-3 pr-xl-5 pr-lg-4 username add-items">
                                            <a class="btn btn-secondary dropdown-toggle p-0" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person mr-0 mr-lg-2"
                                                    viewBox="0 0 14 14">
                                                    <path
                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                </svg><span class="d-none d-lg-block">{{ $user->name }}</span>
                                            </a>

                                            <ul class="dropdown-menu mt-2" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item " href="{{ route('admin.dashboard') }}">@lang('front.myAccount')</a></li>
                                                <li><a class="dropdown-item" href="javascript:;" onclick="logoutUser(event)">@lang('app.logout')</a></li>
                                            </ul>
                                        </div>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="pr-3 pr-xl-5 pr-lg-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-person mr-0 mr-lg-2" viewBox="0 0 14 14">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                        </svg><span class="d-none d-lg-block">@lang('app.signIn')</span>
                                    </a>
                                @endif

                                <a href="{{ route('front.cartPage') }}" class="position-relative pe-3 pe-lg-0">
                                {{-- <a href="/{{$category->slug}}/services" class="position-relative pr-3 pr-lg-0"> --}}
                                    <span class="cart-badge">{{ $productsCount }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-bag mr-0 mr-lg-2" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                    </svg>
                                    <span class="d-none d-lg-block">@lang('front.cart')</span>
                                </a>
                            </div>
                            <div id="nav-icon2" class="navbar-toggler" data-bs-toggle="collapse"
                                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- HEADER END -->

<!-- MOBILE LOCATION SEARCH START -->
@if ($name !== 'front.index')
    <section class="d-block d-lg-none d-md-none">
        <div class="position-relative">
            <div class="banner-box d-flex align-items-center">
                <!-- LOCATION START -->
                <div class="b-b-location position-relative">
                    <a data-bs-toggle="modal" href="#staticBackdrop" class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-geo-alt mr-2 text-red" viewBox="0 0 16 16">
                            <path
                                d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        </svg>
                        <span class="f-14 text-light current-location">Jaipur, India</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor"
                            class="bi bi-chevron-down ms-auto text-light" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </a>
                </div>
                <!-- LOCATION END -->

                <!-- SEARCH START -->
                <div class="b-b-search d-flex align-items-center justify-content-between w-100 ml-3">
                    <form id="searchForm" class="w-100" action="{{ route('front.searchServices') }}" method="GET">
                        <div class="input-group border-0">
                            <input type="text" name="search_term" id="search_term" class="form-control bg-white text-light f-14 pr-0"
                                placeholder="@lang('front.frontSearch')..." aria-label="Recipient's username"
                                aria-describedby="basic-addon2">

                            <button type="submit" class="input-group-text bg-white pr-0 border-0" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-search text-primary" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- SEARCH END -->
            </div>
        </div>
    </section>
@endif
<!-- MOBILE LOCATION SEARCH END -->

@push('footer-script')

    <script>

        $('#searchForm').on('submit', function (e) {

            var searchTerm = $('#search_term').val();

            $("<input />").attr("type", "hidden")
                .attr("name", "location")
                .attr("value", localStorage.getItem('location'))
                .appendTo("#searchForm");
        });

        function logoutUser(e) {
            e.preventDefault();
            $('#logoutForm').submit();
        }
    </script>

@endpush
