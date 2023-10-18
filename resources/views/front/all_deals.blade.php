@if ($deals->count() !== 0)

    <div class="row">
        <div class="col-12">
            <div class="all-title">
                <p> @lang('front.bestDeals') </p>
                <h3 class="sec-title">
                    @lang('app.deal')
                </h3>
            </div>
        </div>
    </div>

    <div class="row" id="owl-carousel">
        <div class="owl-carousel owl-theme owl-loaded">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    @foreach ($deals as $deal)
                        <div class="owl-item col-xs-1">
                            <div class="listing-item">
                                <div class="img-holder" style="background-image: url('{{ $deal->deal_image_url }}')">
                                    <div class="category-name">
                                        <i class="flaticon-fork mr-1">
                                            @if ($deal->deal_type == '')
                                                @lang('app.offer')
                                            @else
                                                {{ $deal->deal_type }}
                                            @endif
                                        </i>
                                    </div>
                                </div>
                                <div class="list-content">
                                    <h5 class="mb-2">
                                        <a href="{{ $deal->deal_detail_url }}">{{ ucwords($deal->title) }}</a>
                                    </h5>
                                    <div><i class="fa fa-map-marker"></i> {{ $deal->location->name }} </div>
                                    <ul class="ctg-info centering h-center v-center">
                                        <li class="mt-2">
                                            <div class="service-price">
                                                <s class="h6 text-danger">{{ currencyFormatter($deal->original_amount) }}</s>
                                                <span
                                                    class="unit"></span>{{ currencyFormatter($deal->deal_amount) }}
                                            </div>
                                        </li>
                                        <li class="mt-2">
                                            <div style="margin-left: 2.5em" class="dropdown add-items center-h">
                                                <a href="{{ $deal->deal_detail_url }}"
                                                    class="btn-custom btn-blue dropdown-toggle">
                                                    @lang('app.view') @lang('app.detail')
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
     $(".owl-carousel").owlCarousel({
            // loop:true,
            margin:20,
            dots:true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                }
            }
        });
    </script>
@endif
