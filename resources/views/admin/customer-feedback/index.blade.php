<div class="table-responsive">
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h4 class="mb-0">@lang('app.customerFeedback')</h4>
        <a href="javascript:;" id="create-feedback" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> @lang('app.createNew')</a>
    </div><hr>

    <table id="feedbackTable" class="table w-100">
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('app.customerName')</th>
                <th>@lang('app.customerMessage')</th>
                <th>@lang('app.status')</th>
                <th>@lang('app.action')</th>
            </tr>
        </thead>
    </table>
</div>
