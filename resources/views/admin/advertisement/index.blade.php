@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('create_advertisement_banner'))
                        <div class="d-flex justify-content-center justify-content-md-end mb-3">
                            <a href="{{ route('admin.advertisements.create') }}" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> @lang('app.createNew')</a>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="myTable" class="table w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('app.image')</th>
                                <th>@lang('app.position')</th>
                                <th>@lang('app.startOn')</th>
                                <th>@lang('app.expireOn')</th>
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
                ajax: '{!! route('admin.advertisements.index') !!}',
                language: languageOptions(),
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-bs-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'image', name: 'image' },
                    { data: 'position', name: 'position' },
                    { data: 'start_date_time', name: 'start_date_time' },
                    { data: 'end_date_time', name: 'end_date_time' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', width: '15%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('click', '.view-advertisement', function() {
                var id = $(this).data('row-id');
                var url = "{{ route('admin.advertisements.show',':id') }}";
                url = url.replace(':id', id);

                $(modal_lg + ' ' + modal_heading).html('Show deal');
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
                            var url = "{{ route('admin.advertisements.destroy',':id') }}";
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

        } );
    </script>
@endpush
