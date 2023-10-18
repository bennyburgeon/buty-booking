@php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())

@if(!is_null($envatoUpdateCompanySetting->supported_until))
    <div class="" id="support-div">
        @if(\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->isPast())
            <div class="col-md-12 alert alert-danger ">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        Your support has been expired on <b><span
                                id="support-date">{{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->format('d M, Y')}}</span></b>
                    </div>

                    <div class="col-md-6 text-right">
                        @if(!$reviewed)
                            <a href="https://community.froiden.com/d/238-now-get-free-support-extension" target="_blank"
                               class="btn btn-success btn-small text-decoration-none">Extend Support for free <i
                                    class="fa fa-shopping-cart"></i></a>

                        @else
                            <a href="{{ config('froiden_envato.envato_product_url') }}" target="_blank"
                               class="btn btn-success btn-small text-decoration-none">Renew support <i
                                    class="fa fa-shopping-cart"></i></a>
                        @endif

                        <a href="javascript:;" onclick="getPurchaseData();"
                           class="btn btn-primary btn-small text-decoration-none">Refresh
                            <i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </div>

        @else
            <div class="col-md-12 alert alert-info">
                Your support will expire on <b><span
                        id="support-date">{{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->format('d M, Y')}}</span></b>
            </div>
        @endif
    </div>
@endif

@php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
@if(isset($updateVersionInfo['lastVersion']))
    <div class="alert alert-info col-md-12">
        <p> @lang('messages.updateAlert')</p>
        <p>@lang('messages.updateBackupNotice')</p>
    </div>

    <div class="alert alert-info">
        <div class="row">
            <div class="col-md-9"><i class="ti-gift"></i> @lang('modules.update.newUpdate') <label
                    class="label label-success">{{ $updateVersionInfo['lastVersion'] }}</label><br><br>
                <h5 class="text-white font-bold"><label class="label label-danger p-1">ALERT: </label> You will get logged
                    out after update. Login again to use the application.</h5>
            </div>
            <div class="col-md-3 text-center">
                <a id="update-app" href="javascript:;"
                   class="btn btn-success btn-small" style="text-decoration: none">@lang('modules.update.updateNow') <i
                        class="fa fa-download"></i></a>

            </div>

            <div class="col-md-12">
                <p>{!! $updateVersionInfo['updateInfo'] !!}</p>
            </div>
        </div>
    </div>

    <div id="update-area" class="m-t-20 m-b-20 col-md-12 white-box hide">
        Loading...
    </div>
@else
    <div class="alert alert-success col-md-12">
        <div class="col-md-12">You have latest version of this app.</div>
    </div>
@endif
