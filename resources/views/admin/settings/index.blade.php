@extends('layouts.master')

@push('head-css')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">
    <link href="{{asset('css/croppie.min.css')}}" rel="stylesheet">
    <style>
        .dropify-wrapper, .dropify-preview, .dropify-render img {
            background-color: var(--sidebar-bg) !important;
        }
        #carousel-image-gallery .card .img-holder {
            height: 150px;
            overflow: hidden;
        }
        #carousel-image-gallery .card .img-holder img {
            height: 100%;
            object-fit: cover;
            object-position: top;
        }
        .select2-container {
            width: 100% !important;
        }
        .note-group-select-from-files {
            display: none;
        }
        .select2-container .select2-selection--single {
            height: 39px;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #d2d1d1;
            border-radius: 4px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 37px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 5px;
            right: 1px;
            width: 20px;
        }
        .add-members .select2-container--default, .add-members .select2-container--default .select2-search__field, .add-members .select2-container--default .select2-search--inline
        {
            width: 100% !important;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            padding: 2px 5px;
            border-radius: 2px;
        }
        .booking-schedule-color a
        {
            color: #000 !important;
        }
        .required-span {
            color:red;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-12 col-md-2 mb-4 mt-3 mb-md-0 mt-md-0">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">
                <a class="nav-link @if(Route::currentRouteName() == 'admin.settings.index' || Route::currentRouteName() == 'admin.settings.index#profile_page') active @endif" href="#profile_page" id="profile-tab" data-toggle="tab">@lang('menu.profile') @lang('menu.settings')</a>
                @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('manage_settings') && !\Session::get('loginRole'))
                    <a class="nav-link" href="#general" data-toggle="tab" id="general-tab">@lang('menu.general') @lang('menu.settings')</a>
                    <a class="nav-link" href="#times" data-toggle="tab">@lang('menu.bookingSettings')</a>
                    <a class="nav-link" href="#tax" data-toggle="tab">@lang('app.tax') @lang('menu.settings')</a>
                    <a class="nav-link" href="#employee-schedule" data-toggle="tab">@lang('app.employee') @lang('app.schedule') @lang('menu.settings')</a>
                    <a class="nav-link" href="#currency" data-toggle="tab">@lang('app.currency') @lang('menu.settings')</a>
                    <a class="nav-link" href="#language" data-toggle="tab">@lang('app.language') @lang('menu.settings')</a>
                    <a class="nav-link" href="#email" data-toggle="tab">@lang('app.email') @lang('menu.settings')</a>
                    <a class="nav-link" href="#admin-theme" data-toggle="tab">@lang('menu.adminThemeSettings')</a>
                    <a class="nav-link" href="#choose-theme" data-toggle="tab">@lang('menu.chooseFrontTheme')</a>
                    <a class="nav-link" href="#" onclick="location.href = '{{ route('admin.front-settings.index') }}';">@lang('menu.frontSettings')</a>
                    <a class="nav-link" href="#front-theme" data-toggle="tab">@lang('menu.frontThemeSettings')</a>
                    <a class="nav-link" href="#seo-settings" data-toggle="tab">@lang('menu.seoSettings')</a>
                    <a class="nav-link" href="#front-pages" data-toggle="tab">@lang('menu.pages')</a>
                    <a class="nav-link" href="#zoom" data-toggle="tab">@lang('app.zoom') @lang('menu.settings')</a>
                    <a class="nav-link" href="#role-permission" data-toggle="tab">@lang('menu.rolesPermissions')</a>
                    <a class="nav-link" href="#office-leaves" data-toggle="tab">@lang('menu.officeleaves')</a>
                    <a class="nav-link" href="#googleCalendar" data-toggle="tab">@lang('menu.googleCalendar')</a>
                    <a class="nav-link" href="#googleMapApiKey" data-toggle="tab">@lang('menu.googleMapApiKey')</a>
                    <a class="nav-link" href="#social-login-settings" data-toggle="tab">@lang('app.socialLogin')
                        @lang('menu.settings')</a>
                    <a class="nav-link @if(Route::currentRouteName() == 'admin.settings.index#payment') active @endif" href="#payment"
                    data-toggle="tab">@lang('app.paymentCredential') @lang('menu.settings')</a>
                    <a class="nav-link @if(Route::currentRouteName() == 'admin.settings.index#sms-settings') active @endif" href="#sms-settings"
                    data-toggle="tab">@lang('app.smsCredentials') @lang('menu.settings')</a>
                    <a class="nav-link @if(Route::currentRouteName() == 'admin.settings.index#update') active @endif" href="#update" data-toggle="tab">
                        @lang('menu.updateApp')
                        @if($newUpdate == 1)
                            <span class="badge bg-success">{{ $lastVersion }}</span>
                        @endif
                    </a>
                @endif
            </div>
        </div>
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content">

                                <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index' || Route::currentRouteName() == 'admin.settings.index#profile_page') active @endif" id="profile_page">
                                    @include('admin.profile.index')
                                </div>

                                @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('manage_settings') && !\Session::get('loginRole'))
                                    <div class="tab-pane" id="general">

                                        @if ($settings->hide_cron_message == 0 || \Carbon\Carbon::now()->diffInHours($settings->last_cron_run) > 48)
                                        <div class="alert alert-primary">
                                            <h6>Set following cron command on your server (Ignore if already done)</h6>
                                            @php
                                                try {
                                                    echo '<code>* * * * * ' . PHP_BINDIR . '/php  ' . base_path() . '/artisan schedule:run >> /dev/null 2>&1</code>';
                                                } catch (\Throwable $th) {
                                                    echo '<code>* * * * * /php' . base_path() . '/artisan schedule:run >> /dev/null 2>&1</code>';
                                                }
                                            @endphp
                                        </div>
                                        @endif

                                        <form class="form-horizontal ajax-form" id="general-form" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.company') @lang('app.name')<span class="required-span">*</span></label>

                                                        <input type="text" class="form-control  form-control-lg"
                                                            id="company_name" name="company_name"
                                                            value="{{ $settings->company_name }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.company') @lang('app.email')<span class="required-span">*</span></label>

                                                        <input type="text" class="form-control  form-control-lg"
                                                            id="company_email" name="company_email"
                                                            value="{{ $settings->company_email }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.company') @lang('app.phone')<span class="required-span">*</span></label>

                                                        <input type="text" class="form-control  form-control-lg"
                                                            id="company_phone" name="company_phone"
                                                            value="{{ $settings->company_phone }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">@lang('app.logo')</label>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <input type="file" id="logo" name="logo"
                                                                    accept=".png,.jpg,.jpeg" class="dropify"
                                                                    data-default-file="{{ $settings->logo_url }}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">@lang('app.address')<span class="required-span">*</span></label>
                                                        <textarea class="form-control form-control-lg" name="address" id=""
                                                                cols="30" rows="5">{!! $settings->address !!}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="date_format" class="control-label">
                                                                    @lang('app.date_format')
                                                                </label>

                                                                <select name="date_format" id="date_format"
                                                                        class="form-control form-control-lg select2">
                                                                    @foreach($dateFormats as $key => $dateFormat)
                                                                        <option value="{{ $key }}" @if($settings->date_format == $key) selected @endif>{{
                                                                            $key.' ('.$dateObject->format($key).')' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="time_format" class="control-label">
                                                                    @lang('app.time_format')
                                                                </label>

                                                                <select name="time_format" id="time_format"
                                                                        class="form-control form-control-lg select2">
                                                                    @foreach($timeFormats as $key => $timeFormat)
                                                                        <option value="{{ $key }}" @if($settings->time_format == $key) selected @endif>{{
                                                                            $key.' ('.$dateObject->format($key).')' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.company') @lang('app.website')<span class="required-span">*</span></label>

                                                        <input type="text" class="form-control form-control-lg" id="website"
                                                            name="website" value="{{ $settings->website }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.timezone')</label>

                                                        <select name="timezone" id="timezone"
                                                                class="form-control form-control-lg select2">
                                                            @foreach($timezones as $tz)
                                                                <option @if($settings->timezone == $tz) selected @endif>{{
                                                                    $tz }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.currency')</label>

                                                        <select name="currency_id" id="currency_id"
                                                                class="form-control  form-control-lg">
                                                            @foreach($currencies as $currency)
                                                                <option
                                                                    @if($currency->id == $settings->currency_id) selected
                                                                    @endif
                                                                    value="{{ $currency->id }}">{{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="tax_name"
                                                            class="control-label">@lang('app.language')</label>

                                                        <select name="locale" id="locale"
                                                                class="form-control form-control-lg">
                                                            @forelse($enabledLanguages as $language)
                                                                <option value="{{ $language->language_code }}"
                                                                        @if($settings->locale == $language->language_code) selected @endif >
                                                                    {{ $language->language_name }}
                                                                </option>
                                                            @empty
                                                                <option @if($settings->locale == "en") selected
                                                                        @endif value="en">English
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id="save-general" type="button" class="btn btn-success"><i
                                                        class="fa fa-check"></i> @lang('app.save')</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#times') active @endif" id="times">
                                        <form id="booking-times-form" method="post" onkeydown="return event.key != 'Enter';">
                                            @csrf
                                            <div class="row">
                                                <h4 class="col-md-12">@lang('app.booking')<hr></h4> <br><br><br>

                                                <div class="col-md-6">
                                                    <h5 class="text-primary">@lang('app.multiTaskingEmployee')</h5>
                                                    <div class="form-group">
                                                        <label class="control-label">@lang('app.assignMultipleEmployeeAtSameTimeSlot')</label>
                                                        <br>
                                                        <label class="switch" style="margin-top: .2em">
                                                            <input type="checkbox" name="multi_task_user" id="multi_task_user" value="enabled" @if ( $settings->multi_task_user=='enabled') checked @endif onchange="multiTaskingEmpChanged()">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5 class="text-primary">@lang('app.limit') @lang('app.booking')</h5>
                                                    <div class="form-group">
                                                        <label class="control-label">@lang('app.maxBookingPerCustomer')</label>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                            <input onkeypress="return isNumberKey(event)" class="form-control" type="number" name="no_of_booking_per_customer" min="0" value="{{$settings->booking_per_day}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <h5 class="text-primary">@lang('app.allowEmployeeSelection')</h5>
                                                    <div class="form-group">
                                                        <label class="control-label">@lang('messages.allowEmployeeSelectionMSG')</label>
                                                        <br>
                                                        <label class="switch" style="margin-top: .2em">
                                                            <input value="enabled" type="checkbox" name="employee_selection" @if ( $settings->employee_selection=='enabled') checked @endif>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <h5 class="text-primary">@lang('app.disableSlotDurationAsPerServiceDuration')</h5>
                                                    <div class="form-group">
                                                        <label class="control-label">Booking time will be calculated based on selected service</label>
                                                        <br>
                                                        <label class="switch" style="margin-top: .2em">
                                                            <input @if ( $settings->disable_slot=='enabled') checked @endif value="enabled" type="checkbox" name="disable_slot" id="disable_slot" onchange="disableSlotChanged()">
                                                            <span class="slider round"></span>
                                                        </label>

                                                        <div class="row" id="div_disable_slot" @if ( $settings->disable_slot=='disabled' || $settings->disable_slot=='') style="display: none" @endif>
                                                            <br>
                                                            <div class="col-md-8">
                                                            <label class="radio-inline pl-lg-2"><input type="radio" @if($settings->booking_time_type == 'sum') checked @endif
                                                                onchange="getDriverValue(this);"
                                                                value="sum" name="booking_time_type" class="booking_time_type"> @lang('app.sum')</label>
                                                            <label class="radio-inline pl-lg-2"><input type="radio"
                                                                @if($settings->booking_time_type == 'avg') checked @endif
                                                                onchange="getDriverValue(this);"
                                                                value="avg" name="booking_time_type" class="booking_time_type"> @lang('app.average')</label>
                                                            <label class="radio-inline pl-lg-2"><input type="radio"
                                                                @if($settings->booking_time_type == 'max') checked @endif
                                                                onchange="getDriverValue(this);"
                                                                value="max" name="booking_time_type" class="booking_time_type"> @lang('app.maximum')</label>
                                                            <label class="radio-inline pl-lg-2"><input type="radio"
                                                                @if($settings->booking_time_type == 'min') checked @endif
                                                                onchange="getDriverValue(this);"
                                                                value="min" name="booking_time_type" class="booking_time_type"> @lang('app.minimum')</label>
                                                            </div>
                                                            <div class="col-12 alert alert-info" role="alert" id="info-msg">

                                                                @if($settings->booking_time_type == 'sum') @lang('messages.sumOfServiceTime').
                                                                @endif
                                                                @if($settings->booking_time_type == 'max') @lang('messages.MaxServiceTime').
                                                                @endif
                                                                @if($settings->booking_time_type == 'min') @lang('messages.MinServiceTime').
                                                                @endif
                                                                @if($settings->booking_time_type == 'avg')@lang('messages.AvgOfServiceTime').form-control-sm
                                                                @endif


                                                            </div>
                                                            <div class="col-12 alert alert-warning" role="alert">
                                                                @lang('messages.disablePaymentsFromFront').
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="text-primary">@lang('app.cronjob')</h5>
                                                    <div class="form-group">
                                                        <label class="control-label">@lang('app.cronjobtitle')</label>
                                                        <br>
                                                        <label class="switch" style="margin-top: .2em">
                                                            <input type="checkbox" name="cron_status" id="cron_status" @if($settings->cron_status == 'active')
                                                            checked
                                                        @endif  value='active' onchange="disableCronJobChanged()" >
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12 p-0 @if($settings->cron_status=='deactive' || $settings->cron_status=='') d-none @endif" id="cron_job_from" >
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="duration" class="control-label">@lang("app.duration")</label>
                                                                    <input type="number" class="form-control" name="duration" min="1" value="{{$settings->duration}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="duration_type" class="control-label">@lang("app.durationType")</label>
                                                                    <select name="duration_type" class="form-control">
                                                                        <option value="minutes"
                                                                            {{ $settings->duration_type == 'minutes' ? 'selected' : '' }}>
                                                                            @lang("app.minutes")
                                                                        </option>
                                                                        <option value="hours" {{ $settings->duration_type == 'hours' ? 'selected' : '' }}>
                                                                            @lang("app.hours")
                                                                        </option>
                                                                        <option value="days" {{ $settings->duration_type == 'days' ? 'selected' : '' }}>
                                                                            @lang("app.days")
                                                                        </option>
                                                                        <option value="weeks" {{ $settings->duration_type == 'weeks' ? 'selected' : '' }}>
                                                                            @lang("app.weeks")
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-success" id="save-booking-times-field"><i
                                                        class="fa fa-check"></i>@lang('app.save')</button>
                                                </div>

                                            </div>
                                            <hr><br>

                                            <div class="row">
                                                <div class="col-md">
                                                    <h4>@lang('app.booking') @lang('app.schedule')</h4><br>
                                                    @foreach($serviceLocations as $serviceLocation)
                                                        <div class="col-md-12 b-all mt-2">
                                                            <div class="row bg-dark p-3">
                                                                <div class="col-md-6">
                                                                    <h5 class="text-white mt-2 mb-2"><strong>{{ ucwords($serviceLocation->locations->name) }}</strong></h5>
                                                                </div>
                                                                <div class="col-md-6 text-center booking-schedule-color">
                                                                    <a href="javascript:;" class="btn btn-default text-dark btn-sm btn-rounded" onclick="toggleTime('#booking-schedule-{{ $serviceLocation->locations->id }}')" data-booking-time-id="{{ $serviceLocation->locations->id }}"><i class="fa fa-pencil"></i> @lang('app.editBookingTime')</a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                @include('admin.booking-time.index')
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    {{-- <div class="table-responsive">
                                                        <table class="table table-condensed">
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>@lang('app.day')</th>
                                                                <th>@lang('modules.settings.openTime')</th>
                                                                <th>@lang('modules.settings.closeTime')</th>
                                                                <th>@lang('modules.settings.allowBooking')</th>
                                                                <th class="text-right">@lang('app.action')</th>
                                                            </tr>
                                                            @foreach($bookingTimes as $key=>$bookingTime)
                                                                <tr>
                                                                    <td>{{ $key+1 }}</td>
                                                                    <td>@lang('app.'.$bookingTime->day)</td>
                                                                    <td>{{ $bookingTime->start_time }}</td>
                                                                    <td>{{ $bookingTime->end_time }}</td>
                                                                    <td>
                                                                        <label class="switch">
                                                                            <input type="checkbox" class="time-status"
                                                                                data-row-id="{{ $bookingTime->id }}"
                                                                                @if($bookingTime->status == 'enabled') checked @endif
                                                                            >
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a href="javascript:;" data-row-id="{{ $bookingTime->id }}"
                                                                        class="btn btn-primary btn-rounded btn-sm edit-row"><i
                                                                                class="icon-pencil"></i> @lang('app.edit')</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#tax') active @endif" id="tax">
                                        @include('admin.tax-setting.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#employee-schedule') active @endif" id="employee-schedule">
                                        @include('admin.employee-schedule.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#currency') active @endif" id="currency">
                                        <div class="row">
                                            <!-- Tabs  -->
                                            <div class="col-md-12">
                                                <ul class="nav nav-tabs" id="currency-tab" role="tablist">
                                                    <li class="nav-item">
                                                    <a class="nav-link active" id="currency-table-tab" data-toggle="tab" href="#currency-table" role="tab" aria-controls="currency-table" aria-selected="true">@lang('app.currency')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                    <a class="nav-link" id="currency-setting-format-tab" data-toggle="tab" href="#currency-setting-format" role="tab" aria-controls="currency-setting-format" aria-selected="true">@lang('app.currency_setting_format')</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="currency-table" role="tabpanel" aria-labelledby="currency-table-tab">
                                                        <br>
                                                        <div align='right'>
                                                            <a href="javascript:;" id="create-currency" class="btn btn-rounded btn-primary mb-1 mr-2">
                                                            <i class="fa fa-plus"></i> @lang('app.createNew') @lang('app.currency')
                                                            </a>
                                                        </div>
                                                        <h4 class="mt-4">@lang('app.currency')</h4>
                                                        <div class="row">
                                                            <div class="col-md-12 table-responsive">
                                                                <table class="table table-condensed">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>@lang('app.currency') @lang('app.name')</th>
                                                                        <th>@lang('app.currencySymbol')</th>
                                                                        <th>@lang('app.currencyCode')</th>
                                                                        <th class="text-right">@lang('app.action')</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($currencies as $key=>$currency)
                                                                        <tr id="currency-{{ $currency->id }}">
                                                                            <td>{{ ($key+1) }}</td>
                                                                            <td>{{ ucwords($currency->currency_name) }}</td>
                                                                            <td>{{ $currency->currency_symbol }}</td>
                                                                            <td>{{ $currency->currency_code }}</td>
                                                                            <td class="text-right">
                                                                                <button data-row-id="{{ $currency->id }}"
                                                                                        class="btn btn-primary btn-circle edit-currency"
                                                                                        type="button"><i
                                                                                        class="fa fa-pencil" data-bs-toggle="tooltip" data-original-title="@lang('app.edit')"></i>
                                                                                </button>
                                                                                @if ($settings->currency->id !== $currency->id)
                                                                                    <button data-row-id="{{ $currency->id }}"
                                                                                            class="btn btn-danger btn-circle delete-currency"
                                                                                            type="button"><i
                                                                                            class="fa fa-times" data-bs-toggle="tooltip" data-original-title="@lang('app.delete')"></i>
                                                                                    </button>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane fade" id="currency-setting-format" role="tabpanel" aria-labelledby="currency-setting-format-tab">
                                                        <div class="col-md-12">
                                                            @include('admin/currency/editCurrencyFormatSettings')
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#language') active @endif" id="language">
                                        @include('admin.language.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#email') active @endif" id="email">
                                        <h4>@lang('app.email') @lang('menu.settings')</h4>
                                        <form class="form-horizontal ajax-form" id="email-form" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div id="alert">
                                                @if($smtpSetting->mail_driver =='smtp')
                                                    @if($smtpSetting->verified)
                                                        <div
                                                            class="alert alert-success">{{__('messages.smtpSuccess')}}</div>
                                                    @else
                                                        <div class="alert alert-danger">{{__('messages.smtpError')}}</div>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>@lang("modules.emailSettings.mailDriver")</label>
                                                        <div class="form-group">
                                                            <label class="radio-inline"><input type="radio"
                                                                                            class="checkbox"
                                                                                            onchange="getDriverValue(this);"
                                                                                            value="mail"
                                                                                            @if($smtpSetting->mail_driver == 'mail') checked
                                                                                            @endif name="mail_driver"> Mail</label>
                                                            <label class="radio-inline pl-lg-2"><input type="radio"
                                                                                                    onchange="getDriverValue(this);"
                                                                                                    value="smtp"
                                                                                                    @if($smtpSetting->mail_driver == 'smtp') checked
                                                                                                    @endif name="mail_driver"> SMTP</label>


                                                        </div>
                                                    </div>
                                                    <div id="smtp_div">
                                                        <div class="form-group">
                                                            <label>@lang("modules.emailSettings.mailHost")</label>
                                                            <input type="text" name="mail_host" id="mail_host"
                                                                class="form-control form-control-lg"
                                                                value="{{ $smtpSetting->mail_host }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang("modules.emailSettings.mailPort")</label>
                                                            <input type="text" name="mail_port" id="mail_port"
                                                                class="form-control form-control-lg"
                                                                value="{{ $smtpSetting->mail_port }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang("modules.emailSettings.mailUsername")</label>
                                                            <input type="text" name="mail_username" id="mail_username"
                                                                class="form-control form-control-lg"
                                                                value="{{ $smtpSetting->mail_username }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="control-label">@lang("modules.emailSettings.mailPassword")</label>
                                                            <input type="password" name="mail_password"
                                                                id="mail_password"
                                                                class="form-control form-control-lg"
                                                                value="{{ $smtpSetting->mail_password }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label">@lang("modules.emailSettings.mailEncryption")</label>
                                                            <select class="form-control form-control-lg"
                                                                    name="mail_encryption"
                                                                    id="mail_encryption">
                                                                <option
                                                                    @if($smtpSetting->mail_encryption == 'none') selected @endif>
                                                                    none
                                                                </option>
                                                                <option
                                                                    @if($smtpSetting->mail_encryption == 'tls') selected @endif>
                                                                    tls
                                                                </option>
                                                                <option
                                                                    @if($smtpSetting->mail_encryption == 'ssl') selected @endif>
                                                                    ssl
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">@lang("modules.emailSettings.mailFrom")</label>
                                                        <input type="text" name="mail_from_name" id="mail_from_name"
                                                            class="form-control form-control-lg"
                                                            value="{{ $smtpSetting->mail_from_name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">@lang("modules.emailSettings.mailFromEmail")</label>
                                                        <input type="text" name="mail_from_email" id="mail_from_email"
                                                            class="form-control form-control-lg"
                                                            value="{{ $smtpSetting->mail_from_email }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <button id="save-email" type="button" class="btn btn-success"><i
                                                                class="fa fa-check"></i> @lang('app.save')</button>
                                                        <button id="send-test-email" type="button" class="btn btn-primary"><i
                                                                class="fa fa-envelope"></i> @lang('app.sendTestEmail')</button>
                                                    </div>


                                                </div>

                                                <!--/span-->
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#admin-theme') active @endif" id="admin-theme">
                                        <h4>@lang('menu.adminThemeSettings')</h4>
                                        <section class="mt-3 mb-3">
                                            <form class="form-horizontal ajax-form" id="theme-form" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <h6 class="col-md-12">@lang('modules.theme.subheadings.colorPallette') <span type="button" id="resetAdminThemeColor" class="btn badge bg-primary">@lang("app.reset")</h6>
                                                    <div class="col-md-2 ">
                                                        <div class="form-group">
                                                            <label>@lang('modules.theme.primaryColor')</label>
                                                            <input type="text" id="adminPrimaryColor" class="form-control color-picker"
                                                                name="primary_color"
                                                                value="{{ $themeSettings->primary_color }}">
                                                            <div
                                                                style="background-color: {{ $themeSettings->primary_color }}"
                                                                class=" border border-1">&nbsp;
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 ">
                                                        <div class="form-group">
                                                            <label>@lang('modules.theme.secondaryColor')</label>
                                                            <input type="text" id="adminSecondaryColor" class="form-control color-picker"
                                                                name="secondary_color"
                                                                value="{{ $themeSettings->secondary_color }}">
                                                            <div
                                                                style="background-color: {{ $themeSettings->secondary_color }}"
                                                                class=" border border-1">&nbsp;
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 ">
                                                        <div class="form-group">
                                                            <label>@lang('modules.theme.sidebarBgColor')</label>
                                                            <input type="text" id="adminSidebarBgColor" class="form-control color-picker"
                                                                name="sidebar_bg_color"
                                                                value="{{ $themeSettings->sidebar_bg_color }}">
                                                            <div style="background-color: {{ $themeSettings->sidebar_bg_color }}" class=" border border-1">&nbsp;
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 ">
                                                        <div class="form-group">
                                                            <label>@lang('modules.theme.sidebarTextColor')</label>
                                                            <input type="text" id="adminSidebarTextColor" class="form-control color-picker"
                                                                name="sidebar_text_color"
                                                                value="{{ $themeSettings->sidebar_text_color }}">
                                                            <div style="background-color: {{ $themeSettings->sidebar_text_color }}"
                                                                class="border border-1">&nbsp;
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 ">
                                                        <div class="form-group">
                                                            <label>@lang('modules.theme.topbarTextColor')</label>
                                                            <input type="text" id="adminTopbarTextColor" class="form-control color-picker"
                                                                name="topbar_text_color"
                                                                value="{{ $themeSettings->topbar_text_color }}">
                                                            <div
                                                                style="background-color: {{ $themeSettings->topbar_text_color }}"
                                                                class="border border-1">&nbsp;
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>

                                                <div class="row mb-3">
                                                    <h6 class="col-md-12">@lang('modules.theme.subheadings.customCss') <span type="button" id="resetAdminCustomCss" class="btn badge bg-primary">@lang("app.reset")</span></h6>

                                                    <div class="col-md-12">
                                                        <div id="admin-custom-css">@if(!$themeSettings->custom_css)@lang('modules.theme.defaultCssMessage')@else{!! $themeSettings->custom_css !!}@endif</div>
                                                    </div>

                                                    <input id="admin-custom-input" type="hidden" name="admin_custom_css">
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id="save-theme" type="button" class="btn btn-success"><i
                                                                class="fa fa-check"></i> @lang('app.save')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#front-theme') active @endif" id="front-theme">
                                        <h4>@lang('menu.frontThemeSettings')</h4>
                                        <hr>
                                        <section class="mt-3 mb-3">
                                            <form class="form-horizontal ajax-form" id="front-theme-form" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="col-md-12 text-primary">@lang('app.logo')</h6>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <input type="file" id="front-input-file-now"
                                                                            name="front_logo"
                                                                            accept=".png,.jpg,.jpeg" class="dropifyy"
                                                                            data-default-file="{{ $frontThemeSettings->logo_url }}"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="col-md-12 text-primary">@lang('app.favicon') <span class="text-danger">@lang('modules.theme.imageDimensions')</span></h6>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <input type="file" id="front-input-file-now"
                                                                            name="favicon"
                                                                            accept=".png,.jpg,.jpeg" class="dropifyy"
                                                                            data-default-file="{{ $frontThemeSettings->favicon_url }}"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-md-12">
                                                        <h6 class="col-md-12 text-primary">@lang('modules.theme.subheadings.colorPallette') <span type="button" id="resetFrontThemeColor" class="btn badge bg-primary">@lang("app.reset")</span></h6>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('modules.theme.primaryColor')</label>
                                                                <input type="text" class="form-control color-picker" id="frontPrimaryColor"
                                                                    name="primary_color"
                                                                    value="{{ $frontThemeSettings->primary_color }}">
                                                                <div
                                                                    style="background-color: {{ $frontThemeSettings->primary_color }}"
                                                                    class=" border border-1">&nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('modules.theme.secondaryColor')</label>
                                                                <input type="text" class="form-control color-picker" id="frontSecondaryColor"
                                                                    name="secondary_color"
                                                                    value="{{ $frontThemeSettings->secondary_color }}">
                                                                <div
                                                                    style="background-color: {{ $frontThemeSettings->secondary_color }}"
                                                                    class=" border border-1">&nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <h6 class="col-md-12 text-primary">@lang('modules.theme.subheadings.customCss') <span type="button" id="resetFrontCustomCss" class="btn badge bg-primary">@lang("app.reset")</span></h6>

                                                    <div class="col-md-12">
                                                        <div id="front-custom-css">@if(!$frontThemeSettings->custom_css)@lang('modules.theme.defaultCssMessage')@else{!! $frontThemeSettings->custom_css !!}@endif</div>
                                                    </div>

                                                    <input id="front-custom-input" type="hidden" name="front_custom_css">
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button id="save-front-theme" type="button" class="btn btn-success">
                                                                <i class="fa fa-check"></i> @lang('app.save')</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </section>
                                        <hr>
                                        <section class="mt-3 mb-3">
                                            <br>
                                            <h3>Carousel/Slider Settings</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="text-primary">Carousel Status</h5>
                                                    <div class="form-group">
                                                        <br>
                                                            <label class="switch">
                                                            <input type="checkbox" name="" class="carousel-status" @if($frontThemeSettings->carousel_status=='enabled') checked @endif>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="text-primary">Carousel Autoplay</h5>
                                                    <div class="form-group">
                                                        <br>
                                                            <label class="switch">
                                                            <input type="checkbox" name="" class="carousel-autoplay" @if($frontThemeSettings->carousel_autoplay=='enabled') checked @endif>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="carousel-area" @if($frontThemeSettings->carousel_status=='disabled') style="display:none" @endif>
                                                    <div class="col-md-12">
                                                        <form id="theme-carousel-form">
                                                            @csrf
                                                            <div class="form-group">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <input type="file" id="carousel-images" name="image"
                                                                            accept=".png,.jpg,.jpeg" class=""
                                                                            data-allowed-formats="landscape"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="uploaded-image" class="d-none"></div>
                                                        </form>
                                                    </div>
                                                    <br>
                                                    <div class="d-none text-center" id="submitBtn">
                                                        <button type="button" onclick="submitForm();" id="saveFrontSliderForm" class="btn btn-success btn-light-round"><i
                                                            class="fa fa-check"></i> @lang('app.submit')</button>
                                                    </div>
                                                    <br><br>
                                                    <div id="carousel-image-gallery" class="row">
                                                        @include('partials.carousel_images')
                                                    </div>
                                                </div>

                                            </div>
                                        </section>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#choose-theme') active @endif" id="choose-theme">
                                        <h4>@lang('menu.chooseFrontTheme')</h4>
                                        <hr>
                                        <section class="mt-3 mb-3">
                                            <form class="form-horizontal ajax-form" id="choose-theme-form" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="col-md-12 text-primary">@lang('modules.theme.subheadings.selectTheme')</h6>
                                                        <br>
                                                        <div class="row ml-1">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="option">
                                                                        <input type="radio" name="front_theme" value="theme-1" id=old @if ($frontThemeSettings->front_theme == 'theme-1') checked @endif/>&nbsp;&nbsp;
                                                                        <label for="old"> <strong>@lang('modules.theme.theme') 1</strong> </label><br><br>
                                                                        <img src="{{ asset('front/images/Appointo-theme-1.png') }}" alt="theme-1" width="400" height="700" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="option">
                                                                        <input type="radio" name="front_theme" value="theme-2" id="new" @if ($frontThemeSettings->front_theme == 'theme-2') checked @endif/>&nbsp;&nbsp;
                                                                        <label for="new"> <strong>@lang('modules.theme.theme') 2</strong> </label><br><br>
                                                                        <img src="{{ asset('front/images/Appointo-theme-2.jpg') }}" alt="theme-1" width="400" height="700" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id="save-theme-option" type="button" class="btn btn-success">
                                                            <i class="fa fa-check"></i> @lang('app.save')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#seo-settings') active @endif" id="seo-settings">
                                        <h4>@lang('menu.seoSettings')</h4>
                                        <hr>
                                        <form class="form-horizontal ajax-form" id="seo-form" method="POST">
                                            @csrf

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label class="control-label">@lang('app.site')  @lang('app.description') <span class="text-danger">*</span></label>

                                                        <textarea name="seo_description" id="seo_description" cols="30" class="form-control-lg form-control" rows="5">{{ ucwords($frontThemeSettings->seo_description) }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">@lang('app.site')  @lang('app.keywords') <span class="text-danger">*</span></label>

                                                        <input type="text" class="form-control form-control-lg"
                                                            id="seo_keywords" name="seo_keywords" data-role="tagsinput" value="{{ ucwords($frontThemeSettings->seo_keywords) }}"/>

                                                    </div>

                                                    <div class="form-group">
                                                        <button id="save-seo-settings" type="button" class="btn btn-success"><i
                                                                class="fa fa-check"></i> @lang('app.save')</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#front-pages') active @endif" id="front-pages">
                                        @include('admin.page.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#zoom') active @endif" id="zoom">
                                        @include('admin.zoom-settings.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#role-permission') active @endif" id="role-permission">
                                        @include('admin.role-permission.index')
                                    </div>

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#office-leaves') active @endif" id="office-leaves">
                                        @include('admin.office-leaves.index')
                                    </div>

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#googleCalender') active @endif" id="googleCalendar">
                                        @include('admin.google-calendar.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#googleMapApiKey') active @endif" id="googleMapApiKey">
                                        @include('admin.google-map-api-key.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <!-- Social login settings-->
                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#social-login-settings') active @endif" id="social-login-settings">
                                        @include('admin.social-settings.index')
                                    </div>
                                    <!-- End Social login settings-->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#payment') active @endif" id="payment">
                                        <h4>@lang('app.paymentCredential') @lang('menu.settings')</h4>
                                        <br>
                                        <form class="form-horizontal ajax-form" id="payment-form" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="row">
                                                        <div class="col-md">
                                                            <h5 class="text-primary">@lang('app.showPaymentOptions')</h5>
                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label">@lang("modules.paymentCredential.allowCustomerPayment")</label>
                                                                <br>
                                                                <label class="switch">
                                                                    <input type="checkbox" value="show" name="show_payment_options"
                                                                        @if($credentialSetting->show_payment_options == 'show') checked
                                                                        @endif class="show_payment_options">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md">
                                                            <h5 class="text-primary">@lang('app.offlinePaymentMethod')</h5>
                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label">@lang("modules.paymentCredential.allowOfflinePayment")</label>
                                                                <br>
                                                                <label class="switch">
                                                                    <input type="checkbox" name=""
                                                                        @if($credentialSetting->offline_payment == 1) checked
                                                                        @endif  class="offline-payment">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr><br>

                                                    <h5 class="text-primary">@lang('app.paypalCredential') </h5>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            @lang("modules.paymentCredential.paypalCredentialStatus")
                                                        </label>
                                                        <br>
                                                        <label class="switch">
                                                            <input type="checkbox" name="paypal_status" id="paypal_status"
                                                                    @if($credentialSetting->paypal_status == 'active')
                                                                        checked
                                                                    @endif  value='active' onchange="toggle('#paypal-credentials');">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div id="paypal-credentials">
                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.paypalClientID") <span class="text-danger">*</span></label>
                                                            <input type="text" name="paypal_client_id" id="paypal_client_id"
                                                                class="form-control form-control-lg"
                                                                value="{{ $credentialSetting->paypal_client_id }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.paypalSecret")<span class="text-danger">*</span></label>
                                                            <input type="password" name="paypal_secret" id="paypal_secret"
                                                                class="form-control form-control-lg"
                                                                value="{{ $credentialSetting->paypal_secret }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.paypalMode")</label>
                                                            <select class="form-control" name="paypal_mode" id="paypal_mode">
                                                                <option @if ($credentialSetting->paypal_mode === 'sandbox')
                                                                    selected
                                                                @endif value="sandbox">Sandbox</option>
                                                                <option @if ($credentialSetting->paypal_mode === 'live')
                                                                    selected
                                                                @endif value="live">Live</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <br>

                                                    <h5 class="text-primary">@lang('app.stripeCredential') </h5>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            @lang("modules.paymentCredential.stripeCredentialStatus")
                                                        </label>
                                                        <br>
                                                        <label class="switch">
                                                            <input type="checkbox" name="stripe_status" id="stripe_status"
                                                                    @if($credentialSetting->stripe_status == 'active')
                                                                        checked
                                                                    @endif value="active" onchange="toggle('#stripe-credentials');">
                                                            <span class="slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="offline_payment"
                                                                @if($credentialSetting->offline_payment == 1) value="1"
                                                                @else value="0" @endif id="offlinePayment">

                                                    </div>
                                                    <div id="stripe-credentials">
                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.stripelClientID") <span class="text-danger">*</span></label>
                                                            <input type="text" name="stripe_client_id" id="stripe_client_id"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->stripe_client_id }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.stripeSecret") <span class="text-danger">*</span></label>
                                                            <input type="password" name="stripe_secret" id="stripe_secret"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->stripe_secret }}">
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <br>

                                                    <h5 class="text-primary">@lang('modules.paymentCredential.payStackCredential') </h5>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            @lang("modules.paymentCredential.payStackCredentialStatus")
                                                        </label>
                                                        <br>
                                                        <label class="switch">
                                                            <input type="checkbox" name="paystack_status" id="paystack_status"
                                                                    @if($credentialSetting->paystack_status == 'active')
                                                                        checked
                                                                    @endif value="active" onchange="toggle('#paystack-credentials');">
                                                            <span class="slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="offline_payment"
                                                                @if($credentialSetting->offline_payment == 1) value="1"
                                                                @else value="0" @endif id="offlinePayment">

                                                    </div>
                                                    <div id="paystack-credentials">
                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.payStackPublicKey") <span class="text-danger">*</span></label>
                                                            <input type="text" name="paystack_public_id" id="paystack_public_id"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->paystack_public_id }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.payStackSecretKey") <span class="text-danger">*</span></label>
                                                            <input type="password" name="paystack_secret_id" id="paystack_secret_id"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->paystack_secret_id }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.payStackwebhook")</label>
                                                            <input type="password" name="paystack_webhook_secret" id="paystack_webhook_secret"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->paystack_webhook_secret }}">
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <br>

                                                    <h5 class="text-primary">@lang('app.razorpayCredential') </h5>
                                                    <div class="form-group d-flex flex-column">
                                                        <label class="control-label">
                                                            @lang("modules.paymentCredential.razorpayCredentialStatus")
                                                        </label>
                                                        <div class="d-flex">
                                                            <label class="switch mr-2">
                                                                <input type="checkbox" name="razorpay_status" id="razorpay_status"
                                                                        @if($credentialSetting->razorpay_status == 'active')
                                                                            checked
                                                                        @endif value="active" onchange="toggleRazorPay('#razorpay-credentials');">
                                                                <span class="slider round"></span>
                                                            </label>
                                                            <span class="text-danger wrong-currency-message">
                                                                @lang('modules.paymentCredential.changeCurrencyToINR') ( <a href="#general" onclick="$('#general-tab').trigger('click');">@lang('menu.general')</a> )
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="razorpay-credentials">
                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.razorpayKey") <span class="text-danger">*</span></label>
                                                            <input type="text" name="razorpay_key" id="razorpay_key"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->razorpay_key }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang("modules.paymentCredential.razorpaySecret") <span class="text-danger">*</span></label>
                                                            <input type="password" name="razorpay_secret" id="razorpay_secret"
                                                                    class="form-control form-control-lg"
                                                                    value="{{ $credentialSetting->razorpay_secret }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <button id="save-payment" type="button" class="btn btn-success"><i
                                                                class="fa fa-check"></i> @lang('app.save')</button>
                                                    </div>
                                                </div>

                                                <!--/span-->
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#sms-settings') active @endif" id="sms-settings">
                                        @include('admin.sms-settings.index')
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane @if(Route::currentRouteName() == 'admin.settings.index#update') active @endif" id="update">
                                        <h4>@lang('menu.updateApp')</h4>
                                        @include('vendor.froiden-envato.update.update_blade')
                                        @include('vendor.froiden-envato.update.version_info')

                                        <hr>

                                        @include('vendor.froiden-envato.update.changelog')
                                    </div>
                                    <!-- /.tab-pane -->
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
@endsection

@push('footer-js')
    <script src="{{ asset('/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('js/croppie.min.js') }}"></script>

    <script>

        var frontCssEditor = ace.edit('front-custom-css', {
            mode: 'ace/mode/css',
            theme: 'ace/theme/twilight'
        });
        var adminCssEditor = ace.edit('admin-custom-css', {
            mode: 'ace/mode/css',
            theme: 'ace/theme/twilight'
        });

        $(function () {
            $('.wrong-currency-message').hide();
            $('#paypal_status').is(':checked') ? $('#paypal-credentials').show() : $('#paypal-credentials').hide();
            $('#stripe_status').is(':checked') ? $('#stripe-credentials').show() : $('#stripe-credentials').hide();
            $('#paystack_status').is(':checked') ? $('#paystack-credentials').show() : $('#paystack-credentials').hide();
            $('#razorpay_status').is(':checked') ? $('#razorpay-credentials').show() : $('#razorpay-credentials').hide();
            $('#nexmo_status').is(':checked') ? $('#nexmo-credentials').show() : $('#nexmo-credentials').hide();
            $('#msg91_status').is(':checked') ? $('#msg91-credentials').show() : $('#msg91-credentials').hide();
            $('#google_status').is(':checked') ? $('#google-credentials').show() : $('#google-credentials').hide();
            $('#facebook_status').is(':checked') ? $('#facebook-credentials').show() : $('#facebook-credentials').hide();

            $('#v-pills-tab a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
                $("html, body").scrollTop(0);
            });

            $(document).ready(function(){
                $(window).scrollTop(0);
            });

            // store the currently selected tab in the hash value
            $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
                var id = $(e.target).attr("href").substr(1);
                if(id == 'currency-table' || id == 'currency-setting-format' ){
                    id = 'currency';
                }
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            $('#v-pills-tab a[href="' + hash + '"]').tab('show');
        });
    </script>
    @permission('manage_settings')
        <script>
        $(document).ready(function (event)
        {

            $(document).on('click', '#addTax', function () {
                var url = "{{ route('admin.tax-settings.create') }}";

                $(modal_default + ' ' + modal_heading).html('@lang('app.add') @lang('app.tax')');
                $.ajaxModal(modal_default, url);
            });

            $('body').on('click', '#save-tax', function() {
            $.easyAjax({
                url: '{{ route('admin.tax-settings.store') }}',
                container: '#tax-form',
                type: "POST",
                data: $('#tax-form').serialize(),
                success: function(response) {
                    if (response.status == "success") {
                        $.unblockUI();
                        $(modal_default).modal('hide');
                        taxTable._fnDraw();
                    }
                }
            })
        });

            $(document).on('click', '#editTax', function () {
                    var id = $(this).data('row-id');
                    var url = "{{ route('admin.tax-settings.edit', ':id') }}";
                    url = url.replace(':id', id);

                    $(modal_default + ' ' + modal_heading).html('@lang('app.edit') @lang('app.tax')');
                    $.ajaxModal(modal_default, url);
            });

            $(document).on('click', '.delete-currency', function () {
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.deleteWarning')",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "{{ route('admin.currency-settings.destroy',':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        $('#currency-' + id).remove();
                                    }
                                }
                            });
                        }
                    });
            });

            $(document).on('click', '.delete-tax', function(){
                    var id = $(this).data('row-id');
                    swal({
                        icon: "warning",
                        buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                        dangerMode: true,
                        title: "@lang('errors.areYouSure')",
                        text: "@lang('errors.deleteWarning')",
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "{{ route('admin.tax-settings.destroy',':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        taxTable._fnDraw();
                                    }
                                }
                            });
                        }
                    });
            });

            $(document).on('click', '.edit-row', function () {

                var id = $(this).data('row-id');
                var url = '{{ route('admin.booking-times.edit', ':id')}}';
                url = url.replace(':id', id);

                $(modal_lg + ' ' + modal_heading).html('@lang('app.edit') @lang('app.bookingTimes')');
                $.ajaxModal(modal_lg, url);
            });

            $(document).on('click', '.edit-officeLeave', function () {
                var id = $(this).data('row-id');
                var url = '{{ route('admin.office-leaves.edit', ':id')}}';
                url = url.replace(':id', id);

                $(modal_lg + ' ' + modal_heading).html('@lang('app.edit') @lang('menu.officeleaves')');
                $.ajaxModal(modal_lg, url);
            });

            $(document).on('click', '#create-office-leaves', function () {
                var url = '{{ route('admin.office-leaves.create') }}';

                $(modal_lg + ' ' + modal_heading).html('@lang('app.createNew') @lang('menu.officeleaves')');
                $.ajaxModal(modal_lg, url);
            });

            $(document).on('click', '#create-currency', function () {
                var url = '{{ route('admin.currency-settings.create') }}';

                $(modal_default + ' ' + modal_heading).html("@lang('app.createNew') @lang('menu.currency')");
                $.ajaxModal(modal_default, url);
            });

            //start tax-script
            taxTable = $('#taxTable').dataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('admin.tax-settings.index') !!}',

                    "fnDrawCallback": function( oSettings ) {
                        $("body").tooltip({
                            selector: '[data-bs-toggle="tooltip"]'
                        });
                    },
                    order: [[1, 'ASC']],
                    columns: [
                        { data: 'DT_RowIndex'},
                        { data: 'name', name: 'name' },
                        { data: 'percent', name: 'percent' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', width: '20%' }
                    ]
            });
            new $.fn.dataTable.FixedHeader(taxTable);

            $(document).on('click', '.delete-officeLeave', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.deleteWarning')",
                }).then((willDelete) => {
                    if (willDelete) {
                        var url = "{{ route('admin.office-leaves.destroy',':id') }}";
                        url = url.replace(':id', id);
                        var token = "{{ csrf_token() }}";
                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    // swal("Deleted!", response.message, "success");
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#save-social-settings', function() {
                $.easyAjax({
                    url: '{{route('admin.social-auth-settings.update', $socialCredentials->id)}}',
                    container: '#social-login-form',
                    type: "POST",
                    file: true,
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
                            location.reload();
                        }
                    }
                });
            });

            $('.dropify').dropify({
                messages: {
                    default: '@lang("app.dragDrop")',
                    replace: '@lang("app.dragDropReplace")',
                    remove: '@lang("app.remove")',
                    error: '@lang('app.largeFile')'
                }
            });

            $('.color-picker').colorpicker({
                format: 'hex'
            }).on('change', function (e) {
                $(this).siblings('div').css('background-color', e.value)
            });

            $(document).on('click', '#save-seo-settings', function () {
                $.easyAjax({
                    url: '{{route('admin.add-seo-details')}}',
                    container: '#seo-form',
                    type: "POST",
                    data: $('#seo-form').serialize()
                });
            });

            $(document).on('click', '#save-theme-option', function () {
                $.easyAjax({
                    url: '{{route('admin.choose-front-theme')}}',
                    container: '#choose-theme-form',
                    type: "POST",
                    data: $('#choose-theme-form').serialize()
                });
            });

            $(document).on('click', '.delete-carousel-row', function () {
                var id = $(this).attr('id');
                swal({
                    icon: "warning",
                    buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.deleteWarning')",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "{{ route('admin.front-theme-settings.destroy',':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        // $('#carousel-image-gallery').html(response.view);
                                        location.reload();
                                    }
                                }
                            });
                        }
                    });
            });

        });

            function checkCurrencyCode(currency_code) {
                if ( currency_code === 'INR') {
                    return true;
                }
                else {
                    return false;
                }
            }
            function disableCronJobChanged() {
                if($('#cron_status').is(":checked")) {
                    $("#cron_job_from").removeClass('d-none');

                } else {
                    $("#cron_job_from").addClass('d-none');
                }
            }

            $('.time-status').change(function () {
                var id = $(this).data('row-id');
                var url = "{{route('admin.booking-times.update', ':id')}}";
                url = url.replace(':id', id);

                if ($(this).is(':checked')) {
                    var status = 'enabled';
                } else {
                    var status = 'disabled';
                }

                $.easyAjax({
                    url: url,
                    type: "POST",
                    data: {'_method': 'PUT', '_token': "{{ csrf_token() }}", 'status': status}
                })
            });

            $('.offline-payment').change(function () {
                if ($(this).is(':checked')) {
                    $('#offlinePayment').val(1);
                } else {
                    $('#offlinePayment').val(0);
                }
            });

            function toggle(elementBox) {
                var elBox = $(elementBox);
                elBox.slideToggle();
            }

            function toggleTime(elementBox) {
                $(elementBox).toggleClass('d-none', 1000);
            }

            function toggleRazorPay(elementBox) {
                var elBox = $(elementBox);
                if (checkCurrencyCode('{{ $settings->currency->currency_code }}')) {
                    elBox.slideToggle();
                    $('.wrong-currency-message').fadeOut();
                }
                else {
                    $('.wrong-currency-message').fadeIn();
                    $('#razorpay_status').prop('checked', false);
                }
            }

            $('#save-general').click(function () {
                $.easyAjax({
                    url: '{{route('admin.settings.update', $settings->id)}}',
                    container: '#general-form',
                    type: "POST",
                    file: true,
                    data: $('#general-form').serialize()
                })
            });

            $('#save-currency').click(function () {
                $.easyAjax({
                    url: '{{route('admin.currency-settings.store')}}',
                    container: '#currency-form',
                    type: "POST",
                    data: $('#currency-form').serialize(),
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
                            location.reload();
                        }
                    }
                })
            });

            $(document).on('click', '#save-zoom-setting', function () {
                $.easyAjax({
                    url: '{{route('admin.zoom-settings.update', $zoomSetting->id)}}',
                    container: '#zoom-form',
                    type: "PUT",
                    data: $('#zoom-form').serialize()
                });
            });

            $('#save-currency-settings-format').click(function () {
                $.easyAjax({
                    url: '{{route('admin.update_currency_format',$currency_settings_formats->id)}}',
                    container: '#currency-settings-formats',
                    type: "POST",
                    data: $('#currency-settings-formats').serialize(),
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
                            // location.reload();
                        }
                    }

                })
            });

            $('#save-booking-times-field').click(function () {
                $.easyAjax({
                    url: '{{route('admin.save-booking-times-field')}}',
                    container: '#booking-times-form',
                    type: "POST",
                    data: $('#booking-times-form').serialize(),
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                        if (response.status == 'error') {
                            location.reload();
                        }
                    }
                })
            });

            $('#save-payment').click(function () {
                $.easyAjax({
                    url: '{{route('admin.credential.update', $credentialSetting->id)}}',
                    container: '#payment-form',
                    type: "POST",
                    data: $('#payment-form').serialize(),
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }

                })
            });

            $('#save-sms-settings').click(function () {
                $.easyAjax({
                    url: '{{route('admin.sms-settings.update', $smsSetting->id)}}',
                    container: '#sms-setting-form',
                    type: "POST",
                    data: $('#sms-setting-form').serialize()
                })
            });

            $('#save-theme').click(function () {
                $('#admin-custom-input').val(adminCssEditor.getValue());
                $.easyAjax({
                    url: '{{route('admin.theme-settings.update', $themeSettings->id)}}',
                    container: '#theme-form',
                    type: "POST",
                    data: $('#theme-form').serialize(),
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                })
            });

            $('#save-front-theme').click(function () {
                $('#front-custom-input').val(frontCssEditor.getValue());
                $.easyAjax({
                    url: '{{route('admin.front-theme-settings.update', $frontThemeSettings->id)}}',
                    container: '#front-theme-form',
                    type: "POST",
                    file: true
                })
            });

            // Upload Front slider image
            $uploadCrop = $('#uploaded-image').croppie({
                enableExif: true,
                viewport: {
                    width: 500,
                    height: 200,
                    type: 'rectangle'
                },
                original: {
                    width: 1920,
                    height: 1080,
                },
                boundary: {
                    width: 774,
                    height: 300,
                }
            });

            $('body').on('change', '#carousel-images', function() {
                $('#uploaded-image').removeClass('d-none');
                $('#submitBtn').removeClass('d-none');
                var reader = new FileReader();
                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
            });

            function submitForm() {
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'original'
                }).then(function (resp) {
                    let form = $('#theme-carousel-form');
                    $.easyAjax({
                        url: '{{route('admin.front-theme-settings.store')}}',
                        container: '#theme-carousel-form',
                        type: "POST",
                        file: true,
                        redirect: true,
                        data: {"images":resp, "data":form.serialize()},
                        success: function (response) {
                            if(response.status == 'success'){
                                location.reload();
                            }
                        }
                    });
                });
            }

            $('.edit-currency').click(function () {
                var id = $(this).data('row-id');
                var url = '{{ route('admin.currency-settings.edit', ':id')}}';
                url = url.replace(':id', id);

                $(modal_default + ' ' + modal_heading).html("@lang('app.edit') @lang('menu.currency')");
                $.ajaxModal(modal_default, url);
            });

            $('#save-email').click(function () {

                $.easyAjax({
                    url: '{{route('admin.email-settings.update', $smtpSetting->id)}}',
                    container: '#email-form',
                    type: "POST",
                    data: $('#email-form').serialize(),
                    messagePosition: "inline",
                    buttonSelector: "#save-email",
                    disableButton: true,
                    blockUI: true,
                    success: function (response) {
                        if (response.status == 'error') {
                            $('#alert').prepend('<div class="alert alert-danger">{{__('messages.smtpError')}}</div>')
                        } else {
                            $('#alert').show();
                        }
                    }
                })
            });

            $('#send-test-email').click(function () {
                var url = '{{route('admin.email-settings.sendTestEmailModal')}}';
                $('#modelHeading').html('@lang("app.testEmail")');
                $.ajaxModal('#application-modal', url);
            });

            $('body').on('click', '#sendTestEmailSubmit', function() {
                $.easyAjax({
                    url: '{{route('admin.email-settings.sendTestEmail')}}',
                    type: "GET",
                    messagePosition: "inline",
                    data: $('#testEmail').serialize(),
                    container: "#testEmail",
                    buttonSelector: "#sendTestEmailSubmit",
                    disableButton: true,
                    blockUI: true,
                })
            });

            function getDriverValue(sel) {
                if (sel.value == 'mail') {
                    $('#smtp_div').hide();
                    $('#alert').hide();
                } else {
                    $('#smtp_div').show();
                    $('#alert').show();
                }
            }

            @if ($smtpSetting->mail_driver == 'mail')
            $('#smtp_div').hide();
            $('#alert').hide();
            @endif

            var table = langTable = '';
            $(document).ready(function() {

                // pages table
                table = $('#myTable').dataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('admin.pages.index') !!}',
                    language: languageOptions(),
                    "fnDrawCallback": function( oSettings ) {
                        $("body").tooltip({
                            selector: '[data-bs-toggle="tooltip"]'
                        });
                    },
                    order: [[0, 'DESC']],
                    columns: [
                        { data: 'DT_RowIndex'},
                        { data: 'image', name: 'image' },
                        { data: 'title', name: 'title' },
                        { data: 'slug', name: 'slug' },
                        { data: 'action', name: 'action', width: '20%' }
                    ]
                });
                new $.fn.dataTable.FixedHeader(table);

                $('body').on('click', '.edit-page', function () {
                    var slug = $(this).data('slug');
                    var url = '{{ route('admin.pages.edit', ':slug')}}';
                    url = url.replace(':slug', slug);
                    console.log(url);
                    $(modal_lg + ' ' + modal_heading).html("@lang('app.edit') @lang('app.page')");
                    $.ajaxModal(modal_lg, url);
                });

                $('body').on('click', '#create-page', function () {
                    var url = '{{ route('admin.pages.create') }}';

                    $(modal_lg + ' ' + modal_heading).html("@lang('app.createNew') @lang('menu.page')");
                    $.ajaxModal(modal_lg, url);
                });

                $('body').on('click', '#save-form-front', function () {
                    // CKEDITOR.instances.content.updateElement()
                    const form = $('#createPageForm');

                    $.easyAjax({
                        url: '{{route('admin.pages.store')}}',
                        container: '#createPageForm',
                        type: "POST",
                        file:true,
                        redirect: true,
                        data: form.serialize(),
                        success: function (response) {
                            if(response.status == 'success'){
                                $(modal_lg).modal('hide');
                                table._fnDraw();
                            }
                        }
                    })
                });

                $('body').on('click', '.delete-row', function(){
                    var id = $(this).data('row-id');
                    swal({
                        icon: "warning",
                        buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                        dangerMode: true,
                        title: "@lang('errors.areYouSure')",
                        text: "@lang('errors.deleteWarning')",
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                var url = "{{ route('admin.pages.destroy',':id') }}";
                                url = url.replace(':id', id);

                                var token = "{{ csrf_token() }}";

                                $.easyAjax({
                                    type: 'POST',
                                    url: url,
                                    data: {'_token': token, '_method': 'DELETE'},
                                    success: function (response) {
                                        if (response.status == "success") {
                                            $.unblockUI();
                                            table._fnDraw();
                                        }
                                    }
                                });
                            }
                        });
                });

                // employee-schedule table
                employeeScheduleTable = $('#employeeScheduleTable').dataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('admin.employee-schedule.index') !!}',

                    "fnDrawCallback": function( oSettings ) {
                        $("body").tooltip({
                            selector: '[data-bs-toggle="tooltip"]'
                        });
                    },
                    order: [[1, 'ASC']],
                    columns: [
                        { data: 'DT_RowIndex'},
                        { data: 'name', name: 'name' },
                        // { data: 'code', name: 'code' },
                        // { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', width: '20%' }
                    ]
                });
                new $.fn.dataTable.FixedHeader( employeeScheduleTable );

                $('body').on('click', '.view-employee-detail', function () {
                    var id = $(this).data('row-id');
                    var url = '{{ route('admin.employee-schedule.show', ':id')}}';
                    url = url.replace(':id', id);

                    $(modal_lg + ' ' + modal_heading).html('@lang('app.view') @lang('app.schedule')');
                    $.ajaxModal(modal_lg, url);
                });

                // language table
                langTable = $('#langTable').dataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('admin.language-settings.index') !!}',
                    language: languageOptions(),
                    "fnDrawCallback": function( oSettings ) {
                        $("body").tooltip({
                            selector: '[data-bs-toggle="tooltip"]'
                        });
                    },
                    order: [[1, 'ASC']],
                    columns: [
                        { data: 'DT_RowIndex'},
                        { data: 'name', name: 'name' },
                        { data: 'code', name: 'code' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', width: '20%' }
                    ]
                });
                new $.fn.dataTable.FixedHeader( langTable );

                $('body').on('click', '.edit-language', function () {
                    var id = $(this).data('row-id');
                    var url = '{{ route('admin.language-settings.edit', ':id')}}';
                    url = url.replace(':id', id);

                    $(modal_default + ' ' + modal_heading).html("@lang('app.edit') @lang('menu.language')");
                    $.ajaxModal(modal_default, url);
                });

                $('body').on('click', '#create-language', function () {
                    var url = '{{ route('admin.language-settings.create') }}';

                    $(modal_default + ' ' + modal_heading).html("@lang('app.createNew') @lang('menu.language')");
                    $.ajaxModal(modal_default, url);
                });

                $('body').on('click', '.delete-language-row', function(){
                    var id = $(this).data('row-id');
                    const lang = {!! $languages !!}.filter(language => language.id == id);

                    swal({
                        icon: "warning",
                        buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                        dangerMode: true,
                        title: "@lang('errors.areYouSure')",
                        text: "@lang('errors.deleteWarning')",
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "{{ route('admin.language-settings.destroy',':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        // swal("Deleted!", response.message, "success");
                                        langTable._fnDraw();

                                        if (lang[0].status == 'enabled') {
                                            location.reload();
                                        }
                                    }
                                }
                            });
                        }
                    });
                });

                $('body').on('change', '.lang_status', function () {
                    const id = $(this).data('lang-id');

                    let url = '{{ route('admin.language-settings.changeStatus', ':id') }}'
                    url = url.replace(':id', id);

                    let status = '';
                    if ($(this).is(':checked')) {
                        status = 'enabled';
                    }
                    else {
                        status = 'disabled';
                    }

                    $.easyAjax({
                        url: url,
                        type: 'POST',
                        container: '#langTable',
                        data: {
                            id: id,
                            status: status,
                            _method: 'PUT',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                location.reload();
                            }
                        }
                    });
                });

                $('body').on('change', '.carousel-status', function () {
                    let carousel_status = '';
                    if ($(this).is(':checked')) {
                        carousel_status = 'enabled';
                        $('#carousel-area').css('display', 'block');
                    }
                    else {
                        carousel_status = 'disabled';
                        $('#carousel-area').css('display', 'none');
                    }

                    $.easyAjax({
                        url: '{{ route('admin.change-carousel-status') }}',
                        type: 'get',
                        data: {
                            carousel_status: carousel_status,
                        }
                    });
                });

                $('body').on('change', '.carousel-autoplay', function () {
                    let carousel_status = '';
                    if ($(this).is(':checked')) {
                        carousel_autoplay = 'enabled';
                    }
                    else {
                        carousel_autoplay = 'disabled';
                    }

                    $.easyAjax({
                        url: '{{ route('admin.carousel-autoplay') }}',
                        type: 'get',
                        data: {
                            carousel_autoplay: carousel_autoplay,
                        }
                    });
                });

            });

            function isNumberKey(evt)
            {
                var charCode = (evt.which) ? evt.which : evt.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
                return true;
            }

            // Change Colors using Reset Button
            function colorChange(element,value) {
                element.val(value);
                element.siblings('div').css('background-color', value);
            }

            $('body').on('click', '#resetFrontThemeColor', function() {
                colorChange($('#frontPrimaryColor'),'#414552');
                colorChange($('#frontSecondaryColor'),'#788AE2');
            });

            $('body').on('click', '#resetAdminThemeColor', function() {
                colorChange($('#adminPrimaryColor'),'#414552');
                colorChange($('#adminSecondaryColor'),'#788AE2');
                colorChange($('#adminSidebarBgColor'),'#FFFFFF');
                colorChange($('#adminSidebarTextColor'),'#5C5C62');
                colorChange($('#adminTopbarTextColor'),'#FFFFFF');
            });

            // Add Default CSS using Reset Button
            $('body').on('click', '#resetFrontCustomCss', function() {
                frontCssEditor.setValue('@lang('modules.theme.defaultCssMessage')');
            });

            $('body').on('click', '#resetAdminCustomCss', function() {
                adminCssEditor.setValue('@lang('modules.theme.defaultCssMessage')');
            });

            function disableSlotChanged()
            {
                if($('#disable_slot').is(":checked"))
                {
                    $("#div_disable_slot").show(10);
                    $('#multi_task_user').prop("checked", false);
                }
                else
                {
                    $("#div_disable_slot").hide(10);
                }
            }

            function multiTaskingEmpChanged()
            {
                if($('#multi_task_user').is(":checked"))
                {
                    $("#div_disable_slot").hide(10);
                    $('#disable_slot').prop("checked", false);
                }
            }

            $(".booking_time_type").click(function(){
                let duration_type = '';
                if($(this).val()=='sum'){
                    duration_type = "@lang('messages.sumOfServiceTime').";
                }
                else if($(this).val()=='avg'){
                    duration_type = "@lang('messages.AvgOfServiceTime').";
                }
                else if($(this).val()=='max'){
                    duration_type = "@lang('messages.MaxServiceTime').";
                }
                else if($(this).val()=='min'){
                    duration_type = "@lang('messages.MinServiceTime').";
                }
                $('#info-msg').html(duration_type+'..!');
            });

            $('body').on('change', '#google_calendar', function() {
                if ($(this).is(':checked')) {
                    $('#google_calendar_config_option').removeClass('d-none')
                } else {
                    $('#google_calendar_config_option').addClass('d-none')
                }
            });

            $('body').on('change', '#enableZoom', function() {
                if ($(this).is(':checked')) {
                    $('#zoom_setting').removeClass('d-none')
                } else {
                    $('#zoom_setting').addClass('d-none')
                }
            });


            $('body').on('click', '#saveGoogleCalendarConfigForm', function() {
                $.easyAjax({
                    url: '{{route('admin.saveGoogleCalendarConfig')}}',
                    container: '#googleCalendarConfigForm',
                    type: "POST",
                    data: $('#googleCalendarConfigForm').serialize(),
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                });
            });
            $('body').on('click', '#googleCalendarDisconnect', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.deleteWarning')",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "{{ route('googleAuth.destroy', $settings->id) }}";
                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        location.reload();
                                    }
                                }
                            });
                        }
                    });
            });

            var fieldHTML = '<div class="row"> <div class="col-6"> <div class="form-group"> <label for="duration" class="control-label">@lang("app.duration")</label> <input type="number" class="form-control form-control-lg" name="duration[]" min="1" value="1"> </div> </div> <div class="col-5"> <label for="duration_type" class="control-label">@lang("app.durationType")</label> <select name="duration_type[]"  class="form-control form-control-lg"> <option value="minutes">@lang("app.minutes")</option> <option value="hours">@lang("app.hours")</option> <option value="days">@lang("app.days")</option> <option value="weeks">@lang("app.weeks")</option> </select> </div> <div class="col-1 pt-3"> <a href="javascript:;" class="btn btn-danger btn-sm btn-circle removeNotifaction mt-4" data-row-id="0"><i class="fa fa-times" aria-hidden="true"></i></a> </div> </div> '; //New input field html
            var notifactionCounter = {{$companyBookingNotifaction->count()}}; //Initial field counter is 1
            //Once add button is clicked
            $('body').on('click', '#addNotifaction', function(){
                //Check maximum number of input fields
                if (notifactionCounter < 2) {
                    notifactionCounter++; //Increment field counter
                    $('.field_wrapper').append(fieldHTML); //Add field html
                    $('#bookingNotifactionFormBtn').removeClass('d-none');
                }
                if(notifactionCounter==2){
                    $('.addNotifaction').addClass('d-none');
                }

            });
            //Once remove button is clicked
            $('body').on('click', '.field_wrapper .removeNotifaction', function(e) {
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                notifactionCounter--; //Decrement field counter
                if(notifactionCounter < 2){
                    $('.addNotifaction').removeClass('d-none');
                }

                if(notifactionCounter==0){
                    $('#bookingNotifactionFormBtn').addClass('d-none');
                }

                var id = $(this).data('row-id');
                if (id) {
                    var url = "{{ route('admin.google.notification.destroy',':id') }}";
                    url = url.replace(':id', id);
                    var token = "{{ csrf_token() }}";
                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                    });
                }
            });

            $('body').on('click', '#saveBookingNotifactionForm', function () {
                $.easyAjax({
                    url: '{{route('admin.google.notification.store')}}',
                    container: '#bookingNotifactionForm',
                    type: "POST",
                    data: $('#bookingNotifactionForm').serialize(),
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
                            location.reload();
                        }
                    }
                })
            });

            $("body").on("change keyup", "#currency_position, #thousand_separator, #decimal_separator, #no_of_decimal", function() {
                let number              = 1234567.89;
                let no_of_decimal       = $('#no_of_decimal').val();
                let decimal_separator   = $('#decimal_separator').val();
                let thousand_separator  = $('#thousand_separator').val();
                let currency_position   = $('#currency_position').val();
                let formatted_currency  =  currency_format(number, no_of_decimal, decimal_separator, thousand_separator, currency_position);
                $('#formatted_currency').html(formatted_currency);
            });
            function currency_format(number, decimals, dec_point, thousands_sep, currency_position)
            {
                // Strip all characters but numerical ones.
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var currency_symbol = '{{globalSetting()->currency->currency_symbol}}';
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                // number = dec_point == '' ? s[0] : s.join(dec);
                number = s.join(dec);
                switch (currency_position) {
                    case 'left':
                            number = number+currency_symbol;
                        break;
                    case 'right':
                            number = currency_symbol+number;
                        break;
                    case 'left_with_space':
                            number = number+' '+currency_symbol;
                        break;
                    case 'right_with_space':
                            number = currency_symbol+' '+number;
                        break;
                    default:
                        number = currency_symbol+number;
                        break;
                }
                return number;
            }
        </script>

<script>
    $('#save-google-map-form').click(function () {

        $.easyAjax({
            url: '{{route('admin.googleMapApiKey')}}',
            container: '#googleMapApiKeyForm',
            type: "POST",
            redirect: true,
            file:true,
            data: $('#googleMapApiKeyForm').serialize(),
            blockUI: true,
            disableButton: true,
            buttonSelector: "#save-form",
        })
    });
</script>

        @include('vendor.froiden-envato.update.update_script')
    @endpermission
@endpush
