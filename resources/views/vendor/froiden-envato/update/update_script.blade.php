<script type="text/javascript">
    var updateAreaDiv = $('#update-area');
    var refreshPercent = 0;
    var checkInstall = true;

    $('#update-app').click(function () {
        if ($('#update-frame').length) {
            return false;
        }

        @php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())

        @if(!is_null($envatoUpdateCompanySetting->supported_until) && \Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->isPast())
        var supportText = " Your support has been expired on {{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->format('d M, Y')}}";
        let freeSupport = "\n \n You can extend your support for 6 months free. All you need to do is follow the guidelines"

        let confirmButtonText = "Renew Now";
        let showGuidelines = false;

        @if(!$reviewed)
            showGuidelines = true;
        confirmButtonText = "Free Support Extension Guidelines"
        supportText += freeSupport
        @endif

        swal({
            title: "Support Expired",
            html: true,

            icon: 'warning',
            text: supportText + " \n \n Please renew your suport for one-click updates.",
            buttons: ["Cancel", confirmButtonText],
        })
            .then((isConfirm) => {
                if (isConfirm) {
                    if (showGuidelines) {
                        window.open(
                            "https://community.froiden.com/d/238-now-get-free-support-extension",
                            '_blank'
                        );

                    } else {
                        window.open(
                            "{{ config('froiden_envato.envato_product_url') }}",
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }

                }

            });
        @else
        swal({
            title: "Are you sure?",
            icon: 'warning',
            text: `Do not click update now button if the application is customised. Your changes will be lost.
                \n
                Take backup of files and database before updating. \
                \n
                Author will not be responsible if something goes wrong
                `,
            buttons: ["No, cancel please!", 'Yes, update it!'],
        }).then((isConfirm) => {
            if (isConfirm) {
                updateAreaDiv.removeClass('hide');
                swal.close();
                $.easyAjax({
                    type: 'GET',
                    url: '{!! route("admin.updateVersion.update") !!}',
                    success: function (response) {
                        if (response.status == 'success') {
                            downloadScript();
                            downloadPercent();
                        } else {
                            swal({
                                title: response.message,
                                type: "error",
                            });
                        }

                    }
                });
            }
        });
        @endif

    })

    function downloadScript() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.download") !!}',
            success: function (response) {
                clearInterval(refreshPercent);
                $('#percent-complete').css('width', '100%');
                $('#percent-complete').html('100%');
                $('#download-progress').append("<i><span class='text-success'>Download complete.</span> Now Installing...Please wait (This may take few minutes.)</i>");

                window.setInterval(function () {
                    /// call your function here
                    if (checkInstall == true) {
                        checkIfFileExtracted();
                    }
                }, 1500);

                installScript();

            }
        });
    }

    function getDownloadPercent() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.downloadPercent") !!}',
            success: function (response) {
                response = response.toFixed(1);
                $('#percent-complete').css('width', response + '%');
                $('#percent-complete').html(response + '%');
            }
        });
    }

    function checkIfFileExtracted() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.checkIfFileExtracted") !!}',
            success: function (response) {
                checkInstall = false;
                if (response.status == 'success') {
                    window.location.reload();
                }
            }
        });
    }

    function downloadPercent() {
        updateAreaDiv.append('<hr><div id="download-progress">' +
            'Download Progress<br><div class="progress progress-lg">' +
            '<div class="progress-bar progress-bar-success active progress-bar-striped" role="progressbar" id="percent-complete" role="progressbar""></div>' +
            '</div>' +
            '</div>'
        );
        //getting data
        refreshPercent = window.setInterval(function () {
            getDownloadPercent();
            /// call your function here
        }, 1500);
    }

    function installScript() {
        $.easyAjax({
            type: 'GET',
            url: '{!! route("admin.updateVersion.install") !!}',
            success: function (response) {
                if (response.status == 'success') {
                    window.location.reload();
                }
            }
        });
    }

    function getPurchaseData() {
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            type: 'POST',
            url: "{{ route('purchase-verified') }}",
            data: {'_token': token},
            container: "#support-div",
            messagePosition: 'inline',
            success: function (response) {
                window.location.reload();
            }
        });
        return false;
    }
</script>
