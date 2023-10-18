@extends('layouts-new.front')

@push('styles')
<style>
    /* Add custom CSS here */
    #contact_form .input-group input{
        border : 1px solid #f1efef;
    }

    .add_image{
        margin-top: 10%;
        margin-left: -24px;
        margin-right: 24px;
    }
</style>
@endpush

@section('content')

<!-- CONTACT FORM START -->
<section class="bg-white py-100">
    <div class="container">

        <div class="row ">
            <div class="col-lg-9 m-auto col-12">
                <form class="contact-form p-3 p-lg-5 p-md-5" id="contact_form" method="post">
                    @csrf

                    <div class="row">
                        <div class="heading text-center  w-100">
                            <h3 class="font-weight-bold">{{ $page->title }}</h3>
                        </div>

                        <div class="row">
                            <div class=" col-6 add_image">
                                <div class="company-img">
                                    <img src="{{ $page->page_image_url }}" alt="Appointo" />
                                </div>
                            </div>
                            <div class="col-6">
                                @if ($page->id != 2) <br><br> @endif
                                <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">
                                    @if ($page->id == 2) @lang('front.contactUsNote') @else {!! $page->content !!} @endif</p>
                                </div>
                            </div>
                        </div>

                        @if ($page->id == 2)

                        <div class="row pt-50">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group mb-10 rounded border-0">
                                        <input type="text" class="form-control f-13" name="name" placeholder="First Name (Required)" required>
                                        <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-person text-light" viewBox="0 0 16 16">
                                            <path
                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-10 rounded border-0">
                                <input type="text" class="form-control f-13" name="lastName" placeholder="Last Name">
                                <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person text-light" viewBox="0 0 16 16">
                                    <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group form-group mb-30 rounded border-0">
                                <input type="text" class="form-control f-13" name="email" placeholder="Email(Required)" required>
                                <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-envelope text-light" viewBox="0 0 16 16">
                                        <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-30 rounded border-0">
                                <input type="text" class="form-control f-13" name="phone" placeholder="Phone Number">
                                <span class="input-group-text border-0 bg-secondary" id="basic-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-telephone text-light" viewBox="0 0 16 16">
                                    <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="input-group form-group mb-30 rounded border-0">
                                <textarea class="form-control f-13 h-auto pt-3" name="details" rows="5"
                                placeholder="Write your message here....(Required)" required></textarea>
                                <span class="input-group-text border-0 bg-secondary align-items-start pt-3" id="basic-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pen text-light" viewBox="0 0 16 16">
                                    <path
                                    d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="primary-btn btn-md mt-4 btn f-13 h-30 d-flex" onclick="contactSubmit();">
                                @lang('app.submit')
                            </button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT FORM END -->

<!-- CTA START -->
<section class="cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-9">
                <h4 class="text-white mb-3">{{ $settings->get_started_title }}</h4>
                <p class="text-white f-14 mb-4 mb-lg-0 mb-md-0">{{ $settings->get_started_note }}</p>
            </div>
            <div class="col-lg-2 col-md-3 d-flex align-items-center">
                <button type="submit" id="getStarted" class="secondary-btn btn-lg btn f-15 w-100">
                    @lang('app.getStarted')
                </button>
            </div>
        </div>
    </div>
</section>
<!-- CTA END -->

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
