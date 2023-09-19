<div class="modal-header">
   <h4 class="modal-title">@lang('app.pay')</h4>
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
<div class="form-body">
<div class="row">
   <div class="col-md-12 ">
      <div class="form-group">
         <div class="row">
            <div class="col-md-1 h5">@lang('app.total'):</div>
            <div class="col-md-5 h5" id="payment-modal-total">{{ currencyFormatter($total) }}</div>
            <input type="hidden" value="{{ $remaining ?? false ? $remaining : '0' }}" id="remaining">
         </div>
      </div>
      <div class="form-group">
         <div class="form-check form-check-inline">
            <input class="form-check-input" checked type="radio" name="payment_gateway"
               id="pay-cash" value="cash">
            <label class="form-check-label"
               for="pay-cash">@lang('modules.booking.payViaCash')</label>
         </div>
         <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_gateway" id="pay-card"
               value="card">
            <label class="form-check-label"
               for="pay-card">@lang('modules.booking.payViaCard')</label>
         </div>
      </div>
      <div id="cash-mode">
         <div class="form-group">
            <label for="">@lang('modules.booking.cashGivenByCustomer')</label>
            <input oninput="limitDecimalPlaces(event)" type="number" min="0" step=".01" class="form-control form-control-lg cash-given" id="cash-given">
            <div id="amount-error" class="invalid-feedback"></div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               <label for="">@lang('modules.booking.cashRemaining')</label>
               <input type="hidden" id="remaining_amount" value="{{ $remaining }}">
               <div class="col-md-12 h5" id="cash-remaining">{{ currencyFormatter($remaining) }}</div>
            </div>
         </div>
      </div>
   </div>
</div>
<input type="hidden" id="booking-id" value="{{ $bookingId }}">
<div class="modal-footer">
   <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
   @lang('app.cancel')</button>
   <button type="button" id="submit-payment" class="btn btn-success"><i class="fa fa-check"></i>
   @lang('app.submit')</button>
</div>


<script>
     $('#payment-modal').on('shown.bs.modal', function () {
            $('#cash-given').val(globalCartTotal);
            $('#cash-remaining').html(currency_format(0.00));
            $('#cash-given').select();
        });

        $('#cash-given').focus(function () {
            $(this).select();
        })

        function limitDecimalPlaces(e)
        {
            let count = 2; /* digits after decimal */
            if (e.target.value.indexOf('.') == -1) { return; }
            if ((e.target.value.length - e.target.value.indexOf('.')) > count) {
                e.target.value = parseFloat(e.target.value).toFixed(count);
            }
        }

        $('#cash-given').keyup(function () {
            let cashGiven = $(this).val();

            if(cashGiven === ''){
                cashGiven = 0;
            }

            let total = $('#remaining').val();
            let cashReturn = (parseFloat(total) - parseFloat(cashGiven)).toFixed(2);
            let cashRemaining = (parseFloat(total) - parseFloat(cashGiven)).toFixed(2);
            if(cashRemaining < 0 || cashGiven >= parseFloat(total)){
                cashRemaining = parseFloat(0).toFixed(2);
            }

            if(cashReturn < 0){
                cashReturn = Math.abs(cashReturn);
            }
            else{
                cashReturn = parseFloat(0).toFixed(2);
            }

            $('#remaining_amount').val(cashRemaining);
            $('#cash-remaining').html(currency_format(cashRemaining));

        });

        $('#submit-payment').on('click', function () {
            let bookingId = $('#booking-id').val();
            let total = parseFloat($('#remaining').val());
            let cashGiven = parseFloat($('.cash-given').val());
            let url = '{{route('admin.bookings.add_payment')}}';
            let bookingTime = $('#posTime').val();
            let cashRemaining = $('#remaining_amount').val();
            var token = "{{ csrf_token() }}";

            if(cashGiven == '' ){
                swal('@lang("Enter amount to pay")');
                $('#amount-error').html('@lang("Enter amount to pay")');
                return false;
            }
            else{
                $('#amount-error').html('');
            }

            if (cashGiven > total) {
                swal("Paying amount can not be greater than pending amount");
                return false;
            }

            $.easyAjax({
                type: 'GET',
                url: url,
                data: {'_token': token, 'payment_gateway': $('input[name="payment_gateway"]:checked').val(), 'pos_time': bookingTime, 'cash_given': cashGiven, 'cash_remaining': cashRemaining, 'booking_id': bookingId, 'total': total
                },
            })
        });

</script>
@include("partials.currency_format")

