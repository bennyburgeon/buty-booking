@extends('layouts-new.front')

@push('styles')
    <!-- Datepicker CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('front/vendor/css/bootstrap-datepicker.min.css') }}">

    <style>
        .d-none{
            display: none !important;
        }
        #selected_user{
            background-color: #bcc6d0;
            color: #212529;
        }
        .input-group> :not(:first-child):not(.dropdown-menu) {
            margin-left: 0 !important;
            border-top-left-radius: 4px !important;
            border-bottom-left-radius: 4px !important;
        }

        .userDetailForm input {
            width: 85%;
            float: left;
        }
        .userDetailForm span {
            width: auto;
            height: 46px;
            padding: 0.375rem 0.75rem;
        }
        .invalid-feedback {
            display: block !important;
        }
        .userDetailForm .select2-container{
            width: 100% !important;
            background-color: #f9f9fe !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: #f9f9fe !important;
            border: 0px !important;
        }
        .select2-container--default .select2-selection--single{
            padding: 0px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            color: #aeaea8 !important;
            line-height: 0px !important;
        }
        .select2-container .select2-selection--single{
            height: 0px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 10px !important;
        }
    </style>
@endpush

@section('content')
    <!-- SERVICES START -->
    <section class="bg-white py-50 statusSection">
        <div class="container">
            <div class="row">
                <!-- SERVICE DETAIL START -->
                <div class="col-lg-8 col-md-12">
                    <!-- Accordion Start -->
                    <div class="accordion pl-4 position-relative" id="accordionExample">

                        <!-- BOOKING DATE TIME START -->
                        <div class="accordion-item rounded grey-border mb-30 in booking-date-time" id="card1">
                            <div class="accordion-header p-4 collapsed" id="accordion1" data-bs-toggle="collapse" data-bs-target="@if($type !== 'deal' && !is_null($products)) #collapse-booking @endif" aria-expanded="false" aria-controls="collapse-booking">
                                <span class="rounded d-flex align-items-center justify-content-center side-icon bg-green"><i class="las la-check-circle f-18"></i></span>
                                <div class="d-block d-lg-flex d-md-flex justify-content-between align-items-center">
                                    <h3 class="font-weight-bold" id="bold-cs">@lang('app.booking') @lang('app.date')/@lang('app.time')</h3>
                                    <span class="text-light" id="show_booking_date"></span>
                                </div>
                            </div>
                            <div id="collapse-booking" class="accordion-collapse collapse @if($type !== 'deal' && !is_null($products)) show @endif" aria-labelledby="accordion1"
                                data-bs-parent="#accordionExample">
                                <div class="row accordion-body p-4 pt-0">
                                    <div class="col-md-6">
                                        <div id="datepicker" data-date="12/03/2012"></div>
                                        <input type="hidden" class="date-picker-field" id="booking_date_time" name="booking_date_time" value="">
                                        <input type="hidden" class="date-picker-field" id="empId" name="empId" value="">
                                    </div>
                                    <div class="col-md-6 slots-wrapper"></div>
                                    <div class="col-md-12">
                                        <center>
                                            <h5 style="color: crimson;" id="msg_div"></h5>
                                        </center>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="button" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex" onclick="addBookingDetails()">
                                            <i class="las la-calendar-check f-18 me-1"></i> @lang('app.select')
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="accordion-line"></div>
                        </div>
                        <!-- BOOKING DATE TIME END -->

                        <!-- CART SUMMARY START -->
                        <div class="accordion-item rounded grey-border mb-30 cart-summary" id="card2">
                            <div class="accordion-header p-4 collapsed" id="accordion2" data-bs-toggle="collapse" data-bs-target="@if($type == 'deal') #collapse-cart-summary @endif" aria-expanded="false" aria-controls="collapse-cart-summary">
                            {{-- <div class="accordion-header p-4 collapsed" id="accordion2" data-bs-toggle="collapse" data-bs-target="#collapse-cart-summary" aria-expanded="false" aria-controls="collapse-cart-summary"> --}}
                                <span class="rounded d-flex align-items-center justify-content-center side-icon " id="bg-green-cs"><i class="bi bi-bag f-18"></i></span>
                                <div class="d-block d-lg-flex d-md-flex justify-content-between align-items-center">
                                    <h3 class="font-weight-bold" id="bold-cart">@lang('front.summary.cart.cart') @lang('front.summary.cart.summary') </h3>
                                    <span class="text-light" id="cartedit"></span>
                                </div>
                            </div>
                            <div id="collapse-cart-summary" class="accordion-collapse collapse @if($type == 'deal') show @endif" aria-labelledby="accordion2" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-4 pt-0">
                                    <div class="col-md-12 table-responsive">
                                        <table class="bg-secondary rounded" width="100%" cellpadding="0" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>@lang('front.table.headings.serviceName')</th>
                                                    <th>@lang('front.table.headings.unitPrice')</th>
                                                    <th>@lang('front.table.headings.quantity')</th>
                                                    <th>@lang('front.table.headings.subTotal')</th>
                                                    <th class="text-center">@lang('front.table.headings.discard')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!is_null($products))
                                                    @foreach($products as $key => $product)
                                                        <tr id="{{ $key }}">
                                                            <td>{{ $product['name'] }}</td>
                                                            <td>{{ currencyFormatter($product['price']) }}</td>
                                                            <td>
                                                                <div class="input-group rounded tax_detail">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="decreaseQuantity(this)" class="btn btn-default btn-number" @if($product['quantity']<= 0) disabled  @endif data-type="minus"
                                                                            data-field="quant[1]">
                                                                            <span>
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash"
                                                                                    viewBox="0 0 16 16">
                                                                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                    </span>
                                                                    @php
                                                                        $appliedTax = 0;
                                                                        $taxPercent = 0;
                                                                        $subTotal = $product['quantity'] * $product['price'];
                                                                    @endphp
                                                                    @if (isset($product['tax']))
                                                                        @foreach (json_decode($product['tax']) as $tax)
                                                                            @if (isset($tax->tax_name))
                                                                                @php
                                                                                    $taxPercent += $tax->percent;
                                                                                    $appliedTax += ($subTotal*$tax->percent)/100;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                    <input type="hidden" name="tax_percent" class="tax_percent" value="{{ $taxPercent }}">
                                                                    <input type="hidden" name="tax_amount" class="tax_amount" value="{{ $appliedTax }}">

                                                                    <input type="text" id="number" name="qty" title="Quantity" onkeypress="return isNumberKey(event)"
                                                                        value="{{ $product['quantity'] }}" class="form-control input-text qty" data-id="{{ $product['unique_id'] }}"
                                                                        data-deal-id="{{ $product['id'] }}" data-price="{{$product['price']}}" data-type="{{$product['type']}}"
                                                                        @if ($product['type'] == 'deal') data-max-order="{{$product['max_order']}}" @endif autocomplete="none">

                                                                    <span class="input-group-btn">
                                                                        <button type="button" onclick="increaseQuantity(this)" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                                                                            <span>
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus"
                                                                                    viewBox="0 0 16 16">
                                                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                                                </svg>
                                                                            </span>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="sub-total"><span>{{ $product['quantity'] * $product['price'] }}</span></td>

                                                            <td align="center">
                                                                <a title="@lang('front.table.deleteProduct')" href="javascript:;" onclick="deleteProduct(this, '{{ $key }}')" class="delete-btn text-dark">
                                                                    <i class="las la-trash f-17 cursor-pointer trash-item"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center text-light">@lang('front.table.emptyMessage')</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 d-lg-flex d-md-flex d-block justify-content-end">
                                        @if (!is_null($products))
                                            <button type="button" onclick="deleteProduct(this, 'all')" class="outline-btn btn-sm mt-4 btn f-13 h-30 d-flex mr-2">
                                                <i class="las la-times-circle f-18 me-1"></i> @lang('front.buttons.clearCart')
                                            </button>
                                            <button type="button" onclick="proceedToCheckout()" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex">
                                                <i class="las la-check-double f-18 me-1"></i> @lang('front.navigation.toCheckout')
                                            </button>
                                        @elseif (is_null($products))
                                            <a href="{{ route('front.index') }}" class="btn btn-custom btn-blue">@lang('front.buttons.continueBooking')</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-line"></div>
                        </div>
                        <!-- CART SUMMARY END -->

                        <!-- CHECKOUT START -->
                        <div class="accordion-item rounded grey-border mb-30 checkout" id="card3">
                            <div class="accordion-header p-4 collapsed" id="accordion3" data-bs-toggle="collapse" data-bs-target="" aria-expanded="false" aria-controls="collapse-checkout">
                                <span class="rounded d-flex align-items-center justify-content-center side-icon" id="bg-green-checkout"><i class="bi bi-person f-18"></i></span>
                                <div class="d-block d-lg-flex d-md-flex justify-content-between align-items-center">
                                    <h3 class="font-weight-bold" id="bold-check">@lang('front.checkout')</h3>
                                    <span class="text-light" id="editcheck"></span>
                                </div>
                            </div>
                            <div id="collapse-checkout" class="accordion-collapse collapse" aria-labelledby="accordion3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body p-4 pt-0">
                                    @if(is_null($user))
                                        <div class="col-md-12">
                                            <p class="text-light mb-3">@lang('front.accountAlready') ? <a href="{{ route('login') }}" class="text-primary">@lang('front.loginNow')</a></p>
                                            <h5 class="text-light">@lang('app.add') @lang('front.personalDetails')</h5><br>
                                            <form id="personal-details" class="ajax-form" method="POST">
                                                @csrf
                                                <input type="hidden" id="request_type" name="request_type" value="booking">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="first_name" id="first_name" class="form-control f-13" placeholder="@lang('front.registration.firstName') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person text-light" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="last_name" class="form-control f-13" placeholder="@lang('front.registration.lastName') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person text-light" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="email" class="form-control f-13" placeholder="@lang('front.registration.email') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope text-light" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="phone" class="form-control f-13" placeholder="@lang('front.registration.phoneNumber') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone text-light" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        @if ($smsSettings->nexmo_status == 'active')
                                                            <span class="text-info ml-2">
                                                                @lang('messages.info.verifyMessage')
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="house_no" class="form-control f-13" placeholder="@lang('front.registration.houseNo') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="address_line" class="form-control f-13" placeholder="@lang('front.registration.addressLine') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="city" class="form-control f-13" placeholder="@lang('front.registration.city') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="state" class="form-control f-13" placeholder="@lang('front.registration.state') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <input type="text" name="pin_code" class="form-control f-13" placeholder="@lang('front.registration.pincode') (required)">
                                                            <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-30 rounded userDetailForm">
                                                            <select name="country_id" id="country_id" class="form-control f-13 select2">
                                                                @foreach($countries as $country)
                                                                    <option value="{{$country->id}}">{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @if ($googleCaptchaSettings->v2_status == 'active' && $googleCaptchaSettings->status == 'active')
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-group">
                                                                @if ($googleCaptchaSettings->status == 'active')
                                                                    <input type="hidden" name="recaptcha" class="form-control" id="recaptcha">
                                                                @endif
                                                                <div id="captcha_container"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>

                                    @elseif($smsSettings->nexmo_status == 'active' && !$user->mobile_verified)
                                        <div class="col-md-12">
                                            <h5>@lang('app.verifyMobile')</h5>
                                            <div id="verify-mobile">
                                                @include('partials.front_verify_phone')
                                            </div>
                                        </div><br>
                                    @endif

                                    @if ($user)
                                            <form id="booking" class="ajax-form" method="POST">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="text-light mb-3">@lang('front.registration.address')</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-30 rounded userDetailForm">
                                                        <input type="text" name="house_no" class="form-control f-13" placeholder="@lang('front.registration.houseNo') (required)">
                                                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-30 rounded userDetailForm">
                                                        <input type="text" name="address_line" class="form-control f-13" placeholder="@lang('front.registration.addressLine') (required)">
                                                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-30 rounded userDetailForm">
                                                        <input type="text" name="city" class="form-control f-13" placeholder="@lang('front.registration.city') (required)">
                                                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-30 rounded userDetailForm">
                                                        <input type="text" name="state" class="form-control f-13" placeholder="@lang('front.registration.state') (required)">
                                                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-30 rounded userDetailForm">
                                                        <input type="text" name="pin_code" class="form-control f-13" placeholder="@lang('front.registration.pincode') (required)">
                                                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-30 rounded userDetailForm">
                                                        <select name="country_id" id="country_id" class="form-control f-13 select2">
                                                            @foreach($countries as $country)
                                                                <option @if ($user && $user->address && $country->id == $user->address->country_id) selected @endif value="{{$country->id}}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 instruction">
                                                    <h5 class="text-light">@lang('front.additionalNotes')</h5><br>
                                                    @csrf
                                                    <div class="input-group mb-2 rounded">
                                                        <input type="hidden" name="request_type" value="{{ $type }}">
                                                        <textarea class="form-control f-13 h-auto pt-3" rows="4" name="additional_notes" placeholder="@lang('front.writeYourMessageHere')"></textarea>
                                                        <span class="input-group-text border-0 bg-secondary align-items-start pt-3" id="basic-addon2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen text-light" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @elseif ($smsSettings->nexmo_status == 'deactive')
                                        <div class="col-md-12 instruction">
                                            <h5 class="text-light">@lang('front.additionalNotes')</h5><br>
                                            <div class="input-group mb-2 rounded">
                                                <input type="hidden" name="request_type" value="{{ $type }}">
                                                <textarea class="form-control f-13 h-auto pt-3" rows="5" name="additional_notes" placeholder="@lang('front.writeYourMessageHere')" form="personal-details"></textarea>
                                                <span class="input-group-text border-0 bg-secondary align-items-start pt-3" id="basic-addon2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen text-light" viewBox="0 0 16 16">
                                                        <path
                                                            d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-12 d-flex justify-content-end">
                                        @if (!$user)
                                            @if ($smsSettings->nexmo_status == 'active')
                                                <button type="button" onclick="saveUser();" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex collapsed">
                                                    <i class="las la-check-double f-18 me-1"></i> @lang('front.navigation.toVerifyMobile')
                                                </button>
                                            @else
                                                <button type="button" onclick="saveUser();" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex collapsed">
                                                    <i class="las la-check-double f-18 me-1"></i> @lang('front.navigation.toPayment')
                                                </button>
                                            @endif
                                        @else
                                            @if ($smsSettings->nexmo_status == 'active')
                                                <button type="button" onclick="saveBooking();" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex @if (!$user->mobile_verified) disabled @endif">
                                                    <i class="las la-check-double f-18 me-1"></i> @lang('front.navigation.toPayment')
                                                </button>
                                            @else
                                                <button type="button" onclick="saveBooking();" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex">
                                                    <i class="las la-check-double f-18 me-1"></i> @lang('front.navigation.toPayment')
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="accordion-line"></div>
                        </div>
                        <!-- CHECKOUT END -->

                        <!-- PAYMENT START -->
                        <div class="accordion-item rounded grey-border payment" id="card4">
                            <div class="accordion-header p-4 collapsed" id="accordion4" data-bs-toggle="collapse"
                                data-bs-target="" aria-expanded="false" aria-controls="collapse-payment">
                                <span class="rounded d-flex align-items-center justify-content-center side-icon" id="bg-green-pay"><i class="las la-dollar-sign f-18"></i></span>
                                <div class="d-block d-lg-flex d-md-flex justify-content-between align-items-center">
                                    <h3 class="font-weight-bold">@lang('front.payment')</h3>
                                </div>
                            </div>
                            <div id="collapse-payment" class="accordion-collapse collapse" aria-labelledby="accordion4" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-4 pt-0">
                                    <div class="row">
                                        @if ($credentials->show_payment_options == 'show')
                                            @if($credentials->stripe_status == 'active')
                                                <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                                    <a href="javascript:;" id="stripePaymentButton" class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                                        <i class="lab la-stripe"></i>
                                                        <p>@lang('front.buttons.payVia') @lang('front.buttons.stripe')</p>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($credentials->paypal_status == 'active')
                                                <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                                    <a href="{{ route('front.paypal') }}" class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                                        <i class="lab la-paypal"></i>
                                                        <p>@lang('front.buttons.payVia') @lang('front.buttons.paypal')</p>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($credentials->paystack_status == 'active')
                                                <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                                    <a href="javascript:;" onclick="payWithPaystack();" id="paystackPaymentButton" class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                                        <i class="las la-money-bill-wave"></i>
                                                        <p>@lang('front.buttons.payVia') @lang('front.buttons.paystack')</p>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($credentials->razorpay_status == 'active')
                                                <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                                    <a href="javascript:startRazorPayPayment();" class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                                        <i class="las la-money-bill-wave-alt"></i>
                                                        <p>@lang('front.buttons.payVia') @lang('front.buttons.razorpay')</p>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($credentials->offline_payment == 1 && $service_type != 'online')
                                                <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                                    <a href="{{ route('front.offline-payment') }}" class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                                        <i class="las la-money-bill"></i>
                                                        <p>@lang('front.buttons.offlinePayment')</p>
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="col-md-12 mb-sm-0 mb-3 mt-3">
                                               <p class="text-danger">@lang('messages.noPaymentOptionAvailable')</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-line"></div>
                        </div>
                        <!-- PAYMENT END -->
                    </div>
                    <!-- Accordion End -->
                </div>
                <!-- SERVICE DETAIL END -->

                <!-- CART START -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="cart-wrap">

                        <!-- Cart Detail Start -->
                        <form class="rounded grey-border p-3 ">
                            <!-- Heading Start -->
                            <div class="heading mb-4">
                                <h3 class="font-weight-bold">@lang('front.summary.cart.heading.cartTotal')</h3>
                            </div>
                            <!-- Heading End -->
                            @if (is_null($products))
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="d-flex justify-content-between mb-4">
                                        <h6 colspan="4" class="text-center text-light">@lang('front.table.emptyMessage')</h6>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between mb-3">
                                <div class="cart-left">
                                    <span class="text-capitalize">@lang('front.summary.cart.subTotal') ({{ $productsCount }} items)</span>
                                </div>
                                <div class="cart-right">
                                    <span class="subTotal"></span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div class="cart-left">
                                    <p class="text-capitalize">@lang('app.totalTax')</p>
                                </div>
                                <div class="cart-right">
                                    <p class="text-right tax"></p>
                                </div>
                            </div>

                            @if ($type == 'booking')

                                <span class="my-30 d-block grey-border-top"></span>

                                <div class="my-4 @if(!is_null($couponData)) d-none @endif applyCouponBox">
                                    <a data-bs-toggle="modal" href="#couponModal" class="d-flex align-items-center form-control dash-border">
                                        <i class="las la-tags f-20 text-black me-1"></i>
                                        <span class="f-14 text-dark">@lang('front.summary.cart.applyCoupon')</span>
                                    </a>
                                </div>

                                <div class= "removeCouponBox" @if(is_null($couponData)) style="display: none" @endif>
                                    <h6 class="text-capitalize f-w-600">@lang('front.summary.cart.applied') @lang('app.coupons')</h6>
                                        <div class="d-flex justify-content-between my-3">
                                        <div class="cart-left">
                                            <span class="coupons-name mb-0 text-uppercase couponCode">
                                                @if(!is_null($couponData))
                                                    {{ $couponData[0]['title'] }}
                                                @endif
                                            </span>
                                            <p class="mb-0 text-success savetext">
                                                @lang('app.youSaved') {{ $settings->currency->currency_symbol }}
                                                <span class="couponCodeAmount">
                                                    @if(!is_null($couponData))
                                                        {{ $couponData['applyAmount'] }}
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                        <div class="cart-right">
                                            <div class="input-group rounded">
                                                <button onclick="removeCoupon();" type="button" class="text-red btn btn-sm btn-danger remove-button">@lang('app.remove')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(!is_null($couponData))
                                    <div class="d-flex justify-content-between mt-0 couponDiscountBox">
                                        <div class="cart-left">
                                            <span class="text-capitalize">@lang('app.discount') ({{ $couponData[0]['title'] }})</span>
                                        </div>
                                        <div class="cart-right">
                                            <span id="couponDiscoiunt" class="text-right">-{{ currencyFormatter($couponData['applyAmount']) }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div id="totalAmountBox"></div>

                            @endif

                            <span class="my-30 d-block black-border-top"></span>

                            <div class="d-flex justify-content-between">
                                <div class="cart-left">
                                    <span class="text-uppercase f-w-600 f-15">@lang('front.summary.cart.totalAmount')</span>
                                </div>
                                <div class="cart-right">
                                    <span class="total"></span>
                                </div>
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

    <!-- CART MODAL START -->
    <div class="modal fade" id="cart" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="cart-wrap">
                    <a type="submit" class="pr-3 pt-3 f-16 float-right text-red" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-circle"></i>
                    </a>

                    <!-- Cart Detail Start -->
                    <form class="rounded p-3 ">
                        <!-- Heading Start -->
                        <div class="heading mb-4">
                            <h3 class="font-weight-bold">@lang('front.summary.cart.heading.cartTotal')</h3>
                        </div>
                        <!-- Heading End -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="cart-left">
                                <span class="text-capitalize">@lang('front.summary.cart.subTotal') ({{ $productsCount }} @lang('front.items'))</span>
                            </div>
                            <div class="cart-right">
                                <span class="subTotal"></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="cart-left">
                                <p class="text-capitalize">@lang('app.totalTax')</p>
                            </div>
                            <div class="cart-right">
                                <p class="text-right tax"></p>
                            </div>
                        </div>

                        <span class="my-30 d-block grey-border-top"></span>

                        <div class="my-4 @if(!is_null($couponData)) d-none @endif applyCouponBox">
                            <a data-bs-toggle="modal" href="#couponModal" class="d-flex align-items-center form-control dash-border">
                                <i class="las la-tags f-20 text-black me-1"></i>
                                <span class="f-14 text-black">@lang('front.summary.cart.applyCoupon')</span>
                            </a>
                        </div>

                        <div class="row removeCouponBox" @if(is_null($couponData)) style="display: none" @endif>
                            <h6 class="text-capitalize f-w-600">@lang('front.summary.cart.applied') @lang('app.coupons')</h6>
                                <div class="d-flex justify-content-between my-3">
                                <div class="cart-left">
                                    <span class="coupons-name mb-0 text-uppercase couponCode" >
                                        @if(!is_null($couponData))
                                            {{ $couponData[0]['title'] }}
                                        @endif
                                    </span>
                                    <p class="mb-0 text-success savetext">
                                        <span class="couponCodeAmonut">
                                            @if(!is_null($couponData))
                                                @lang('app.youSaved') {{ $settings->currency->currency_symbol }}{{ $couponData['applyAmount'] }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                <div class="cart-right">
                                    <div class="input-group rounded">
                                        <button onclick="removeCoupon();" type="button" class="text-red btn btn-sm btn-danger remove-button">@lang('app.remove')</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!is_null($couponData))
                            <div class="d-flex justify-content-between mb-3 couponDiscountBox">
                                <div class="cart-left">
                                    <p class="text-capitalize">@lang('app.discount') ({{ $couponData[0]['title'] }})</p>
                                </div>
                                <div class="cart-right">
                                    <p class="text-right" id="couponDiscoiunt">-{{ currencyFormatter($couponData['applyAmount']) }}</p>
                                </div>
                            </div>
                        @endif

                        <span class="my-30 d-block black-border-top"></span>

                        <div class="d-flex justify-content-between">
                            <div class="cart-left">
                                <span class="text-uppercase f-w-600 f-15">@lang('front.summary.cart.totalAmount')</span>
                            </div>
                            <div class="cart-right">
                                <span class="total text-right f-w-600 f-15"></span>
                            </div>
                        </div>

                    </form>
                    <!-- Cart Detail End -->
                </div>
            </div>
        </div>
    </div>
    <!-- CART MODAL END -->

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
                                    <h4 class="card-title font-weight-bold mb-0">@lang('front.get') @if (!is_null($coupon->percent)) {{$coupon->percent}}% @else {{ currencyFormatter($coupon->amount)}} @endif @lang('front.off')</h4>
                                    <p class="card-text f-13 text-secondary">{!! $coupon->description !!}</p>
                                </div>
                                <div class="card-footer border-0 bg-white p-0 d-flex mt-3 justify-content-between">
                                    <button type="button" id="couponValue" class="copy-code dash-btn btn btn-md f-13 h-30 d-flex px-4" data-code="{{ strtoupper($coupon->title)}}">{{strtoupper($coupon->title)}}</button>
                                    <a class="f-13 text-green copy-code" href="javascript:;" data-code="{{ strtoupper($coupon->title)}}">@lang('app.copy')</a>
                                </div>
                            </div>
                            <span class="my-30 d-block grey-border-top"></span>
                        @empty
                            <div class="d-flex justify-content-between">
                                <h6 colspan="4" class="text-center text-light">@lang('front.table.emptyCoupon').</h6>
                            </div>
                        @endforelse
                    </div>
                @endif

                <div class="modal-footer">
                    {{-- <a class="btn-close" data-dismiss="modal" aria-label="Close">&times;</a> --}}
                    <button type="submit" class="outline-btn btn-md btn f-13 h-30 d-flex float-right"
                        data-bs-dismiss="modal" aria-label="Close">
                        @lang('app.cancel')
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- DISCOUNT MODAL END -->

@endsection

@push('footer-script')
    <!-- Datepicker JS-->
    <script src="{{ asset('front-assets/js/date.format.js') }}"></script>
    <script src="{{ asset('front/vendor/js/bootstrap-datepicker.min.js') }}"></script>
    @if ($locale !== 'en')
        <script src="{{ 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.'.$locale.'.min.js' }}" charset="UTF-8"></script>
    @endif
    <!-- Cookie -->
    <script src="{{ asset('assets/js/cookie.js') }}"></script>

    @if ($googleCaptchaSettings->v2_status == 'active' && $googleCaptchaSettings->status == 'active')
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer></script>
        <script>
            var gcv3;
            var onloadCallback = function() {
                    // Renders the HTML element with id 'captcha_container' as a reCAPTCHA widget.
                    // The id of the reCAPTCHA widget is assigned to 'gcv3'.
                    gcv3 = grecaptcha.render('captcha_container', {
                    'sitekey' : '{{$googleCaptchaSettings->v2_site_key}}',
                    'theme' : 'light',
                    'callback' : function(response) {
                        if(response) {

                            document.getElementById('recaptcha').value = response;
                        }
                    },
                });
            };
        </script>
    @endif

    @if ($googleCaptchaSettings->v3_status == 'active' && $googleCaptchaSettings->status == 'active')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $googleCaptchaSettings->v3_site_key }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ $googleCaptchaSettings->v3_site_key }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                        document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif

    <script>

        $('.copy-code').click(function(){
            var couponCode = $(this).data('code');
            $('#coupon').val(couponCode);

        });
    </script>

    <!-- Calculate total amount for payment gatways -->
    <script>
        var couponAmount = 0;

        @if(!is_null($couponData) && $couponData['applyAmount'])
            couponAmount = '{{ $couponData['applyAmount'] }}';
        @endif

        let cartTotal = totalTax = totalAmount = 0.00;

        $('.sub-total>span').each(function () {
            cartTotal += parseFloat($(this).text());
        });

        // calculate tax
        $('input.qty').each(function () {
            let quantity = $(this).val();
            let price = $(this).data('price');

            var tax = $(this).closest('.tax_detail').find('.tax_percent').val();

            taxAmt = ((parseFloat(tax)/100) * ((parseFloat(price) * parseInt(quantity))));
            totalTax += parseFloat(taxAmt);
        });

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
    </script>

    @if($credentials->razorpay_status == 'active')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
        if(totalAmount > 0){
            var options = {
                "key": "{{ $credentials->razorpay_key }}", // Enter the Key ID generated from the Dashboard
                "amount": Math.round(totalAmount * 100), // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
                "currency": "INR",
                "name": "{{ Auth::user()  ? Auth::user()->name : '' }}",
                "description": "@lang('app.booking') @lang('front.headings.payment')",
                "image": "{{ $settings->logo_url }}",
                "handler": function (response){
                    confirmRazorPayPayment(response.razorpay_payment_id, response);
                },
                "prefill": {
                    "email": "{{ Auth::user() ? Auth::user()->email : '' }}",
                    "contact": "{{ Auth::user() ? Auth::user()->mobile : '' }}"
                },
                "notes": {
                    "booking_id": ""
                },
                "theme": {
                    "color": "{{ $frontThemeSettings->primary_color }}"
                }
            };
            var rzp1 = new Razorpay(options);

            function startRazorPayPayment() {
                rzp1.open();
                $.easyBlockUI('.statusSection');
            }

            function confirmRazorPayPayment(paymentId, response) {
                var bookingId = null;
                $.easyAjax({
                    url: '{{ route('front.razorpay') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_id: paymentId,
                        booking_id: bookingId,
                        response: response
                    },
                    container: '#invoice_container',
                    redirect: true
                });
            }
        }
        </script>
    @endif

    @if ($credentials->paystack_status == 'active')
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            if(totalAmount > 0){
                // const paymentForm = document.getElementById('paystackPaymentButton');
                // paymentForm.addEventListener("submit", payWithPaystack, false);
                function payWithPaystack(e) {
                    var bookingId = '';
                    var handler = PaystackPop.setup({
                        key: '{{ $credentials->paystack_public_id }}',
                        email: '{{ Auth::user() ? Auth::user()->email : '' }}',
                        amount: Math.round(totalAmount * 100),
                        onClose: function(){
                            // window.location.reload();
                            $.easyUnblockUI('.statusSection');
                        },
                        callback: function(response){
                            $.easyBlockUI('.statusSection');
                            let id = 'bookingId';
                            let url = "{{ route('front.paystackCallback',':id') }}";
                            url = url.replace(':id', id);

                            $.easyAjax({
                                url: url,
                                type: "GET",
                                redirect: true,
                                data: {"_token" : "{{ csrf_token() }}", "reference" : response,},
                            });
                        },
                        error: function(){
                            swal('@lang("modules.booking.paystackError")');
                        },
                    });
                    handler.openIframe();
                }
            }
        </script>
    @endif

    @if($credentials->stripe_status == 'active')
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            if(totalAmount > 0){
                var token_triggered = false;
                var handler = StripeCheckout.configure({
                    key: '{{ $credentials->stripe_client_id }}',
                    // image: '{{ $settings->logo_url }}',
                    locale: 'auto',
                    closed: function(data) {
                        if (!token_triggered) {
                            $.easyUnblockUI('.statusSection');
                        } else {
                            $.easyBlockUI('.statusSection');
                        }
                    },
                    token: function(token) {
                        token_triggered = true;
                        // You can access the token ID with `token.id`.
                        // Get the token ID to your server-side code for use.
                        $.easyAjax({
                            url: '{{route('front.stripe')}}',
                            container: '#invoice_container',
                            type: "POST",
                            redirect: true,
                            data: {token: token, "_token" : "{{ csrf_token() }}"}
                        })
                    }
                });

                document.getElementById('stripePaymentButton').addEventListener('click', function(e) {
                    // Open Checkout with further options:
                    handler.open({
                        name: '{{ $setting->company_name }}',
                        amount: totalAmount* 100,
                        currency: '{{ $setting->currency->currency_code }}',
                        email: "{{ $user ? $user->email : ''}}"
                    });
                    $.easyBlockUI('.statusSection');
                    e.preventDefault();
                });

                // Close Checkout on page navigation:
                window.addEventListener('popstate', function() {
                    handler.close();
                });
            }
        </script>
    @endif

    <!-- Date Time -->
    <script>
        $(function () {
            @if (!is_null($bookingDetails) && sizeof($bookingDetails) > 0)

                getBookingSlots({ bookingDate:  '{{ $bookingDetails['bookingDate'] }}', _token: "{{ csrf_token() }}"});

                var bookingDate = '{{ $bookingDetails['bookingDate'] }}';

                bookingDetails.bookingDate = bookingDate;
                $('#datepicker').datepicker('update', dateFormat(new Date(bookingDate), 'yyyy-mm-dd', true));
            @endif
        });

        $('#datepicker').datepicker({
            templates: {
                leftArrow: '«',
                rightArrow: '»'
            },
            startDate: '-0d',
            language: '{{ $locale }}',
            weekStart: 0,
            format: "yyyy-mm-dd"
        });

        var bookingDetails = {_token: $("meta[name='csrf-token']").attr('content')};

        function getBookingSlots(data) {
            $('#msg_div').hide();
            data['location_id'] = localStorage.getItem('location');
            $.easyAjax({
                url: "{{ route('front.bookingSlots') }}",
                type: "POST",
                data: data,
                success: function (response) {
                    if(response.status == 'success'){
                        $('.slots-wrapper').html(response.view);
                        // check for cookie
                        @if (!is_null($bookingDetails) && sizeof($bookingDetails) > 0)
                            var bookingTime = '{{ $bookingDetails['bookingTime'] }}';
                            var bookingDate = '{{ $bookingDetails['bookingDate'] }}';
                            var emp_name    = '{{ $bookingDetails['emp_name'] }}';

                            if (bookingDate == bookingDetails.bookingDate) {
                                bookingDetails.bookingTime = bookingTime;
                                $(`input[value='${bookingTime}']`).attr('checked', true);
                                if(emp_name != ''){
                                    $('#show_emp_name_div').show();
                                    $('#show_emp_name_div').html(emp_name + "{{ __('messages.selectedForBooking') }}");
                                }
                            }
                            else {
                                bookingDetails.bookingTime = '';
                            }
                        @else
                            bookingDetails.bookingTime = '';
                        @endif
                    }
                    else{
                        $('.slots-wrapper').html('');
                        $('.slots-wrapper').css('display', 'none');
                        $('#msg_div').show();
                        $('#msg_div').html(response.msg);
                    }
                }
            })
        }

        $('#datepicker').on('changeDate', function() {
            $('.slots-wrapper').css({'display': 'flex', 'align-items': 'center'});
            var initialHeight = $('.slots-wrapper').css('height');
            var html = '<div class="loading text-white d-flex align-items-center" style="height: '+initialHeight+';">Loading... </div>';
            $('.slots-wrapper').html(html);

            $('html, body').animate({
                scrollTop: $(".slots-wrapper").offset().top
            }, 1000);

            var formattedDate = $('#datepicker').datepicker('getFormattedDate');

            $('#booking_date').val(formattedDate);
            bookingDetails.bookingDate = dateFormat((new Date(formattedDate)), "yyyy-mm-dd", true);

            getBookingSlots({ bookingDate:  bookingDetails.bookingDate, _token: "{{ csrf_token() }}"})
        });

        $(document).on('change', $('input[name="booking_time"]'), function (e) {
            bookingDetails.bookingTime = $(this).find('input[name="booking_time"]:checked').val();
        });

        function addBookingDetails()
        {
            bookingDetails.selected_user = $('#selected_user').val();
            let time = $(this).find('input[name="booking_time"]:checked').val();

            $.easyAjax({
                url: '{{ route('front.addBookingDetails') }}',
                type: 'POST',
                container: 'section.section',
                data: bookingDetails,
                success: function (response) {
                    if (response.status == 'success') {
                        if ($("#collapse-booking").hasClass("show")) {
                            $("#collapse-booking").collapse('hide');

                            // $("#cart-summary").addClass('show');
                            $("#collapse-cart-summary").addClass('show');
                            $("#bg-green-cs").addClass('bg-green');
                        }
                        $('#accordion2').attr("data-bs-target","#collapse-cart-summary")

                        $('#show_booking_date').html('');
                        $('#show_booking_date').append(response.getDate);
                        $('#show_booking_date').append("<a class='text-dark f-17'><i class='las la-edit'></i></a>");
                        $('#bold-cs').css('color','black');

                        $('#booking_date_time').val(response.getDate);
                        $('#empId').val(response.empId);
                    }
                },
                error: function (err) {
                   var errors = err.responseJSON.errors;
                    for (var error in errors) {
                       $.showToastr(errors[error][0], 'error')
                    }
                }
            });
        }

        function checkUserAvailability(date, radioID, time)
        {
            $('#select_user_div').hide();
            $('#no_emp_avl_msg').hide();
            $('#show_emp_name_div').hide();
            $.easyAjax({
                url: '{{ route('front.checkUserAvailability') }}',
                type: 'POST',
                container: 'section.section',
                data: {date:date, _token: "{{ csrf_token() }}", location_id:location_id },
                success: function (response) {
                    if (response.continue_booking == 'no') {
                        $('#no_emp_avl_msg').show();
                        $('#timeSpan').html(time);
                        $('#radio'+radioID).prop("checked", false);
                    }
                    else{
                        $('#no_emp_avl_msg').hide();
                        if(typeof response.select_user !== 'undefined'){
                            $('#select_user_div').show();
                            $('#select_user').html(response.select_user);
                        }
                    }
                }
            });
        }

    </script>

    <!-- Cart Summary -->
    <script>
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
            let cartTotal = tax = totalTax = totalAmount = 0.00;

            $('input.qty').each(function () {
                let quantity = $(this).val();
                let price = $(this).data('price');
                let id = $(this).data('id');

                let subTotal = parseInt(quantity) * parseInt(price);
                cartTotal += subTotal;

                var tax = $(this).closest('.tax_detail').find('.tax_percent').val();

                taxAmt = ((parseFloat(tax)/100) * ((parseFloat(price) * parseInt(quantity))));
                totalTax += parseFloat(taxAmt);

                $('.sub-total').text(currency_format(subTotal.toFixed(2)));
            });

            $('.subTotal').text(currency_format(cartTotal.toFixed(2)));

            $('.tax').text(currency_format(totalTax.toFixed(2)));

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

            $('.total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));
        }

        function increaseQuantity(ele)
        {
            var input = $(ele).parent().siblings('input.qty');
            var currentValue = input.val();
            if(currentValue>0)
            {
                input.val(parseInt(currentValue) + 1);
                input.trigger('keyup');
            }
        }

        function decreaseQuantity(ele) {
            var input = $(ele).parent().siblings('input.qty');
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
            ele = $(ele);
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

            if(type == 'deal' && parseInt(currentValue) > parseInt(max_order))
            {
                showError = true;
                ele.val(parseInt(max_order));

                totalAmount = 0;
                $('input.qty').each(function () {
                    let quantity = $(this).val();
                    let price = $(this).data('price');
                    let id = $(this).data('id');

                    let subTotal = parseInt(quantity) * parseInt(price);
                    totalAmount += subTotal;

                    var tax = $(this).closest('.tax_detail').find('.tax_percent').val();

                    taxAmt = ((parseFloat(tax)/100) * ((parseFloat(price) * parseInt(quantity))));
                    totalTax += parseFloat(taxAmt);

                    $('.sub-total').text(currency_format(subTotal.toFixed(2)));
                });

                $('.tax').text(currency_format(totalTax.toFixed(2)));

                $('.total').text(currency_format(totalAmount.toFixed(2)));
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
                        // calculateTotal();
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

                    $('.couponDiscountBox').remove();
                    $('.removeCouponBox').hide();
                    $('.applyCouponBox').removeClass('d-none');
                }
            })
        }

        function applyCoupon(couponCode)
        {
            let cartTotal = totalTax = totalAmount = 0.00;

            $('.sub-total>span').each(function () {
                cartTotal += parseFloat($(this).text());
            });

            $('input.qty').each(function () {
                let quantity = $(this).val();
                let price = $(this).data('price');
                let id = $(this).data('id');


                let subTotal = parseInt(quantity) * parseFloat(price);
                cartTotal += subTotal;

                var tax = $(this).closest('.tax_detail').find('.tax_percent').val();

                taxAmt = ((parseFloat(tax)/100) * ((parseFloat(price) * parseInt(quantity))));
                totalTax += parseFloat(taxAmt);

                $('.sub-total').text(currency_format(subTotal.toFixed(2)));
            });

            $('.subTotal').text(currency_format(cartTotal.toFixed(2)));

            $('.tax').text(currency_format(totalTax.toFixed(2)));

            totalAmount = cartTotal + totalTax;

            var couponVal = $('#coupon').val();
            if((couponVal === undefined || couponVal === "" || couponVal === null)){
                return $.showToastr("@lang('errors.coupon.required')", 'error');
            }else{
                var currencySymbol = '{{ $settings->currency->currency_symbol }}';
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
                            var discountElement = '<div class="d-flex justify-content-between mt-0" id="couponDiscountBox">'+
                                    '<div class="cart-left">'+
                                        '<span class="text-capitalize">'+
                                        "@lang('app.discount') ("+response.couponData.title+')</span>'+
                                    '</div>'+
                                    '<div class="cart-right">'+
                                        '<span id="discountCoupon" class="text-right">-'+currency_format(couponAmount)+
                                        '</span>'+
                                    '</div>'+
                                '</div>';
                            $(discountElement).insertBefore( "#totalAmountBox" );

                            $("#couponModal").modal('hide');
                            $('.applyCouponBox').addClass('d-none');

                            $('.removeCouponBox').show();

                            $('.couponCodeAmonut').html(currency_format(couponAmount));
                            $('.couponCode').html(response.couponData.title);

                        }else{
                            removeCoupon ();
                        }
                    }
                })
            }
        }

        function updateCoupon () {

            let cartTotal = totalTax = totalAmount = 0.00;

            $('.sub-total>span').each(function () {
                cartTotal += parseFloat($(this).text());
            });

            $('input.qty').each(function () {
                let quantity = $(this).val();
                let price = $(this).data('price');
                let id = $(this).data('id');


                let subTotal = parseInt(quantity) * parseFloat(price);
                cartTotal += subTotal;

                var tax = $(this).closest('.tax_detail').find('.tax_percent').val();

                taxAmt = ((parseFloat(tax)/100) * ((parseFloat(price) * parseInt(quantity))));
                totalTax += parseFloat(taxAmt);

                $('.sub-total').text(currency_format(subTotal.toFixed(2)));
            });

            $('.subTotal').text(currency_format(cartTotal.toFixed(2)));

            $('.tax').text(currency_format(totalTax.toFixed(2)));

            totalAmount = cartTotal + totalTax;

            $('.total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));

            if (couponApplied){
                var currencySymbol = '{{ $settings->currency->currency_symbol }}';
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
                            var discountElement = '<div class="d-flex justify-content-between mt-0" id="couponDiscountBox">'+
                                    '<div class="cart-left">'+
                                        '<span class="text-capitalize">'+
                                        "@lang('app.discount') ("+response.couponData.title+')</span>'+
                                    '</div>'+
                                    '<div class="cart-right">'+
                                        '<span id="discountCoupon" class="text-right">-'+currency_format(couponAmount)+
                                        '</span>'+
                                    '</div>'+
                                '</div>';
                            $(discountElement).insertBefore("#totalAmountBox");

                            $('.applyCouponBox').addClass('d-none');
                            $('.removeCouponBox').show();

                            $('.couponCodeAmonut').html(currency_format(couponAmount));
                            $('.couponCode').html(response.couponData.title);
                        }
                        else {
                            removeCoupon();
                        }
                    }
                });
            }
        }

        $(document).on('keyup', 'input.qty', function () {
            const id = $(this).data('id');
            const price = $(this).data('price');
            const quantity = $(this).val();
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

            $(`tr#${id}`).find('.sub-total>span').text(currency_format(subTotal.toFixed(2)));
            calculateTotal();

            cartUpdate = setTimeout(() => {
                updateCart(this);
            }, 500);
        });

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        });

        function proceedToCheckout() {
            $('#accordion3').attr("data-bs-target","#collapse-checkout")
            $("#collapse-cart-summary").collapse('hide');

            $("#collapse-checkout").addClass('show');
            $("#bg-green-checkout").addClass('bg-green');
            $('#cartedit').append("<a class='text-dark f-17'><i class='las la-edit'></i></a>");
            $('#bold-cart').css('color','black');
        }
    </script>

    <!-- Select Booking Time -->
    <script>
        $(function() {
            $('#datepicker').datepicker({
                customDays: ['Sun', 'Mon', 'Tu', 'We', 'Th', 'Fr', 'Sa']
            });
        })
    </script>

    <!-- Checkout script -->
    <script>
        $('.select2').select2();

        function saveUser() {
            var url =  '{{ route('front.saveBooking') }}';
            var form = $('#personal-details');
            $.easyAjax({
                url: url,
                type: 'POST',
                container: '#personal-details',
                data: form.serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        if (response.action == "userCreated") {
                            //
                        }
                        else if(response.action == "bookingCreated") {
                            $('#accordion4').attr("data-bs-target","#collapse-payment");
                            $("#collapse-checkout").collapse('hide');
                            $("#collapse-payment").addClass('show');

                            $("#booking_id").val(response.booking);
                        }
                    }
                }
            })
        }

        function saveBooking() {
            $.easyAjax({
                url: '{{ route('front.saveBooking') }}',
                type: 'POST',
                container: '#booking',
                data: $('#booking').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        if (response.action == "userCreated") {
                            //
                        }
                        else if(response.action == "bookingCreated") {
                            $('#accordion4').attr("data-bs-target","#collapse-payment");
                            $("#collapse-checkout").collapse('hide');
                            $("#collapse-payment").addClass('show');

                            $("#booking_id").val(response.booking);
                            $("#bg-green-pay").addClass('bg-green');
                            $('#editcheck').append("<a class='text-dark f-17'><i class='las la-edit'></i></a>");
                            $('#bold-check').css('color','black');
                        }
                    }
                }
            });
        }

        // User verification
        @if ($smsSettings->nexmo_status == 'active' && $user && !$user->mobile_verified && !session()->has('verify:request_id'))
            sendOTPRequest();
        @endif

        var x = '';

        function clearLocalStorage() {
            localStorage.removeItem('otp_expiry');
            localStorage.removeItem('otp_attempts');
        }

        function checkSessionAndRemove() {
            $.easyAjax({
                url: '{{ route('removeSession') }}',
                type: 'GET',
                data: {'sessions': ['verify:request_id']}
            })
        }

        function startCounter(deadline) {
            x = setInterval(function() {
                var now = new Date().getTime();
                var t = deadline - now;

                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);

                $('#demo').html('Time Left: '+minutes + ":" + seconds);
                $('.attempts_left').html(`${localStorage.getItem('otp_attempts')} attempts left`);

                if (t <= 0) {
                    clearInterval(x);
                    clearLocalStorage();
                    checkSessionAndRemove();
                    location.href = '{{ route('front.cartPage') }}'
                }
            }, 1000);
        }

        if (localStorage.getItem('otp_expiry') !== null) {
            let localExpiryTime = localStorage.getItem('otp_expiry');
            let now = new Date().getTime();

            if (localExpiryTime - now < 0) {
                clearLocalStorage();
                checkSessionAndRemove();
            }
            else {
                $('#otp').focus().select();
                startCounter(localStorage.getItem('otp_expiry'));
            }
        }

        function sendOTPRequest() {
            $.easyAjax({
                url: '{{ route('sendOtpCode') }}',
                type: 'POST',
                container: '#request-otp-form',
                messagePosition: 'inline',
                data: $('#request-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        localStorage.setItem('otp_attempts', 3);

                        $('#verify-mobile').html(response.view);
                        $('.attempts_left').html(`3 attempts left`);

                        $('#otp').focus();

                        var now = new Date().getTime();
                        var deadline = new Date(now + parseInt('{{ config('vonage.settings.pin_expiry') }}')*1000).getTime();

                        localStorage.setItem('otp_expiry', deadline);
                        startCounter(deadline);
                        // intialize countdown
                    }
                    if (response.status == 'fail') {
                        $('#mobile').focus();
                    }
                }
            });
        }

        function sendVerifyRequest() {
            $.easyAjax({
                url: '{{ route('verifyOtpCode') }}',
                type: 'POST',
                container: '#verify-otp-form',
                messagePosition: 'inline',
                data: $('#verify-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        clearLocalStorage();

                        location.reload();
                        $('#verify-mobile-info').html('');

                        // select2 reinitialize
                        $('.select2').select2();
                    }
                    if (response.status == 'fail') {
                        // show number of attempts left
                        let currentAttempts = localStorage.getItem('otp_attempts');

                        if (currentAttempts == 1) {
                            clearLocalStorage();
                        }
                        else {
                            currentAttempts -= 1;

                            $('.attempts_left').html(`${currentAttempts} attempts left`);
                            $('#otp').focus().select();
                            localStorage.setItem('otp_attempts', currentAttempts);
                        }

                        if (Object.keys(response.data).length > 0) {
                            $('#verify-mobile').html(response.data.view);

                            // select2 reinitialize
                            $('.select2').select2();

                            clearInterval(x);
                        }
                    }
                }
            });
        }

        $('body').on('submit', '#request-otp-form', function (e) {
            e.preventDefault();
            sendOTPRequest();
        })

        $('body').on('click', '#request-otp', function () {
            sendOTPRequest();
        })

        $('body').on('submit', '#verify-otp-form', function (e) {
            e.preventDefault();
            sendVerifyRequest();
        })

        $('body').on('click', '#verify-otp', function() {
            sendVerifyRequest();
        })
    </script>

    @include("partials.currency_format")

@endpush


