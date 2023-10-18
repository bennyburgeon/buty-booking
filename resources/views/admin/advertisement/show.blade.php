<div class="modal-header">
    <h4 class="modal-title">@lang('menu.advertisement') @lang('app.detail')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6 deal-detail-img-thumb">
                <img src="{{ $advertisement->advertisement_image_url }}" class="img img-responsive img-thumbnail"
                    width="100%">
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <h6>@lang('app.position')</h6>
                        <p>{{ $advertisement->position }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6>@lang('app.discount') @lang('app.type')</h6>
                        <p> {{ $advertisement->status }} </p>
                    </div>

                    <div class="col-md">
                        <h6>@lang('app.appliedBetweenDateTime')</h6>
                        <p> {{ \Carbon\Carbon::parse($advertisement->start_date_time)->translatedFormat($settings->date_format . ' ' . $settings->time_format) }}--{{ \Carbon\Carbon::parse($advertisement->end_date_time)->translatedFormat($settings->date_format . ' ' . $settings->time_format) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
            @lang('app.cancel')</button>
    </div>
