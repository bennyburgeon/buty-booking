@extends('layouts.master')

@push('head-css')
    <style>
        .googlemap {
                height: 400px;
            }

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.edit') @lang('app.location')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST" onkeydown="return event.key != 'Enter';">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.name') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="{{ $location->name }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.pincode') </label>
                                    <input type="text" class="form-control form-control-lg" name="pincode" value="{{ $location->pincode }}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.latitude') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="latitude" name="lat" value="{{ $location->lat }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.longitude') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="longitude" name="lng" value="{{ $location->lng }}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.country') <span class="text-danger">*</span></label>
                                    <div class="input-group form-group">
                                        <select name="country_id" id="country_id" class="form-control select2">
                                            <option value="">@lang('app.select') @lang('app.location')</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ $country->id == $location->country_id ? 'selected' : '' }}>
                                                    {{ '+' . $country->phonecode . ' - ' . $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.timezone') <span class="text-danger">*</span></label>
                                    <div class="input-group form-group">
                                        <select name="timezone_id" id="timezone_id" class="form-control select2">
                                            <option value="">@lang('app.select') @lang('app.timezone')</option>
                                            @foreach ($timezones as $timezone)
                                                <option value="{{ $timezone->id }}" {{ $timezone->id == $location->timezone_id ? 'selected' : '' }}>
                                                    {{ $timezone->zone_name }}</option>
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tax_name" class="control-label">@lang('app.company') @lang('app.location')</label>
                                    <input type="text" class="form-control form-control-lg" id="location">
                                </div>
                            </div>
                            <div class="col-md-12 p-3">
                                <div class="googlemap"></div>
                                <label class="control-label text-danger">@lang("app.superAdminAllowMapDevMessage")</label>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> @lang('app.save')</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('footer-js')
@if (!empty($googleMapAPIKey))
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{$googleMapAPIKey->google_map_api_key}}&sensor=false&libraries=places&language={{app()->getLocale()}}'></script>
<script src="{{ asset('js/locationpicker.jquery.js') }}"></script>
    <script>

            $('.googlemap').locationpicker({
                location: {
                    latitude: {{$location->latitude?$location->latitude:'26.85259403535702'}},
                    longitude: {{$location->longitude?$location->longitude:'75.80531537532806'}}
                },
                radius: 0,
                zoom: 4,
                inputBinding: {
                    latitudeInput: $('#latitude'),
                    longitudeInput: $('#longitude'),
                    locationNameInput: $('#location')
                },
                enableAutocomplete: true

            });

    </script>

@endif
    <script>

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.locations.update', $location->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize(),
                success: function(response){
                    if(response.status === 'success')
                    {
                        var msgs = response.message;
                        $.showToastr(msgs, 'success');
                    }
                }

            })
        });

        $('#country_id').change(function () {
            $.easyAjax({
                url: '{{ route('admin.timezone') }}',
                type: "GET",
                redirect: false,
                data: {"_token": "{{ csrf_token() }}", 'country_id' : this.value},
                dataType: "JSON",
                success: function (response){
                    let option = '';
                    $('#timezone_id').html(`<option value=''>@lang('app.select') @lang('app.timezone')</option>`);
                    response.forEach(timezone => {
                        option = `<option value='${timezone.id}'>${timezone.zone_name}</option>`;
                        $('#timezone_id').append(option);
                    });
                }
            })
        });
    </script>

@endpush
