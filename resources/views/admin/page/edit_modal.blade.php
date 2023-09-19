<div class="modal-header">
    <h4 class="modal-title">@lang('app.edit')@lang('app.page')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="editForm"  class="ajax-form" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $page->id }}">
        <div class="row">
            <div class="col-md">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('app.page')@lang('app.title')<span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg" value="{{ $page->title }}" autofocus>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label>@lang('app.page')@lang('app.slug')<span class="text-danger">*</span></label>
                    <input type="text" name="slug" id="slug" class="form-control form-control-lg" value="{{ $page->slug }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label><h6>Choose Section<span class="text-danger">*</span></h6></label>
                    <div class="radio radio-inline">
                        <input type="radio" id="who-we-are" value="who_we_are" {{ $page->section == 'who-we-are' ? 'checked' : '' }} name="section" checked="">
                        <label for="who-we-are">@lang('app.whoWeAre')</label>
                    </div>
                    <div class="radio radio-inline">
                        <input type="radio" id="support" value="support" {{ $page->section == 'support' ? 'checked' : '' }} name="section">
                        <label for="support">@lang('app.support') </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>@lang('app.page')@lang('app.content')</label>
                    <textarea name="content" id="content" cols="30" class="form-control-lg form-control" rows="4">{{ $page->content }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <h6 class="text-primary">@lang('app.image')</h6>
                <div class="form-group">
                    <div class="card">
                        <div class="card-body">
                            <input type="file" id="image" name="image" accept=".png,.jpg,.jpeg" class="dropify" data-default-file="{{ $page->page_image_url  }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
    <button type="button" id="save-page-edit-form" class="btn btn-success"><i class="fa fa-check"></i>
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

    $(function() {
        $('#content').summernote({
            dialogsInBody: true,
            height: 300
        })
    })
    $('#save-page-edit-form').click(function () {
        const form = $('#editForm');

        $.easyAjax({
            url: '{{route('admin.pages.update', $page->slug)}}',
            container: '#editForm',
            type: "POST",
            redirect: true,
            file:true,
            data: form.serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $(modal_lg).modal('hide');
                    table._fnDraw();
                }
            }
        })
    });

    function createSlug(value) {
        value = value.replace(/\s\s+/g, ' ');
        let slug = value.split(' ').join('-').toLowerCase();
        slug = slug.replace(/--+/g, '-');
        $('#slug').val(slug);
    }

    $('#title').keyup(function(e) {
        createSlug($(this).val());
    });

    $('#slug').keyup(function(e) {
        createSlug($(this).val());
    });
</script>
