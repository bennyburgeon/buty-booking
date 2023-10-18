<div class="row">
    @foreach ($deals as $deal)
        <div class="col-lg-6 col-md-6 mb-24 categories-list">
            <div class="deal-wrap rounded">
                <div class="deal-img">
                    <img src="{{ $deal->deal_image_url }}" />
                </div>
                <div class="p-4">
                    <a href="{{ $deal->deal_detail_url }}" class="text-dark">
                        <h6 class="f-w-600 mb-2">{{ ucwords($deal->title) }}</h6>
                    </a>

                    <div class="d-flex justify-content-between">
                        <p class="text-light line-height-1">
                            <i class="las la-map-marker mr-2"></i>{{ $deal->location->name }}
                        </p>

                        <p class="line-height-1">
                            @if ($deal->original_amount > $deal->deal_amount)
                                <span
                                    class="text-decoration-line-through text-red mr-2"></i>{{ currencyFormatter($deal->original_amount) }}</span>
                            @endif
                            {{ currencyFormatter($deal->deal_amount) }}
                        </p>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ $deal->deal_detail_url }}"
                            class="outline-btn btn-md h-30 btn f-14 d-flex align-items-center justify-content-center">
                            <i class="las la-eye f-18 me-1"></i>
                            @lang('app.view') @lang('app.detail')
                        </a>

                        <a href="javascript:;" id="deal{{ $deal->id }}"
                            data-total_tax_percent="{{ $deal->total_tax_percent }}" data-type="deal"
                            data-unique-id="deal{{ $deal->id }}" data-id="{{ $deal->id }}"
                            data-price="{{ $deal->deal_amount }}" data-name="{{ ucwords($deal->title) }}"
                            data-max-order="{{ $deal->max_order_per_customer }}"
                            class="primary-btn btn-md btn f-13 h-30 d-flex align-items-center justify-content-center add-to-cart">
                            <i class="las la-shopping-cart f-18 me-1"></i> @lang("front.navigation.addToCart")
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
