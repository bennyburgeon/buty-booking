<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="all-title">
                <p> @lang('front.servicesTitle') </p>
                <h3 class="sec-title">
                    @lang('front.services')
                </h3>
            </div>
        </div>
    </div>
    <div id="services" class="row">
        @foreach ($services as $service)
            <div class="col-lg-3 col-md-6 col-12 mb-30 services-list service-category-{{ $service->category_id }}">
                <div class="listing-item">
                    <div class="img-holder" style="background-image: url('{{ $service->service_image_url }}')">
                        <div class="category-name">
                            <i class="flaticon-fork mr-1"></i>{{ ucwords($service->category->name) }}
                        </div>
                    </div>
                    <div class="list-content">
                        <h5 class="mb-2">
                            <a href="{{ $service->service_detail_url }}">{{ ucwords($service->name) }}</a>
                        </h5>
                        <ul class="ctg-info centering h-center v-center">
                            <li class="mt-1">
                                <div class="service-price">
                                    <span class="unit"></span>{{ currencyFormatter($service->discounted_price) }}
                                </div>
                            </li>
                            <li class="mt-1">
                                <div class="dropdown add-items">
                                    <a href="javascript:;" class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                            data-service-price="{{ $service->discounted_price }}"
                                            data-service-id="{{ $service->id }}"
                                            data-service-name="{{ ucwords($service->name) }}"
                                            aria-expanded="false">
                                        @lang('app.add')
                                        <span class="fa fa-plus"></span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-12 text-right">
            @if ($services->count() > 0)
                <a href="javascript:;" onclick="goToPage('GET', '{{ route('front.bookingPage') }}')" class="btn btn-custom">
                    @lang('front.selectBookingTime')
                    <i class="fa fa-angle-right ml-1"></i>
                </a>
            @endif
        </div>
    </div>
    {{ $services->links() }}
</div>
