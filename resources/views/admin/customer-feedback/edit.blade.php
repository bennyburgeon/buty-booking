<div class="modal-header">
    <h4>@lang('app.edit') @lang('app.feedbackMessage')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-primary">@lang('app.customer') @lang('app.name')<span class="text-danger">*</span></h6>
                    <div class="form-group">
                        <input type="text" name="customer_name" id="customer_name" value="{{$feedback->customer_name}}" class="form-control-lg form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <h6 class="text-primary">@lang('app.feedbackMessage')<span class="text-danger">*</span></h6>
                    <div class="form-group">
                        <textarea name="feedback_message" id="feedback_message" cols="30" class="form-control-lg form-control"
                            rows="4">{{$feedback->feedback_message}}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary">@lang('app.feedback') @lang('app.status') <span class="text-danger">*</span></h6>
                        <select name="status" id="status" class="form-control form-control-lg">
                            <option @if($feedback->status == 'active') selected @endif
                                value="active">@lang('app.active')</option>
                            <option @if($feedback->status == 'inactive') selected @endif
                                value="inactive">@lang('app.inactive')</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
    <button type="button" id="save-edit-form" class="btn btn-success"><i class="fa fa-check"></i>
        @lang('app.submit')</button>
</div>

<script>

    $('#save-edit-form').click(function () {
        const form = $('#editForm');

        $.easyAjax({
            url: '{{route('admin.feedback.update', $feedback->id)}}',
            container: '#editForm',
            type: "POST",
            file:true,
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $(modal_lg).modal('hide');
                    table._fnDraw();
                }
            }
        })
    });

</script>
