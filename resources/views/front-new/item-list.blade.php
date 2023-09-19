@forelse ($products as $key => $product)
    <div class="d-flex justify-content-between mb-4 removeItemDiv{{$key}}">
        <div class="cart-left">
            <p class="text-capitalize">{{ $product['name'] }}</p>
            <a title="@lang('front.table.deleteProduct')" href="javascript:;" onclick="deleteProduct(this, '{{ $key }}')" class="delete-btn text-dark">
                <i class="las la-trash f-17 cursor-pointer trash-item"></i>
            </a>
        </div>
        <div class="cart-right" id="{{ $key }}">
            <p class="text-right productAmt">
            <span>{{ currencyFormatter($product['quantity'] * $product['price']) }}</p>
            <div class="input-group rounded tax_detail">
                <span class="input-group-btn">
                    <button type="button" onclick="decreaseQuantity(this)" class="btn btn-default btn-number" @if ($product['quantity'] <= 0) disabled @endif
                        data-type="minus" data-field="quant[1]">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-dash" viewBox="0 0 16 16">
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                            </svg>
                        </span>
                    </button>
                </span>
                @php
                    $appliedTax = 0;
                    $totalTax = 0;
                    $taxPercent = 0;
                    $subTotal = $product['quantity'] * $product['price']
                @endphp
                @if (isset($product['tax']))
                    @forelse (json_decode($product['tax']) as $tax)
                        @if (isset($tax->tax_name))
                            @php
                                $taxPercent += $tax->percent;
                                $appliedTax += ($subTotal*$tax->percent)/100;
                                $totalTax += $appliedTax;
                            @endphp
                        @endif
                    @empty
                    @endforelse
                @endif

                <input type="hidden" class="tax_percent" value="{{ $taxPercent }}">
                <input type="hidden" class="tax_amount" value="{{ $appliedTax }}">

                <input type="text" id="number" name="qty" title="Quantity" onkeypress="return isNumberKey(event)"
                    value="{{ $product['quantity'] }}" class="form-control input-text qty"
                    data-id="{{ $product['unique_id'] }}" data-deal-id="{{ $product['id'] }}"
                    data-price="{{ $product['price'] }}" data-type="{{ $product['type'] }}" @if ($product['type'] == 'deal') data-max-order="{{ $product['max_order'] }}" @endif
                    autocomplete="none">
                <span class="input-group-btn">
                    <button type="button" onclick="increaseQuantity(this)" class="btn btn-default btn-number"
                        data-type="plus" data-field="quant[1]">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                        </span>
                    </button>
                </span>
            </div>
        </div>
    </div>
@empty
    <div class="d-flex justify-content-between mb-4">
        <h6 colspan="4" class="text-center text-danger">@lang('front.table.emptyMessage')</h6>
    </div>
@endforelse
