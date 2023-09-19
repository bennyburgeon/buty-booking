@extends('layouts-new.front')

@section('content')
    <!-- DEAL DETAIL START -->
    <section class="py-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="owl-carousel owl-theme" id="deal_detail_slider">
                        <div class="item">
                            <div class="deal-detail-img position-relative">
                                <img src="{{ $deal->deal_image_url }}" alt="{{ $deal->slug }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <h3 class="my-3 line-height-1">{{ $deal->title }}</h3>

                    <p class="text-light mb-4 f-15"><i class="las la-map-marker mr-2"></i>{{ $deal->location->name }}</p>

                    <hr/>

                    <div class="mt-4">

                        <p class="line-height-1 mr-3 f-20 f-w-600">
                            @if ($deal->original_amount > $deal->deal_amount)
                            <span class="text-decoration-line-through text-red mr-2 f-15"></i>{{ currencyFormatter($deal->original_amount) }}</span>
                            @endif
                            {{ currencyFormatter($deal->deal_amount) }}
                        </p>
                        <p class="line-height-1 mt-4">@lang('app.expireOn') :
                            {{ \Carbon\Carbon::parse($deal->end_date_time)->format('d-M-Y H:i A') }}
                        </p>
                    </div>

                    <div class="deal-input input-group rounded w-25 mr-3 mt-4">
                        <span class="input-group-btn h-30">
                            <button type="button" onclick="decreaseQuantity(this)" class="btn btn-default btn-number py-0 increment_qty" disabled="disabled" data-type="minus"
                                data-field="quant[1]">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash"
                                        viewBox="0 0 16 16">
                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                                    </svg>
                                </span>
                            </button>
                        </span>
                        <input type="text" size="4" name="qty" class="form-control text-center h-30 f-12 input-number qty" data-id="{{ $deal->id }}" data-max-order="{{ $deal->max_order_per_customer }}" autocomplete="none" @if(sizeof($reqProduct) == 0) value="1" @else value="{{$reqProduct['deal'.$deal->id]['quantity']}}" @endif min="1"
                            max="10" readonly />
                        <span class="input-group-btn">
                            <button type="button" onclick="increaseQuantity(this)" class="btn btn-default btn-number py-0 decrement_qty" data-type="plus" data-field="quant[1]">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </span>
                            </button>
                        </span>
                    </div>

                    <div class="d-flex w-100 mt-4">

                        <button type="button" class="add grab-deal me-3 mr-2 primary-btn btn-lg btn f-14 @if(sizeof($reqProduct) == 0) d-flex @else d-none @endif align-items-center justify-content-center h-30 py-3">
                            <i class="las la-shopping-cart f-18 me-1"></i> @lang('front.addItem')
                        </button>

                        <button type="button" class="update grab-deal me-3 mr-2 primary-btn btn-lg btn f-14 @if(sizeof($reqProduct) > 0) d-flex @else d-none @endif align-items-center justify-content-center h-30 py-3">
                            <i class="las la-shopping-cart f-18 me-1"></i> @lang('app.update') @lang('front.cart')
                        </button>

                        <button type="button" id="delete-product" class="update red-btn btn-lg btn f-13 @if(sizeof($reqProduct) > 0) d-flex @else d-none @endif align-items-center justify-content-center h-30 py-3">
                            <i class="las la-shopping-cart f-18 me-1"></i> @lang('app.remove') @lang('app.from') @lang('front.cart')
                        </button>
                    </div>

                </div>
                <div class="col-md-12 mt-3">
                    <p class="text-grey">{!! $deal->description !!}</p><br><br>
                </div>
            </div>
        </div>
    </section>
    <!-- DEAL DETAIL END -->

    <!-- CTA START -->
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
    <!-- CTA END -->
@endsection

@push('footer-script')
    <script>
        function increaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            if(currentValue<parseInt({{$deal->max_order_per_customer}})){
                input.val(parseInt(currentValue) + 1);
            }
            else if('{{$deal->max_order_per_customer}}'=='Infinite'){
                input.val(parseInt(currentValue) + 1);
            }
            else{
                return false;
            }
        }

        function decreaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();
            if (currentValue > 1) {
                input.val(parseInt(currentValue) - 1);
            }
        }

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        });

        // add items to cart
        $('body').on('click', '.grab-deal', function () {
            let max_order = "{{ $deal->max_order_per_customer }}";
            let type = 'deal';
            let unique_id = 'deal'+'{{ $deal->id }}';
            let id = '{{ $deal->id }}';
            let price = '{{  $deal->deal_amount }}';
            let name = '{{ $deal->title }}';
            let quantity = $('.qty').val();

            var data = {id, type, price, name, quantity, unique_id, max_order, _token: $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                blockUI: false,
                disableButton: true,
                success: function (response) {
                    if(response.result=='fail')
                    {
                        swal({
                            title: "@lang('front.buttons.clearCart')?",
                            text: "@lang('messages.front.errors.addOneItemAtATime')",
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
                                    success: function (response) {
                                        if (response.status == 'success') {
                                            $.easyAjax({
                                                url: '{{ route('front.addOrUpdateProduct') }}',
                                                type: 'POST',
                                                data: data,
                                                success: function (response) {
                                                    $('.cart-badge').text(response.productsCount);
                                                    if (response.status == 'success') {
                                                        window.location.href = '{{ route('front.cartPage') }}'
                                                    }
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
                        $('.add').removeClass('d-flex');
                        $('.add').addClass('d-none');

                        $('.update').addClass('d-flex');
                        $('.update').removeClass('d-none');
                    }

                    if (response.status == 'success') {
                        window.location.href = '{{ route('front.cartPage') }}'
                    }
                }
            })
        });

        $('body').on('click', '#delete-product', function() {
            let key = $('input.qty').data('id');

            var url = '{{ route('front.deleteFrontProduct', ':id') }}';
            url = url.replace(':id', 'deal'+key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                blockUI: false,
                disableButton: true,
                buttonSelector: "#delete-product",
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);
                    $('.add').addClass('d-flex');
                    $('.add').removeClass('d-none');

                    $('.update').removeClass('d-flex');
                    $('.update').addClass('d-none');

                    $('input.qty').val(1);
                }
            })
        });

    </script>
@endpush
