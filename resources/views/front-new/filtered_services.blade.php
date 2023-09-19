@foreach ( $services as $service )
    <div class="row">
        <div class="col-md-12 px-0 service-wrap d-flex">
            <div class="service-img">
                <img src="{{ $service->service_image_url }}" alt="Appointo" />
                @if ($service->service_type == 'online')
                    <span class="online"></span>
                @endif
            </div>
            <div class="service-detail d-flex justify-content-between align-items-center w-100 p-1  p-lg-4 p-md-4">
                <div class="s-d-text">
                    <a href="{{ $service->service_detail_url }}"
                        class="text-dark">
                        <h6 class="f-w-600 mb-3">{{ $service->name }}</h6>
                    </a>
                    <p class="line-height-1"><i class="mr-2">{{ currencyFormatter($service->discounted_price) }}</i></p>
                    <p class="text-light"><i class="las la-clock mr-2"></i>{{ $service->time }} @lang('app.'.$service->time_type)</p>
                </div>
                <div class="s-d-btn">
                    <a id="service{{ $service->id }}"
                        href="javascript:;"
                        class="outline-btn btn-lg btn f-14 d-flex align-items-center justify-content-center add-to-cart"
                        data-type="service"
                        data-id="{{ $service->id }}"
                        data-unique-id="{{ $service->id }}"
                        data-price="{{$service->discounted_price}}"
                        data-service-type="{{$service->service_type}}"
                        data-total_tax_percent="{{ $service->total_tax_percent }}"
                        data-name="{{ ucwords($service->name) }}">
                        @lang('app.add')
                        <i class="las la-plus text-primary f-17"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <span class="my-30 d-block grey-border-top"></span>
@endforeach