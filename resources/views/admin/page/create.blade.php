<div class="modal-header">
    <h4 class="modal-title">@lang('app.createNew')@lang('app.page')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form role="form" id="createPageForm" class="ajax-form" method="POST">
        @csrf

        <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

        <div class="row">
            <div class="col-md">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('app.page')@lang('app.title')<span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg" value="">
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label>@lang('app.page')@lang('app.slug')<span class="text-danger">*</span></label>
                    <input type="text" name="slug" id="slug" class="form-control form-control-lg" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label><h6>Choose Section<span class="text-danger">*</span></h6></label>
                    <div class="radio radio-inline">
                        <input type="radio" id="who-we-are" value="who_we_are" name="section" checked="">
                        <label for="who-we-are">@lang('app.whoWeAre')</label>
                    </div>
                    <div class="radio radio-inline">
                        <input type="radio" id="support" value="support" name="section">
                        <label for="support">@lang('app.support') </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>@lang('app.page')@lang('app.content')<span class="text-danger">*</span></label>
                    <textarea name="content" id="content" cols="30" class="form-control-lg form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <h6 class="text-primary">@lang('app.image')</h6>
                <div class="form-group">
                    <div class="card">
                        <div class="card-body">
                            <input type="file" id="image" name="image" accept=".png,.jpg,.jpeg" class="dropify"/>
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
    <button type="button" id="save-form-front" class="btn btn-success"><i class="fa fa-check"></i>
        @lang('app.submit')</button>
</div>

<script>

    $('.dropify').dropify({
        messages: {
            default: '@lang("app.dragDrop")',
            replace: '@lang("app.dragDropReplace")',
            remove: '@lang("app.remove")',
            error: '@lang('app.largeFile')',
        }
    });

    $('#content').summernote({
        dialogsInBody: true ,
        height: 300
    });

    function createSlug(value) {
        value = value.replace(/\s\s+/g, ' ');
        let slug = value.split(' ').join('-').toLowerCase();
        slug = slug.replace(/--+/g, '-');
        $('#slug').val(slug);
    }

    $('#title').keyup(function (e) {
        createSlug($(this).val());
    });

    $('#slug').keyup(function (e) {
        createSlug($(this).val());
    });
</script>
