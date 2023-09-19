@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.edit') @lang('app.customer')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.name')<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="{{ ucwords($customer->name) }}">
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.email')<sup class="text-danger">*</sup></label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="{{ $customer->email }}">
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.password')</label>
                                    <input type="password" class="form-control form-control-lg" name="password">
                                    <span class="help-block">@lang('messages.leaveBlank')</span>
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.mobile')</label>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <input type="text" readonly class="form-control form-control-lg" name="mobile" value="{{ $customer->formatted_mobile }}">
                                        </div>
                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                            @if ($customer->mobile_verified)
                                                <span class="text-success">
                                                    @lang('app.verified')
                                                </span>
                                            @else
                                                <span class="text-danger">
                                                    @lang('app.notVerified')
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <label>@lang('front.registration.address')<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control form-control-lg" placeholder="@lang('front.registration.houseNo')" name="house_no" type="text" @if($customer && $customer->address) value="{{ $customer->address->house_no }}"@endif>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <label>@lang('front.registration.addressLine')<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control form-control-lg" placeholder="@lang('front.registration.addressLine')" name="address_line" type="text" @if($customer && $customer->address) value="{{ $customer->address->address_line }}"@endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>@lang('front.registration.city')<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control form-control-lg" placeholder="@lang('front.registration.city')" name="city" type="text" @if($customer && $customer->address) value="{{ $customer->address->city }}"@endif>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('front.registration.state')<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control form-control-lg" placeholder="@lang('front.registration.state')" name="state" type="text" @if($customer && $customer->address) value="{{ $customer->address->state }}"@endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>@lang('front.registration.pincode')<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control form-control-lg" placeholder="@lang('front.registration.pincode')" name="pin_code" type="text" @if($customer && $customer->address) value="{{ $customer->address->pin_code }}"@endif>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('front.registration.country')</label>
                                        <div class="form-group">
                                            <select name="country_id" id="country_id" class="form-control form-control-lg select2">
                                                <option>@lang('front.registration.country')</option>
                                                @foreach($countries as $country)
                                                    <option @if ($customer && $customer->address && $country->id == $customer->address->country_id) selected @endif value="{{$country->id}}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.image')</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" data-default-file="{{ $customer->user_image_url  }}" class="dropify dropify-event"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> @lang('app.save')</button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

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

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.customers.update', $customer->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true
            })
        });
    </script>

@endpush
