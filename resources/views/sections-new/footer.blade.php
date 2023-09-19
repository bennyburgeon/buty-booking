<!-- FOOTER START -->
<footer class="bg-secondary pt-50">
    <div class="container">
        <div class="row pb-50">
            <div class="col-md-4">
                <div class="footer-wrap footer-menu">
                    <ul class="mb-0">
                        <li class="text-uppercase f-14 text-primary f-w-600 mb-3">@lang('front.whoWeAre')</li>
                        @foreach ($pages as $page)
                                @if ($page->section == 'who we are')
                                    <li class="mb-1">
                                        <a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a>
                                    </li>
                                @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-wrap footer-menu mt-4 mt-lg-0 mt-md-0 d-flex flex-column align-items-center">
                    <ul class="mb-0">
                        <li class="text-uppercase f-14 text-primary f-w-600 mb-3">@lang('front.support')</li>
                        @foreach ($pages as $page)
                                @if ($page->section == 'support')
                                    <li class="mb-1">
                                        <a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a>
                                    </li>
                                @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="footer-wrap mt-4 mt-lg-0 mt-md-0 d-flex flex-column align-items-center align-items-lg-end align-items-md-end">
                    <ul class="mb-0">
                        <li class="text-uppercase f-14 text-primary f-w-600 mb-3">@lang('front.reachUs')</li>
                        <li class="mb-1"><a href="tel:{{ $settings->company_phone }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                                    class="bi bi-telephone mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                                {{ $settings->company_phone }}</a></li>
                        <li class="mb-3">
                            <a href="mailto:{{ $settings->company_email }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                                    class="bi bi-envelope mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
                                </svg>
                                {{ $settings->company_email }}
                            </a>
                        </li>
                        <li class="social-icons">
                            @foreach ($footerSetting->social_links as $link)
                                @if($link['link'] !== null)
                                    <a href="{{ $link['link'] }}" target="_blank" class="@if($link['name']=='facebook') fb @elseif($link['name']=='twitter') tw @elseif($link['name']=='youtube') yt @elseif($link['name']=='instagram') insta @elseif($link['name']=='linkedin') li @endif mr-1">
                                        <i class="lab la-{{$link['name']}}"></i>
                                    </a>
                                @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-0 footer-line" />
        <div class="row py-3 footer-bottom">
            <div class="col-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-globe text-primary" viewBox="0 0 16 16">
                    <path
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                </svg>
                <select class="js-select2 language" name="language">
                    @forelse ($languages as $language)
                        <option value="{{ $language->language_code }}" @if (Cookie::get('appointo_language_code') == $language->language_code) selected @elseif ($settings->locale == $language->language_code) selected @endif>{{ $language->language_name }}</option>
                    @empty
                        <option value= "en" selected>English</option>
                    @endforelse
                </select>
            </div>
            <div class="col-8 d-flex align-items-center justify-content-end">
                <p class="text-grey f-12">{{ ucfirst($footerSetting->footer_text) }}</p>
            </div>
        </div>
        @if (Request::url() == route('front.cartPage') || Request::url() == route('front.manageBooking'))
            <div class="row">
                <div class="mobile-cart p-3 d-flex d-lg-none justify-content-between f-16 font-weight-bold align-items-center">
                    <div class="d-flex">
                        <a data-bs-toggle="modal" href="#cart" class="text-primary d-flex align-items-center justify-content-between mr-2">
                            <i class="las la-shopping-bag f-20 me-1"></i>
                            <span >@lang('app.view') @lang('front.cart')</span>
                        </a>
                        <span class="total text-green"></span>
                    </div>
                    @if(Request::url() == route('front.cartPage'))
                        <a href="{{ route('front.manageBooking') }}" class="primary-btn btn-md btn f-13 h-30 d-flex">
                            <i class="las la-clock f-18 me-1"></i>@lang('front.selectBookingTime')
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</footer>
<!-- FOOTER END -->

@push('footer-script')
    <script>

        $('body').on('change', '.language', function () {
            let code = $(this).val();
            let url = '{{ route('front.changeLanguage', ':code') }}';
            url = url.replace(':code', code);
            $.easyAjax({
                url: url,
                type: 'POST',
                container: 'body',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            });
        });

    </script>
@endpush
