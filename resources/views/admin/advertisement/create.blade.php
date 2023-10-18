@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('menu.advertisement')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf

                        <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

                        <div class="row">
                            <div class="col-md">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.position')<span class="text-danger">*</span></label>
                                    <select name="position" class="form-control">
                                        <option value="">@lang('app.selectServices')</option>
                                        <option value="after deal"> @lang('app.after') @lang('app.deal') </option>
                                        <option value="after categories"> @lang('app.after') @lang('app.category') </option>
                                        <option value="after banner">@lang('app.after') @lang('app.banner')</option>
                                        <option value="after company detail"> @lang('app.after') @lang('app.company') @lang('app.detail') </option>
                                        <option value="after customer feedback"> @lang('app.after') @lang('app.customer') @lang('app.feedback') </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="name">@lang('app.status')</label>
                                    <select name="status" class="form-control">
                                        <option value="active"> @lang('app.active') </option>
                                        <option value="inactive"> @lang('app.inactive') </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.appliedBetweenDateTime')<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="daterange" name="applied_between_dates" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.image')<span class="text-danger">* (image resolution 1300*200px)</span></label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> @lang('app.save')</button>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="advertisement_startDate" id="advertisement_startDate">
                        <input type="hidden" name="advertisement_endDate" id="advertisement_endDate">

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('footer-js')

    <script>
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $(function() {
            moment.locale('{{ $settings->locale }}');
            $('input[name="applied_between_dates"]').daterangepicker({
                timePicker: true,
                minDate: moment().startOf('hour'),
                autoUpdateInput: false,
            });
        });

        function convert(str)
        {
            var date = new Date(str);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            hours = ("0" + hours).slice(-2);
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        $('input[name="applied_between_dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('{{ $date_picker_format }} {{$time_picker_format}}') + '--' + picker.endDate.format('{{ $date_picker_format }} {{$time_picker_format}}'));
            $('#advertisement_startDate').val(picker.startDate.format('YYYY-MM-DD')+' '+convert(picker.startDate));
            $('#advertisement_endDate').val(picker.endDate.format('YYYY-MM-DD')+' '+convert(picker.endDate));
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.advertisements.store')}}',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize(),

                container: '#createForm',
                blockUI: true,
                disableButton: true,
                buttonSelector: "#save-form",
            })
        });

    </script>

@endpush
