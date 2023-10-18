<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="company-details text-center">
                        <div class="row justify-content-center mb-5 pb-4 border-bottom">
                            <div class="col-md-4 col-sm-6 col-12 mb-30">
                                <div class="f-content">
                                    <i class="fa fa-map-marker"></i>
                                    <p>
                                        <strong>{{ $settings->company_name }}</strong>
                                    </p>
                                    <p>{!! $settings->formatted_address !!}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12 mb-30">
                                <div class="f-content">
                                    <i class="fa fa-phone"></i>
                                    {{ $settings->company_phone }}

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12 mb-30">
                                <div class="f-content">
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:{{ $settings->company_email }}">{{ $settings->company_email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($pages as $page)
                <div class=" col-md-4 quick-link d-flex flex-wrap align-items-center justify-content-between">
                        @if ($page->id !== null)
                            <a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a>
                        @endif
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {{ ucfirst($footerSetting->footer_text) }}
                </div>
            </div>
        </div>
    </div>
</footer>
