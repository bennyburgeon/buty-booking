@extends('layouts.master')

@push('head-css')
    <style>
        #do-payment{
            margin-left: -50px;
        }
    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
       <div class="card card-dark">
          <div class="card-header">
             @if ($current_url == 'backend')
             <div>
                <h4 class="modal-title">@lang('app.bookingDetail')</h4>
             </div>
             @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
             <div class="row">
                <div class="col-md-12 text-right mt-2 mb-2">
                   @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('update_booking') && $user->roles()->withoutGlobalScopes()->first()->name != 'customer' && $current_emp_role->name != 'customer' && $booking->status != 'completed' && $booking->status != 'canceled')
                   <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-primary edit-booking" data-booking-id="{{ $booking->id }}"><i class="fa fa-edit"></i> @lang('app.edit')</a>
                   @endif
                   @if ($booking->status == 'pending')
                   @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking') && $booking->date_time!='' && \Carbon\Carbon::parse($booking->date_time)->greaterThanOrEqualTo(\Carbon\Carbon::now()) && $current_emp_role->name != 'customer')
                   <a href="javascript:;" data-booking-id="{{ $booking->id }}" class="btn btn-outline-dark btn-sm send-reminder"><i class="fa fa-send"></i> @lang('modules.booking.sendReminder')</a>
                   @endif
                   @endif
                   @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('update_booking') && $booking->status != 'completed' && $booking->status != 'canceled')
                   <button class="btn btn-sm btn-outline-danger cancel-row" data-row-id="{{ $booking->id }}" type="button"><i class="fa fa-times"></i> @lang('modules.booking.requestCancellation')</button>
                   @endif
                </div>
                <div class="col-md-12 text-center mb-3">
                   <img src="{{ $booking->user->user_image_url }}" class="border img-bordered-sm img-circle" height="70em" width="70em">
                   <h6 class="text-uppercase mt-2">{{ ucwords($booking->user->name) }}</h6>
                </div>
             </div>
             <div class="row">
                <div class="col-md-6 border-right">
                   <strong>@lang('app.email')</strong> <br>
                   <p class="text-muted"><i class="icon-email"></i> {{ $booking->user->email ?? '--' }}</p>
                </div>
                <div class="col-md-6">
                   <strong>@lang('app.mobile')</strong> <br>
                   <p class="text-muted"><i class="icon-mobile"></i> {{ $booking->user->mobile ? $booking->user->formatted_mobile : '--' }}</p>
                </div>
             </div>
             <hr>
             @if ($booking->deal_id!='')
             <div class="row">
                <div class="col-md-12 border-right"> <strong>@lang('app.deal') @lang('app.name')</strong> <br>
                   <a data-bs-toggle="tooltip" data-original-title="@lang('app.view') @lang('app.deal')" href="{{ route('admin.deals.index') }}">{{$booking->deal->title}}</a>
                </div>
             </div>
             <hr>
             <div class="row">
                <div class="col-md-6 border-right">
                   <strong>@lang('app.deal') @lang('app.location')</strong> <br>
                   <p> {{$booking->deal->location->name}} </p>
                </div>
                <div class="col-md-6 border-right">
                   <strong>@lang('app.deal') @lang('app.quantity')</strong> <br>
                   <p> {{$booking->deal_quantity}} </p>
                </div>
             </div>
             <hr>
             @endif
             <div class="row">
                <div class="col-sm-4 border-right">
                   <strong>@lang('app.booking') @lang('app.date')</strong> <br>
                   <p class="text-primary"><i class="icon-calendar"></i>
                      @if ($booking->date_time != '')
                      {{  \Carbon\Carbon::parse($booking->date_time)->format($settings->date_format) }}
                      @endif
                   </p>
                </div>
                <div class="col-sm-4 border-right">
                   <strong>@lang('app.booking') @lang('app.time')</strong> <br>
                   <p class="text-primary"><i class="icon-alarm-clock"></i>
                      @if ($booking->date_time != '')
                      {{ $booking->date_time }}
                      @endif
                   </p>
                </div>
                <div class="col-sm-4"> <strong>@lang('app.booking') @lang('app.status')</strong> <br>
                   <span class="text-uppercase small border
                      @if($booking->status == 'completed') border-success text-success @endif
                      @if($booking->status == 'pending') border-warning text-warning @endif
                      @if($booking->status == 'approved') border-info text-info @endif
                      @if($booking->status == 'in progress') border-primary text-primary @endif
                      @if($booking->status == 'canceled') border-danger text-danger @endif
                      badge-pill">{{ __('app.'.$booking->status) }}</span>
                </div>
             </div>
             <hr>
             @if(count($booking->users)>0)
             <div class="row">
                <div class="col-sm-12">
                   <strong>@lang('menu.employee') </strong> <br>
                   <p class="text-primary" style="margin: 0.2em">
                      @foreach ($booking->users as $user)
                      &nbsp;&nbsp;&nbsp;  <i class="icon-user"></i> {{$user->name}}
                      @endforeach
                   </p>
                </div>
             </div>
             <hr>
             @endif

             @if($booking->booking_type === 'online' && $meeting && ($meeting->start_link || $meeting->join_link))
             <div class="row">
                 <div class="col-sm-6 border-right"> <strong>@lang('app.bookingType')</strong> <br>
                     <p class="text-success"><i class="icon-active"></i>
                         @lang('app.online')
                     </p>
                 </div>
                 <div class="col-sm-6 text-center"> <br>
                     @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('create_booking') && $user->roles()->withoutGlobalScopes()->first()->name != 'customer' && $booking->users->first()->id === Auth::user()->id && $booking->status === 'approved')
                         <a href='{{ $meeting->start_link }}' target="_blank" class="btn btn-primary btn-sm">@lang('app.startMeeting')</a>
                     @elseif($booking->status === 'approved' && $booking->user->id === Auth::user()->id)
                         <a href='{{ $meeting->join_link }}' target="_blank" class="btn btn-primary btn-sm">@lang('app.joinMeeting')</a>
                     @endif
                 </div>
             </div>
             <hr>
         @endif
             <div class="row">
                <div class="col-md-12">
                   <table class="table table-condensed">
                      <thead class="bg-secondary">
                         <tr>
                            <th>#</th>
                            <th>@lang('app.item')</th>
                            <th>@lang('app.unitPrice')</th>
                            <th>@lang('app.quantity')</th>
                            <th class="text-right">@lang('app.amount')</th>
                            {{--
                            <th class="text-right">@lang('app.amount remaining')</th>
                            --}}
                         </tr>
                      </thead>
                      <tbody>
                         @foreach($booking->items as $key=>$item)
                         <tr>
                            <td>{{ $key+1 }}.</td>
                            <td>{{ ucwords(is_null($item->business_service_id) ? $item->product->name : $item->businessService->name) }}<br>
                               <small>@if(is_null($item->business_service_id)) @lang('app.product') @else @lang('app.service') @endif</small>
                            </td>
                            <td>{{ currencyFormatter(number_format((float)$item->unit_price, 2, '.', '')) }}</td>
                            <td>x{{ $item->quantity }}</td>
                            @if ($booking->deal_id!='')
                            <td class="text-right">{{ currencyFormatter(number_format((float)($item->unit_price  * $item->quantity * $booking->deal_quantity), 2, '.', ''))}}</td>
                            @else
                            <td class="text-right">{{ currencyFormatter(number_format((float)(is_null($item->business_service_id) ? $item->product->discounted_price * $item->quantity : $item->businessService->discounted_price  * $item->quantity), 2, '.', ''))}}</td>
                            @endif
                            {{--
                            <td class="text-right">{{ currencyFormatter($booking->amountDue()) }}</td>
                            --}}
                         </tr>
                         @endforeach
                      </tbody>
                   </table>
                </div>

                <div class="col-md-7">
                   <div class="row">
                      <div class="col-md-12">
                        <tr>
                            <td>
                               @if ($user->can('update_booking'))
                               @if($booking->payment_status == 'pending')
                               <div class="col-md-12 text-left ml-5">
                                  <button type="button" id="do-payment"
                                     class="btn btn-sm btn-outline-primary" data-booking-id="{{ $booking->id }}"><i class="fa fa-plus"></i>@lang('app.addPayment')</button>
                                  <div id="cart-item-error" class="invalid-feedback"></div>
                               </div>
                               @endif
                               @if($booking->payment_status == 'partial_payment')
                               <div class="col-md-12 text-left ml-5">
                                  <button type="button" id="do-payment"
                                     class="btn btn-sm btn-outline-primary" data-booking-id="{{ $booking->id }}"><i class="fa fa-plus"></i>@lang('app.addPayment')</button>
                                  <div id="cart-item-error" class="invalid-feedback"></div>
                               </div>
                               @endif
                               @endif
                            </td>
                         </tr>
                         <table class="table table-condensed">
                            <thead class="bg-secondary">
                               <tr>
                                  <th>#</th>
                                  <th>@lang('app.date')</th>
                                  <th>@lang('modules.booking.paymentMethod')</th>
                                  <th>@lang('app.amountPaid')</th>
                               </tr>
                            </thead>
                            <tbody>
                               @foreach ($booking->bookingPayments as $key => $payment)
                               <tr>
                                  <td>{{ ++$key  }}.</td>
                                  <td>{{ \Carbon\Carbon::parse($payment->paid_on)->translatedFormat($settings->date_format) }}</td>
                                  <td>{{ $payment->gateway }}</td>
                                  <td>{{ ($payment->amount_paid != 0) ? currencyFormatter($payment->amount_paid) : currencyFormatter(0) }}</td>
                               </tr>
                               @endforeach
                            </tbody>
                            @if ($commonCondition)
                            <tr>
                               <td colspan="2">
                                  <div class="payment-type">
                                     <h5>@lang('front.paymentMethod')</h5>
                                     <div class="payments text-center d-flex">
                                        @if($credentials->stripe_status == 'active')
                                        <a href="javascript:;" id="stripePaymentButton" data-bookingId="{{ $booking->id }}" class="btn btn-custom btn-blue mb-2"><i class="fa fa-cc-stripe mr-2"></i>@lang('front.buttons.stripe')</a>
                                        @endif
                                        @if($credentials->paypal_status == 'active')
                                        <a href="{{ route('front.paypal', $booking->id) }}" class="btn btn-custom btn-blue mb-2"><i class="fa fa-paypal mr-2"></i>@lang('front.buttons.paypal')</a>
                                        @endif
                                        @if($credentials->paystack_status == 'active' && $booking->amount_to_pay > 0)
                                        <a href="javascript:;" onclick="payWithPaystack();" class="btn btn-custom btn-blue mb-2"><i class="fa fa-money mr-2"></i>@lang('front.buttons.paystack')</a>
                                        @endif
                                        @if($credentials->razorpay_status == 'active')
                                        <a href="javascript:startRazorPayPayment();" class="btn btn-custom btn-blue mb-2"><i class="fa fa-card mr-2"></i>@lang('front.buttons.razorpay')</a>
                                        @endif
                                     </div>
                                  </div>
                               </td>
                            </tr>
                            @endif
                            @if($booking->status == 'completed')
                            <tr>
                               <td>
                                  <a target="_blank" href="{{ route('admin.bookings.print', $booking->id) }}" class="btn btn-outline-info btn-sm"><i class="fa fa-print"></i> @lang('app.print') @lang('app.receipt')</a>
                               </td>
                               <td>
                                  <a href="{{ route('admin.bookings.download', $booking->id) }}" class="btn btn-success btn-sm"><i class="fa fa-download"></i> @lang('app.download') @lang('app.receipt')</a>
                               </td>
                            </tr>
                            @endif
                         </table>
                      </div>
                   </div>
                </div>
                <div class="col-md-5 amountDetail">
                   <div class="row">
                      <div class="col-md-12">
                         <table class="table table-condensed">
                            <tr class="h6">
                               <td class="border-top-0">@lang('app.serviceTotal')</td>
                               <td class="border-top-0">{{ currencyFormatter(number_format((float)$booking->original_amount, 2, '.', '')) }}</td>
                            </tr>
                            @if($booking->discount > 0)
                            <tr class="h6">
                               <td>@lang('app.discount')</td>
                               <td>{{ currencyFormatter(number_format((float)$booking->discount, 2, '.', '')) }}</td>
                            </tr>
                            @endif
                            @if ($booking->product_amount > 0)
                            <tr class="h6">
                               <td class="border-top-0">@lang('app.productSubTotal')</td>
                               <td class="border-top-0">{{ currencyFormatter(number_format((float)$booking->product_amount, 2, '.', '')) }}</td>
                            </tr>
                            @endif
                            @if($booking->coupon_discount > 0)
                            <tr class="h6">
                               <td>@lang('app.couponDiscount') (<a href="javascript:;" onclick="showCoupon();" class="show-coupon">{{ $booking->coupon->title}}</a>)</td>
                               <td>{{ currencyFormatter(number_format((float)$booking->coupon_discount, 2, '.', '')) }}</td>
                            </tr>
                            @endif
                            @if($booking->tax_amount > 0)
                            <tr class="h6">
                               <td>@lang('app.totalTax')</td>
                               <td>{{ currencyFormatter(number_format((float)$booking->tax_amount, 2, '.', '')) }}</td>
                            </tr>
                            @endif
                            <tr class="h6">
                               <td>@lang('app.total')</td>
                               <td id="total-amount">{{ currencyFormatter(number_format((float)$booking->amount_to_pay, 2, '.', '')) }}
                                  <input type="hidden" id="hidden-total-amount" value="{{ number_format((float)$booking->amount_to_pay, 2, '.', '') }}">
                               </td>
                            </tr>
                            <tr class="h6">
                               <td>@lang('app.total') @lang('app.paid')</td>
                               <td id="amount-paid">{{ currencyFormatter(number_format((float)$booking->amountPaid(), 2, '.', '')) }}</td>
                            </tr>
                            <tr class="h6">
                               <td>@lang('app.amountRemaining')</td>
                               <td id="amount-remaining">{{ currencyFormatter(number_format((float)$booking->amountDue(), 2, '.', '')) }}
                                  <input type="hidden" id="hidden-amount-remaining" value="{{ number_format((float)$booking->amountDue(), 2, '.', '') }}">
                               </td>
                            </tr>
                            <tr class="h6">
                               <td>@lang('modules.booking.paymentStatus')</td>
                               <td>
                                  @if($booking->payment_status == 'completed')
                                  <span class="text-success  font-weight-normal"><i class="fa fa-circle"></i> {{ __('app.'.$booking->payment_status) }}</span>
                               </td>
                               @endif
                               @if($booking->payment_status == 'pending')
                                <span class="text-secondary font-weight-normal"><i class="fa fa-circle"></i> {{ __('app.'.$booking->payment_status) }}</span></td>
                               @endif
                                 @if($booking->payment_status == 'partial_payment')
                               <span class="text-warning font-weight-normal"><i class="fa fa-circle"></i> {{ __('app.'.$booking->payment_status) }}</span></td>
                               @endif
                            </tr>
                         </table>
                      </div>
                   </div>
                </div>
                @if(!is_null($booking->additional_notes))
                <div class="col-md-12 font-italic">
                   <h4 class="text-info">@lang('modules.booking.additionalNote')</h4>
                   <p class="text-lg">
                      {!! $booking->additional_notes !!}
                   </p>
                </div>
                @endif
                <!-- Don't remove below commented code -->
                <!-- Start Customer Feedback -->
                {{-- @if ($booking->status == 'completed' && !$user->is_admin)
                <div class="col-md-12 font-italic">
                   <h4 class="text-info cust_feedback_msg_title @if ($booking->feedback == null) d-none @endif">
                      @lang('modules.booking.feedbackMessage')
                   </h4>
                   <a href="javascript:;" onclick="giveFeedback()" class="text-lg custFeedback @if ($booking->feedback != null) d-none @endif">
                   @lang('modules.booking.giveFeedback')</a>
                   <h4 class="text-info custFeedbackSmileys @if ($booking->feedback !== null) d-none @endif">
                      &#128544;&#128542;&#128528;&#128522;&#128516;
                   </h4>
                   <p class="cust_feedback_msg @if ($booking->feedback == null) d-none @endif">
                      {{ $booking->feedback ? $booking->feedback->feedback_message : ''}}
                   </p>
                </div>
                @endif --}}
                <!-- End Customer Feedback -->
                {{--coupon detail Modal--}}
                <div class="modal fade bs-modal-lg in" id="coupon-detail-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                   <div class="modal-dialog modal-lg" id="modal-data-application">
                      <div class="modal-content">
                         <div class="modal-header">
                            <h4 class="modal-title">@lang('app.coupon')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         </div>
                         <div class="modal-body">
                         </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> @lang('app.close')</button>
                         </div>
                      </div>
                      <!-- /.modal-content -->
                   </div>
                   <!-- /.modal-dialog -->
                </div>
                {{--coupon detail Modal Ends--}}
             </div>
          </div>
       </div>
    </div>
 </div>
 @if ($current_url == 'backend')
 <div class="modal-footer">
    <a href="/account/bookings" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>@lang('app.cancel')</a>
 </div>
 @endif
@endsection

@push('footer-js')
    <script>
        @if($booking->coupon_discount > 0)
            function showCoupon () {
                var url = '{{ route('admin.coupons.show', $booking->coupon_id)}}';
                $('#modelHeading').html('Show Coupon');
                $.ajaxModal('#coupon-detail-modal', url);
            }
        @endif

        @if ($booking->status == 'completed' && !$user->is_admin)
            function giveFeedback () {
                var url = '{{ route('admin.give-feedback', $booking->id)}}';
                $.ajaxModal('#coupon-detail-modal', url);
            };
        @endif

    </script>

    @if ($credentials->paystack_status == 'active' && $commonCondition)
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            function payWithPaystack(e) {
                var handler = PaystackPop.setup({
                    key: '{{ $credentials->paystack_public_id }}', // Replace with your public key
                    email: '{{ $booking->user->email }}',
                    amount: '{{ $booking->amount_to_pay * 100 }}',

                    onClose: function(){
                        window.location.reload();
                    },
                    callback: function(response){
                        let id = '{{$booking->id}}';
                        let url = "{{ route('front.paystackCallback',':id') }}";
                        url = url.replace(':id', id);

                        $.easyAjax({
                            url: url,
                            type: "GET",
                            redirect: true,
                            data: {"_token" : "{{ csrf_token() }}",
                                "reference" : response,
                                'return_url' :  '{{ $current_url }}',
                            },
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

    @if($credentials->stripe_status == 'active' && $commonCondition)
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
                        url: '{{route('front.stripe', $booking->id)}}',
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
                    amount: {{ $booking->amount_to_pay * 100 }},
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

    @if($credentials->razorpay_status == 'active' && $commonCondition)
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
                    container: 'body',
                    redirect: true
                });
            }

        </script>
    @endif

    {{-- open payment modal --}}
    <script>
        $('#do-payment').click(function () {
            let bookingId = $(this).data('booking-id');
            let total = $('#hidden-total-amount').val();
            let totalRemaining = $('#hidden-amount-remaining').val();

            // var url = "{{ route('admin.pos.show-payment-modal',':total') }}?type=amount";
            let url = "{{ route('admin.pos.show-payment-modal') }}?bookingId="+bookingId+"&total="+total+"&totalRemaining="+totalRemaining;
            url = url.replace(':bookingId', bookingId);
            url = url.replace(':total', total);
            url = url.replace(':totalRemaining', totalRemaining);

            $(modal_lg + ' ' + modal_heading).html('pay');
            $.ajaxModal(modal_lg, url);
        });

        $('body').on('click', '.cancel-row', function(){
        var id = $(this).data('row-id');
        swal({
            icon: "warning",
            buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
            dangerMode: true,
            title: "@lang('errors.areYouSure')",
        })
        .then((willDelete) => {
            if (willDelete) {
                var url = "{{ route('admin.bookings.requestCancel',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    blockUI: true,
                    data: {'_token': token, '_method': 'POST', 'current_url': 'booking_url'},
                    success: function (response) {
                        if (response.status == "success") {
                            location.reload();
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.send-reminder', function () {
        let bookingId = $(this).data('booking-id');

        $.easyAjax({
            type: 'POST',
            url: '{{ route("admin.bookings.sendReminder") }}',
            data: {bookingId: bookingId, _token: '{{ csrf_token() }}'}
        });
    });

    </script>
@include("partials.currency_format")

@endpush
