<div class="modal-header">
    <h4>@lang('menu.UpdateGetStartedNote')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <h6 class="text-primary">@lang('app.title')</h6>
                <div class="form-group">
                    <input type="text" name="get_started_title" id="get_started_title" value="{{$getStartedData->get_started_title}}" class="form-control-lg form-control">
                </div>
            </div>
            <div class="col-md-12">
                <h6 class="text-primary">@lang('app.note')</h6>
                <div class="form-group">
                    <textarea name="get_started_note" id="get_started_note" cols="30" class="form-control-lg form-control"
                        rows="4">{{ $getStartedData->get_started_note }}</textarea>
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
            url: '{{ route('admin.getStartedNote', $getStartedData->id) }}',
            container: '#editForm',
            type: "POST",
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    });

</script>
