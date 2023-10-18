<div class="modal-header">
    <h4>@lang('menu.newDeal') @lang('app.detail')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $newDeals->new_deal_image_url }}" class="img img-responsive img-thumbnail" width="100%">
            </div>

            <div class="col-md-6">
                <h6>@lang('app.status')</h6>
                <p> {{ ucfirst($newDeals->status) }} </p>

                <h6>@lang('app.link')</h6>
                <p> {{ ($newDeals->link) }} </p>
            </div>
            {{-- <div class="col-md-6">
            </div> --}}

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
</div>

