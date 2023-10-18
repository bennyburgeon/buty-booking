
<h4>@lang('menu.googleMapApiKey')</h4>

<hr>

<form class="form-horizontal ajax-form" id="googleMapApiKeyForm" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-md-10 d-flex align-items-center">@lang('messages.nearbyLocation')</div>
                    </div>
            </div>
        </div>
        <div class="col-md-12">
            <!-- text input -->
            <div class="form-group">
                <label>@lang('menu.googleMapApiKey')<span class="required-span">*</span></label>
                <input type="text" class="form-control form-control-lg" name="google_map_api_key" >
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <button type="button" id="save-google-map-form" class="btn btn-success btn-light-round"><i
                            class="fa fa-check"></i> @lang('app.save')</button>
            </div>
        </div>
    </div>
</form>
