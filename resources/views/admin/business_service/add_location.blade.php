<style>
    .googlemap {
            height:200px;
        }
        .select2{
            width: 100% !important
        }

</style>
<div class="modal-header">
    <h4 class="modal-title">@lang('app.add') @lang('app.location')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <form role="form" id="addLocationForm"  class="ajax-form" method="POST" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

                        <div class="row">
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.name')<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control form-control-lg" name="name" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.pincode') </label>
                                    <input type="text" class="form-control form-control-lg" name="pincode" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.latitude')<sup class="text-danger">*</sup></label>
                                    <input type="text" id="latitude" class="form-control form-control-lg" name="lat" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.longitude')<sup class="text-danger">*</sup></label>
                                    <input type="text" id="longitude" class="form-control form-control-lg" name="lng" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.country')<sup class="text-danger">*</sup></label>
                                    <div class="input-group form-group">
                                        <select name="country_id" id="country_id" class="form-control select2 w-100">
                                            <option value="">@lang('app.select') @lang('app.location')</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{'+'.$country->phonecode.' - '.$country->name}}</option>
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.timezone')<sup class="text-danger">*</sup></label>
                                    <div class="input-group form-group">
                                        <select name="timezone_id" id="timezone_id" class="form-control select2 w-100">
                                            <option value="">@lang('app.select') @lang('app.timezone')</option>
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
                        </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" id="save-location-new" class="btn btn-success"><i
        class="fa fa-check "></i> @lang('app.save')</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
</div>

@if (!empty($googleMapAPIKey))
    <script>
            $('.googlemap').locationpicker({
                location: {
                    latitude: 0,
                    longitude: 0
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
    $('.select2').select2();

    $('#save-location-new').click(function () {
        $.easyAjax({
                url: '{{route('admin.locations.store')}}',
                container: '#addLocationForm',
                type: "POST",
                redirect: true,
                data: $('#addLocationForm').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        $('#location_id').html(response.data);
                        $(modal_lg).modal('hide');
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



