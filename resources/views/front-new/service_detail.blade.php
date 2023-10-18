@extends('layouts-new.front')

@section('content')
    <!-- SERVICE DETAIL START -->
    <section class="py-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="owl-carousel owl-theme" id="deal_detail_slider">
                        <div class="item">
                            <div class="deal-detail-img position-relative">
                                <img src="{{ $service->service_image_url }}" alt="{{ $service->slug }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <h3 class="my-3">{{ $service->name }}</h3>

                    <p class="text-light mb-4 f-15"><i class="las la-map-marker mr-2"></i>{{ $service->location->name }}</p>

                    <hr/>

                    <div class="mt-4">

                        <p class="line-height-1 mr-3 f-20 f-w-600">{{ $settings->currency->currency_symbol }}{{ $service->price }}</p>

                        @if ($service->discount > 0)
                            <p class="line-height-1 mt-4">@lang('app.discount') :
                                @switch($service->discount_type)
                                @case('percent')
                                {{ $service->discount.' %' }}
                                @break
                                @case('fixed')
                                {{ $settings->currency->currency_symbol.' '.$service->discount }}
                                @break
                                @endswitch
                            </p>
                        @endif

                    </div>

                    <div class="deal-input input-group rounded w-25 mr-3 mt-4">
                        <span class="input-group-btn">
                            <button type="button" onclick="decreaseQuantity(this)" class="btn btn-default btn-number py-0 increment_qty" min="1" data-type="minus"
                                data-field="quant[1]">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash"
                                        viewBox="0 0 16 16">
                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                                    </svg>
                                </span>
                            </button>
                        </span>
                        @php $product = current($reqProduct);@endphp
                        <input type="text" id="number" size="4" name="qty" class="form-control text-center h-30 f-12 input-number qty" data-id="{{ $service->id }}" data-max-order="{{ $service->max_order_per_customer }}" autocomplete="none" value="{{ sizeof($reqProduct) > 0 ? $product['quantity'] : 1 }}" min="1"
                        title="Quantity" data-id="{{ $service->id }}" data-price="{{$service->price}}" max="10" readonly />
                        <span class="input-group-btn h-30">
                            <button type="button" onclick="increaseQuantity(this)" class="btn btn-default btn-number py-0 decrement_qty" data-type="plus" data-field="quant[1]">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </span>
                            </button>
                        </span>
                    </div>

                    <div class="d-flex w-100 mt-4">
                        <button id="service{{ $service->id }}"
                            type="button"
                            class="add me-3 primary-btn btn-lg btn f-14 @if(sizeof($reqProduct) == 0) d-flex @else d-none @endif align-items-center justify-content-center h-30 py-3 add-to-cart"
                            data-type="service"
                            data-unique-id="{{ $service->id }}"
                            data-id="{{ $service->id }}"
                            data-price="{{$service->discounted_price}}"
                            data-service-type="{{$service->service_type}}"
                            data-name="{{ ucwords($service->name) }}">
                            <i class="las la-shopping-cart f-18 mr-1"></i>
                            @lang('front.addItem')
                        </button>

                        <button id="service{{ $service->id }}"
                            type="button"
                            class="update me-3 primary-btn mr-2 btn-lg btn f-14 @if(sizeof($reqProduct) > 0) d-flex @else d-none @endif align-items-center justify-content-center h-30 py-3 update-cart"
                            data-type="service"
                            data-unique-id="{{ $service->id }}"
                            data-id="{{ $service->id }}"
                            data-price="{{$service->discounted_price}}"
                            data-name="{{ ucwords($service->name) }}">
                            <i class="las la-shopping-cart f-18 me-1"></i>
                            @lang('front.buttons.updateCart')
                        </button>

                        <button type="button" onclick="deleteProduct(this)" class="red-btn btn-lg btn f-13 @if(sizeof($reqProduct) > 0) d-flex @else d-none @endif align-items-center justify-content-center h-30 py-3 delete">
                            <i class="las la-shopping-cart f-18 mr-1"></i> @lang('app.remove') @lang('app.from') @lang('front.cart')
                        </button>
                    </div>

                </div>
                <div class="col-md-12 mt-3">
                    <p class="text-grey">{!! $service->description !!}</p><br><br>
                </div>
            </div>
        </div>
    </section>
    <!-- SERVICE DETAIL END -->

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
                    $('.add').addClass('d-flex');
                    $('.add').removeClass('d-none');

                    $('.update').removeClass('d-flex');
                    $('.update').addClass('d-none');

                    $('.delete').removeClass('d-flex');
                    $('.delete').addClass('d-none');
                    $('input.qty').val(1);
                }
            })
        }

        // add items to cart
        $('body').on('click', '.add-to-cart, .update-cart', function () {

            let $this = $(this);
            let type = 'service';
            let unique_id = '{{ $service->id }}';
            let id = '{{ $service->id }}';
            let price = '{{ $service->discounted_price }}';
            let name = '{{ $service->name }}';
            let service_type = '{{ $service->service_type }}';
            let quantity = $('#number').val();

            var data = {id, type, price, name, quantity, unique_id, service_type, _token: $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                blockUI: false,
                disableButton: true,
                success: function (response) {
                    if(response.result=='fail')
                    {
                        swal({
                            title: "@lang('front.buttons.clearCart')?",
                            text: "@lang('messages.front.errors.addOneItemAtATime')",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete)
                            {
                                var url = '{{ route('front.deleteProduct', ':id') }}';
                                url = url.replace(':id', 'all');

                                $.easyAjax({
                                    url: url,
                                    type: 'POST',
                                    data: {_token: $("meta[name='csrf-token']").attr('content')},
                                    redirect: false,
                                    success: function (response) {
                                        if (response.status == 'success') {
                                            $.easyAjax({
                                                url: '{{ route('front.addOrUpdateProduct') }}',
                                                type: 'POST',
                                                data: data,
                                                success: function (response) {
                                                    $('.cart-badge').text(response.productsCount);

                                                    $('.add').removeClass('d-flex');
                                                    $('.add').addClass('d-none');

                                                    $('.update').addClass('d-flex');
                                                    $('.update').removeClass('d-none');

                                                    $('.delete').addClass('d-flex');
                                                    $('.delete').removeClass('d-none');
                                                }
                                            })
                                        }
                                    }
                                })
                            }
                        });
                    }

                    $('.cart-badge').text(response.productsCount);
                    let addButton = $this.parents('.add');

                    if (response.productsCount > 0) {
                        $('.add').removeClass('d-flex');
                        $('.add').addClass('d-none');

                        $('.update').addClass('d-flex');
                        $('.update').removeClass('d-none');

                        $('.delete').addClass('d-flex');
                        $('.delete').removeClass('d-none');
                    }

                    if (addButton.length > 0) {
                        addButton.addClass('hide').siblings('.update').removeClass('hide');
                    }
                }
            })
        });

    </script>
@endpush
