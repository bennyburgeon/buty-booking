<style>
    .dropify-wrapper, .dropify-preview, .dropify-render img {
        background-color: var(--sidebar-bg) !important;
    }
</style>

<div class="modal-header">
    <h4>@lang('app.createNew') @lang('menu.frontSection')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="createForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">@lang('app.sectionTitle')<sup class="text-danger">*</sup></h6>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" name="section_title" id="section_title">
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">@lang('app.titleNote')<sup class="text-danger">*</sup></h6>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" name="title_note" id="title_note">
                    </div>
                </div>
                <div class="col-md-12">
                    <h6 class="text-primary">@lang('app.content')<sup class="text-danger">*</sup></h6>
                    <div class="form-group">
                        <textarea name="section_content" id="section_content" cols="30" class="form-control-lg form-control"
                            rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <h6 class="text-primary">@lang('app.contentAlignment')</h6>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body" style="margin-top:3%;">
                                <input type="radio" id="content_alignment" name="content_alignment" value="left" checked>
                                <label for="content_alignment"> <h6 class="">@lang('app.left')</h6></label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="content_alignments" name="content_alignment" value="right">
                                <label for="content_alignments">  <h6 class="">@lang('app.right')</h6></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h6 class="text-primary">@lang('app.image')</h6>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="image" name="image"
                                    accept=".png,.jpg,.jpeg" class="dropify"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
    <button type="button" id="save-form" class="btn btn-success"><i class="fa fa-check"></i>
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

    $(function () {
        $('#section_content').summernote({
            dialogsInBody: true,
            height: 200
        })
    });

    $('#save-form').click(function () {
        const form = $('#createForm');
        $.easyAjax({
            url: '{{route('admin.front-section.store')}}',
            container: '#createForm',
            type: "POST",
            file:true,
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
