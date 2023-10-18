<style>
    .dropify-wrapper, .dropify-preview, .dropify-render img {
        background-color: var(--sidebar-bg) !important;
    }
</style>

<div class="modal-header">
    <h4>@lang('app.createNew') @lang('menu.deal')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <section class="mt-3 mb-3">
        <form class="form-horizontal ajax-form" id="createForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">
            <div class="row">

                <div class="col-md-12">
                    <h6 class="text-primary">@lang('app.image') <span class="text-danger">*@lang('app.image resolution 800×547px')
                    </span></h6>
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

                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary"> @lang('app.location') <span class="text-danger">*</span></h6>
                        <select name="location_id" class="form-control">
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" selected> {{ $location->name }} </option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary"> @lang('app.link') <span class="text-danger">*</span></h6>
                        <input type="text" name="link" class="form-control form-control-lg" autocomplete="off">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <h6 class="text-primary"> @lang('app.status') <span class="text-danger">*</span></h6>
                        <select name="status" class="form-control">
                            <option value="active"> @lang('app.active') </option>
                            <option value="inactive"> @lang('app.inactive') </option>
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

    $('#save-form').click(function () {
        const form = $('#createForm');
        $.easyAjax({
            url: '{{route('admin.new-deal.store')}}',
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
