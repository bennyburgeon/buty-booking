@extends('layouts.front')

@section('content')
    <section class="section sp-80 bg-w">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="all-title">
                        <h3 class="sec-title">
                            {{ $page->title }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="company-img">
                        <img src="{{ $page->page_image_url }}" alt="Appointo" />
                    </div>
                </div>
                <div class="col-6 content mx-5">
                    {!! $page->content !!}
                    @if ($page->id == 2)
                        <hr>
                        <div class="row">
                            <form class="contact-form col-md-6" id="contact_form" method="post" action="">
                                @csrf
                                <div id="alert"></div>
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Message<span class="text-danger">*</span></label>
                                    <textarea name="details" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="button" name="submit" onclick="javascript:contactSubmit();" class="btn btn-custom">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    <script>
        function contactSubmit() {
            $.easyAjax({
                url: '{{ route('front.contact') }}',
                type: 'POST',
                container: '#contact_form',
                formReset: true,
                data: $('#contact_form').serialize()
            })
        }

        $('body').on('keypress', '#contact_form input,#contact_form textarea', function(e) {
            $(this).siblings('.invalid-feedback').remove();
        })
    </script>
@endpush
