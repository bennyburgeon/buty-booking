<div class="modal-header">
    <h4 class="modal-title">@lang('app.product') @lang('app.detail')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6 deal-detail-img-thumb">
                <img src="{{ $product->product_image_url }}" class="img img-responsive img-thumbnail" width="100%">
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <h6>@lang('app.product') @lang('app.name')</h6>
                        <p>{{ $product->name}}</p>
                    </div>

                    <div class="col-md-6">
                        <h6>@lang('app.location')</h6>
                        <p>{{ $product->location->name}}</p>
                    </div>

                    <div class="col-md-6">
                        <h6>@lang('app.price')</h6>
                        <p> {{ $product->price }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.discount')</h6>
                        <p> {{ $product->discount }} </p>
                    </div>

                    <div class="col-md-6">
                        <h6>@lang('app.discountType')</h6>
                        <p> {{ $product->discount_type }} </p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.selling') @lang('app.price')</h6>
                        <p> {{ $product->discounted_price }} </p>
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.tax')</h6>
                        @foreach($taxes as $tax)
                            @if(in_array($tax->id, $selectedTax))
                                <p>{{ $tax->tax_name }} {{ $tax->percent }}%</p>
                            @else
                            <p>--</p>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h6>@lang('app.status')</h6>
                        <p> @if($product->status == 'deactive')@lang('app.inactive') @else @lang('app.active')
                        @endif </p>
                    </div>

                </div>
            </div>
            @if (!is_null($product->description))
            <div class="col-md-12">
                <h6>@lang('app.description')</h6>
                <p>{!! $product->description !!} </p>
            </div>
        @endif
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
            @lang('app.cancel')</button>
    </div>
