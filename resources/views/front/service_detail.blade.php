@extends('layouts.front')

@section('content')
    <section class="section">
        <section class="service-detail sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>{{ $service->name }}</h4>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        @if ($service->image && is_array($service->image) && sizeof($service->image) > 1)
                            <div id="banner-slider" class="carousel slide detail-image mb-30" data-ride="carousel">
                                <ul class="carousel-indicators">
                                    @php $count = 0 @endphp
                                    @forelse($service->image as $image)
                                        <li data-target="#banner-slider" data-slide-to="{{ $count }}" @if($service->service_image_url == asset_url('service/'.$service->id.'/'.$image)) class="active" @endif></li>
                                        @php $count++ @endphp
                                    @empty
                                        <li data-target="#banner-slider" data-slide-to="0" class="active"></li>
                                        <li data-target="#banner-slider" data-slide-to="1"></li>
                                        <li data-target="#banner-slider" data-slide-to="2"></li>
                                        <li data-target="#banner-slider" data-slide-to="3"></li>
                                    @endforelse
                                </ul>
                                <div class="carousel-inner">
                                    @php $count = 0 @endphp
                                    @forelse($service->image as $image)
                                        <div class="carousel-item {{ $service->service_image_url == asset_url('service/'.$service->id.'/'.$image) ? 'active' : '' }}">
                                            <a href="javascript:void(0);">
                                                <img class="img-fluid" src="{{ asset('user-uploads/service/'.$service->id.'/'.$image) }}" alt="carousel image">
                                            </a>
                                        </div>
                                        @php $count++ @endphp
                                    @empty
                                        <div class="carousel-item active">
                                            <a href="javascript:void(0);">
                                                <img src="assets/img/banner.jpg" alt="Los Angeles">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="javascript:void(0);">
                                                <img src="assets/img/banner.jpg" alt="Chicago">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="javascript:void(0);">
                                                <img src="assets/img/banner.jpg" alt="Los Angeles">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="javascript:void(0);">
                                                <img src="assets/img/banner.jpg" alt="Chicago">
                                            </a>
                                        </div>

                                    @endforelse

                                </div>
                                <div class="banner-controls">
                                    <a class="carousel-control-prev" href="#banner-slider" data-slide="prev">
                                        <span class="fa fa-angle-left"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#banner-slider" data-slide="next">
                                        <span class="fa fa-angle-right"></span>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="detail-image mb-30">
                                <img src="{{ $service->service_image_url }}" alt="service">
                            </div>
                        @endif
                        <div class="content">
                            {!! $service->description !!}
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-60">
                        <div class="detail-info mb-5">
                            <ul>
                                <li>
                                    <span>
                                        @lang('app.serviceName')
                                    </span>
                                    <span>
                                        {{ $service->name }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.price')
                                    </span>
                                    <span>
                                        {{ currencyFormatter($service->price) }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.time')
                                    </span>
                                    <span>
                                        {{ $service->time }}  @lang('app.'.$service->time_type)
                                    </span>
                                </li>
                                <li>
                                    <span>
                                       @lang('app.discount')
                                    </span>
                                    <span>
                                        @switch($service->discount_type)
                                            @case('percent')
                                                {{ $service->discount.' %' }}
                                            @break
                                            @case('fixed')
                                                {{ currencyFormatter($service->discount) }}
                                            @break
                                        @endswitch
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <ul class="add-qty">
                            <li>
                                <span class="text-capitalize mb-2 d-block">@lang('app.add') @lang('app.quantity')</span>
                                <div class="qty-wrap">
                                    <div class="qty-elements">
                                        <a class="decrement_qty" href="javascript:void(0)" onclick="decreaseQuantity(this)">-</a>
                                    </div>
                                    @php
                                        $product = current($reqProduct);
                                    @endphp

                                    <input name="qty" value="{{ sizeof($reqProduct) > 0 ? $product['quantity'] : 1 }}" size="4" title="Quantity" class="input-text qty" data-id="{{ $service->id }}" data-price="{{$service->price}}" autocomplete="none" />
                                    <div class="qty-elements">
                                        <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="update @if(sizeof($reqProduct) == 0) hide @endif">
                                    <div class="row">
                                        <div class="col-md mb-2">
                                            <a id="service{{ $service->id }}"
                                                href="javascript:;"
                                                class="btn btn-custom update-cart"
                                                data-type="service"
                                                data-unique-id="{{ $service->id }}"
                                                data-id="{{ $service->id }}"
                                                data-price="{{$service->discounted_price}}"
                                                data-name="{{ ucwords($service->name) }}">
                                                @lang('front.buttons.updateCart')
                                            </a>
                                        </div>
                                        <div class="col-md">
                                            <a href="javascript:void(0)" onclick="deleteProduct(this)" class="btn btn-custom-danger">
                                                @lang('front.table.deleteProduct')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="add @if(sizeof($reqProduct) > 0) hide @endif">
                                    <div class="row">
                                        <div class="col">
                                            <a id="service{{ $service->id }}"
                                                href="javascript:;"
                                                class="btn btn-custom add-to-cart"
                                                data-type="service"
                                                data-unique-id="{{ $service->id }}"
                                                data-id="{{ $service->id }}"
                                                data-price="{{$service->discounted_price}}"
                                                data-name="{{ ucwords($service->name) }}"
                                                data-service-type="{{ ucwords($service->service_type) }}"
                                                aria-expanded="false">
                                                @lang('front.addItem')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="navigation mt-4">
                            <a href="{{ route('front.index') }}" class="btn btn-custom btn-dark">
                                <i class="fa fa-angle-left mr-1"></i>@lang('front.navigation.goBack')
                            </a>
                            <a href="javascript:;" class="btn btn-custom btn-dark" onclick="goToPage('GET', '{{ route('front.bookingPage') }}');">@lang('front.selectBookingTime') <i class="fa fa-angle-right ml-2"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection

@push('footer-script')
    <script>
        function increaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            input.val(parseInt(currentValue) + 1);
        }

        function decreaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            if (currentValue > 1) {
                input.val(parseInt(currentValue) - 1);
            }
        }

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        });

        function deleteProduct(ele) {
            let key = $('input.qty').data('id');

            var url = '{{ route('front.deleteFrontProduct', ':id') }}';
            url = url.replace(':id', key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);
                    $(ele).parents('.update').addClass('hide').siblings('.add').removeClass('hide')
                    $('input.qty').val(1);
                }
            })
        }

    </script>
@endpush
