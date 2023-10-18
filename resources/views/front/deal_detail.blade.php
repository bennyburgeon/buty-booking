@extends('layouts.front')

@push('styles')
    <style>
        .img{
            height: 25em;
        }
    </style>
@endpush


@section('content')
    <section class="section">
        <section class="service-detail sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>{{ $deal->title }}</h4>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <img class="img" src="{{ $deal->deal_image_url }}" alt="{{ $deal->slug }}" width="100%" height="300px">

                        <div class="row col-md-12" style="margin-top: 2em">
                            <h6 class="text-uppercase">@lang('app.description')</h6>
                            <div class="row col-12 text-justify">
                            {!! $deal->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-60">
                        <div class="detail-info mb-5">
                            <ul>
                                <li>
                                    <span>
                                        @lang('app.location')
                                    </span>
                                    <span>
                                        {{ $deal->location->name }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.deal') @lang('app.type')
                                    </span>
                                    <span>
                                        {{ $deal->deal_type=='' ? __('app.offer') : __('app.combo') }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.price')
                                    </span>
                                    <span>
                                        {{ currencyFormatter($deal->deal_amount) }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.startTime')
                                    </span>
                                    <span>
                                        {{ $deal->start_date_time }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.endTime')
                                    </span>
                                    <span>
                                        {{ $deal->end_date_time }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.appliedBeweenTime')
                                    </span>
                                    <span>
                                        {{ $deal->open_time }} - {{ $deal->close_time }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('messages.howManyTimeCustomerCanUse')
                                    </span>
                                    <span>
                                        {{ $deal->max_order_per_customer }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        @if (\Carbon\Carbon::now()->toTimeString() >= \Carbon\Carbon::createFromFormat('h:i A',$deal->open_time)->format('h:i:s') && \Carbon\Carbon::now()->toTimeString() <= \Carbon\Carbon::createFromFormat('h:i A',$deal->open_time)->format('h:i:s'))
                            <ul class="add-qty">
                                <li>
                                    <span class="text-capitalize mb-2 d-block">@lang('app.add') @lang('app.quantity')</span>
                                    <div class="qty-wrap">
                                        <div class="qty-elements">
                                            <a class="decrement_qty" href="javascript:void(0)" onclick="decreaseQuantity(this)">-</a>
                                        </div>
                                        <input name="qty" size="4" title="Quantity" class="input-text qty" autocomplete="none" value="1" readonly />
                                        <div class="qty-elements">
                                            <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                        </div>
                                    </div>
                                    <input name="qty" size="4" title="Quantity" class="input-text qty" autocomplete="none" value="1" readonly />
                                    <div class="qty-elements">
                                        <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="add">
                                    <div class="row">
                                        <div class="col">
                                            <a href="javascript:;"
                                                id="deal{{ $deal->id }}"
                                                class="btn btn-custom grab-deal"
                                                data-type="deal"
                                                data-unique-id="deal{{ $deal->id }}"
                                                data-id="{{ $deal->id }}"
                                                data-price="{{$deal->deal_amount}}"
                                                data-name="{{ ucwords($deal->title) }}"
                                                data-max-order="{{ $deal->max_order_per_customer }}"
                                                aria-expanded="false">
                                                @lang('app.grab')
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="navigation mt-4">
                            <a href="{{ route('front.index') }}" class="btn btn-custom btn-dark">
                                <i class="fa fa-angle-left mr-1"></i>@lang('front.navigation.goBack')
                            </a>

                            <a href="javascript:;"
                                id="deal{{ $deal->id }}"
                                class="btn btn-custom grab-deal"
                                data-type="deal"
                                data-unique-id="deal{{ $deal->id }}"
                                data-id="{{ $deal->id }}"
                                data-price="{{$deal->deal_amount}}"
                                data-name="{{ ucwords($deal->title) }}"
                                data-max-order="{{ $deal->max_order_per_customer }}"
                                aria-expanded="false">
                                @lang('app.grab') @lang('app.deal')
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

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

                    if (response.status == 'success') {
                        window.location.href = '{{ route('front.cartPage') }}'
                    }
                }
            })
        });

    </script>
@endpush
