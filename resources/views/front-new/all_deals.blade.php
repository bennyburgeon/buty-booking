@if ($deals->count() !== 0)

    <div class="row">
        <div class="heading text-center">
            <h3 class="font-weight-bold">@lang('app.ourDeals')</h3>
            <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">@lang('front.bestDeals')</p>
        </div>
    </div>

    <div class="row pt-50">
        @foreach ($deals as $deal)
            <div class="col-lg-4 col-md-6 mb-24 categories-list" data-category-id="{{ $deal->id }}">
                <div class="deal-wrap rounded">
                    <div class="deal-img">
                        <img width="150" height="50" src="{{ $deal->deal_image_url }}" />
                    </div>
                    <div class="p-4">
                        <h6 class="f-w-600 mb-2">{{ ucwords($deal->title) }}</h6>

                        <div class="d-flex justify-content-between">
                            <p class="text-light line-height-1"><i
                                    class="las la-map-marker mr-2"></i>{{ $deal->location->name }}</p>

                            <p class="line-height-1">@if ($deal->original_amount != $deal->deal_amount)<span
                                class="text-decoration-line-through text-red mr-2"></i>{{ currencyFormatter($deal->original_amount) }}</span>@endif{{ currencyFormatter($deal->deal_amount) }}
                            </p>
                        </div>

                        <div class="d-flex justify-content-between mt-4">

                            <a href="{{ $deal->deal_detail_url }}"
                                class="outline-btn btn-md h-30 btn f-14 d-flex align-items-center justify-content-center">
                                <i class="las la-eye f-18 me-1"></i>
                                @lang('app.view') @lang('app.detail')
                            </a>

                            <a href="javascript:;" id="deal{{ $deal->id }}" data-type="deal"
                                data-unique-id="deal{{ $deal->id }}" data-id="{{ $deal->id }}"
                                data-price="{{ $deal->deal_amount }}" data-name="{{ ucwords($deal->title) }}"
                                data-max-order="{{ $deal->max_order_per_customer }}"
                                data-total_tax_percent="{{ $deal->total_tax_percent }}"
                                class="primary-btn btn-md btn f-13 h-30 d-flex align-items-center justify-content-center add-to-cart">
                                <i class="las la-shopping-cart f-18 me-1"></i> @lang("front.navigation.addToCart")
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @if ($deals->count() === 6)
        <div class="row">
            <div class="col-md-2 mx-auto mt-3">
                <a href="{{ route('front.cartPage', 'deal') }}" class="secondary-btn btn-lg btn f-15 w-100">
                    @lang('app.loadMore')
                </a>
            </div>
        </div>
    @endif
@endif
