<div class="modal-header">
    <h4 class="modal-title">@lang('app.coupon') @lang('app.detail')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
                <div class="col-md-12">
                    <h6 class="text-uppercase">@lang('app.coupon') @lang('app.code')</h6>
                    <p >{{ $coupon->title }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase">@lang('app.startTime')</h6>
                    <p>{{ $coupon->start_date_time->format('Y M d H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase">@lang('app.endTime')</h6>
                    <p>
                        @if($coupon->end_date_time)
                            {{ $coupon->end_date_time->format('Y M d H:i') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase">@lang('app.usesTime')</h6>
                    <p>
                        @if($coupon->uses_limit > 0)
                        {{ $coupon->uses_limit }}
                        @else
                            @lang('app.infinite')
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase">@lang('app.usedTime')</h6>
                    <p>{{ $coupon->used_time }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase">@lang('app.amountOrPercent')</h6>
                    <p>@if(!is_null($coupon->amount)){{($coupon->amount) }} @else - @endif @if(($coupon->discount_type) == "percentage") % @else {{globalSetting()->currency->currency_symbol}} @endif</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase">@lang('app.dayForApply')</h6>
                    <p>
                        @if(sizeof($days) == 7)
                            @lang('app.allDays')
                        @else
                            @forelse($days as $day)
                                <span> @lang('app.'. strtolower($day)) </span>
                            @empty
                            @endforelse
                        @endif
                    </p>
                </div>
                @if(!is_null($coupon->description))
                    <div class="col-md-12">
                        <h6 class="text-uppercase">@lang('app.description')</h6>
                        <p>{!! $coupon->description !!} </p>
                    </div>
                @endif
            </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
</div>
