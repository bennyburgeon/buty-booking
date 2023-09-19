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
             <div class="col-md-5 h5" id="payment-modal-total">{{ $amount }}</div>
          </div>
       </div>
       <div class="form-group">
          <div class="form-check form-check-inline">
             <input class="form-check-input" checked type="radio" name="payment_gateway" id="pay-cash" value="cash">
             <label class="form-check-label" for="pay-cash">@lang('modules.booking.payViaCash')</label>
          </div>
          <div class="form-check form-check-inline">
             <input class="form-check-input" type="radio" name="payment_gateway" id="pay-card" value="card">
             <label class="form-check-label" for="pay-card">@lang('modules.booking.payViaCard')</label>
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
                <div class="col-md-12 h5" id="cash-remaining">-</div>
             </div>
             <div class="form-group col-md-6">
                <label for="">@lang('modules.booking.cashToReturn')</label>
                <div class="col-md-12 h5" id="cash-return">-</div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
    @lang('app.cancel')</button>
    <button type="button" id="submit-cart" class="btn btn-success"><i class="fa fa-check"></i>
    @lang('app.submit')</button>
 </div>

<script>
    $('#payment-modal').on('shown.bs.modal', function () {
        let count = {{currencyFormatSetting()->no_of_decimal}};
            $('#cash-given').val(globalCartTotal);
            $('#cash-return').html(currency_format(count));
            $('#cash-remaining').html(currency_format(count));
            $('#cash-given').select();
    });

    $('#cash-given').focus(function () {
        $(this).select();
    });

    function limitDecimalPlaces(e)
    {
        let count = {{currencyFormatSetting()->no_of_decimal}}; /* digits after decimal */
        if (e.target.value.indexOf('.') == -1) { return; }
        if ((e.target.value.length - e.target.value.indexOf('.')) > count) {
            e.target.value = parseFloat(e.target.value).toFixed(count);
        }
    }

    $('#cash-given').keyup(function () {
        let cashGiven = $(this).val();
        let count = {{currencyFormatSetting()->no_of_decimal}}

        if(cashGiven === ''){
            cashGiven = 0;
        }

        let total = $('#cart-total-input').val();
        let cashReturn = (parseFloat(total) - parseFloat(cashGiven)).toFixed(count);
        let cashRemaining = (parseFloat(total) - parseFloat(cashGiven)).toFixed(count);

        if(cashRemaining < 0 || cashGiven >= parseFloat(total)){
            cashRemaining = parseFloat(0).toFixed(count);
        }

        if(cashReturn < 0){
            cashReturn = 0;
        }
        else{
            cashReturn = parseFloat(0).toFixed(count);
        }

        $('#cash-return').html(cashReturn);
        $('#cash-remaining').html(cashRemaining);

    });

    $('#submit-cart').click(function () {
        let cashGiven = parseFloat($('.cash-given').val());
        let url = '{{route('admin.pos.store')}}';
        let bookingTime = $('#posTime').val();
        let cashRemaining = $("#cash-remaining").html();
        let cashRemainingNew = parseFloat(cashRemaining);
        let location = '{{ request()->location_id }}';

        let total = $('#payment-modal-total').html();
        total = total.slice(1);
        total = parseFloat(total);

        if(cashGiven == '' ){
            swal('@lang("Enter amount to pay")');
            $('#amount-error').html('@lang("Enter amount to pay")');
            return false;
        }
        else{
            $('#amount-error').html('');
        }

        if(cashGiven > total)
        {
            swal('@lang("modules.booking.amountNotMore")');

            $('#amount-error').html('@lang("modules.booking.amountNotMore")');
            return false;
        }
        else{
            $('#amount-error').html('');
        }

        $.easyAjax({
            url: url,
            container: '#pos-form',
            type: "POST",
            blockUI: true,
            data: $('#pos-form').serialize()+'&payment_gateway='+$('input[name="payment_gateway"]:checked').val()+'&pos_date='+pos_date+'&pos_time='+bookingTime+'&cash_remaining='+cashRemainingNew+'&cash_given='+cashGiven+'&location_id='+location,
            redirect: true,
            success: function (response) {
                $.unblockUI();
                $('#save-category').attr('disabled', true);
            }
        })
    });
</script>
