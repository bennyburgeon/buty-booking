@extends('layouts-new.front')

@push('styles')
    <style>
        /* Add custom CSS here */

    </style>
@endpush

@section('content')
    <section class="bg-white py-100">
        <div class="container">
            <div class="row ">
                <div class="col-lg-9 m-auto col-12">
                    <form class="contact-form p-3 p-lg-5 p-md-5" id="contact_form" method="post">
                        @csrf
                        <div class="row">
                            <div class="heading text-center">
                                <h3 class="font-weight-bold">@lang('front.headings.payment')</h3>
                                <br><br><br>

                                @if ($message = session()->get('success'))
                                    <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-success">{!! $message !!}</p>
                                    {{ session()->forget('success') }}
                                @endif

                                @if ($message = session()->get('error'))
                                    <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-danger">{!! $message !!}</p>
                                @endif

                            </div>
                        </div>
                        <br><br>

                        @if ($message = session()->get('error') && $credentials->show_payment_options == 'show')
                            <div class="row">
                                <h5 class="font-weight-bold text-center">@lang('front.payAgainNote')</h5>
                                @if ($credentials->stripe_status == 'active')
                                    <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                        <a href="javascript:;" id="stripePaymentButton"
                                            class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                            <i class="lab la-stripe"></i>
                                            <p>@lang('front.buttons.payVia') @lang('front.buttons.stripe')</p>
                                        </a>
                                    </div>
                                @endif
                                @if ($credentials->paypal_status == 'active')
                                    <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                        <a href="{{ route('front.paypal') }}"
                                            class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                            <i class="lab la-paypal"></i>
                                            <p>@lang('front.buttons.payVia') @lang('front.buttons.paypal')</p>
                                        </a>
                                    </div>
                                @endif
                                @if ($credentials->paystack_status == 'active')
                                    <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                        <a href="javascript:;" onclick="payWithPaystack();" id="paystackPaymentButton"
                                            class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                            <i class="las la-money-bill-wave"></i>
                                            <p>@lang('front.buttons.payVia') @lang('front.buttons.paystack')</p>
                                        </a>
                                    </div>
                                @endif
                                @if ($credentials->razorpay_status == 'active')
                                    <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                        <a href="javascript:startRazorPayPayment();"
                                            class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                            <i class="las la-money-bill-wave-alt"></i>
                                            <p>@lang('front.buttons.payVia') @lang('front.buttons.razorpay')</p>
                                        </a>
                                    </div>
                                @endif
                                @if ($credentials->offline_payment == 1 && $booking->booking_type != 'online')
                                    <div class="col-md-4 mb-sm-0 mb-3 mt-3">
                                        <a href="{{ route('front.offline-payment') }}" class="w-100 d-block text-center bg-secondary p-4 rounded text-grey">
                                            <i class="las la-money-bill"></i>
                                            <p>@lang('front.buttons.offlinePayment')</p>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="row mt-30">
                            <div class="col-md-12 d-flex justify-content-center">
                                <a href="{{ route('front.index') }}" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex">
                                    <i class="las la-home f-18 mr-2"></i> @lang('front.navigation.backToHome')
                                </a>
                                <a href="{{ route('admin.bookings.index') }}" target="_blank" class="outline-btn btn-md mt-4 btn f-13 h-30 d-flex ml-4">
                                    <i class="las la-clock f-18 mr-1"></i>@lang('front.viewRecentOrders')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    @if($credentials->razorpay_status == 'active')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            var options = {
                "key": "{{ $credentials->razorpay_key }}", // Enter the Key ID generated from the Dashboard
                "amount": "{{ $booking->amount_to_pay * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
                "currency": "INR",
                "name": "{{ $booking->user->name }}",
                "description": "@lang('app.booking') @lang('front.headings.payment')",
                "image": "{{ $settings->logo_url }}",
                "handler": function (response){
                    confirmRazorPayPayment(response.razorpay_payment_id, '{{ $booking->id }}', response);
                },
                "prefill": {
                    "email": "{{ $booking->user->email }}",
                    "contact": "{{ $booking->user->mobile }}"
                },
                "notes": {
                    "booking_id": "{{ $booking->id }}"
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

            function confirmRazorPayPayment(paymentId, bookingId, response) {
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
        </script>
    @endif

    @if($credentials->stripe_status == 'active')
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            var token_triggered = false;
            var handler = StripeCheckout.configure({
                key: '{{ $credentials->stripe_client_id }}',
                image: '{{ $settings->logo_url }}',
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
                        url: '{{route('front.stripe', [$booking->id])}}',
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
                    amount: {{ $booking->total*100 }},
                    currency: '{{ $setting->currency->currency_code }}',
                    email: "{{ $user->email }}"
                });
                $.easyBlockUI('.statusSection');
                e.preventDefault();
            });

            // Close Checkout on page navigation:
            window.addEventListener('popstate', function() {
                handler.close();
            });
        </script>
    @endif

    @if ($credentials->paystack_status == 'active')
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            // const paymentForm = document.getElementById('paystackPaymentButton');
            // paymentForm.addEventListener("submit", payWithPaystack, false);
            function payWithPaystack(e) {
                var handler = PaystackPop.setup({
                    key: '{{ $credentials->paystack_public_id }}',
                    email: '{{ $booking->user->email }}',
                    amount: '{{ $booking->amount_to_pay * 100 }}',
                    onClose: function(){
                        // window.location.reload();
                        $.easyUnblockUI('.statusSection');
                    },
                    callback: function(response){
                        $.easyBlockUI('.statusSection');

                        let id = '{{$booking->id}}';
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
        </script>
    @endif

@endpush
