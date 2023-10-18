<div class="modal-header">
    <h4>@lang('menu.frontSlider') @lang('app.detail')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
                <div class="col-12">
                    <img src="{{$section_details->image_url}}" class="img img-responsive img-thumbnail" width="100%">
                </div>

                <div class="col-md-6">
                    <br>
                    <h6 class="text-uppercase">@lang('app.sectionTitle')</h6>
                    <p>{{ $section_details->section_title }}</p>
                </div>

                <div class="col-md-6">
                    <br>
                    <h6 class="text-uppercase">@lang('app.contentAlignment')</h6>
                    <p>{{ ucwords($section_details->content_alignment) }}</p>
                </div>

                <div class="col-md-12">
                    <br>
                    <h6 class="text-uppercase">@lang('app.titleNote')</h6>
                    <p>{{ $section_details->title_note }}</p>
                </div>

                @if(!is_null($section_details->section_content))
                    <div class="col-md-12">
                        <br>
                        <h6 class="text-uppercase">@lang('app.content')</h6>
                        <p>{!! $section_details->section_content !!} </p>
                    </div>
                @endif

            </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
        @lang('app.cancel')</button>
</div>
