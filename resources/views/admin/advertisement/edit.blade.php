@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.edit') @lang('menu.advertisement')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $advertisement->id }}">
                        <div class="row">
                            <div class="col-md">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.position')<span class="text-danger">*</span></label>
                                    <select name="position" class="form-control">
                                        <option @if ($advertisement->position == 'after deal') selected @endif value="after deal"> @lang('app.after') @lang('app.deal') </option>
                                        <option @if ($advertisement->position == 'after services') selected @endif  value="after services"> @lang('app.after') @lang('app.services') </option>
                                        <option @if ($advertisement->position == 'after categories') selected @endif  value="after categories"> @lang('app.after') @lang('app.category') </option>
                                        <option @if ($advertisement->position == 'after banner') selected @endif  value="after banner"> @lang('app.after') @lang('app.banner') </option>
                                        <option @if ($advertisement->position == 'after company detail') selected @endif  value="after company detail"> @lang('app.after') @lang('app.company') @lang('app.detail') </option>
                                        <option @if ($advertisement->position == 'after customer feedback') selected @endif  value="after customer feedback"> @lang('app.after') @lang('app.customer') @lang('app.feedback') </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="name">@lang('app.status')</label>
                                    <select name="status" class="form-control">
                                        <option @if ($advertisement->status=='active') selected @endif value="active"> @lang('app.active') </option>
                                        <option @if ($advertisement->status=='inactive') selected @endif value="inactive"> @lang('app.inactive') </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.appliedBetweenDateTime')<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="daterange" name="applied_between_dates" autocomplete="off" value="{{ $advertisement->start_date_time}}--{{$advertisement->end_date_time}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.image')<span class="text-danger">* (image resolution 1300*200px)</span></label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify dropify-event"
                                                   data-default-file="{{ $advertisement->advertisement_image_url  }}"
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

                        <input type="hidden" name="advertisement_startDate" id="advertisement_startDate" value="{{ $advertisement->start_date_time}}">
                        <input type="hidden" name="advertisement_endDate" id="advertisement_endDate" value="{{ $advertisement->end_date_time}}">

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
        var drEvent = $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        drEvent.on("dropify.afterClear", function (event, element) {
        var elementID = element.element.id;
        var elementName = element.element.name;
        if ($("#" + elementID + "_delete").length == 0) {
            console.log(element, elementID);
            $("#" + elementID).after(
                '<input type="hidden" name="' +
                    elementName +
                    '_delete" id="' +
                    elementID +
                    '_delete" value="yes">'
            );
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
                url: '{{route('admin.advertisements.update', $advertisement->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize()
            })
        });
    </script>

@endpush
