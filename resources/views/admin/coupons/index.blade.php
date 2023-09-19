@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('create_coupon'))
                        <div class="d-flex justify-content-center justify-content-md-end mb-3">
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> @lang('app.createNew')</a>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="myTable" class="table w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('app.coupon') @lang('app.code')</th>
                                {{-- <th>@lang('app.code')</th> --}}
                                <th>@lang('app.startOn')</th>
                                <th>@lang('app.expireOn')</th>
                                <th>@lang('app.amountOrPercent')</th>
                                <th>@lang('app.status')</th>
                                <th class="text-right">@lang('app.action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    <script>
        $(document).ready(function() {
            var table = $('#myTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.coupons.data') !!}',
                language: languageOptions(),
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-bs-toggle="tooltip"]'
                    });
                    $('.role_id').select2({
                        width: '100%'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'title', name: 'title' },
                    { data: 'start_date_time', name: 'start_date_time' },
                    { data: 'end_date_time', name: 'end_date_time' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('click', '.view-coupon', function() {
                var id = $(this).data('row-id');
                var url = "{{ route('admin.coupons.show',':id') }}";
                url = url.replace(':id', id);

                $(modal_lg + ' ' + modal_heading).html('View coupon');
                $.ajaxModal(modal_lg, url);
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
                            var url = "{{ route('admin.coupons.destroy',':id') }}";
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
                                        table._fnDraw();
                                    }
                                }
                            });
                        }
                    });
            });
        } );
    </script>
@endpush
