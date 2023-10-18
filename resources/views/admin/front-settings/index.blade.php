@extends('layouts.master')

@push('head-css')
    <style>
        #captcha-detail-modal .modal-dialog{
            height: 90%;
            max-width: 100%;
        }
        #captcha-detail-modal .modal-content{
            width: 600px;
            margin: 0 auto;
        }
        .modal.show{
            padding-right: 0px !important;
        }
        #v2_captcha_container {
            margin-bottom: 1%;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-12 col-md-2 mb-4 mt-3 mb-md-0 mt-md-0">
            <a class="nav-link mb-2" href=" {{ route('admin.settings.index') }}#profile_page">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('app.back')
            </a>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" href="#section-setting" data-toggle="tab">@lang('menu.sectionSetting')</a>
                <a class="nav-link" href="#new-deal" data-toggle="tab">@lang('menu.newDeal')</a>
                <a class="nav-link" href="#customer-feedback" data-toggle="tab">@lang('menu.customerFeedback')</a>
                <a class="nav-link" href="#get-started" data-toggle="tab">@lang('menu.getStartedNote')</a>
                <a class="nav-link" href="#footer-setting" data-toggle="tab">@lang('menu.footerSettings')</a>
                <a class="nav-link" href="#google-captcha-settings" data-toggle="tab">@lang('menu.googleCaptcha') @lang('menu.settings')</a>
            </div>
        </div>
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content">

                                <!-- Start section content settings -->
                                <div class="active tab-pane" id="section-setting">
                                    @include('admin.front-section.index')
                                </div>
                                <!-- End section content settings -->

                                <!-- Start new deal content settings -->
                                <div class="tab-pane" id="new-deal">
                                    @include('admin.new-deal.index')
                                </div>
                                <!-- End new deal content settings -->

                                <!-- Start Customer feedback settings -->
                                <div class="tab-pane" id="customer-feedback">
                                    @include('admin.customer-feedback.index')
                                </div>
                                <!-- End Customer feedback settings -->

                                <!-- Start Get Started Settings -->
                                <div class="tab-pane" id="get-started">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <h4>@lang('menu.getStartedNote')</h4>
                                            <table class="table table-condensed">
                                                <thead>
                                                <tr>
                                                    <th>@lang('app.title')</th>
                                                    <th>@lang('app.note')</th>
                                                    <th>@lang('app.action')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>{{ $getStartedData->get_started_title }}</td>
                                                    <td>{{ $getStartedData->get_started_note }}</td>
                                                        <td>
                                                            <a href="javascript:;" class="btn btn-primary btn-circle edit-get-started" data-bs-toggle="tooltip" data-original-title="@lang('app.edit')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Get Started Settings -->

                                <!-- Start Footer Settings -->
                                <div class="tab-pane" id="footer-setting">
                                    <form id="footerSetting" class="ajax-form" method="post">
                                        @csrf
                                        @method('PUT')
                                        <h4>@lang('menu.footerSettings')</h4>
                                        <br>
                                        <h5 id="social-links">@lang('modules.frontCms.socialLinks')</h5>
                                        <hr>
                                        <span class="text-danger">@lang('modules.frontCms.socialLinksNote')</span><br><br>
                                        <div class="row">
                                            @foreach($footerSetting->social_links as $link)
                                                <div class="col-sm-12 col-md-3 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="{{ $link['name'] }}">
                                                            @lang('modules.frontCms.'.$link['name'])
                                                        </label>
                                                        <input class="form-control" id="{{ $link['name'] }}" name="social_links[{{ $link['name'] }}]"
                                                            type="url" value="{{ $link['link'] }}" placeholder="@lang('modules.frontCms.enter'.ucfirst($link['name']).'Link')">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <h5 id="footer-text">@lang('modules.frontCms.footerText')</h5>
                                        <hr>
                                        <div class="form-group">
                                            <input type="text" name="footer_text" class="form-control" value="{{ $footerSetting->footer_text }}">
                                        </div>
                                        <div class="form-group">
                                            <button id="save-footer-settings" type="button" class="btn btn-success">
                                            <i class="fa fa-check"></i> @lang('app.save')</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- End Footer Settings -->

                                <!-- Google reCAptcha -->
                                <div class="tab-pane" id="google-captcha-settings">
                                    <h4>@lang('menu.googleCaptcha') @lang('menu.settings')</h4>
                                    <br>
                                    <form class="form-horizontal ajax-form" id="google-captcha-setting-form" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <h5 class="text-info">@lang('menu.googleCaptcha') @lang('menu.credential') </h5>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        @lang('menu.googleCaptcha') @lang('menu.status')
                                                    </label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="google_captcha_status" id="google_captcha_status"
                                                        @if($googleCaptchaSettings->status == 'active') checked @endif
                                                        value="active">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div id="google-captcha-credentials">

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">@lang('menu.chooseReCAPTCHAVersion')</label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="radio-inline"><input value="v2" id="v2" type="radio" name="version" @if ($googleCaptchaSettings->v2_status=="active") checked @endif >&nbsp;&nbsp; v2</label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="radio-inline"><input value="v3" id="v3" type="radio" name="version" @if ($googleCaptchaSettings->v3_status=="active") checked @endif>&nbsp;&nbsp; v3</label>
                                                    </div>

                                                    <div id="google_captcha_v3">
                                                        <div class="form-group">
                                                            <label>@lang('menu.site') @lang('menu.key')</label>
                                                            <input type="text" name="google_captcha3_site_key" id="v3_google_captcha_site_key"
                                                            class="form-control form-control-lg"
                                                            value="{{ $googleCaptchaSettings->v3_site_key }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang('menu.secret') @lang('menu.key')</label>
                                                            <input type="text" name="google_captcha3_secret" id="v3_google_captcha_secret"
                                                            class="form-control form-control-lg"
                                                            value="{{ $googleCaptchaSettings->v3_secret_key }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-success" id="verify-v3"><i class="fa fa-check"></i> @lang('menu.verify')
                                                            </button>
                                                        </div>
                                                        <div class="col-lg-12" id="v3_captcha_container"></div>

                                                    </div>

                                                    <div id="google_captcha_v2">
                                                        <div class="form-group">
                                                            <label>@lang('menu.site') @lang('menu.key')</label>
                                                            <input type="text" name="google_captcha2_site_key" id="v2_google_captcha_site_key"
                                                            class="form-control form-control-lg"
                                                            value="{{ $googleCaptchaSettings->v2_site_key }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>@lang('menu.secret') @lang('menu.key')</label>
                                                            <input type="text" name="google_captcha2_secret" id="v2_google_captcha_secret"
                                                            class="form-control form-control-lg"
                                                            value="{{ $googleCaptchaSettings->v2_secret_key }}">
                                                        </div>

                                                        <div class="col-lg-12" id="v2_captcha_container"></div>

                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-success" id="verify-v2"><i class="fa fa-check"></i> @lang('menu.verify')
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </form>
                                </div>
                                <!-- GOOGLE RECAPTCHA -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>

@endsection

@push('footer-js')

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>

        $(document).on('click', '#verify-v2', function() {

            let captchaContainerV2 = null;
            let key = $('#v2_google_captcha_site_key').val();
            let secret = $('#v2_google_captcha_secret').val();

            if(key === '' || secret ==='') {
                swal({ title: "Error..!", icon: 'warning', text: '@lang("errors.reCaptchaWarning")', });
                return false;
            }

            try {
                captchaContainer = grecaptcha.render('v2_captcha_container', {
                    'sitekey' : key,
                    'callback' : function(response) {
                        if(response) {
                            saveForm();
                        }
                    },
                    'error-callback': function() {
                        errorMsg();
                    }
                });
            } catch (error) {
                errorMsg();
            }
        });

        $(document).on('click', '#verify-v3', function() {
            let key = $('#v3_google_captcha_site_key').val();
            let secret = $('#v3_google_captcha_secret').val();
            var url = '{{ route('admin.google-captcha-settings.index')}}?key='+key;

            if(key === '' || secret === '') {
                swal({ title: "Error..!", icon: 'warning', text: '@lang("errors.reCaptchaWarning")', });
                return false;
            }

            var url = url;
            $.ajaxModal(modal_lg, url);
        });

        function saveForm() {
            var url = "{{route('admin.google-captcha-settings.update', $googleCaptchaSettings->id)}}";

            $.easyAjax({
                url: url,
                container: '#google-captcha-setting-form',
                type: "POST",
                data: $('#google-captcha-setting-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            })
        }

        function errorMsg() {
            var form = $("#google-captcha-setting-form");
            var checkedValue = form.find("input[name=version]:checked").val();

            if(checkedValue == 'v3') {
                let msg = `<div class="alert alert-danger" role="alert"><i class="fa fa-info-circle"></i>
                Unexpected error occured.
                </div>`;
                $('#portlet-body').html(msg);
                $('#portlet-body').attr('data-error', true);
                $('#save-method').hide();
                return false;
            }

            swal({
                title: "Error..!",
                text: "@lang('errors.invalidReCaptcha')",
                icon: 'warning',
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false,
            }).then((willDelete) => {
                location.reload();
            });
        }

        $('#google_captcha_status').is(':checked') ? $('#google-captcha-credentials').show() : $('#google-captcha-credentials').hide();
        '{{ $googleCaptchaSettings->v2_status }}' === 'active' ? $('#google_captcha_v2').show() : $('#google_captcha_v2').hide();
        '{{ $googleCaptchaSettings->v3_status }}' === 'active' ? $('#google_captcha_v3').show() : $('#google_captcha_v3').hide();

        $('body').on('click', 'input[type="radio"]', function() {
            if($(this).attr('id') == 'v2') {
                    $('#google_captcha_v2').show();
                    $('#google_captcha_v3').hide();
            }
            else {
                $('#google_captcha_v3').show();
                $('#google_captcha_v2').hide();
            }
        });

        $('input[type=checkbox][name=google_captcha_status]').change(function() {
            $('#google-captcha-credentials').toggle();
        });

        $('#v-pills-tab a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
                $("html, body").scrollTop(0);
            });

            // store the currently selected tab in the hash value
            $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            $('#v-pills-tab a[href="' + hash + '"]').tab('show');
    </script>

    <script>
        var table = langTable = '';
        $(document).ready(function() {
            // front section table
            table = $('#sectionTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.front-section.index') !!}',
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-bs-toggle="tooltip"]'
                    });
                },
                order: [[0, 'DESC']],
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'image', name: 'image' },
                    { data: 'have_content', name: 'haveContent' },
                    { data: 'title', name: 'title' },
                    { data: 'action', name: 'action' }
                ],
                columnDefs: [
                    {
                    targets: 4 ,
                    className: 'text-right'
                    }]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('click', '#create-section', function () {
                var url = '{{ route('admin.front-section.create') }}';

                $(modal_lg + ' ' + modal_heading).html('@lang('app.createNew') @lang('app.slider')');
                $.ajaxModal(modal_lg, url);
            });

            $('body').on('click', '.view-section', function() {
                var id = $(this).data('section-id');
                var url = '{{ route('admin.front-section.show', ':id')}}';
                url = url.replace(':id', id);

                $(modal_lg + ' ' + modal_heading).html('@lang('app.createNew') @lang('app.slider')');
                $.ajaxModal(modal_lg, url);
            });

            $('body').on('click', '.edit-section', function () {
                var id = $(this).data('id');
                var url = '{{ route('admin.front-section.edit', ':id')}}';
                url = url.replace(':id', id);

                $(modal_lg + ' ' + modal_heading).html('@lang('app.edit') @lang('app.slider')');
                $.ajaxModal(modal_lg, url);
            });

            $('body').on('click', '.delete-section', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.deleteWarning')",
                }).then((willDelete) => {
                    if (willDelete) {
                        var url = "{{ route('admin.front-section.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.unblockUI();
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function() {
        // front newDeal table
        table = $('#newDealTable').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.new-deal.index') !!}',
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-bs-toggle="tooltip"]'
                });
            },
            order: [[0, 'DESC']],
            columns: [
                { data: 'DT_RowIndex'},
                { data: 'image', name: 'image' },
                { data: 'status', name: 'status' },
                { data: 'location_id', name: 'location_id' },
                { data: 'action', name: 'action' }
            ],
            columnDefs: [
                    {
                    targets: 4 ,
                    className: 'text-right'
                    }]
        });
        new $.fn.dataTable.FixedHeader( table );

        $('body').on('click', '#create-newDeal', function () {
            var url = '{{ route('admin.new-deal.create') }}';

            $(modal_lg + ' ' + modal_heading).html('@lang('app.createNew') @lang('menu.newDeal')');
            $.ajaxModal(modal_lg, url);
        });

        $('body').on('click', '.view-newDeal', function() {
            var id = $(this).data('id');
            var url = '{{ route('admin.new-deal.show', ':id')}}';
            url = url.replace(':id', id);

            $(modal_lg + ' ' + modal_heading).html('@lang('app.createNew') @lang('menu.newDeal')');
            $.ajaxModal(modal_lg, url);
        });

        $('body').on('click', '.edit-newDeal', function () {
            var id = $(this).data('id');
            var url = '{{ route('admin.new-deal.edit', ':id')}}';
            url = url.replace(':id', id);

            $(modal_lg + ' ' + modal_heading).html('@lang('app.edit') @lang('menu.newDeal')');
            $.ajaxModal(modal_lg, url);
        });

        $('body').on('click', '.delete-newDeal', function(){
            var id = $(this).data('row-id');
            swal({
                icon: "warning",
                buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                dangerMode: true,
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
            }).then((willDelete) => {
                if (willDelete) {
                    var url = "{{ route('admin.new-deal.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                location.reload();
                            }
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    var table = langTable = '';
    $(document).ready(function() {
        // feedbackTable
        table = $('#feedbackTable').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.feedback.index') !!}',
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-bs-toggle="tooltip"]'
                });
            },
            order: [[0, 'DESC']],
            columns: [
                { data: 'DT_RowIndex'},
                { data: 'name', name: 'customerName' },
                { data: 'message', name: 'customerMessage' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' }
            ]
        });
        new $.fn.dataTable.FixedHeader( table );

        $('body').on('click', '#create-feedback', function () {
            var url = '{{ route('admin.feedback.create') }}';

            $(modal_lg + ' ' + modal_heading).html('@lang('app.createNew') @lang('app.feedback')');
            $.ajaxModal(modal_lg, url);
        });

        $('body').on('click', '.edit-feedback', function () {
            var id = $(this).data('id');
            var url = '{{ route('admin.feedback.edit', ':id')}}';
            url = url.replace(':id', id);

            $(modal_lg + ' ' + modal_heading).html('@lang('app.edit') @lang('app.feedback')');
            $.ajaxModal(modal_lg, url);
        });

        $('body').on('click', '.delete-feedback', function(){
            var id = $(this).data('row-id');
            swal({
                icon: "warning",
                buttons: ["@lang('app.cancel')", "@lang('app.ok')"],
                dangerMode: true,
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
            }).then((willDelete) => {
                if (willDelete) {
                    var url = "{{ route('admin.feedback.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
    });
</script>


    <script>

        $('#save-footer-settings').click(function () {
            $.easyAjax({
                url: "{{ route('admin.front-settings.update', $footerSetting->id) }}",
                container: '#footerSetting',
                type: 'POST',
                data: $('#footerSetting').serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        location.reload();
                    }
                }
            })
        });

        $('body').on('click', '.edit-get-started', function () {
            var url = "{{ route('admin.front-settings.edit', $footerSetting->id) }}";

            $(modal_lg + ' ' + modal_heading).html('@lang('app.edit')');
            $.ajaxModal(modal_lg, url);

        });

    </script>

@endpush
