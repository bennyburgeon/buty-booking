<div class="modal-header">
    <h4 class="modal-title">@lang("app.testEmail")</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="testEmail" class="ajax-form" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang("app.testEmailLable")</label>
                    <input type="text" name="test_email" id="test_email" class="form-control form-control-lg" value="{{ auth()->user()->email }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="button" id="sendTestEmailSubmit" class="btn btn-success btn-light-round">@lang('app.submit')</button>
        </div>
    </form>
</div>
