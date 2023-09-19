<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #999;
    }
    .select2-dropdown .select2-search__field:focus, .select2-search--inline .select2-search__field:focus {
        border: 0px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        margin: 0 13px;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #cfd1da;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__clear {
        cursor: pointer;
        float: right;
        font-weight: bold;
        margin-top: 8px;
        margin-right: 15px;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title">@lang('app.add') @lang('app.employeeGroup')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <form role="form" id="createEmployeeGroup"  class="ajax-form" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>@lang('app.name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="name" value="">
                            </div>

                            <div class="form-group">
                                <label>@lang('app.assignServices')</label>
                                <select name="business_service_id[]" id="business_service" class="form-control form-control-lg business_service_id" multiple="multiple" style="width: 100%">
                                    <option value="0">@lang('app.selectServices')</option>
                                    @foreach($business_services as $business_service)
                                        <option value="{{ $business_service->id }}">{{ $business_service->name }} ( {{ $business_service->location->name }} ) </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" id="save-employee-group" class="btn btn-success"><i
        class="fa fa-check "></i> @lang('app.save')</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
</div>
<script>

    $( document ).ready(function() {
        $('#business_service').select2();
    });

    $('#save-employee-group').click(function () {
        $.easyAjax({
                url: '{{route('admin.employee-group.store')}}',
                container: '#createEmployeeGroup',
                type: "POST",
                redirect: true,
                data: $('#createEmployeeGroup').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        $('#group_id').html(response.data);
                        $(modal_lg).modal('hide');
                    }
                }
            })
    });
</script>





