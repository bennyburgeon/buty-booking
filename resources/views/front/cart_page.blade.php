@extends('layouts.front')

@push('styles')
<style>
    .coupons-base-content .fa-tag{
        font-size: 20px;
        color: #222;
    }
    .coupons-base-content p{
        color: #3289da;
        font-size: 11px;
    }
    .remove-button{
        margin-bottom: 4px;
        margin-left: 3px;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button
    {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number]
    {
    -moz-appearance: textfield;
    }
</style>
@endpush
@section('content')
    <section class="section">
        <section class="cart-area sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                @lang('front.headings.bookingDetails')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-12 mb-30">
                        <div class="shopping-cart-table">
                            <table class="table table-responsive-md">
                                <thead>
                                <tr>
                                    <th>@lang('front.table.headings.serviceName')</th>
                                    <th>@lang('front.table.headings.unitPrice')</th>
                                    <th>@lang('front.table.headings.quantity')</th>
                                    @if(!is_null($taxes))
                                    <th>@lang('app.tax')</th>
                                    @endif
                                    <th>@lang('front.table.headings.subTotal')</th>
                                    @if (!is_null($products))
                                        <th>&nbsp;</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null($products))
                                        @foreach($products as $key => $product)
                                            <tr id="{{ $key }}">
                                                <td>{{ $product['name'] }}</td>
                                                <td>{{ currencyFormatter($product['price']) }}</td>
                                                <td>
                                                    <div class="qty-wrap">
                                                        <div class="qty-elements">
                                                            <a class="decrement_qty" href="javascript:void(0)" onclick="decreaseQuantity(this)">-</a>
                                                        </div>
                                                            <input type="number"
                                                                id="number"
                                                                name="qty"
                                                                title="Quantity"
                                                                onkeypress="return isNumberKey(event)"
                                                                value="{{ $product['quantity'] }}"
                                                                class="input-text qty"
                                                                data-id="{{ $product['unique_id'] }}"
                                                                data-deal-id="{{ $product['id'] }}"
                                                                data-price="{{$product['price']}}"
                                                                data-type="{{$product['type']}}"
                                                                @if ($product['type'] == 'deal')
                                                                    data-max-order="{{$product['max_order']}}"
                                                                @endif
                                                                autocomplete="none">

                                                        <div class="qty-elements">
                                                            <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                @if(!is_null($taxes))
                                                    <td class="tax_detail">
                                                        @php
                                                            $appliedTax = 0;
                                                            $taxPercent = 0;
                                                            $subTotal = $product['quantity'] * $product['price']
                                                        @endphp
                                                        @if (isset($product['tax']))
                                                            @forelse (json_decode($product['tax']) as $tax)
                                                                @if (isset($tax->tax_name))
                                                                    @php
                                                                        $taxPercent += $tax->percent;
                                                                        $appliedTax += ($subTotal*$tax->percent)/100;
                                                                    @endphp
                                                                @endif

                                                                {{ $tax->tax_name }}-<span>{{ $tax->percent }}% @if(!$loop->last),@endif </span>

                                                            @empty
                                                                <span>-----</span>
                                                            @endforelse
                                                        @endif

                                                        <input type="hidden" class="tax_percent" value="{{ $taxPercent }}">
                                                        <input type="hidden" class="tax_amount" value="{{ $appliedTax }}">
                                                    </td>
                                                @endif
                                                <td class="sub-total">
                                                    <input type="hidden" value="{{ $product['quantity'] * $product['price'] }}">
                                                    <span>{{ currencyFormatter($product['quantity'] * $product['price']) }}</span>
                                                </td>
                                                <td>
                                                    <a title="@lang('front.table.deleteProduct')" href="javascript:;" onclick="deleteProduct(this, '{{ $key }}')" class="delete-btn">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">@lang('front.table.emptyMessage')</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <ul class="cart-buttons">
                                            <li>
                                            </li>
                                            <li>
                                                <a href="{{ route('front.index') }}" class="btn btn-custom btn-blue">@lang('front.buttons.continueBooking')</a>
                                                @if (!is_null($products))
                                                    <a href="javascript:;" onclick="deleteProduct(this, 'all')" class="btn btn-custom btn-blue">@lang('front.buttons.clearCart')</a>
                                                @endif
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-30">
                        <div class="cart-block">
                            <div class="final-cart">
                                <h5>@lang('front.summary.cart.heading.cartTotal')</h5>

                                @if ($type == 'booking')

                                    <div class="my-2 @if(!is_null($couponData)) d-none @endif applyCouponBox" id="applyCouponBox">
                                        <a data-bs-toggle="modal" href="#couponModal" class="d-flex align-items-center form-control dash-border">
                                            {{-- <i class="las la-tags f-20 me-1"></i> --}}
                                            <span class="f-14">@lang('front.summary.cart.applyCoupon')</span>
                                        </a>
                                    </div>

                                    <div class=" py-3 border-bottom" id="removeCouponBox"  @if(is_null($couponData)) style="display: none" @endif>
                                        <h6  class="clearfix text-secondary">@lang('app.coupons')</h6>

                                        <div class="coupons-base-content justify-content-between d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3 ">
                                                    <i class="fa fa-tag text-white"></i>
                                                </div>
                                                <div>
                                                    <span class="coupons-name mb-0 text-uppercase" id="couponCode" >
                                                        @if(!is_null($couponData))
                                                            {{ $couponData[0]['title'] }}
                                                        @endif
                                                    </span>
                                                    <p class="mb-0 text-success savetext">
                                                        @lang('app.youSaved') {{ $settings->currency->currency_symbol }}
                                                        <span id="couponCodeAmonut">
                                                            @if(!is_null($couponData))
                                                                {{ $couponData['applyAmount'] }}
                                                            @endif
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" onclick="removeCoupon();" class="btn btn-sm btn-danger remove-button"> @lang('app.remove') </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="cart-value" @if ($type == 'deal') style="padding-top: 0px !important" @endif>
                                    <ul>
                                        <li>
                                            <span>
                                                @if ($type == 'booking') @lang('front.summary.cart.subTotal')
                                                @else  @lang('front.summary.cart.totalAmount'): @endif
                                            </span>
                                            <span id="sub-total">
                                            </span>
                                        </li>
                                        <li>
                                            <span>@lang('app.totalTax')</span>
                                            <span id="tax"></span>
                                        </li>
                                        @if(!is_null($couponData))
                                            <li id="couponDiscountBox">
                                                <span>
                                                    @lang('app.discount') ({{ $couponData[0]['title'] }}):
                                                </span>
                                                <span id="couponDiscoiunt">
                                                    -{{ currencyFormatter($couponData['applyAmount']) }}
                                                </span>
                                            </li>
                                        @endif
                                        <li id="totalAmountBox">
                                            <span>
                                                @lang('front.summary.cart.totalAmount'):
                                            </span>
                                            <span id="total">
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!is_null($products))
                    <div class="row">
                        <div class="col-12 text-right">
                            <div class="navigation">
                                <a href="{{ route('front.bookingPage') }}" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-1"></i>@lang('front.navigation.goBack')</a>
                                @if ($type == 'deal')
                                    <a href="{{ route('front.checkoutPage') }}" class="btn btn-custom btn-dark">
                                        @lang('front.navigation.toCheckout')<i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                @else
                                    <a href="{{ route('front.checkoutPage') }}" class="btn btn-custom btn-dark">
                                        {{ !is_null($bookingDetails) ? __('front.navigation.toCheckout') : __('front.selectBookingTime') }}
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </section>

    <!-- DISCOUNT MODAL START -->
    <div class="modal fade" id="couponModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="input-group rounded">
                        <input type="text" name="coupon" id="coupon" class="form-control f-14" placeholder="@lang('front.summary.cart.applyCoupon')"
                            aria-label="Enter your coupon code" aria-describedby="basic-addon1">
                        <button onclick="applyCoupon();" data-type="input-data-code" type="button" class="input-group-text text-uppercase bg-primary text-white px-4 f-w-600 f-15"
                            id="basic-addon1">@lang('front.summary.cart.applyCoupon')</button>
                    </div>
                </div>
                @if (!is_null($coupons))
                    <div class="modal-body p-3">
                        @forelse ($coupons as $coupon)
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <h5 class="card-title font-weight-bold mb-0">@lang('front.get') @if (!is_null($coupon->percent)) {{$coupon->percent}}% @else {{ currencyFormatter($coupon->amount)}} @endif @lang('front.off')</h5>
                                    <p class="card-text f-13 text-secondary">{!! $coupon->description !!}</p>
                                </div>
                                <div class="card-footer border-0 bg-white p-0 d-flex mt-3 justify-content-between">
                                    <button type="button" id="couponValue" onclick="copyCouponCode()" class="dash-btn btn btn-md f-13 h-30 d-flex px-4">{{strtoupper($coupon->title)}}</button>
                                    <a class="f-13 text-green" href="javascript:;" onclick="copyCouponCode()">@lang('app.copy')</a>
                                </div>
                            </div>
                            <span class="my-30 d-block grey-border-top"></span>
                        @empty
                            <div class="d-flex justify-content-between">
                                <h6 colspan="4" class="text-center text-secondary">@lang('front.table.emptyCoupon').</h6>
                            </div>
                        @endforelse
                    </div>
                @endif

                <div class="modal-footer">
                    <button type="submit" class="btn-outline-secondary btn-md btn f-13 h-30 d-flex float-right"
                        data-dismiss="modal" aria-label="Close">
                        @lang('app.cancel')
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- DISCOUNT MODAL END -->
@endsection

@push('footer-script')
<script src="{{ asset('assets/js/cookie.js') }}"></script>
    <script>

        function copyCouponCode() {
            var couponTitle = $('#couponValue').html();
            $('#coupon').val(couponTitle);
        }

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }

        $(function () {
            var couponCode = '';
            calculateTotal();
        });

        var cartUpdate;
        var couponAmount = 0;
        var couponApplied = false;
        var products = {!! json_encode($products) !!};

        @if(!is_null($couponData) && $couponData['applyAmount'])
            couponAmount = '{{ $couponData['applyAmount'] }}';
            couponCode = '{{ $couponData[0]['title'] }}';
            couponApplied = true;
        @endif

        function calculateTotal()
        {
            let cartTotal = tax = totalAmount = 0.00;

            $('.sub-total>input').each(function () {
                cartTotal += parseFloat($(this).val());
            });

            $('#sub-total').text(currency_format(cartTotal.toFixed(2)));

            // calculate and display tax
            var totalTax = 0;

            $('.tax_detail').each(function () {
                var tax = $(this).closest('.tax_detail').find('.tax_amount').val();
                totalTax += parseFloat(tax);
            });

            $('#tax').text(currency_format(totalTax.toFixed(2)));

            totalAmount = cartTotal + totalTax;

            if(couponAmount)
            {
                if(totalAmount>=couponAmount)
                {
                    totalAmount = totalAmount - couponAmount;
                }
                else
                {
                    totalAmount = 0;
                }
            }

            $('#total').text(currency_format(totalAmount.toFixed(2)));
        }

        function increaseQuantity(ele)
        {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();
            if(currentValue>0)
            {
                input.val(parseInt(currentValue) + 1);
                input.trigger('keyup');
            }
        }

        function decreaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            if (currentValue > 1) {
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
                            updateCoupon ();
                            $(ele).parents(`tr#${key}`).remove();
                            calculateTotal();
                            $('.cart-badge').text(response.productsCount);
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

            $('input.qty').each(function () {
                const serviceId = $(this).data('id');
                products[serviceId].quantity = parseInt($(this).val());
            });

            if(type == 'deal' && parseInt(currentValue) > parseInt(max_order)) {
                showError = true;
                ele.val(parseInt(max_order));

                totalAmount = 0;
                $('input.qty').each(function () {
                    let quantity = $(this).val();
                    let price = $(this).data('price');
                    let id = $(this).data('id');

                    let subTotal = parseInt(quantity) * parseInt(price);

                    totalAmount += subTotal;
                    $(`tr#${id}`).find('.sub-total>span').text(subTotal.toFixed(2));

                    var taxPercent = $(`tr#${id}`).find('.tax_detail>.tax_percent').val();

                    tax = (taxPercent * subTotal)/100;
                    $(`tr#${id}`).find('.tax_detail>.tax_amount').val(tax);
                });


                // calculate and display tax
                // var taxPercent = $(`tr#${id}`).find('.tax_detail>.tax_percent').val();

                // tax = (taxPercent * subTotal)/100;
                // $(`tr#${id}`).find('.tax_detail>.tax_amount').val(tax);

                // $(`tr#${id}`).find('.sub-total>span').text(subTotal.toFixed(2));

                $('.sub-total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));

                // calculate and display tax
                var totalTax = 0;
                $('.tax_detail').each(function () {
                    var tax = $(this).closest('.tax_detail').find('.tax_amount').val();
                    totalTax += parseFloat(tax);
                });

                totalAmount = (totalAmount+totalTax);

                $('#total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));
            }

            data.showError = showError;
            data.products = products;
            data.currentValue = currentValue;
            data.type = type;
            data.max_order = max_order;
            data.unique_id = unique_id;
            data._token = '{{ csrf_token() }}';


            if($('input.qty').val()>=0 && $('input.qty').val()!='') {
                $.easyAjax({
                    url: '{{ route('front.updateCart') }}',
                    type: 'POST',
                    data: data,
                    container: '.section',
                    blockUI: false,
                    success:function(response){
                        updateCoupon();
                    }
                })
            }
        }

        function removeCoupon () {
            $.easyAjax({
                url: '{{ route('front.remove-coupon') }}',
                type: 'GET',
                success: function (response) {
                    couponApplied = false;
                    $('#coupon').val('');
                    $('#coupon_amount').val(0);
                    couponAmount = 0;
                    calculateTotal();
                    $('#couponDiscountBox').remove();
                    $('#removeCouponBox').hide();
                    $('#applyCouponBox').removeClass('d-none');
                }
            })


        }

        function applyCoupon()
        {
            let cartTotal = tax = totalAmount = 0.00;

            $('.sub-total>input').each(function () {
                cartTotal += parseFloat($(this).val());
            });

            $('#sub-total').text(currency_format(cartTotal.toFixed(2)));

            // calculate and display tax
            var totalTax = 0;
            $('.tax_detail').each(function () {
                var tax = $(this).closest('.tax_detail').find('.tax_amount').val();
                totalTax += parseFloat(tax);
            });

            $('#tax').text(currency_format(totalTax.toFixed(2)));

            totalAmount = cartTotal + totalTax;

           var couponVal = $('#coupon').val();
           if((couponVal === undefined || couponVal === "" || couponVal === null)){
               return $.showToastr("@lang('errors.coupon.required')", 'error');
           }else{
               $.easyAjax({
                   url: '{{ route('front.apply-coupon') }}',
                   type: 'GET',
                   data: {'coupon':couponVal},
                   success: function (response) {
                       if(response.status != 'fail'){
                           couponApplied = true;
                           couponCode = couponVal;
                           couponAmount = response.amount;
                           if(couponAmount>totalAmount)
                           {
                                couponAmount = totalAmount;
                           }
                            calculateTotal();
                           $('#couponDiscountBox').remove();
                           var discountElement = '<li id="couponDiscountBox">'+
                               '<span>'+
                               "@lang('app.discount') ("+response.couponData.title+'):'+
                               '</span>'+
                               '<span id="discountCoupon">-'+currency_format(couponAmount)+
                               '</span>'+
                               '</li>';
                           $(discountElement).insertBefore( "#totalAmountBox" );

                            $("#couponModal").modal('hide');

                            $('#applyCouponBox').addClass('d-none');

                           $('#removeCouponBox').show();

                           $('#couponCodeAmonut').html(currency_format(couponAmount));
                           $('#couponCode').html(response.couponData.title);
                       }
                       else{
                           removeCoupon ();
                       }

                   }
               })
           }

        }

        function updateCoupon () {

            let cartTotal = tax = totalAmount = 0.00;

            totalAmount = 0;
            $('input.qty').each(function () {
                let quantity = $(this).val();
                let price = $(this).data('price');
                let id = $(this).data('id');

                let subTotal = parseInt(quantity) * parseInt(price);

                totalAmount += subTotal;
            });

            $('#sub-total').text(currency_format(totalAmount.toFixed(2)));

            // calculate and display tax
            var totalTax = 0;
            $('.tax_detail').each(function () {
                var tax = $(this).closest('.tax_detail').find('.tax_amount').val();
                totalTax += parseFloat(tax);
            });

            $('#tax').text(currency_format(totalTax.toFixed(2)));

            totalAmount = totalAmount + totalTax;


            if (couponApplied){


                $.easyAjax({
                    url: '{{ route('front.update-coupon') }}',
                    type: 'GET',
                    data: {'coupon': couponCode},
                    success: function (response) {
                        if (response.status != 'fail') {

                            couponAmount = response.amount;
                            if(couponAmount>totalAmount)
                            {
                                couponAmount = totalAmount;
                            }

                            calculateTotal();
                            $('#couponDiscountBox').remove();
                            var discountElement = '<li id="couponDiscountBox">' +
                                '<span>' +
                                "@lang('app.discount') (" + response.couponData.title + '):' +
                                '</span>' +
                                '<span id="discountCoupon">-' + currency_format(couponAmount) +
                                '</span>' +
                                '</li>';
                            $(discountElement).insertBefore("#totalAmountBox");

                            $('#applyCouponBox').addClass('d-none');

                            $('#removeCouponBox').show();


                            $('#couponCodeAmonut').html(currency_format(couponAmount));
                            $('#couponCode').html(response.couponData.title);
                        }
                        else {
                            removeCoupon();
                        }

                    }
                })

            }
        }

        $('input.qty').on('keyup', function () {
            const id = $(this).data('id');
            const price = $(this).data('price');
            const quantity = $(this).val();

            const el = $(this);

            const type = $(this).data('type');
            const dealId = $(this).data('deal-id');

            let subTotal = 0;

            if (quantity<0)
            {
                $(this).val(0);
            }

            clearTimeout(cartUpdate);

            if (quantity == '' || quantity == 0) {
                subTotal = price * 1;
            }
            else {
                subTotal = price * quantity;
            }
            setSubTotal(id,subTotal);

            // calculate and display tax
            var taxPercent = $(`tr#${id}`).find('.tax_detail>.tax_percent').val();

            tax = (taxPercent * subTotal)/100;
            $(`tr#${id}`).find('.tax_detail>.tax_amount').val(tax);

            $(`tr#${id}`).find('.sub-total>span').text(subTotal.toFixed(2));

            calculateTotal();

            cartUpdate = setTimeout(() => {
                updateCart($(this));
            }, 500);
        });

        function setSubTotal(id,value)
        {
            $(`tr#${id}`).find('.sub-total>input').val(value.toFixed(2));
            $(`tr#${id}`).find('.sub-total>span').text(currency_format(value.toFixed(2)));
        }

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        })
    </script>
     @include("partials.currency_format")
@endpush
