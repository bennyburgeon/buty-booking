<style>
    .serviceTypeDropdown{
        width: 200px;
        border: 1px solid grey;
        border-radius: 4px;
    }
</style>
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
<div class="col-md-12 d-flex justify-content-between p-0 mb-4 position-relative grey-border rounded align-items-center">
    <h5 class="mb-0">@lang('messages.chooseServiceType')</h5>
    <div class="dropdown serviceTypeDropdown">
        <a class="dropdown-toggle f-12 text-dark d-flex justify-content-between align-items-center p-2"
            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            service type</a>
        <ul class="w-100 dropdown-menu grey-border" aria-labelledby="dropdownMenuButton1">
            <li>
                <a class="dropdown-item f-12 service-filter active" id="service-filter-all" data-service-type="all" href="javascript:;">@lang('app.all')</a>
            </li>
            <li>
                <a class="dropdown-item f-12 service-filter" id="service-filter-online" data-service-type="online" href="javascript:;">@lang('app.online')</a>
            </li>
            <li>
                <a class="dropdown-item f-12 service-filter" id="service-filter-offline" data-service-type="offline" href="javascript:;">@lang('app.offline')</a>
            </li>
        </ul>
    </div>
</div>
<div id="services" class="row">
    @forelse ($services as $service)
        <div class="col-lg-3 col-md-6 col-12 mb-30 services-list service-category-{{ $service->category_id }}">
            <div class="listing-item">
                <div class="img-holder" style="background-image: url('{{ $service->service_image_url }}')">
                    @if ($service->service_type === 'online')
                        <div class="online"></div>
                    @endif
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
                                <span
                                    class="unit"></span>{{ currencyFormatter($service->discounted_price) }}
                            </div>
                        </li>
                        <li class="mt-1">
                            <div class="dropdown add-items">
                                <a id="service{{ $service->id }}"
                                    href="javascript:;"
                                    class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                    data-type="service"
                                    data-unique-id="{{ $service->id }}"
                                    data-id="{{ $service->id }}"
                                    data-price="{{$service->discounted_price}}"
                                    data-name="{{ ucwords($service->name) }}"
                                    data-service-type="{{ ucwords($service->service_type) }}"
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
    @empty
        <div id="services" class="col-md-12 d-block">
            <div class="col-12 text-center mb-5">
                <h3 class="no-services">
                    <i class="fa fa-exclamation-triangle"></i> @lang('app.noServicesFound').
                </h3>
            </div>
        </div>
    @endforelse

</div>

@if ($services->count() > 0)
    <div class="services_pagination mt-4 d-flex justify-content-center" id="pagination">
        <div class="col-md-6 text-left pagination"> {{ $services->links() }}</div>
        <div class="col-md-6 text-right">
            <a href="javascript:;" onclick="goToPage('GET', '{{ route('front.bookingPage') }}')" class="btn btn-custom">
                @lang('front.selectBookingTime')
                <i class="fa fa-angle-right ml-1"></i>
            </a>
        </div>
    </div>
@endif

