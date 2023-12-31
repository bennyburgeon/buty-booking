@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="modal-title">@lang('app.edit')@lang('app.page')</h3>
                </div>
                <div class="card-body">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    <script>
        $(function() {
            $('#content').summernote({
                dialogsInBody: true,
                height: 300
            })
        })
        $('#save-form').click(function () {
            const form = $('#editForm');

            $.easyAjax({
                url: '{{route('admin.pages.update', $page->slug)}}',
                container: '#editForm',
                type: "PUT",
                redirect: true,
                data: form.serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        // location.href = '{{ route('admin.search.show', session()->get("searchKey")) }}'
                        location.href = '{{ route('admin.settings.index').'#front-pages' }}'
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
@endpush
