<style>
    #customerReportRange {
        background: #fff;
        cursor: pointer;
        padding: 15px 20px;
        border: 1px solid #ccc;
        width: 100%
    }
    #customerreportlocation {
        background: #fff;
        cursor: pointer;
        padding: 9px 15px;
        border: 1px solid #ccc;
    }
    #customer_report_location {
        width:100%; border: none;
    }

    #customerTable {
        width: 100% !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <h6>@lang('app.dateRange') </h6>
                        <div id="customerReportRange" class="form-group">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down pull-right"></i>
                            <input type="hidden" id="start-date">
                            <input type="hidden" id="end-date">
                        </div>
                    </div>
                </div>
                <!-- Custom Tabs -->
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">@lang('menu.customerReport')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="table-responsive">
                                    <table id="customerTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('app.customer') @lang('app.image')</th>
                                                <th>@lang('app.customer') @lang('app.name')</th>
                                                <th>@lang('app.email')</th>
                                                <th>@lang('app.phone')</th>
                                                <th>@lang('app.total') @lang('app.booking')</th>
                                                <th>@lang('app.registeredDate')</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- /myTable -->
                        </div>
                        <!-- /.carmyTable -->
                    </div>
                    <!-- ./card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>

@push('footer-js')
    <script>
        $(function() {
            var start = moment().subtract(30, 'days');
            var end = moment();


            $('#customerReportRange span').html('{{ \Carbon\Carbon::now()->subDays(30)->translatedFormat($settings->date_format) }} - {{ \Carbon\Carbon::now()->translatedFormat($settings->date_format) }}');
            $('#start-date').val(start.format('YYYY-MM-DD'));
            $('#end-date').val(end.format('YYYY-MM-DD'));

            function renderTranslatedNames() {
                @foreach($labels as $key => $label)
                    $(`.daterangepicker li[data-range-key='{{ $key }}']`).html("@lang('app.daterangepicker.'.$label)");
                @endforeach
            }

            moment.locale('{{ $settings->locale }}');

            $('#customerReportRange').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: "MM/DD/YYYY",
                    separator: " - ",
                    applyLabel: "@lang('app.apply')",
                    cancelLabel: "@lang('app.cancel')",
                    customRangeLabel: "@lang('app.daterangepicker.custom')"
                },
                ranges: {
                '@lang("app.daterangepicker.today")': [moment(), moment()],
                '@lang("app.daterangepicker.yesterday")': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '@lang("app.daterangepicker.lastWeek")': [moment().subtract(6, 'days'), moment()],
                '@lang("app.daterangepicker.lastThirtyDays")': [moment().subtract(29, 'days'), moment()],
                '@lang("app.daterangepicker.thisMonth")': [moment().startOf('month'), moment().endOf('month')],
                '@lang("app.daterangepicker.lastMonth")': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#customerReportRange').on('apply.daterangepicker', function(ev, picker) {
                $('#customerReportRange span').html(picker.startDate.format('{{ $date_picker_format }}') + ' - ' + picker.endDate.format('{{ $date_picker_format }}'));

                let startDate = picker.startDate.format('YYYY-MM-DD');
                let endDate = picker.endDate.format('YYYY-MM-DD');

                $('#start-date').val(startDate);
                $('#end-date').val(endDate);

                table.draw();
            });

            renderTranslatedNames();

            $('#start-date').val(start.format('YYYY-MM-DD'));
            $('#end-date').val(end.format('YYYY-MM-DD'));

            var table = $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: '@lang("app.exportCSV")',
                        exportOptions: {
                            columns: [2,3,4,5,6]
                        }
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.reports.customerTable') }}",
                    data: function (d) {
                        d.startDate = $('#start-date').val(),
                        d.endDate = $('#end-date').val()
                    }
                },
                columns: [
                    { data: 'id', name: 'user_id' },
                    { data: 'image', name: 'image' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'totalBookings', name: 'totalBookings' },
                    { data: 'registeredDate', name: 'registeredDate' }
                ]
            });

        });
    </script>
@endpush
