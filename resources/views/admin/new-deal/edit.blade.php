<style>
    .dropify-wrapper, .dropify-preview, .dropify-render img {
        background-color: var(--sidebar-bg) !important;
    }
</style>

<div class="modal-header">
    <h4>@lang('app.edit') @lang('menu.newDeal')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $newDeals->id }}">
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                    <h6 class="text-primary">@lang('app.image') <span class="text-danger">* @lang('app.image resolution 800×547px')</span></h6>

                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="image" name="image" accept=".png,.jpg,.jpeg"  class="dropify" data-default-file="{{ $newDeals->new_deal_image_url }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary"> @lang('app.location') <span class="text-danger">*</span></h6>
                        <select name="location_id" class="form-control" >
                        @foreach ($locations as $location)
                            <option @if ($location->id == $newDeals->location_id)
                                selected
                            @endif value="{{ $location->id }}">{{ $location->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary"> @lang('app.link') <span class="text-danger">*</span></h6>
                        <input type="text" name="link" class="form-control form-control-lg" autocomplete="off" value="{{ $newDeals->link }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary"> @lang('app.status') <span class="text-danger">*</span></h6>
                        <select name="status" class="form-control">
                            <option @if ($newDeals->status=='active') selected @endif value="active"> @lang('app.active') </option>
                            <option @if ($newDeals->status=='inactive') selected @endif value="inactive"> @lang('app.inactive') </option>
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


    $('#save-edit-form').click(function () {
        const form = $('#editForm');

        $.easyAjax({
            url: '{{route('admin.new-deal.update', $newDeals->id)}}',
            container: '#editForm',
            type: "POST",
            file:true,
            redirect: true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $(modal_lg).modal('hide');
                    table._fnDraw();
                    window.location.reload();
                }
            }
        })
    });

</script>
