<h4>@lang('app.zoomCredentials') @lang('menu.settings')</h4>
<br>
<form class="form-horizontal ajax-form" id="zoom-form" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">

            <div class="form-group d-flex">
                <label class="switch">
                    <input type="checkbox" name="enable_zoom" id="enableZoom" {{ $zoomSetting->enable_zoom == 'active' ? 'checked' : '' }} value="active">
                    <span class="slider round"></span>
                </label>
                <label class="control-label ml-2" for="enable_zoom">@lang("modules.enableZoom")</label>
            </div>
        <div class="col-md-12 {{ $zoomSetting->enable_zoom == 'inactive' ? 'd-none' : '' }}" id="zoom_setting">
            <div class="form-group">
                <label
                class="control-label">@lang("modules.zoomKey")</label>
                <input type="text" name="zoom_api_key" id="zoom_api_key"
                class="form-control form-control-lg"
                value="{{ $zoomSetting->api_key }}">
            </div>
            <div class="form-group">
                <label
                class="control-label">@lang("modules.zoomSecret")</label>
                <input type="text" name="zoom_secret_key" id="zoom_secret_key"
                class="form-control form-control-lg"
                value="{{ $zoomSetting->secret_key }}">
            </div>

            <div class="form-group">
                <label>@lang("modules.openInZoom")?</label>
                <div class="form-group">
                <label class="radio-inline"> <input type="radio" class="checkbox get-driver"
                value="zoom_app"
                @if($zoomSetting->meeting_app == 'zoom_app') checked
                @endif
                name="meeting_app"> @lang("app.yes")</label>
                <label class="radio-inline pl-lg-2"> <input type="radio" class="checkbox get-driver"
                value="in_app"
                @if($zoomSetting->meeting_app == 'in_app') checked
                @endif
                name="meeting_app"> @lang("app.no")</label>
                </div>
            </div>

            <div class="form-group">
                <p class="text-primary"> @lang('app.webHookUrl'):-  {{ route('zoom-webhook') }}<br><span class='text-danger'>(@lang('messages.webHookUrl'))</span></p>
            </div>
        </div>

            <div class="form-group">
                <button id="save-zoom-setting" type="button" class="btn btn-success"><i
                class="fa fa-check"></i> @lang('app.save')</button>
            </div>
        </div>
        <!--/span-->
    </div>
</form>
