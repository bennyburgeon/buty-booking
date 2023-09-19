
<div class="modal-header">
    <h4 class="modal-title">@lang('app.add') @lang('app.category')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <form role="form" id="addCategoryForm"  class="ajax-form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md">
                            <!-- text input -->
                            <div class="form-group">
                                <label>@lang('app.category') @lang('app.name')<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>@lang('app.category') @lang('app.slug')<span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control form-control-lg" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputPassword1">@lang('app.image')</label>
                                <div class="card">
                                    <div class="card-body">
                                        <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" id="save-location-new" class="btn btn-success"><i
        class="fa fa-check "></i> @lang('app.save')</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
</div>
<script>
    $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        function createSlug(value) {
            value = value.replace(/\s\s+/g, ' ');
            let slug = value.split(' ').join('-').toLowerCase();
            slug = slug.replace(/--+/g, '-');
            $('#slug').val(slug);
        }

        $('#name').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#slug').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#save-location-new').click(function () {
            $.easyAjax({
                url: '{{route('admin.categories.store')}}',
                container: '#addCategoryForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#addCategoryForm').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        $('#category_id').html(response.data);
                        $(modal_lg).modal('hide');
                    }
                }
            })
        });
</script>





