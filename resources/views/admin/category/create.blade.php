@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('app.category')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf

                        <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

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

                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> @lang('app.save')</button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('footer-js')

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

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.categories.store')}}',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize(),
                success: function (response)
                {
                    if(response.status === 'success')
                    {
                        var msgs = response.message;
                        $.showToastr(msgs, 'success');
                    }
                },

                container: '#createForm',
                blockUI: true,
                disableButton: true,
                buttonSelector: "#save-form",
            })
        });

    </script>

@endpush
