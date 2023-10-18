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
    .card-dark:not(.card-outline) .card-header .note-btn-group a {
        color: #000000;
    }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('app.product')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm" class="ajax-form" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.product') @lang('app.name')<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location')<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="location_id" id="location_id" class="form-control form-control-lg">
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" @if (!empty($product) && $product->location->id == $location->id)
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

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('app.product') @lang('app.description')<span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" cols="30" class="form-control-lg form-control" rows="4">{{ !empty($product) ? $product->description : '' }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('app.price')<span class="text-danger">*</span></label>
                                    <input onkeypress="return isNumberKey(event)" type="number" step="0.01" min="0" name="price" id="price" class="form-control form-control-lg" @if (!empty($product)) value="{{ $product->price }}" @endif/>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>@lang('modules.services.discount')<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input onkeypress="return isNumberKey(event)" type="number" max="100" class="form-control form-control-lg" name="discount" id="discount" min="0" @if (!empty($product)) value="{{ $product->discount }}" @endif>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="discount-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if (!empty($product))
                                                    @if ($product->discount_type == 'percent')
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

                            @if (!is_null($taxes))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('app.select') @lang('app.tax')</label>
                                        <select name="tax_ids[]" id="tax_ids" class="form-control form-control-lg select2" multiple="multiple">
                                            <option value="0">@lang('app.select') @lang('app.tax')</option>
                                            @foreach($taxes as $tax)
                                                <option value="{{ $tax->id }}">{{ $tax->tax_name }} {{ $tax->percent }}%</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

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

                                <input type="hidden" name="productID" id="productID">

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
            });

            @if (!empty($product))
                $('#discount-type').val('{{ $product->discount_type }}');
                $('#time-type').val('{{ $product->time_type }}');
            @endif

            calculateDiscountedPrice();
        })
        var defaultImage = '';
        var lastIndex = 0;
        Dropzone.autoDiscover = false;
        //Dropzone class
        myDropzone = new Dropzone("#file-upload-dropzone", {
            url: "{{ route('admin.products.storeImages') }}",
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
            var id = $('#productID').val();
            formData.append('product_id', id);
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
            window.location.href = '{{ route('admin.products.index') }}'
        });

        $('.discount_type').click(function () {
            var type = $(this).data('type');

            $('#discount-type-select').html(type.charAt(0).toUpperCase()+type.slice(1)+' <i class="fa fa-caret-down" aria-hidden="true"></i>');

            $('#discount-type').val(type);

            calculateDiscountedPrice();
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.products.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize(),
                success: function (response) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        productID = response.productID;
                        defaultImage = response.defaultImage;
                        $('#productID').val(response.productID);
                        myDropzone.processQueue();
                    }
                    else{
                        var msgs = "@lang('messages.createdSuccessfully')";
                        $.showToastr(msgs, 'success');
                        window.location.href = '{{ route('admin.products.index') }}'
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
                    discountedPrice = parseFloat(price)-(parseFloat(price)*(parseFloat(discount)/100));
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

        $(".location-modal").click(function(){
            var url = "{{ route('admin.add-location') }}";
            $(modal_lg + ' ' + modal_heading).html('...');
            $.ajaxModal(modal_lg, url);
        });

    </script>

@endpush
