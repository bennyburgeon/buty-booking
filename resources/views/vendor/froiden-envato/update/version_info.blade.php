@php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
@php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())
<div class="table-responsive p-10">

    <table class="table table-bordered p-10">
        <thead>
        <th>@lang('modules.update.systemDetails')</th>
        </thead>
        <tbody>
        <tr>
            <td>App Version <span
                    class="pull-right">{{ $updateVersionInfo['appVersion'] }}</span></td>
        </tr>
        <tr>
            <td>Laravel Version <span
                    class="pull-right">{{ $updateVersionInfo['laravelVersion'] }}</span></td>
        </tr>
        <td>PHP Version
            @if (version_compare(PHP_VERSION, '7.2.5') > 0)
                <span class="pull-right">{{ phpversion() }} <i class="fa fa fa-check-circle text-success"></i></span>
            @else
                <span class="pull-right">{{ phpversion() }} <i data-bs-toggle="tooltip"
                                                               data-original-title="@lang('messages.phpUpdateRequired')"
                                                               class="fa fa fa-warning text-danger"></i></span>
            @endif
        </td>
        @if(!is_null($mysql_version))
            <tr>
                <td>{{ $databaseType }}
                    <span
                        class="pull-right">
                    {{ $mysql_version}}
                </span>
                </td>

            </tr>
        @endif
        @if(!is_null($envatoUpdateCompanySetting->purchase_code))
            <tr>
                <td>Envato Purchase code <span
                        class="pull-right">{{$envatoUpdateCompanySetting->purchase_code}}</span>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
