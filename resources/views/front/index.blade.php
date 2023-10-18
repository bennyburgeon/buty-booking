@extends('layouts.front')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">

    <style>
        .no-services {
            border: 1px solid #f7d8dd;
            background-color: #fbeeed;
            color: #d9534f;
            padding: 20px 0;
        }

        .owl-item:hover {
            margin-top: -10px;
            transition: 1s;
            box-shadow: 0px 0px 30px 0px #dadada;
        }

        /* Pagination CSS */
        .pagination i {
            font-size: 20px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: normal;
            text-align: center;
            color: var(--primary-color);
        }

        .pagination .page-item .page-link {
            width: 26px;
            height: 26px;
            font-size: 13px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.92;
            letter-spacing: normal;
            text-align: center;
            color: var(--primary-color);
            border-radius: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: solid 1px #707070;
        }

        .pagination .page-item .page-link:focus {
            box-shadow: none;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        .pagination .page-item {
            margin: 0px 7.5px;
        }

        .services_pagpaginationination .page-item:nth-child(1) .page-link:hover,
        .deals_pagination .page-item:nth-child(7) .page-link:hover {
            background-color: transparent;
        }
        .modal-header{
        margin-top: -23px;
        margin-bottom: -41px;
        }
        .online{
            width: 30px;
            height: 30px;
            background-color: #01BF01;
            border-radius: 100%;
            position: absolute;
            top: 15px;
            left: 10px;
            z-index: 99;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        @if ($frontThemeSettings->carousel_status == 'enabled')
            <div class="banner-area">
                <div id="banner-slider" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                        @php $count = 0 @endphp
                        @forelse($images as $image)
                            <li data-target="#banner-slider" data-slide-to="{{ $count }}"
                                @if ($count == 0) class="active" @endif></li>
                            @php $count++ @endphp
                        @empty
                            <li data-target="#banner-slider" data-slide-to="0" class="active"></li>
                            <li data-target="#banner-slider" data-slide-to="1"></li>
                            <li data-target="#banner-slider" data-slide-to="2"></li>
                            <li data-target="#banner-slider" data-slide-to="3"></li>
                        @endforelse
                    </ul>
                    <div class="carousel-inner">
                        @php $count = 0 @endphp
                        @forelse($images as $image)
                            <div class="carousel-item {{ $count == 0 ? 'active' : '' }}">
                                <a href="javascript:void(0);">
                                    <img class="img-fluid" src="{{ $image->file_image_url }}" alt="carousel image">
                                </a>
                            </div>
                            @php $count++ @endphp
                        @empty
                            <div class="carousel-item active">
                                <a href="javascript:void(0);">
                                    <img src="assets/img/banner.jpg" alt="Los Angeles">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="javascript:void(0);">
                                    <img src="assets/img/banner.jpg" alt="Chicago">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="javascript:void(0);">
                                    <img src="assets/img/banner.jpg" alt="Los Angeles">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="javascript:void(0);">
                                    <img src="assets/img/banner.jpg" alt="Chicago">
                                </a>
                            </div>
                        @endforelse

                    </div>
                    <div class="banner-controls">
                        <a class="carousel-control-prev" href="#banner-slider" data-slide="prev">
                            <span class="fa fa-angle-left"></span>
                        </a>
                        <a class="carousel-control-next" href="#banner-slider" data-slide="next">
                            <span class="fa fa-angle-right"></span>
                        </a>
                    </div>
                </div>
            </div>
        @endif



        <!-- ADVERTISEMENT SECTION START -->
        @foreach ($advertisement as $advertisements)
            @if ($advertisements->position == 'after banner' && $advertisements->status == 'active')
                <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
            @endif
        @endforeach
        <!-- ADVERTISEMENT SECTION END -->

        <section class="sp-80 bg-w" id="deals_section">
            <div class="container" id="all_deals">

            </div>
        </section>

        <!-- ADVERTISEMENT SECTION START -->
        @foreach ($advertisement as $advertisements)
            @if ($advertisements->position == 'after deal' && $advertisements->status == 'active')
                <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
            @endif
        @endforeach
        <!-- ADVERTISEMENT SECTION END -->

        <section class="categories sp-80-50 bg-dull">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <p>@lang('front.categoriesTitle')</p>
                            <h3 class="sec-title">
                                @lang('front.categories')
                            </h3>
                        </div>
                    </div>
                </div>
                <div id="categories" class="row justify-content-center">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="0">
                        <div class="ctg-item" style="background: var(--primary-color)">
                            <input type="hidden" id="category" name="category" value="all">
                            <a href="javascript:;">
                                <div class="icon-box">
                                    <i class="flaticon-fork"></i>
                                </div>
                                <div class="content-box">
                                    <h5 class="mb-0">
                                        @lang('front.all')
                                    </h5>
                                </div>
                            </a>
                        </div>
                    </div>

                    @foreach ($categories as $category)

                        @if($category->services()->count() > 0)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="{{ $category->id }}">
                            <div class="ctg-item" style="background-image:url('{{ $category->category_image_url }}')">
                                <a href="javascript:;">
                                    <div class="icon-box">
                                        <i class="flaticon-fork"></i>
                                    </div>
                                    <div class="content-box">
                                        <h5 class="mb-0">
                                            {{ ucwords($category->name) }}
                                        </h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ADVERTISEMENT SECTION START -->
        @foreach ($advertisement as $advertisements)
            @if ($advertisements->position == 'after categories' && $advertisements->status == 'active')
                <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
            @endif
        @endforeach
        <!-- ADVERTISEMENT SECTION END -->

        <section class="listings sp-80 bg-w">
            <div class="container " id="all_services">
            </div>
        </section>

        <!-- ADVERTISEMENT SECTION START -->
        @foreach ($advertisement as $advertisements)
            @if ($advertisements->position == 'after services' && $advertisements->status == 'active')
                <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
            @endif
        @endforeach
        <!-- ADVERTISEMENT SECTION END -->


    </section>

@endsection

@push('footer-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                // loop:true,
                margin: 20,
                dots: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1024: {
                        items: 4
                    }
                }
            });

            const autopay = '{{$frontThemeSettings->carousel_autoplay}}';
            if(autopay == 'enabled'){
            $('#banner-slider').carousel({
                    interval: 3000,
                    cycle: true
            });
            }
            else{
                $('#banner-slider').carousel({  interval: false});
            }

        });


        $(function() {

            var locaion = '';
            var category = '0';

            // change services as per category selected
            $('body').on('click', '.categories-list', (function() {
                let id = $(this).data('category-id');
                category = id;

                if (localStorage.getItem('location')) {
                    locaion = localStorage.getItem('location');
                }

                var url = '{{ route('front.index') }}?location=' + locaion + '&category=' + category;
                $.get(url, function(response) {
                    $('#all_services').html(response.view);
                    $('#all_deals').html(response.html);

                    if (response.deal_count === 0) {
                        $('#deals_section').hide()
                    } else {
                        $('#all_deals').html(response.html);
                        $('#deals_section').show();
                    }
                });

                $('html, body').animate({
                    scrollTop: $(".listings").offset().top
                }, 1000);

            }));

            // change services as per service type (online/offline)
            $('body').on('click', '.service-filter', (function() {
                let category = '';
                let serviceFilter = $(this).data('service-type');

                $('.service-filter').removeClass('active');

                if (serviceFilter == 'online') {
                    $('#service-filter-online').addClass('active');
                } else if (serviceFilter == 'offline') {
                    $('#service-filter-offline').addClass('active');
                } else {
                    $('#service-filter-all').addClass('active');
                }

                if(localStorage.getItem('location')) {
                    locaion = localStorage.getItem('location');
                }

                var url = '{{ route('front.index') }}?serviceFilter='+serviceFilter+'&location='+locaion+'&category='+category;
                $.get(url, function(response){
                    $('#all_services').html(response.view);
                    $('#all_deals').html(response.html);

                    if(response.deal_count === 0)
                    {
                        $('#deals_section').hide()
                    } else{
                        $('#all_deals').html(response.html); $('#deals_section').show();
                    }

                });
            }));

            // Apply pagination for services
            $('body').on('click', '#pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                if (localStorage.getItem('location')) {
                    locaion = localStorage.getItem('location');
                }

                var url = '{{ route('front.index') }}?page=' + page + '&location=' + locaion +
                    '&category=' + category;
                $.get(url, function(response) {

                    $('#all_services').html(response.view);
                    $('#all_deals').html(response.html);

                    if (response.deal_count === 0) {
                        $('#deals_section').hide()
                    } else {
                        $('#all_deals').html(response.html);
                        $('#deals_section').show();
                    }

                });
            });

            function loadData(page) {

                if (localStorage.getItem('location')) {
                    locaion = localStorage.getItem('location');
                }

                var url = '{{ route('front.index') }}?page='+page+'&location='+locaion+'&category='+category;
                $.get(url, function(response){

                    $('#all_services').html(response.view);
                    $('.change-category').html(response.themeOneCategoryView);

                    $('#all_deals').html(response.html);

                    if (response.deal_count === 0) {
                        $('#deals_section').hide()
                    } else {
                        $('#all_deals').html(response.html);
                        $('#deals_section').show();
                    }

                });
            }

            // Apply pagination for services
            $('body').on('click', '#pagination a', function(e) {

                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                loadData(page)
            });

            loadData(1)

        })
    </script>
@endpush
