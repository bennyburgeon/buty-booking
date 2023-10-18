<br>
<table class="table table-bordered table-condensed" width="100%" id="deal_table">
    <thead class="thead-dark">
        <tr>
            <th>@lang('app.service')</th>
            <th>@lang('app.unitPrice')</th>
            <th>@lang('app.quantity')</th>
            <th>@lang('app.subTotal')</th>
            <th>@lang('app.discount')</th>
            <th>@lang('app.total')</th>
            <th>#</th>
        </tr>
    </thead>

    @php $subTotal=0; $discount=0; $total=0; @endphp
    @foreach ($deal_list as $deal)
        <tr id="row{{$deal->id}}">
            <td><input type="hidden" name="deal_services[]" value="{{$deal->id}}">{{$deal->name}}</td>
            <td><input type="hidden" class="deal-price-{{$deal->id}}" name="deal_unit_price[]" value="{{$deal->price}}">{{currencyFormatter($deal->price)}}</td>
            <td style="width: 15%">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-default quantity-minus" data-service-id="{{$deal->id}}"><i class="fa fa-minus"></i></button>
                    </div>
                        <input data-service-id="{{$deal->id}}" type="text" readonly name="deal_quantity[]" class="form-control deal-service-{{$deal->id}}" value="1">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default quantity-plus" data-service-id="{{$deal->id}}"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </td>
            <input type="hidden" name="deal-subtotal-val[]" class="deal-subtotal-val-{{$deal->id}}" value="{{$deal->price}}">
            <td name="deal-subtotal[]" class="deal-subtotal-{{$deal->id}}">
                {{currencyFormatter($deal->price)}}
            </td>
            <td style="width: 15%">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">{{$settings->currency->currency_symbol}}</span>
                    </div>
                    <input type="number" name="deal_discount[]" onkeypress="return isNumberKey(event)" class="form-control deal_discount" value="0" readonly>
                </div>
            </td>
            <td name="deal-total[]" class="deal-total-{{$deal->id}}">{{currencyFormatter($deal->price)}}</td>
            <td>
                <a onclick="deleteRow({{$deal->id}}, '{{$deal->name}}')" href="javascript:;" class="btn btn-danger btn-sm btn-circle delete-cart-row"  data-original-title="Delete" data-toggle="tooltip" data-placement="top" title="@lang('app.delete')"><i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        @php $subTotal += $deal->price; @endphp
    @endforeach

    <tr>
        <td colspan="3"></td>
        <td id="deal-sub-total">{{currencyFormatter($subTotal)}}</td>
        <td id="deal-discount-total">{{currencyFormatter($discount)}}</td>
        <td id="deal-total-price">{{currencyFormatter($subTotal)}}</td>
    </tr>

</table>

<script>
    $('#discount_amount').val('{{$subTotal}}');
    $('#original_amt').val('{{$subTotal}}');

    $('[data-toggle="tooltip"]').tooltip();
    
    $('.fa-times').on('click', function(){
        $('.tooltip').removeClass('show');
    })
</script>

