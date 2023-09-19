@extends('layouts.master')

@push('head-css')
    <style>
        #myTable td{
            padding: 0;
        }
        .status{
            font-size: 80%;
        }
        .booking-selected{
            border: 3px solid var(--main-color);
        }
        .payments a {
            border: 2px solid;
        }
        #myTable tbody tr td
        {
            padding-top:20px !important;
            padding-bottom : 15px !important;
        }

        #myTable tbody tr td:nth-child(4)
        {
            text-align: right !important;
        }
        #myTable tbody tr td:nth-child(5)
        {
            text-align: center !important;
        }

        #myModalDefault
        {
            z-index: 9999;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
       <div class="card card-light">
          {{-- @if(($user->is_admin || $user->is_employee) && !\Session::get('loginRole') && ($current_emp_role->name == 'administrator' || $current_emp_role->name == 'employee')) --}}
          <div class="card-header">
             <div class="row">
                <div class="col-md">
                   <div class="form-group">
                      @if ($source == 'online')
                      <input type="hidden" name="booking-via" value="online" id="booking-via">
                      @endif
                      @if ($sourcePos == 'pos')
                      <input type="hidden" name="booking-via-pos" value="pos" id="booking-via-pos">
                      @endif
                      <select name="" id="filter-status" class="form-control">
                         <option value="">@lang('app.filter') @lang('app.status'): @lang('app.viewAll')</option>
                         <option @if($status == 'completed') selected @endif value="completed">@lang('app.completed')</option>
                         {{-- @if ($user->is_employee || $current_emp_role->name == 'employee') --}}
                         <option @if($status == 'pending') selected @endif value="pending">@lang('app.pending')</option>
                         {{-- @endif --}}
                         <option @if($status == 'approved') selected @endif value="approved">@lang('app.approved')</option>
                         <option @if($status == 'in progress') selected @endif value="in progress">@lang('app.in progress')</option>
                         <option @if($status == 'canceled') selected @endif value="canceled">@lang('app.canceled')</option>
                      </select>
                   </div>
                </div>
                @if($current_emp_role->name == 'administrator')
                <div class="col-md">
                   <div class="form-group">
                      <select name="" id="filter-customer" class="form-control select2">
                         <option value="">@lang('modules.booking.selectCustomer'): @lang('app.viewAll')</option>
                         @foreach($customers as $customer)
                         <option value="{{ $customer }}">{{ ucwords($customer) }}</option>
                         @endforeach
                      </select>
                   </div>
                </div>
                <div class="col-md">
                   <div class="form-group">
                      <select name="" id="filter-location" class="form-control select2">
                         <option value="">@lang('modules.booking.selectLocation'): @lang('app.viewAll')</option>
                         @foreach($locations as $location)
                         <option value="{{ $location->id }}">{{ ucwords($location->name) }}</option>
                         @endforeach
                      </select>
                   </div>
                </div>
                <div class="col-md">
                   <div class="form-group">
                      <select style="width:100%" selected name="filter-booking" id="filter-booking" class="form-control select2">
                         <option value="">@lang('app.filter') @lang('app.booking'): @lang('app.viewAll')</option>
                         <option value="booking">@lang('app.service')</option>
                         <option value="deal">@lang('app.deal')</option>
                      </select>
                   </div>
                </div>
                <div class="col-md">
                   <div class="form-group">
                      <select style="width:100%" selected name="filter-sort" id="filter-sort" class="form-control select2">
                         <option value="">@lang('modules.booking.sortBy')</option>
                         <option value="desc">@lang('modules.booking.sort.desc') </option>
                         <option value="asc">@lang('modules.booking.sort.asc')</option>
                      </select>
                   </div>
                </div>
                @endif
                <div class="col-md-12">
                   <h6>@lang('app.dateRange')</h6>
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                      <input type="text" class="form-control datepicker" name="start_date" id="start-date"
                         placeholder="@lang('app.startDate')"
                         value="{{$startDate}}">
                   </div>
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                      <input type="text" class="form-control datepicker" name="end_date" id="end-date"
                         placeholder="@lang('app.endDate')" value="{{$endDate}}">
                   </div>
                </div>
                {{-- @endif --}}
                <div class="col-md">
                   <div class="form-group">
                      <button type="button" id="reset-filter" class="btn btn-danger"><i class="fa fa-times"></i> @lang('app.reset')</button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    {{-- @endif --}}
    <!-- /.card-header -->
    {{-- card-body start --}}
    <div class="card-body">
       <div class="row">
          <div class="col-md-12">
             <div class="card">
                <div class="card-body">
                   <div class="table-responsive">
                      <table id="myTable" class="table w-100">
                         <thead>
                            <tr>
                               <th>#</th>
                               <th>Customer Name</th>
                               <th>Booking Time</th>
                               <th class="text-right">Total</th>
                               <th class="text-center">Status</th>
                               <th class="text-right">@lang('app.action')</th>
                            </tr>
                         </thead>
                      </table>
                   </div>
                </div>
                {{-- @endif --}}
             </div>
             <div class="row">
                @if($user->is_admin && !\Session::get('loginRole') && $current_emp_role->name == 'administrator')
                <div class="col-md-12 alert alert-primary"><i class="fa fa-info-circle"></i> @lang('modules.booking.selectNote')</div>
                @endif
             </div>
             <div class="row">
                <div class="col-md-6">
                   <div class="table-responsive">
                      <table id="myTable" class="table table-borderless w-100">
                         <thead class="hide">
                            <tr>
                               <th>#</th>
                            </tr>
                         </thead>
                      </table>
                   </div>
                </div>
             </div>
             <div class="col-md-6 pl-md-5" id="booking-detail"></div>
          </div>
          {{-- card-body end --}}
       </div>
    </div>
 </div>
 </div>
@endsection

@push('footer-js')

@if($credentials->stripe_status == 'active' && !$user->is_admin)
<script src="https://checkout.stripe.com/checkout.js"></script>
@endif

@if($credentials->razorpay_status == 'active' && !$user->is_admin)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif

@if ($credentials->paystack_status == 'active' && !$user->is_admin)
<script src="https://js.paystack.co/v1/inline.js"></script>
@endif

<script>
    $(document).ready(function()
    {

        $('.select2').select2();

        var table = $('#myTable').dataTable({
            responsive: true,
            "searching": false,
            serverSide: true,
            "ordering": false,
            ajax: {'url' : '{!! route('admin.bookings.index') !!}',
                "data": function ( d ) {
                    return $.extend( {}, d, {
                        "start_date": $('#start-date').val(),
                        "end_date": $('#end-date').val(),
                        "filter_status": $('#filter-status').val(),
                        "booking-via": $('#booking-via').val(),
                        "booking-via-pos": $('#booking-via-pos').val(),
                        "filter_customer": $('#filter-customer').val(),
                        "filter_location": $('#filter-location').val(),
                        "filter_booking": $('#filter-booking').val(),
                        "filter_sort": $('#filter-sort').val(),
                    } );
                }
            },
            language: languageOptions(),
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-bs-toggle="tooltip"]'
                });
            },
            order: [[0, 'DESC']],
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false},
                { data: 'customer name', name: 'customer name' },
                { data: 'booking time', name: 'date time' },
                { data: 'total', name: 'total' },
                { data: 'status', name: 'payment_status' },
                { data: 'action', name: 'action'}
            ]
        });
        new $.fn.dataTable.FixedHeader( table );

        $('.datepicker').datetimepicker({
            format: '{{ $date_picker_format }}',
            locale: '{{ $settings->locale }}',
            allowInputToggle: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-angle-double-left",
                next: "fa fa-angle-double-right",
            },
            useCurrent: false,
        }).on("dp.change", function (e) {
            $('#startDate').val( moment(e.date).format('YYYY-MM-DD'));
            table._fnDraw();
        });

        function updateBooking(currEle) {
            let url = '{{route('admin.bookings.update', ':id')}}';
            url = url.replace(':id', currEle.data('booking-id'));
            $.easyAjax({
                url: url,
                container: '#update-form',
                type: "POST",
                data: $('#update-form').serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        location.reload();
                    }
                }
            });
        }

        $('body').on('click', '#update-booking', function () {
            let cartItems = $("input[name='cart_prices[]']").length;
            let productItems = $("input[name='product_prices[]']").length;

            if(cartItems === 0 && productItems === 0){
                swal('@lang("modules.booking.addItemsToCart")');
                $('#cart-item-error').html('@lang("modules.booking.addItemsToCart")');
                return false;
            }
            else {
                $('#cart-item-error').html('');
                var updateButtonEl = $(this);
                if ($('#booking-status').val() == 'completed' && $('#payment-status').val() == 'pending' && $('.fa.fa-money').parent().text().indexOf('cash') !== -1) {
                    swal({
                        text: '@lang("modules.booking.changePaymentStatus")',
                        closeOnClickOutside: false,
                        buttons: [
                        'NO', 'YES'
                        ]
                    }).then(function (isConfirmed) {
                        if (isConfirmed) {
                            $('#payment-status').val('completed');
                        }
                        updateBooking(updateButtonEl);
                    });
                }
                else {
                    updateBooking(updateButtonEl);
                }
            }

        });

    $('#change-status').click(function () {
        $('#change-status').attr('disabled', true);
        $.easyAjax({
            url: '{{route('admin.bookings.multiStatusUpdate')}}',
            container: '#createForm',
            blockUI: true,
            type: "POST",
            data: $('#createForm').serialize(),
            success: function(response){
                table._fnDraw();
                $.unblockUI();
                $('#change-status').attr('disabled', true);
            }
        })
    });

    $('#change_status').change(function () {
        if ($(this).hasClass('is-invalid')){
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    })

    $('body').on('click', '.delete-row', function(){
        var id = $(this).data('row-id');
        swal({
            icon: "warning",
            buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
            dangerMode: true,
            title: "@lang('errors.areYouSure')",
            text: "@lang('errors.deleteWarning')",
        }).then((willDelete) => {
            if (willDelete) {
                var url = "{{ route('admin.bookings.destroy',':id') }}";
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
                            $('#booking-detail').html('');
                        }
                    }
                });
            }
        });
    });



    $('body').on('click', '.edit-booking', function () {
        let bookingId = $(this).data('booking-id');
        let url = '{{ route('admin.bookings.edit', ':id') }}';
        url = url.replace(':id', bookingId);

        $.easyAjax({
            type: 'GET',
            url: url,
            success: function (response) {
                if (response.status == "success") {
                    $('#booking-detail').hide().html(response.view).fadeIn('slow');
                }
            }
        });
    });

    $('#filter-status,#booking-via,#booking-via-pos, #filter-customer, #filter-location, #filter-booking, #filter-sort').change(function () {
        table._fnDraw();
    });

    $('#reset-filter').click(function () {
        $('#filter-status, #filter-date').val('');
        $("#filter-customer").val('').trigger('change');
        $("#filter-location").val('').trigger('change');
        $("#filter-booking").val('').trigger('change');
        $("#filter-sort").val('').trigger('change');
        $("#start-date").val('').trigger('change');
        $("#end-date").val('').trigger('change');
        table._fnDraw();
    })

});
</script>

@if($user->is_admin)
<script>
    $('#myTable').on('click', '.booking-div', function(){
        let checkbox = $(this).closest('.row').find('.booking-checkboxes');
        if(checkbox.is(":checked")){
            checkbox.removeAttr('checked');
            $(this).closest('.row').removeClass('booking-selected');
        }
        else{
            checkbox.attr('checked', true);
            $(this).closest('.row').addClass('booking-selected');
        }

        $('#selected-booking-count').html($('[name="booking_checkboxes[]"]:checked').length)
        if($('[name="booking_checkboxes[]"]:checked').length > 0){
            $('#change-status').removeAttr('disabled');
        }
        else{
            $('#change-status').attr('disabled', true);
        }
    })

    let moment_startDate = moment().subtract(30, 'days');
    let moment_endDate = moment();

    let startDate = moment_startDate.format('YYYY-MM-DD');
    let endDate = moment_endDate.format('YYYY-MM-DD');

    $('#start-date').datetimepicker({
        format: '{{ $date_picker_format }}',
        locale: '{{ $settings->locale }}',
        allowInputToggle: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
            previous: "fa fa-angle-double-left",
            next: "fa fa-angle-double-right",
        }
    }).on('dp.change', function(e) {
        startDate =  moment(e.date).format('YYYY-MM-DD');
    });

    $('#end-date').datetimepicker({
        format: '{{ $date_picker_format }}',
        locale: '{{ $settings->locale }}',
        allowInputToggle: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
            previous: "fa fa-angle-double-left",
            next: "fa fa-angle-double-right",
        }
    }).on('dp.change', function(e) {
        endDate =  moment(e.date).format('YYYY-MM-DD');
    });

</script>
@endif

@if (Session::has('success'))
<script>
    toastr.success("{!!  Session::get('success') !!}");
    {{ Session::forget('success') }}
</script>
@endif

@endpush
