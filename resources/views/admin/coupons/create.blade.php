
@extends('layouts.master')

@push('head-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

<style>
    .collapse.in{
        display: block;
    }
</style>

@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('menu.coupon')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf

                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.coupon') @lang('app.code') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.startTime') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.endTime')</label>
                                    <input type="text" class="form-control" id="end_time"  name="end_time" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.usesTime')</label>
                                    <input type="number" class="form-control" name="uses_time">
                                    <span class="help-block">@lang('messages.howManyTimeUserCanUse')</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.discountType')</label>
                                    <select name="discount_type" id="discount_type" class="form-control">
                                    <option value="percentage"> @lang('app.percentage') </option>
                                    <option value="amount"> @lang('app.fixAmount')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.percent') / @lang('app.amount')</label>
                                    <input type="number" class="form-control" name="amount" id="amount" min="0" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.minimumPurchaseAmount')</label>
                                    <input type="number" class="form-control" name="minimum_purchase_amount">
                                    <span class="help-block">@lang('messages.coupon.keepBlankForwithoutMinimumAmount')</span>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="row">
                                    <label style="margin-left: 10px">@lang('app.dayForApply') </label>
                                    @forelse($days as $day)
                                        <div class="form-group" style="margin-left: 20px">
                                            <label class="">
                                                <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false" style="position: relative; margin-right: 5px">
                                                    <input type="checkbox" checked value="{{$day}}" name="days[]" class="flat-red columnCheck"  style="position: absolute; opacity: 0;">
                                                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                </div>
                                                @lang('app.'. strtolower($day))
                                            </label>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@lang('app.status')</label>
                                    <select name="status" class="form-control">
                                        <option value="active"> @lang('app.active') </option>
                                        <option value="inactive"> @lang('app.inactive') </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('app.description')</label>
                                    <textarea name="description" id="description" cols="30" class="form-control-lg form-control" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> @lang('app.save')</button>
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
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/js/collaps.js') }}"></script>
<script src="{{ asset('assets/js/transition.js') }}"></script>


    <script>

        let startDate = '';
        let endDate = '';
        let startTime = '';
        let endTime = '';

        $(function () {
            $('#description').summernote({
                dialogsInBody: true,
                height: 300
            });
            $('#customers').select2();
        })

        $('#start_time').datetimepicker({
            format: '{{ $date_picker_format }} {{ $time_picker_format }}',
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
            startDate =  moment(e.date).format('YYYY-MM-DD');
            startTime = convert(e.date);
        });

        $('#end_time').datetimepicker({
            format: '{{ $date_picker_format }} {{ $time_picker_format }}',
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
            endDate =  moment(e.date).format('YYYY-MM-DD');
            endTime = convert(e.date);
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.coupons.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data:$('#createForm').serialize()+'&startDate='+startDate+'&endDate='+endDate+'&startTime='+startTime+'&endTime='+endTime,
            })
        });

        $('#amount').keyup(function () {
            let discount_type =  $('#discount_type').val();

            if(discount_type == 'percentage' && $(this).val() > 100){
                $(this).val(0);
            }
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

    </script>

@endpush
