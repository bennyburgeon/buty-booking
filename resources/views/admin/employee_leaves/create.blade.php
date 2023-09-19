<style>
    .select2-container--default .select2-selection--single {
        height: 31px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.4 !important;
    }

</style>

    <div class="row">
        <div class="col-md-12">
                <div class="modal-header">
                    @if ($user->is_employee)
                    <h4>@lang('app.applyLeave')</h4>
                    @else
                    <h4>@lang('app.assignLeave')</h4>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form role="form" id="createLeaveForm" class="ajax-form" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">

                            @if ($user->is_admin)
                            <div class="col-md-12">
                                <div class="form-group" id="emp">
                                    <label>@lang('app.selectEmployee')<sup class="text-danger">*</sup></label>
                                    <select name="employee" id="employee" class="form-control form-control-lg select2"
                                        style="width: 100%">
                                        <option value="">@lang('app.select') @lang('app.employee')</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-12">
                                <label for="">@lang('app.startDate')<sup class="text-danger">*</sup></label>
                                <div class="input-group form-group">
                                    <input type="text" class="form-control" name="startdate" id="startdate" value="">
                                    <span class="input-group-append input-group-addon">
                                        <button type="button" class="btn btn-info" disabled><span
                                                class="fa fa-calendar-o"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="">@lang('app.endDate')<sup class="text-danger">*</sup></label>
                                <div class="input-group form-group">
                                    <input type="text" class="form-control" name="enddate" id="enddate" value="">
                                    <span class="input-group-append input-group-addon">
                                        <button type="button" class="btn btn-info" disabled><span
                                                class="fa fa-calendar-o"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.halfday')</label>
                                    <br>
                                    <label class="switch" style="margin-top: .2em">
                                        <input type="checkbox" name="half_day" id="half_day" value="">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="w-100 leavetime" style="display: none">
                                <div class="col-md-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>@lang('app.fromTime')<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" id="starttime" name="starttime"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>@lang('app.toTime')<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" id="endtime" name="endtime"
                                            autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="">@lang('app.reason')<sup class="text-danger">*</sup></label>
                                <div class="form-group">
                                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="leave_startTime" id="leave_startTime">
                            <input type="hidden" name="leave_endTime" id="leave_endTime">

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        @lang('app.cancel')</button>
                    <button type="button" id="save-form" class="btn btn-success"><i class="fa fa-check"></i>
                        @lang('app.submit')</button>
                </div>
        </div>
    </div>

    <script>

        // save leave
        $('#save-form').click(function () {
            $('#save-form').attr('disabled', true);
        const form = $('#createLeaveForm');

            $.easyAjax({
                url: '{{route('admin.employee-leaves.store')}}',
                container: '#createLeaveForm',
                blockUI: true,
                type: "POST",
                redirect: true,
                data: form.serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        window.location.reload();
                        $.unblockUI();
                        $('#save-form').attr('disabled', true);
                    }
                }
            })
        });


        $(document).ready(function() {
            $('#half_day').change(function() {
                if ($('#half_day').is(":checked"))
                {
                    $('#half_day').val('true');
                    $('.leavetime').show();

                }else {

                    $('#half_day').val('');

                    $('.leavetime').hide();
                    $('#starttime').val('');
                    $('#endtime').val('');
                    $('#leave_startTime').val('');
                    $('#leave_endTime').val('');
                }
            });
        });

        $("#employee").select2({
            // allowClear: true
        });

        $('#starttime').datetimepicker({
            format: '{{ $time_picker_format }}',
            locale: '{{ $settings->locale }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-angle-double-left",
                next: "fa fa-angle-double-right",
            },
            useCurrent: false,
        }).on('dp.change', function(e) {
            $('#leave_startTime').val(convert(e.date));
        });

        $('#endtime').datetimepicker({
            format: '{{ $time_picker_format }}',
            locale: '{{ $settings->locale }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-angle-double-left",
                next: "fa fa-angle-double-right",
            },
            useCurrent: false,
        }).on('dp.change', function(e) {
            $('#leave_endTime').val(convert(e.date));
        });


        $('#startdate').datetimepicker({
            format: '{{ $date_picker_format }}',
            locale: '{{ $settings->locale }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-angle-double-left",
                next: "fa fa-angle-double-right"
            },
            useCurrent: false,
        }).on('dp.change', function(e) {
            startDate = moment(e.date).format('YYYY-MM-DD');
        });

        $('#enddate').datetimepicker({
            format: '{{ $date_picker_format }}',
            locale: '{{ $settings->locale }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-angle-double-left",
                next: "fa fa-angle-double-right"
            },
            useCurrent: false,
        }).on('dp.change', function(e) {
            endDate = moment(e.date).format('YYYY-MM-DD');
        });

        function convert(str) {
            var date = new Date(str);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            hours = ("0" + hours).slice(-2);
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

    </script>

