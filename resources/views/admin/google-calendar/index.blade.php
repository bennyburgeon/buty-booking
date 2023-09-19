@push('head-css')
    <style>
        .removeNotifaction {
            padding: 9px;
            margin-top: 7px;
        }

        .status-badge {
                border-radius: 100px;
            }
    </style>
@endpush
@if (Session::has('message'))
    <p class="alert alert-success">{{ Session::get('message') }}</p>
@endif

<h4>@lang('menu.googleCalendar') @lang('menu.configuration')</h4>

<hr>
<form class="form-horizontal ajax-form" id="googleCalendarConfigForm" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-secondary">@lang('app.showGoogleCalendarOption')</h5>
            <div class="form-group">
                <label class="control-label">@lang("app.allowGoogleCalendarOption")</label>
                <br>
                <label class="switch">
                    <input type="checkbox" name="google_calendar" id="google_calendar"
                        {{ $settings->google_calendar == 'active' ? 'checked' : '' }} value="active">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="col-md-12 {{ $settings->google_calendar == 'deactive' ? 'd-none' : '' }}"
            id="google_calendar_config_option">
            <div class="form-group">
                <label for="google_client_id" class="control-label">@lang('app.ClientId')</label>
                <input type="text" class="form-control  form-control-lg" id="google_client_id" name="google_client_id"
                    value="{{ $settings->google_client_id }}">
            </div>
            <div class="form-group">
                <label for="google_client_secret" class="control-label">@lang('app.ClientSecret')</label>
                <input type="password" class="form-control  form-control-lg" id="google_client_secret"
                    name="google_client_secret" value="{{ $settings->google_client_secret }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button id="saveGoogleCalendarConfigForm" type="button" class="btn btn-success"><i
                        class="fa fa-check"></i>
                    @lang('app.save')</button>
            </div>
        </div>
    </div>
</form>


@if ($settings->google_calendar == 'active')

    <hr>
    <div class="row mt-4">
        <div class="col-md-6">
            <h5 class="text-info">@lang('menu.googleCalendar')</h5>
            <a href="{{ route('googleAuth') }}"> <button type="button" class="btn btn-success mt-1">
                    <i class="fa fa-play"></i>
                    @if ($settings->google_id) @lang('app.change')
                        @lang('menu.googleCalendar') @lang('app.account')
                    @else @lang('app.connect') @lang('menu.googleCalendar') @lang('app.account')@endif
                </button>
            </a>
            @if ($settings->google_id)
                <button type="button" id="googleCalendarDisconnect" class="btn btn-danger mt-1">
                    @lang('app.disconnect') @lang('menu.googleCalendar') </button>

            @endif
        </div>

        <div class="col-md-3">
            <h5 class="text-info">@lang('app.status')</h5>
            <div class="form-group">
                <span
                    class="badge status-badge {{ $settings->google_id ? 'bg-success' : 'badge-danger' }}">{{ $settings->google_id ? __('app.connected') : __('app.notConnected') }}</span>
            </div>
        </div>

    </div>
    @if ($settings->google_id)
        <br>
        <form class="form-horizontal ajax-form" id="bookingNotifactionForm" method="POST">
            @csrf
            <div class="field_wrapper">
                @foreach ($companyBookingNotifaction as $notifaction)
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="duration" class="control-label">@lang("app.duration")</label>
                                <input type="number" class="form-control form-control-lg" name="duration[]" min="1"
                                    value="{{ $notifaction->duration }}">
                            </div>
                        </div>
                        <div class="col-5">
                            <label for="duration_type" class="control-label">@lang("app.durationType")</label>
                            <select name="duration_type[]" class="form-control form-control-lg">
                                <option value="minutes"
                                    {{ $notifaction->duration_type == 'minutes' ? 'selected' : '' }}>
                                    @lang("app.minutes")
                                </option>
                                <option value="hours" {{ $notifaction->duration_type == 'hours' ? 'selected' : '' }}>
                                    @lang("app.hours")
                                </option>
                                <option value="days" {{ $notifaction->duration_type == 'days' ? 'selected' : '' }}>
                                    @lang("app.days")
                                </option>
                                <option value="weeks" {{ $notifaction->duration_type == 'weeks' ? 'selected' : '' }}>
                                    @lang("app.weeks")
                                </option>
                            </select>
                        </div>
                        <div class="col-1 pt-4">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-circle removeNotifaction"
                                data-row-id="{{ $notifaction->id }}"><i class="fa fa-times"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="row addNotifaction {{ $companyBookingNotifaction->count() >= 2 ? 'd-none' : '' }}">
                <button type="button" id="addNotifaction" class="btn btn-link">@lang("app.addMoreMotification")</button>
            </div>
            <div id="bookingNotifactionFormBtn"
                class="row {{ $companyBookingNotifaction->count() == 0 ? 'd-none' : '' }}">
                <div class="col-md-12">
                    <div class="form-group">
                        <button id="saveBookingNotifactionForm" type="button" class="btn btn-success"><i
                                class="fa fa-check"></i> @lang('app.save')</button>
                    </div>
                </div>
            </div>
        </form>
    @endif
@endif
