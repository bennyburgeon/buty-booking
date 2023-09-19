<div class="row">
    <h4 class="col-md-12">@lang('menu.profile') @lang('app.settings') <hr></h4>
    <div class="col-md-12">
        <div id="verify-mobile">
            @include('partials.admin_verify_phone')
        </div>
        <form role="form" id="createForm"  class="ajax-form" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <!-- text input -->
                    <div class="form-group">
                        <label>@lang('app.name')<span class="required-span">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ ucwords($user->name) }}">
                    </div>

                    <!-- text input -->
                    <div class="form-group">
                        <label>@lang('app.email')<span class="required-span">*</span></label>
                        <input type="email" class="form-control form-control-lg" name="email" value="{{ $user->email }}">
                    </div>

                    <!-- text input -->
                    <div class="form-group">
                        <label>@lang('app.password')</label>
                        <input type="password" class="form-control form-control-lg" name="password">
                        <span class="help-block">@lang('messages.leaveBlank')</span>
                    </div>

                    @if ($smsSettings->nexmo_status == 'deactive')
                        <!-- text input -->
                        <div class="form-group">
                            <label>@lang('app.mobile')<span class="required-span">*</span></label>
                            <div class="form-row">
                                <div class="col-sm-2">
                                    <select name="calling_code" id="calling_code" class="form-control select2">
                                        @foreach ($calling_codes as $code => $value)
                                            <option value="{{ $value['dial_code'] }}"
                                            @if ($user->calling_code)
                                                {{ $user->calling_code == $value['dial_code'] ? 'selected' : '' }}
                                            @endif>{{ $value['dial_code'] . ' - ' . $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="mobile" value="{{ $user->mobile }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            <label>@lang('front.registration.address')<span class="required-span">*</span></label>
                            <div class="form-group">
                                <input class="form-control form-control-lg" placeholder="@lang('front.registration.houseNo')" name="house_no" type="text" @if($user && $user->address) value="{{ $user->address->house_no }}"@endif>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <label>@lang('front.registration.addressLine')<span class="required-span">*</span></label>
                            <div class="form-group">
                                <input class="form-control form-control-lg" placeholder="@lang('front.registration.addressLine')" name="address_line" type="text" @if($user && $user->address) value="{{ $user->address->address_line }}"@endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>@lang('front.registration.city')<span class="required-span">*</span></label>
                            <div class="form-group">
                                <input class="form-control form-control-lg" placeholder="@lang('front.registration.city')" name="city" type="text" @if($user && $user->address) value="{{ $user->address->city }}"@endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('front.registration.state')<span class="required-span">*</span></label>
                            <div class="form-group">
                                <input class="form-control form-control-lg" placeholder="@lang('front.registration.state')" name="state" type="text" @if($user && $user->address) value="{{ $user->address->state }}"@endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>@lang('front.registration.pincode')<span class="required-span">*</span></label>
                            <div class="form-group">
                                <input class="form-control form-control-lg" placeholder="@lang('front.registration.pincode')" name="pin_code" type="text" @if($user && $user->address) value="{{ $user->address->pin_code }}"@endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('front.registration.country')<span class="required-span">*</span></label>
                            <div class="form-group">
                                <select name="country_id" id="country_id" placeholder="country" class="form-control form-control-lg select2">
                                    <option disabled>@lang('front.registration.country')</option>
                                    @foreach($countries as $country)
                                        <option @if ($user && $user->address && $country->id == $user->address->country_id) selected @endif value="{{$country->id}}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('app.image') (@lang('app.imageExtentions'))</label>
                        <div class="card">
                            <div class="card-body">
                                <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" data-default-file="{{ $user->user_image_url  }}" class="dropify"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <h5 class="text-primary">@lang('app.siteRtlFeature')</h5>
                        <label class="control-label">@lang('app.siteRtlNote')</label>
                        <br>
                        <label class="switch">
                            <input type="checkbox" name="rtl" id="rtl" value="enabled" @if ( $user->rtl=='enabled') checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                    class="fa fa-check"></i> @lang('app.save')</button>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>

@push('footer-js')

    <script>
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $('body').on('click', '#change-mobile', function () {
            $.easyAjax({
                url: "{{ route('changeMobile') }}",
                container: '#verify-mobile',
                type: "GET",
                success: function (response) {
                    $('#verify-mobile').html(response.view);
                    $('.select2').select2();
                }
            })
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.profile.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize(),
                blockUI: true,
                disableButton: true,
                buttonSelector: "#save-form",
            })
        });
    </script>

    <script>
        var x = '';

        function clearLocalStorage() {
            localStorage.removeItem('otp_expiry');
            localStorage.removeItem('otp_attempts');
        }

        function checkSessionAndRemove() {
            $.easyAjax({
                url: '{{ route('removeSession') }}',
                type: 'GET',
                data: {'sessions': ['verify:request_id']}
            })
        }

        function startCounter(deadline) {
            x = setInterval(function() {
                var now = new Date().getTime();
                var t = deadline - now;

                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);

                $('#demo').html('Time Left: '+minutes + ":" + seconds);
                $('.attempts_left').html(`${localStorage.getItem('otp_attempts')} attempts left`);

                if (t <= 0) {
                    clearInterval(x);
                    clearLocalStorage();
                    checkSessionAndRemove();
                    location.href = '{{ route('admin.profile.index') }}'
                }
            }, 1000);
        }

        if (localStorage.getItem('otp_expiry') !== null) {
            let localExpiryTime = localStorage.getItem('otp_expiry');
            let now = new Date().getTime();

            if (localExpiryTime - now < 0) {
                clearLocalStorage();
                checkSessionAndRemove();
            }
            else {
                $('#otp').focus().select();
                startCounter(localStorage.getItem('otp_expiry'));
            }
        }


        function sendOTPRequest() {
            $.easyAjax({
                url: '{{ route('sendOtpCode.account') }}',
                type: 'POST',
                container: '#request-otp-form',
                messagePosition: 'inline',
                data: $('#request-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        localStorage.setItem('otp_attempts', 3);

                        $('#verify-mobile').html(response.view);
                        $('.attempts_left').html(`3 attempts left`);

                        let html = `<div class="alert alert-info mb-0" role="alert">
                            @lang('messages.info.verifyAlert')
                            <a href="{{ route('admin.profile.index') }}" class="btn btn-warning">
                                @lang('menu.profile')
                            </a>
                        </div>`;

                        $('#verify-mobile-info').html(html);
                        $('#otp').focus();

                        var now = new Date().getTime();
                        var deadline = new Date(now + parseInt('{{ config('vonage.settings.pin_expiry') }}')*1000).getTime();

                        localStorage.setItem('otp_expiry', deadline);
                        // intialize countdown
                        startCounter(deadline);
                    }
                    if (response.status == 'fail') {
                        $('#mobile').focus();
                    }
                }
            });
        }

        function sendVerifyRequest() {
            $.easyAjax({
                url: '{{ route('verifyOtpCode.account') }}',
                type: 'POST',
                container: '#verify-otp-form',
                messagePosition: 'inline',
                data: $('#verify-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        clearLocalStorage();

                        $('#verify-mobile').html(response.view);
                        $('#verify-mobile-info').html('');

                        // select2 reinitialize
                        $('.select2').select2();
                    }
                    if (response.status == 'fail') {
                        // show number of attempts left
                        let currentAttempts = localStorage.getItem('otp_attempts');

                        if (currentAttempts == 1) {
                            clearLocalStorage();
                        }
                        else {
                            currentAttempts -= 1;

                            $('.attempts_left').html(`${currentAttempts} attempts left`);
                            $('#otp').focus().select();
                            localStorage.setItem('otp_attempts', currentAttempts);
                        }

                        if (Object.keys(response.data).length > 0) {
                            $('#verify-mobile').html(response.data.view);

                            // select2 reinitialize
                            $('.select2').select2();

                            clearInterval(x);
                        }
                    }
                }
            });
        }

        $('body').on('submit', '#request-otp-form', function (e) {
            e.preventDefault();
            sendOTPRequest();
        })

        $('body').on('click', '#request-otp', function () {
            sendOTPRequest();
        })

        $('body').on('submit', '#verify-otp-form', function (e) {
            e.preventDefault();
            sendVerifyRequest();
        })

        $('body').on('click', '#verify-otp', function() {
            sendVerifyRequest();
        })
    </script>

@endpush
