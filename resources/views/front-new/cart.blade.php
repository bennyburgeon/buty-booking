@extends('layouts-new.front')

@push('styles')
<style>
    /* Add custom CSS here */
    .disabledBtn {
        pointer-events: all !important;
        opacity: 0.40 !important;
        cursor: not-allowed !important;
    }

    .dropdown-menu li:before {
        content: none;
    }
</style>
@endpush

@section('content')
<!-- SERVICES START -->
<section class="bg-white py-50">
    <div class="container">
        <div class="row">
            <!-- SERVICE DETAIL START -->
            <div class="col-lg-8 col-md-12">
                <!-- Heading Start -->
                <div class="row">
                    <div class="col-md-12 heading mb-5 p-0">
                        <h3 class="font-weight-bold category-name">@if( Request::url() ==
                            route('front.cartPage').'/'.'deal' ) @lang('app.deals') @else {{ $category_id ?
                            $category_id->name : __('app.services')}} @endif</h3>
                    </div>

                    <div class="col-md-4 p-0 mb-4 position-relative grey-border rounded">
                        <div class="dropdown">
                            <a class="dropdown-toggle f-12 text-dark d-flex justify-content-between align-items-center p-2"
                                type="button" id="service-filter" data-bs-toggle="dropdown" aria-expanded="false">
                                @lang('app.all') </a>
                            <ul class="w-100 dropdown-menu grey-border" aria-labelledby="dropdownMenuButton1">

                                <li>
                                    <a class="dropdown-item f-12 active" id="service-filter-all" href="javascript:;" onclick="serviceFilter('all')" selected>@lang('app.all')</a>
                                </li>

                                <li>
                                    <a class="dropdown-item f-12" id="service-filter-online" onclick="serviceFilter('online')" href="javascript:;">@lang('app.online')</a>
                                </li>
                                <li>
                                    <a class="dropdown-item f-12" id="service-filter-offline" onclick="serviceFilter('offline')" href="javascript:;">@lang('app.offline')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Heading End -->

                <!-- Service Start -->
                <div id="filtered_services">

                </div>
                <!-- Service End -->
            </div>
            <!-- SERVICE DETAIL END -->

            <!-- CART START -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="cart-wrap">
                    <!-- Heading Start -->
                    <div class="row">
                        <div class="col-md-12 heading d-flex justify-content-between align-items-center mb-5">
                            <h3 class="font-weight-bold">@lang('front.cart')</h3>
                            <p class="text-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bag mr-1" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                </svg>
                                <span class="cart-items">{{ $productsCount }} </span> @lang('app.items')
                            </p>
                        </div>
                    </div>
                    <!-- Heading End -->

                    <!-- Cart Detail Start -->
                    <form class="rounded grey-border p-3 desktop">
                        <div class="itemBox">
                            @if (!is_null($products))
                            @forelse ($products as $key => $product)
                            <div class="d-flex justify-content-between mb-4 removeItemDiv{{$key}}">
                                <div class="cart-left">
                                    <p class="text-capitalize">{{ $product['name'] }}</p>
                                    <a title="@lang('front.table.deleteProduct')" href="javascript:;"
                                        onclick="deleteProduct(this, '{{ $key }}')" class="delete-btn text-dark">
                                        <i class="las la-trash f-17 cursor-pointer trash-item"></i>
                                    </a>
                                </div>
                                <div class="cart-right" id="{{ $key }}">
                                    <p class="text-right productAmt">
                                    <span>{{ currencyFormatter($product['quantity'] * $product['price']) }}</p>
                                    <div class="input-group rounded tax_detail">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="decreaseQuantity(this)" class="btn btn-default btn-number" @if ($product['quantity'] <= 0) disabled @endif
                                                data-type="minus" data-field="quant[1]">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        class="bi bi-dash" viewBox="0 0 16 16">
                                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </span>
                                        @php
                                            $appliedTax = 0;
                                            $totalTax = 0;
                                            $taxPercent = 0;
                                            $subTotal = $product['quantity'] * $product['price']
                                        @endphp
                                        @if (isset($product['tax']))
                                            @forelse (json_decode($product['tax']) as $tax)
                                                @if (isset($tax->tax_name))
                                                    @php
                                                        $taxPercent += $tax->percent;
                                                        $appliedTax += ($subTotal*$tax->percent)/100;
                                                        $totalTax += $appliedTax;
                                                    @endphp
                                                @endif
                                            @empty
                                            @endforelse
                                        @endif

                                        <input type="hidden" class="tax_percent" value="{{ $taxPercent }}">
                                        <input type="hidden" class="tax_amount" value="{{ $appliedTax }}">

                                        <input type="text" id="number" name="qty" title="Quantity" onkeypress="return isNumberKey(event)"
                                            value="{{ $product['quantity'] }}" class="form-control input-text qty"
                                            data-id="{{ $product['unique_id'] }}" data-deal-id="{{ $product['id'] }}"
                                            data-price="{{ $product['price'] }}" data-type="{{ $product['type'] }}" @if ($product['type'] == 'deal') data-max-order="{{ $product['max_order'] }}" @endif
                                            autocomplete="none">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="increaseQuantity(this)" class="btn btn-default btn-number"
                                                data-type="plus" data-field="quant[1]">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        class="bi bi-plus" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="d-flex justify-content-between mt-3">
                                <h6 colspan="4" class="text-center text-light">@lang('front.table.emptyMessage')</h6>
                            </div>
                            @endforelse
                            @else
                            <div class="d-flex justify-content-between mt-3">
                                <h6 colspan="4" class="text-center text-light">@lang('front.table.emptyMessage')</h6>
                            </div>
                            @endif
                        </div>

                        <span class="my-30 d-block grey-border-top"></span>

                        <div class="d-flex justify-content-between mb-4">
                            <div class="cart-left">
                                <p class="text-capitalize">@lang('front.summary.cart.subTotal')</p>
                            </div>
                            <div class="cart-right">
                                <p class="text-right sub-total"></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <div class="cart-left">
                                <p class="text-capitalize">@lang('app.totalTax')</p>
                            </div>
                            <div class="cart-right">
                                <p class="text-right tax">{{ $totalTax ?? '0' }}</p>
                            </div>
                        </div>

                        <span class="my-30 d-block grey-border-top"></span>

                        <div class="d-flex justify-content-between mb-4">
                            <div class="cart-left">
                                <p class="text-capitalize f-w-600">@lang('front.summary.cart.totalAmount')</p>
                            </div>
                            <div class="cart-right">
                                <p class="text-right f-w-600 total"></p>
                            </div>
                        </div>

                        <div
                            class="col-md-12 d-flex px-0 clearCartBtnDiv @if(is_null($products)) justify-content-end @else justify-content-between @endif">
                            <div class="clearCartBtn  @if(is_null($products)) d-none @endif">
                                <button type="button" onclick="deleteProduct(this, 'all')"
                                    class="outline-btn btn-sm mt-4 btn f-13 h-30 d-flex mr-2">
                                    <i class="las la-times-circle f-18 me-1"></i> @lang('front.buttons.clearCart')
                                </button>
                            </div>
                            <a href="javascript:;"
                                class="manage-booking primary-btn btn-md mt-4 btn f-13 h-30 d-flex @if (is_null($products)) disabledBtn @endif">
                                <i class="las la-clock f-18 me-1"></i>@lang('front.selectBookingTime')
                            </a>
                        </div>
                    </form>
                    <!-- Cart Detail End -->
                </div>
            </div>
            <!-- CART END -->
        </div>
    </div>
</section>
<!-- SERVICES END -->

<!-- CART MODAL START (FOR SMALL SCREEN DEVICES)-->
<div class="modal fade" id="cart" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="cart-wrap">
                <a type="submit" class="pr-3 pt-3 f-16 float-right text-red" data-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-circle"></i>
                </a>

                <!-- Cart Detail Start -->
                <form class="rounded p-3 mobile">
                    <!-- Heading Start -->
                    <div class="heading mb-4">
                        <h3 class="font-weight-bold">@lang('front.summary.cart.heading.cartTotal')</h3>
                    </div>
                    <!-- Heading End -->
                    <div class="itemBox">
                        @if (!is_null($products))
                        @forelse ($products as $key => $product)
                        <div class="d-flex justify-content-between mb-4 tax_detail removeItemDiv{{$key}}">
                            <div class="cart-left">
                                <p class="text-capitalize">{{ $product['name'] }}</p>
                                <a title="@lang('front.table.deleteProduct')" href="javascript:;"
                                    onclick="deleteProduct(this, '{{ $key }}')" class="delete-btn text-dark">
                                    <i class="las la-trash f-17 cursor-pointer trash-item"></i>
                                </a>
                            </div>
                            <div class="cart-right {{ $key }}">
                                <p class="text-right productAmt"><span>{{ currencyFormatter($product['quantity'] *
                                        $product['price']) }}</p>
                                <div class="input-group rounded">
                                    <span class="input-group-btn">
                                        <button type="button" onclick="decreaseQuantity(this)"
                                            class="btn btn-default btn-number" @if($product['quantity']<=0) disabled
                                            @endif data-type="minus" data-field="quant[1]">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                    </span>
                                    @php
                                    $appliedTax = 0;
                                    $totalTax = 0;
                                    $taxPercent = 0;
                                    $subTotal = $product['quantity'] * $product['price']
                                    @endphp
                                    @if (isset($product['tax']))
                                    @forelse (json_decode($product['tax']) as $tax)
                                    @if (isset($tax->tax_name))
                                    @php
                                    $taxPercent += $tax->percent;
                                    $appliedTax += ($subTotal*$tax->percent)/100;
                                    $totalTax += $appliedTax;
                                    @endphp
                                    @endif
                                    @empty
                                    <span>-- --</span>
                                    @endforelse
                                    @endif

                                    <input type="hidden" class="tax_percent" value="{{ $taxPercent }}">
                                    <input type="hidden" class="tax_amount" value="{{ $appliedTax }}">

                                    <input type="text" id="number" name="qty" title="Quantity"
                                        onkeypress="return isNumberKey(event)" value="{{ $product['quantity'] }}"
                                        class="form-control input-texts qty" data-id="{{ $product['unique_id'] }}"
                                        data-deal-id="{{ $product['id'] }}" data-price="{{$product['price']}}"
                                        data-type="{{$product['type']}}" @if ($product['type']=='deal' )
                                        data-max-order="{{$product['max_order']}}" @endif autocomplete="none">
                                    <span class="input-group-btn">
                                        <button type="button" onclick="increaseQuantity(this)"
                                            class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                </svg>
                                            </span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="d-flex justify-content-between mt-3">
                            <h6 colspan="4" class="text-center text-light">@lang('front.table.emptyMessage')</h6>
                        </div>
                        @endforelse
                        @else
                        <div class="d-flex justify-content-between mt-3">
                            <h6 colspan="4" class="text-center text-light">@lang('front.table.emptyMessage')</h6>
                        </div>
                        @endif
                    </div>

                    <span class="my-30 d-block grey-border-top"></span>

                    <div class="d-flex justify-content-between mb-4">
                        <div class="cart-left">
                            <p class="text-capitalize">@lang('front.summary.cart.subTotal')</p>
                        </div>
                        <div class="cart-right">
                            <p class="text-right sub-total"></p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <div class="cart-left">
                            <p class="text-capitalize">@lang('app.totalTax')</p>
                        </div>
                        <div class="cart-right">
                            <p class="text-right tax"></p>
                        </div>
                    </div>

                    <span class="my-30 d-block grey-border-top"></span>

                    <div class="d-flex justify-content-between mb-4">
                        <div class="cart-left">
                            <p class="text-capitalize f-w-600">@lang('front.summary.cart.totalAmount')</p>
                        </div>
                        <div class="cart-right">
                            <p class="text-right f-w-600 total"></p>
                        </div>
                    </div>
                </form>

                <!-- Cart Detail End -->
            </div>
        </div>
    </div>
</div>
<!-- CART MODAL END -->

@endsection

@push('footer-script')
<script src="{{ asset('assets/js/cookie.js') }}"></script>
<script>
    function filter()
    {
        let queryString = window.location.search;

        let urlParams = new URLSearchParams(queryString);
        let term = urlParams.get('search_term');

        let url = '{{ $url ? $url : '' }}';

        let currentRoute = '{{url()->current()}}';

        let category = '{{ $category_id ? $category_id->id : ''}}';

        locations = [];
        if(localStorage.getItem('location')) {
            locations.push(localStorage.getItem('location'));
        }

        $.easyAjax({
            type: 'GET',
            url: '{{ route('front.services', "all") }}',
            data: {url : url, currentRoute : currentRoute, category : category, locations : locations, term : term },
            success: function (response) {

                if(response.url == 'deal'){
                    $('#filtered_services').html(response.view);
                }

                if(response.service_count == 0) {
                    let image_path = '{{ asset("front/images/no-search-result.png") }}';
                    $('#filtered_services').html('<div style="margin-top:30px" class="mt-4 no_result text-center"><img src="'+image_path+'" class="mx-auto d-block" alt="Image" width="40%" /><h2 class="mt-3">@lang("messages.noResultFound") :(</h2><p>@lang("messages.checkSpellingOrUseGeneralTerms")</p></div>');
                } else {
                    $('#filtered_services').html(response.view);
                }
            }
        });

        @if(!is_null($products))
            $('a.manage-booking').attr("href", "{{ route('front.manageBooking') }}")
            $('.manage-booking').removeClass('disabled');
        @endif
    }

    filter();

    function serviceFilter(ele)
    {
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let term = urlParams.get('search_term');
        let url = '{{ $url ? $url : '' }}';
        let currentRoute = '{{url()->current()}}';
        let category = '{{ $category_id ? $category_id->id : ''}}';
        let serviceFilter = ele;

        if (serviceFilter === 'all') {
            $('#service-filter-all').addClass('active');
            $('#service-filter').html('{{__("app.all")}}');
            $('#service-filter-online').removeClass('active');
            $('#service-filter-offline').removeClass('active');
        } else if (serviceFilter === 'online') {
            $('#service-filter-online').addClass('active');
            $('#service-filter').html('{{__("app.online")}}');
            $('#service-filter-all').removeClass('active');
            $('#service-filter-offline').removeClass('active');
        } else if (serviceFilter === 'offline') {
            $('#service-filter-offline').addClass('active');
            $('#service-filter').html('{{__("app.offline")}}');
            $('#service-filter-online').removeClass('active');
            $('#service-filter-all').removeClass('active');
        }

        locations = [];
        if(localStorage.getItem('location')) {
            locations.push(localStorage.getItem('location'));
        }

        $.easyAjax({
            type: 'GET',
            url: '{{ route('front.services', "all") }}',
            data: {url : url, currentRoute : currentRoute, category : category, locations : locations, term : term, serviceFilter },
            success: function (response) {

                if(response.url == 'deal'){
                    $('#filtered_services').html(response.view);
                }

                if(response.service_count == 0) {
                    let image_path = '{{ asset("front/images/no-search-result.png") }}';
                    $('#filtered_services').html('<div style="margin-top:30px" class="mt-4 no_result text-center"><img src="'+image_path+'" class="mx-auto d-block" alt="Image" width="40%" /><h2 class="mt-3">@lang("messages.noResultFound") :(</h2><p>@lang("messages.checkSpellingOrUseGeneralTerms")</p></div>');
                } else {
                    $('#filtered_services').html(response.view);
                }
            }
        });

        @if(!is_null($products))
            $('a.manage-booking').attr("href", "{{ route('front.manageBooking') }}")
            $('.manage-booking').removeClass('disabled');
        @endif
    }

    $('body').on('click', '.add-to-cart', function ()
    {
        let id = $(this).data('id');
        let type = $(this).data('type');
        let name = $(this).data('name');
        let price = $(this).data('price');
        let unique_id = $(this).data('unique-id');
        let service_type = $(this).data('service-type');
        let token = $("meta[name='csrf-token']").attr('content');

        if(type == 'deal')
        {
            var max_order = $(this).data('max-order');
        }

        var data = {id, type, price, unique_id, service_type, name, max_order, _token: token};

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
                                                $('.cart-items').text(response.productsCount);
                                                $('.itemBox').html(response.productView);
                                                $('#clearCartBtn').removeClass('d-none');
                                                $('.clearCartBtnDiv').removeClass('justify-content-end');
                                                $('.clearCartBtnDiv').addClass('justify-content-between');
                                                $('a.manage-booking').attr("href", "{{ route('front.manageBooking') }}");
                                                $('.manage-booking').removeClass('disabled');
                                                $('.manage-booking').removeClass('disabledBtn');
                                                calculateTotal();
                                                location.reload();
                                            }
                                        })
                                    }
                                }
                            })
                        }
                    });
                }

                $('.cart-badge').text(response.productsCount);
                $('.cart-items').text(response.productsCount);
                $('.itemBox').html(response.productView);
                $('.clearCartBtn').removeClass('d-none');
                $('.clearCartBtnDiv').removeClass('justify-content-end');
                $('.clearCartBtnDiv').addClass('justify-content-between');
                $('a.manage-booking').attr("href", "{{ route('front.manageBooking') }}");
                $('.manage-booking').removeClass('disabled');
                $('.manage-booking').removeClass('disabledBtn');

                calculateTotal();

            }
        })
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        return true;
    }

    $(function () {
        var couponCode = '';
        calculateTotal();
    });

    var cartUpdate;
    var products = {!! json_encode($products) !!};

    function calculateTotal()
    {
        let cartTotal = totalTax = totalAmount = 0.00;
        let deviceData = '';
        if (window.matchMedia("(max-width: 767px)").matches)
        {
            deviceData = $('.mobile input.qty');
        } else {
            deviceData = $('.desktop input.qty');
        }

        deviceData.each(function () {
            const id = $(this).data('id');
            let quantity = $(this).val();

            let price = $(this).data('price');

            let subTotal = parseInt(quantity) * parseInt(price);
            cartTotal += subTotal;

            var tax = $(this).closest('.tax_detail').find('.tax_percent').val();

            taxAmt = ((parseFloat(tax)/100) * ((parseFloat(price) * parseInt(quantity))));
            totalTax += parseFloat(taxAmt);
            $('#'+id).find('.productAmt').text(currency_format(subTotal));
        });

        $('.sub-total').text(currency_format(cartTotal.toFixed(2)));

        $('.tax').text(currency_format(totalTax.toFixed(2)));

        totalAmount = cartTotal + totalTax;

        $('.total').text(currency_format(totalAmount.toFixed(2)));

        return false;
    }

    function increaseQuantity(ele)
    {
        let deviceData = '';
        if (window.matchMedia("(max-width: 767px)").matches)
        {
            deviceData = '.mobile input.qty';
        } else {
            deviceData = '.desktop input.qty';
        }

        var input = $(ele).parent().siblings(deviceData);
        var currentValue = input.val();

        if(currentValue>0)
        {
            input.val(parseInt(currentValue) + 1);
            input.trigger('keyup');
        }
    }

    function decreaseQuantity(ele) {

        let deviceData = '';

        if (window.matchMedia("(max-width: 767px)").matches)
        {
            deviceData = '.mobile input.qty';
        } else {
            deviceData = '.desktop input.qty';
        }

        var input = $(ele).parent().siblings(deviceData);
        var currentValue = input.val();
        var a = (currentValue - 1);

        if (currentValue > 1)
        {
            input.val(parseInt(currentValue) - 1);
            input.trigger('keyup');
        }
    }

    function deleteProduct(ele, key) {
        var url = '{{ route('front.deleteProduct', ':id') }}';
        url = url.replace(':id', key);

        $.easyAjax({
            url: url,
            type: 'POST',
            data: {_token: $("meta[name='csrf-token']").attr('content')},
            redirect: false,
            success: function (response) {
                if (response.status == 'success') {
                    if (response.action == "redirect") {
                        var message = "";
                        if (typeof response.message != "undefined") {
                            message += response.message;
                        }

                        $.showToastr(message, "success", {
                            positionClass: "toast-top-right"
                        });

                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);

                    }
                    else {
                        $('.removeItemDiv'+key).remove();
                        $('.itemBox').html(response.productView);
                        $('.cart-badge').text(response.productsCount);
                        $('.cart-items').text(response.productsCount);
                        calculateTotal();
                        products = response.products;
                    }
                }
            }
        })
    }

    function updateCart(ele) {
        let data = {};

        let currentValue = ele.val();
        let type = ele.data('type');
        let max_order = ele.data('max-order');
        let unique_id = ele.data('id');
        let price = ele.data('price');

        let showError = false;

        let deviceData = '';
        if (window.matchMedia("(max-width: 767px)").matches)
        {
            deviceData = '.mobile input.qty';
        } else {
            deviceData = '.desktop input.qty';
        }

        $(deviceData).each(function () {
            const serviceId = $(this).data('id');
            let quantity = $(this).val();
            products[serviceId].quantity = parseInt($(this).val());
        });

        if(type == 'deal' && parseInt(currentValue) > parseInt(max_order)) {

            showError = true;
            ele.val(parseInt(max_order));

            totalAmount = 0;
            $(deviceData).each(function () {
                let quantity = $(this).val();
                let price = $(this).data('price');
                let id = $(this).data('id');

                let subTotal = parseInt(quantity) * parseInt(price);
                totalAmount += subTotal;

                $('.sub-total').text(currency_format(subTotal.toFixed(2)));
            });

            $('.total').text(currency_format(totalAmount.toFixed(2)));
        }

        data.showError = showError;
        data.products = products;
        data.currentValue = currentValue;
        data.type = type;
        data.max_order = max_order;
        data.unique_id = unique_id;
        data._token = '{{ csrf_token() }}';

        if($(deviceData).val()>=0 && $(deviceData).val()!='') {
            $.easyAjax({
                url: '{{ route('front.updateCart') }}',
                type: 'POST',
                data: data,
                container: '.section',
                blockUI: false,
                success:function(response){
                    calculateTotal();
                }
            })
        }
    }

    let deviceData = '';
    if (window.matchMedia("(max-width: 767px)").matches)
    {
        deviceData = '.mobile input.qty';
    } else {
        deviceData = '.desktop input.qty';
    }
    $(document).on('keyup', deviceData, function () {
        const id = $(this).data('id');
        const price = $(this).data('price');
        const quantity = $(this).val();
        let subTotal = 0;

        const el = $(this);
        const type = $(this).data('type');
        const dealId = $(this).data('deal-id');

        if (quantity<0)
        {
            $(this).val(0);
        }

        clearTimeout(cartUpdate);

        calculateTotal();

        cartUpdate = setTimeout(() => {
            updateCart($(this));
        }, 500);
    });

    $('input.qty').on('blur', function () {
        if ($(this).val() == '' || $(this).val() == 0) {
            $(this).val(1);
        }
    })

</script>

@include("partials.currency_format")

@endpush
