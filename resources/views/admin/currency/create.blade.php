<div class="modal-header">
    <h4 class="modal-title">@lang('app.add') @lang('app.currency')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
        <form class="form-horizontal ajax-form" id="currency-form" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label
                        class="control-label">@lang('app.currency') @lang('app.name')</label>

                        <input type="text" class="form-control form-control-lg"
                                id="currency_name" name="currency_name">
                    </div>

                    <div class="form-group">
                        <label class="control-label">@lang('app.currencySymbol')</label>

                            <input type="text" class="form-control form-control-lg"
                            id="currency_symbol" name="currency_symbol">
                    </div>

                    <div class="form-group">
                        <label class="control-label">@lang('app.currencyCode')</label>

                        <input type="text" class="form-control form-control-lg"
                                                                    id="currency_code" name="currency_code">
                    </div>
                </div>

            </div>
        </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
    <button type="button" id="save-currency" class="btn btn-success"><i class="fa fa-check"></i>
        @lang('app.submit')</button>
</div>

<script>
    $('#save-currency').click(function () {
        $.easyAjax({
            url: '{{route('admin.currency-settings.store')}}',
            container: '#currency-form',
            type: "POST",
            data: $('#currency-form').serialize(),
            success: function (response) {
                if (response.status == "success") {
                    window.location.reload();
                }
            }
        })
    });
</script>
