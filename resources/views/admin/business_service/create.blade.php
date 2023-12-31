@extends('layouts.master')

@section('content')
<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #999;
    }
    .select2-dropdown .select2-search__field:focus, .select2-search--inline .select2-search__field:focus {
        border: 0px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        margin: 0 13px;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #cfd1da;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__clear {
        cursor: pointer;
        float: right;
        font-weight: bold;
        margin-top: 8px;
        margin-right: 15px;
    }

    .card-dark:not(.card-outline) .card-header a {
    color: #121111;
}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('app.service')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm" class="ajax-form" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang("app.serviceType")</label>
                                    <div>
                                        <label class="radio-inline">
                                            <input type="radio" name="service_type" class="checkbox service_type_chkbox" value="offline" id="service_type" checked>
                                            @lang('app.serviceOffline')
                                        </label>
                                        <label class="radio-inline pl-lg-2">
                                            <input type="radio" name="service_type" class="checkbox service_type_chkbox" value="online" id="service_type" >
                                            @lang('app.serviceOnline')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.service') @lang('app.name')<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{ old('name') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>@lang('app.service') @lang('app.slug')<span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="slug" class="form-control form-control-lg" @if (!empty($service)) value="{{ $service->slug }}" @endif autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('app.service') @lang('app.description')<span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" cols="30" class="form-control-lg form-control" rows="4">{{ !empty($service) ? $service->description : '' }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('app.price')<span class="text-danger">*</span></label>
                                    <input onkeypress="return isNumberKey(event)" type="number" step="0.01" min="0" name="price" id="price" class="form-control form-control-lg" @if (!empty($service)) value="{{ $service->price }}" @endif/>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>@lang('modules.services.discount')<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input onkeypress="return isNumberKey(event)" type="number" max="100" class="form-control form-control-lg" name="discount" id="discount" min="0" @if (!empty($service)) value="{{ $service->discount }}" @endif>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="discount-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if (!empty($service))
                                                    @if ($service->discount_type == 'percent')
                                                        @lang('modules.services.percent')
                                                    @else
                                                        @lang('modules.services.fixed')
                                                    @endif
                                                @else
                                                        @lang('modules.services.percent')
                                                @endif
                                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item discount_type" data-type="percent" href="javascript:;">@lang('modules.services.percent')</a>
                                                <a class="dropdown-item discount_type" data-type="fixed" href="javascript:;">@lang('modules.services.fixed')</a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="discount-type" name="discount_type" value="percent">

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 offset-md-1">
                                <div class="form-group">
                                    <label>@lang('modules.services.discountedPrice')</label>
                                    <p class="form-control-static" id="discounted-price" style="font-size: 1.5rem">--</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location')<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="location_id" id="location_id" class="form-control form-control-lg">
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" @if (!empty($service) && $service->location->id == $location->id)
                                                    selected
                                                @endif>{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success location-modal" type="button"><i class="fa fa-plus"></i> @lang('app.add')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.category')<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-control form-control-lg">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if (!empty($service) && $service->category->id == $category->id)
                                                    selected
                                                @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success category-modal" type="button"><i class="fa fa-plus"></i> @lang('app.add')</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>@lang('modules.services.time')</label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input onkeypress="return isNumberKey(event)" type="number" class="form-control form-control-lg" name="time" @if (!empty($service)) value="{{ $service->time }}" @endif>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="time-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if (!empty($service))
                                                    @switch($service->time_type)
                                                        @case('minutes')
                                                            @lang('app.minutes')
                                                            @break
                                                        @case('hours')
                                                            @lang('app.hours')
                                                            @break
                                                        @case('days')
                                                            @lang('app.days')
                                                            @break
                                                        @default
                                                    @endswitch
                                                @else
                                                    @lang('app.minutes')
                                                @endif
                                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item time_type" data-type="minutes" href="javascript:;">@lang('app.minutes')</a>
                                                <a class="dropdown-item time_type" data-type="hours" href="javascript:;">@lang('app.hours')</a>
                                                <a class="dropdown-item time_type" data-type="days" href="javascript:;">@lang('app.days')</a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="time-type" name="time_type" value="minutes">

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('app.select') @lang('app.tax')</label>
                                    <select name="tax_ids[]" id="tax_ids" class="form-control form-control-lg select2" multiple="multiple">
                                        @foreach($taxes as $tax)
                                            <option value="{{ $tax->id }}">{{ $tax->tax_name }} {{ $tax->percent }}%</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >@lang('app.assign') @lang('app.employee')<span id="assign-employee" class="text-danger"></span></label>
                                    <select name="employee_ids[]" id="employee_ids" class="form-control form-control-lg select2" multiple="multiple" style="width: 100%">
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-outline-info btn-sm col-md-2 select-image-button" style="margin-bottom: 10px;display: none "><i class="fa fa-upload"></i> File Select Or Upload</button>
                                <div id="file-upload-box" >
                                    <div class="row" id="file-dropzone">
                                        <div class="col-md-12">
                                            <div class="dropzone"
                                                    id="file-upload-dropzone">
                                                {{ csrf_field() }}
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="text-danger">@lang('modules.theme.recommendedResolutionNote')</h6>

                                <input type="hidden" name="serviceID" id="serviceID">

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

@if (!empty($googleMapAPIKey))
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{$googleMapAPIKey->google_map_api_key}}&sensor=false&libraries=places&language={{app()->getLocale()}}'></script>
<script src="{{ asset('js/locationpicker.jquery.js') }}"></script>
@endif

    <script>

        $(function () {
            $('#description').summernote({
                dialogsInBody: true,
                height: 300
            })

            @if (!empty($service))
                $('#discount-type').val('{{ $service->discount_type }}');
                $('#time-type').val('{{ $service->time_type }}');
            @endif

            calculateDiscountedPrice();
        })
        var defaultImage = '';
        var lastIndex = 0;
        Dropzone.autoDiscover = false;
        //Dropzone class
        myDropzone = new Dropzone("#file-upload-dropzone", {
            url: "{{ route('admin.business-services.storeImages') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            paramName: "file",
            maxFilesize: 10,
            maxFiles: 10,
            acceptedFiles: "image/*",
            autoProcessQueue: false,
            uploadMultiple: true,
            addRemoveLinks:true,
            parallelUploads:10,
            init: function () {
                myDropzone = this;
            },
            dictDefaultMessage: "@lang('app.dropzone.defaultMessage')",
            dictRemoveFile: "@lang('app.dropzone.removeFile')"
        });

        myDropzone.on('sending', function(file, xhr, formData) {
            var id = $('#serviceID').val();
            formData.append('service_id', id);
            formData.append('default_image', defaultImage);
        });

        myDropzone.on('addedfile', function (file) {
            lastIndex++;
            var div = document.createElement('div');
            div.className = 'form-check form-check-inline';
            var input = document.createElement('input');
            input.className = 'form-check-input';
            input.type = 'radio';
            input.name = 'default_image';
            input.id = 'default-image-'+lastIndex;
            input.value = file.name;
            div.appendChild(input);
            var label = document.createElement('label');
            label.className = 'form-check-label';
            label.innerHTML = "@lang('app.dropzone.makeDefaultImage')";
            label.htmlFor = 'default-image-'+lastIndex;
            div.appendChild(label);
            file.previewTemplate.appendChild(div);
        })

        myDropzone.on('completemultiple', function () {
            var msgs = "@lang('messages.createdSuccessfully')";
            $.showToastr(msgs, 'success');
            window.location.href = '{{ route('admin.business-services.index') }}'
        });

        function createSlug(value) {
            value = value.replace(/\s\s+/g, ' ');
            let slug = value.split(' ').join('-').toLowerCase();
            slug = slug.replace(/--+/g, '-');
            $('#slug').val(slug);
        }

        $('.service_type_chkbox').change(function() {
            var test = $(this).val();

            if(test == 'online'){
                $('#assign-employee').html('*');
            }
            else{
                $('#assign-employee').html('');
            }
        })

        $('#name').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#slug').keyup(function(e) {
            createSlug($(this).val());
        });

        $('.time_type').click(function () {
            var type = $(this).data('type');

            $('#time-type-select').html(type);
            $('#time-type').val(type);
        });


        $('.discount_type').click(function () {
            var type = $(this).data('type');

            $('#discount-type-select').html(type.charAt(0).toUpperCase()+type.slice(1)+' <i class="fa fa-caret-down" aria-hidden="true"></i>');
            $('#discount-type').val(type);
            calculateDiscountedPrice();
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.business-services.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize(),
                success: function (response) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        serviceID = response.serviceID;
                        defaultImage = response.defaultImage;
                        $('#serviceID').val(response.serviceID);
                        myDropzone.processQueue();
                    }
                    else{
                        var msgs = "@lang('messages.createdSuccessfully')";
                        $.showToastr(msgs, 'success');
                        window.location.href = '{{ route('admin.business-services.index') }}'
                    }
                }
            })
        });

        $('#discount, #price').keyup(function () {
            calculateDiscountedPrice();
        });

        $('#discount, #price').change(function () {
            calculateDiscountedPrice();
        });

        $('#discount, #price').on('wheel', function () {
            calculateDiscountedPrice();
        });

        function calculateDiscountedPrice() {
            var price = $('#price').val();
            var discount = $('#discount').val();
            var discountType = $('#discount-type').val();

            if (discountType == 'percent') {
                if(discount > 100){
                    $('#discount').val(100);
                    discount = 100;
                }
            }
            else {
                if (parseInt(discount) > parseInt(price)) {
                    $('#discount').val(price);
                    discount = price;
                }
            }

            var discountedPrice = price;

            if(discount >= 0 && discount >= '' && price != '' && price > 0){
                if(discountType == 'percent'){
                    discountedPrice = parseFloat(price)-(parseFloat(price)*(parseFloat(discount))/100);
                }
                else{
                    discountedPrice = parseFloat(price)-parseFloat(discount);
                }
            }
            if(discount != '' && price != '' && price > 0){
                $('#discounted-price').html(discountedPrice.toFixed(2));
            }
            else {
                $('#discounted-price').html('--');
            }
        }

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }

        $('body').on('click', '.location-modal', function() {
            var url = "{{ route('admin.add-location') }}";

            $(modal_lg + ' ' + modal_heading).html('...');
            $.ajaxModal(modal_lg, url);
        });

        $(".category-modal").click(function(){
            var url = "{{ route('admin.add-category') }}";

            $(modal_lg + ' ' + modal_heading).html('...');
            $.ajaxModal(modal_lg, url);
        });
    </script>
@endpush
