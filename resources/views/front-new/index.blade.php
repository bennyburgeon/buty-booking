@extends('layouts-new.front')

@push('styles')
    <style>
        .feedback-text {
            height: 127px;
        }
    .modal-header{
        margin-top: -23px;
    margin-bottom: -41px;
    }
        .online
        {
            width: 15px;
            height: 15px;
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

    <!-- BANNER SLIDER START -->
    <section>
        <div class="position-relative">
            <div class="owl-carousel owl-theme d-none d-xl-block d-lg-block d-md-block" id="banner-slider">
                @forelse($images as $image)
                    <div class="item">
                        <div class="banner-slider-item">
                            <img src="{{ $image->file_image_url }}" class="d-block w-100" alt="Appointo">
                        </div>
                    </div>
                @empty
                    <div class="item">
                        <div class="banner-slider-item">
                            <img src="assets/img/banner.jpg" class="d-block w-100" alt="Appointo">
                        </div>
                    </div>
                    <div class="item">
                        <div class="banner-slider-item">
                            <img src="assets/img/banner.jpg" class="d-block w-100" alt="Appointo">
                        </div>
                    </div>
                @endforelse
            </div>

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
                    <form id="searchForm" class="w-100" action="{{ route('front.searchServices') }}"
                        method="GET">
                        <div class="input-group border-0">
                            <input type="text" name="search_term" class="form-control bg-white text-light f-14 pr-0"
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
    <!-- BANNER SLIDER END -->

    <!-- ADVERTISEMENT SECTION START -->
    @foreach ($advertisement as $advertisements)
        @if ($advertisements->position == 'after banner' && $advertisements->status == 'active')
            <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
        @endif
    @endforeach
    <!-- ADVERTISEMENT SECTION END -->

    <!-- DEALS START -->
    @if ($deals->count() !== 0)
        <section class="py-50" id="deals_section">
            <div class="container" id="all_deals">

                <div class="w-100">
                    <div class="heading text-center">
                        <h3 class="font-weight-bold">@lang('app.ourDeals')</h3>
                        <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">@lang('front.bestDeals')</p>
                    </div>
                </div>

                <div class="row pt-50">
                    @foreach ($deals as $deal)
                        <div class="col-lg-4 col-md-6 mb-24 categories-list" data-category-id="{{ $deal->id }}">
                            <div class="deal-wrap rounded">
                                <div class="deal-img">
                                    <img width="150" height="50" src="{{ $deal->deal_image_url }}" />
                                </div>
                                <div class="p-4">
                                    <h6 class="f-w-600 mb-2">{{ ucwords($deal->title) }}</h6>

                                    <div class="d-flex justify-content-between">
                                        <p class="text-light line-height-1"><i
                                                class="las la-map-marker mr-2"></i>{{ $deal->location->name }}</p>

                                        <p class="line-height-1">
                                            @if ($deal->original_amount != $deal->deal_amount)
                                                <span
                                                    class="text-decoration-line-through text-red mr-2"></i>{{ currencyFormatter($deal->original_amount) }}</span>
                                            @endif{{ currencyFormatter($deal->deal_amount) }}
                                        </p>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">

                                        <a href="{{ $deal->deal_detail_url }}"
                                            class="outline-btn btn-md h-30 btn f-14 d-flex align-items-center justify-content-center">
                                            <i class="las la-eye f-18 me-1"></i>
                                            @lang('app.view') @lang('app.detail')
                                        </a>

                                        <a href="javascript:;" id="deal{{ $deal->id }}"
                                            data-total_tax_percent="{{ $deal->total_tax_percent }}" data-type="deal"
                                            data-unique-id="deal{{ $deal->id }}" data-id="{{ $deal->id }}"
                                            data-price="{{ $deal->deal_amount }}"
                                            data-name="{{ ucwords($deal->title) }}"
                                            data-max-order="{{ $deal->max_order_per_customer }}"
                                            class="primary-btn btn-md btn f-13 h-30 d-flex align-items-center justify-content-center add-to-cart">
                                            <i class="las la-shopping-cart f-18 me-1"></i>
                                            @lang("front.navigation.addToCart")
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                @if ($deals->count() === 6)
                    <div class="row">
                        <div class="col-md-2 mx-auto mt-3">
                            <a href="{{ route('front.cartPage', 'deal') }}" class="secondary-btn btn-lg btn f-15 w-100">
                                @lang('app.loadMore')
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </section>
    @endif
    <!-- DEALS END -->

    <!-- ADVERTISEMENT SECTION START -->
    @foreach ($advertisement as $advertisements)
        @if ($advertisements->position == 'after deal' && $advertisements->status == 'active')
            <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
        @endif
    @endforeach
    <!-- ADVERTISEMENT SECTION END -->

    <!-- COMPANY DETAIL START -->
    @if ($section_contents->count() !== 0)
        @foreach ($section_contents as $section_content)
            <section class="bg-secondary py-50">
                <div class="container">
                    <div class="w-100">
                        <div class="heading text-center">
                            <h3 class="font-weight-bold">{{ $section_content->section_title }}</h3>
                            <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">{{ $section_content->title_note }}</p>
                        </div>
                    </div>
                    <div class="row pt-50">
                        <div
                            class="col-lg-6 col-md-12 f-14 text-grey d-flex align-items-center @if ($section_content->content_alignment == 'right') order-0 order-lg-1 @endif">
                            <div class="company-detail">
                                {!! $section_content->section_content !!}
                            </div>
                        </div>
                        <div
                            class="col-lg-6 col-md-12 mb-5 mb-lg-0 @if ($section_content->content_alignment == 'left') order-1 order-lg-0 @endif">
                            <div class="company-img">
                                <img src="{{ $section_content->image_url }}" alt="Appointo" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif
    <!-- COMPANY DETAIL END -->

    <!-- ADVERTISEMENT SECTION START -->
    @foreach ($advertisement as $advertisements)
        @if ($advertisements->position == 'after company detail' && $advertisements->status == 'active')
            <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
        @endif
    @endforeach
    <!-- ADVERTISEMENT SECTION END -->

    <!-- OUR CATEGORIES START -->
    @if ($categories->count() !== 0)
        <section class="bg-secondary py-50">
            <div class="container" id="all_categories">
                <div class="w-100">
                    <div class="heading text-center">
                        <h3 class="font-weight-bold">@lang('front.our') @lang('front.categories')</h3>
                        <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">@lang('front.categoriesTitle')</p>
                    </div>
                </div>
                <div class="row pt-100 justify-content-center">
                    <!-- START -->
                    @foreach ($categories as $category)
                        @if ($category->services()->count() > 0)
                            <div class="col-md-3 mb-24 categories-list" data-category-id="{{ $category->id }}">
                                <div class="categories position-relative">
                                    <a href="{{ url($category->slug.'/services') }}">
                                        <figure class="effect-layla w-100">
                                            <img src="{{ $category->category_image_url }}" alt="Appointo" />
                                            <figcaption>
                                                <p>{{ ucwords($category->name) }}</p>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <!-- END -->
                </div>
                @if ($categories->count() === 8)
                    <div class="row">
                        <div class="col-md-2 mx-auto mt-3">
                            <a href="{{ route('front.cartPage') }}"
                                class="secondary-btn btn-lg btn f-15 w-100 text-dark">
                                @lang('app.loadMore')
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    <!-- OUR CATEGORIES END -->

    <!-- ADVERTISEMENT SECTION START -->
    @foreach ($advertisement as $advertisements)
        @if ($advertisements->position == 'after categories' && $advertisements->status == 'active')
            <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
        @endif
    @endforeach
    <!-- ADVERTISEMENT SECTION END -->

    <!-- CUSTOMER FEEDBACK START -->
    @if ($customerFeedbacks->count() !== 0 && !is_null($customerFeedbacks))
        <section class="bg-white py-50">
            <div class="container">
                <div class="w-100">
                    <div class="heading text-center">
                        <h3 class="font-weight-bold">@lang('front.customerFeedback')</h3>
                        <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">@lang('front.customerFeedbackNote')</p>
                    </div>
                </div>
                <div class="row pt-50">
                    <div class="owl-carousel owl-theme" id="customer-feedback">
                        @foreach ($customerFeedbacks as $customerFeedback)
                            <div class="item">
                                <div class="customer-feedback-wrap rounded text-center mx-auto text-grey">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                        class="bi bi-chat-square-quote mb-5" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                        <path
                                            d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z" />
                                    </svg>
                                    <p class="f-13 mb-5 text-truncate text-wrap feedback-text">
                                        {{ $customerFeedback->feedback_message }}
                                    </p>
                                    <span class="mb-5"></span>
                                    <h6>{{ $customerFeedback->customer_name }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- CUSTOMER FEEDBACK END -->

    <!-- ADVERTISEMENT SECTION START -->
    @foreach ($advertisement as $advertisements)
        @if ($advertisements->position == 'after customer feedback' && $advertisements->status == 'active')
            <img style="width: 1293px; height: 200px" src="{{ $advertisements->advertisement_image_url }}" />
        @endif
    @endforeach
    <!-- ADVERTISEMENT SECTION END -->

    <!-- CTA START -->
    @if (!is_null($settings->get_started_note) && !is_null($settings->get_started_title))
        <section class="cta">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-9">
                        <h4 class="text-white mb-3">{{ $settings->get_started_title }}</h4>
                        <p class="text-white f-14 mb-4 mb-lg-0 mb-md-0">{{ $settings->get_started_note }}</p>
                    </div>
                    <div class="col-lg-2 col-md-3 d-flex align-items-center">
                        <button type="submit" id="getStarted" class="secondary-btn btn-lg btn f-15 w-100">
                            @lang('app.getStarted')
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- CTA END -->

@endsection

@push('footer-script')
    <script>

$(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                // loop:true,
                margin:20,
                dots:true,
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

                $('.owl-carousel').trigger('play.owl.autoplay',[3000])
            }

        });
        // send location id with search terms
        $('#searchForm').on('submit', function(e) {
            var searchTerm = $('#search_term').val();

            $("<input />").attr("type", "hidden")
                .attr("name", "location")
                .attr("value", localStorage.getItem('location'))
                .appendTo("#searchForm");
        });

        // Add items to cart
        $('body').on('click', '.add-to-cart', function() {
            let type = $(this).data('type');
            let unique_id = $(this).data('unique-id');
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            let service_type = $(this).data('service-type');
            let token = $("meta[name='csrf-token']").attr('content');

            if (type == 'deal') {
                var max_order = $(this).data('max-order');
            }

            var data = {id, type, price, unique_id, name, max_order, service_type, _token: token};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                blockUI: false,
                disableButton: true,
                defaultTimeout: '1000',
                success: function(response) {
                    if (response.result == 'fail' || response.result == 'typeerror') {
                        swal({
                                title: "@lang('front.buttons.clearCart')?",
                                text: response.message,
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    var url = '{{ route('front.deleteProduct', ':id') }}';
                                    url = url.replace(':id', 'all');

                                    $.easyAjax({
                                        url: url,
                                        type: 'POST',
                                        data: {
                                            _token: $("meta[name='csrf-token']").attr(
                                                'content')
                                        },
                                        redirect: false,
                                        blockUI: false,
                                        disableButton: true,
                                        success: function(response) {
                                            if (response.status == 'success') {
                                                $.easyAjax({
                                                    url: '{{ route('front.addOrUpdateProduct') }}',
                                                    type: 'POST',
                                                    data: data,
                                                    blockUI: false,
                                                    success: function(
                                                    response) {
                                                        $('.cart-badge')
                                                            .text(response
                                                                .productsCount
                                                                );
                                                    }
                                                })
                                            }
                                        }
                                    })
                                }
                            });
                    }
                    $('.cart-badge').text(response.productsCount);
                }
            })
        });
    </script>
@endpush
