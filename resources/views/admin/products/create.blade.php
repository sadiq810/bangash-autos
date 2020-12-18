@extends('admin._partials._master')
@section('content')
    <style>
        .dz-progress {
            /* progress bar covers file name */
            display: none !important;
        }
        .dz-details{
            cursor: move !important;
        }

        .sortable {
            padding: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .sortable div.dz-image-preview {
            float: left;
            width: 120px;
            height: 120px;
            overflow:hidden;
            border:1px solid red;
            text-align: center;
            margin:5px;
        }
        .el-card-item, .el-card-avatar {
            padding-bottom: 0 !important;
        }
        .mfp-wrap, .mfp-bg {
            z-index: 9999 !important;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Products Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Products List</a>
                </li>
                <li class="breadcrumb-item active">New Product</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Body Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title">What You're Selling</h4>
                            <h6 class="card-subtitle"> Add new product </h6>
                        </div>
                    </div>

                    {{ Form::model($product, ['route' => 'products.store', 'class' => 'form', 'method' => 'post', 'id' => 'myProductForm']) }}

                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <div class="form-group row">
                        <label for="status" class="col-2 col-form-label">&nbsp;</label>
                        <div class="col-10">
                            <button class="btn btn-block btn-lg btn-secondary" id="browseMedia" style="width: 20%; float: left; margin-right: 16px;">
                                <i class="fas fa-file-image"></i> Media Center
                            </button>
                            <button class="btn btn-block btn-lg btn-secondary" id="uploadMedia" style="width: 15%; float: left; margin-top: 0">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-2 col-form-label">&nbsp;</label>
                        <div class="col-10">
                            <div class="dropzone" id="myDropzone"></div>
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        {{ Form::label('title', 'Name', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Product name', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('category_id', 'Category', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::select('category_id', $categories, null, ['class' => 'custom-select col-12', 'placeholder' => 'Select category', 'required' => 'required', 'id' => 'mainCategory']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('sub_category_id', 'Sub Category', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::select('sub_category_id', $subCategories ?? [], null, ['class' => 'custom-select col-12', 'placeholder' => 'Select sub category', 'id' => 'sub_category_list']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Description</label>
                        <div class="col-10">
                            <div class="summernote">{!! $product->description !!}</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-url-input" class="col-2 col-form-label">URL</label>
                        <div class="col-10">
                            {{ Form::url('url', null, ['class' => 'form-control', 'placeholder' => 'Youtube iframe url']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-4" style="padding-left: 0;">
                            {{ Form::label('weight', 'Package Weight (kg)', ['class' => 'col-6 col-form-label', 'style' => 'float: left;']) }}
                            <div class="col-6" style="float: left;padding-left: 20px;">
                                {{ Form::number('weight', null, ['class' => 'form-control', 'min' => 0.0, 'step' => 0.1, 'required' => 'required', 'placeholder' => 'kg']) }}
                            </div>
                        </div>
                        <div class="form-group col-lg-8" >
                            {{ Form::label('weight', 'Package Dimensions (cm)', ['class' => 'col-4 col-form-label']) }}
                            <div class="col-8" style="float:right;">
                                {{ Form::number('length', $product->dimension['length'] ?? null, ['class' => 'form-control col-lg-3', 'style' => 'float: left; margin-right: 12px;', 'placeholder' => 'Length', 'min' => 0, 'required'=> 'required']) }}
                                {{ Form::number('width', $product->dimension['width'] ?? null, ['class' => 'form-control col-lg-3', 'style' => 'float: left; margin-right: 12px;', 'placeholder' => 'Width', 'min' => 0, 'required'=> 'required']) }}
                                {{ Form::number('height', $product->dimension['height'] ?? null, ['class' => 'form-control col-lg-3', 'style' => 'float: left;', 'placeholder' => 'Height', 'min' => 0, 'required'=> 'required']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6" style="padding-left: 2px;">
                            {{ Form::label('quantity', 'Quantity', ['class' => 'col-4 col-form-label']) }}
                            <div class="col-8" style="float: right;">
                                {{ Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Quantity', 'min' => 0]) }}
                            </div>
                        </div>
                        <div class="form-group col-lg-6" >
                            {{ Form::label('alert_quantity', 'Minimum Quantity (Alert)', ['class' => 'col-5 col-form-label', 'style' => 'float:left;']) }}
                            <div class="col-6" style="float:left;">
                                {{ Form::number('alert_quantity', null, ['class' => 'form-control', 'placeholder' => 'Alert on', 'min' => 0]) }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6" style="padding-left: 0; margin-left: -7px; float: left;">
                        {{ Form::label('purchase_price', 'Purchase Price', ['class' => 'col-4 col-form-label', 'style' => 'padding-left: 9px;']) }}
                        <div class="col-8" style="float: right;">
                            {{ Form::number('purchase_price', null, ['class' => 'form-control', 'placeholder' => 'Purchase price', 'min' => 0, 'step' => 1]) }}
                        </div>
                    </div>

                    <div class="form-group col-lg-6" style="float:left;">
                        {{ Form::label('sale_price', 'Sale Price', ['class' => 'col-4 col-form-label']) }}
                        <div class="col-8" style="float: right;">
                            {{ Form::number('sale_price', null, ['class' => 'form-control', 'placeholder' => 'Sale price', 'min' => 0, 'step' => 1]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ Form::label('discount', 'Discount', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::number('discount', null, ['class' => 'form-control', 'placeholder' => 'Discount', 'min' => 0, 'step' => '0.1']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-date-input" class="col-2 col-form-label">Discount Start Date</label>
                        <div class="col-10">
                            {{ Form::date('discount_start_date', null, ['class' => 'form-control', 'id' => 'example-date-input']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-date-input" class="col-2 col-form-label">Discount End Date</label>
                        <div class="col-10">
                            {{ Form::date('discount_end_date', null, ['class' => 'form-control', 'id' => 'example-date-input']) }}
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        {{ Form::label('free_items', 'Free Items', ['class' => 'col-2 col-form-label']) }}
                        <div class="col-10">
                            {{ Form::text('free_items', null, ['class' => 'form-control', 'placeholder' => 'Free items']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-4" style="padding-left: 0;">
                            {{ Form::label('car_brand', 'Car Brand', ['class' => 'col-6 col-form-label', 'style' => 'float: left;']) }}
                            <div class="col-6" style="float: left;padding-left: 20px;">
                                {{ Form::select('car_brand_id', $carBrands, null, ['class' => 'custom-select col-12', 'placeholder' => 'Select car brand', 'id' => 'carBrand']) }}
                            </div>
                        </div>
                        <div class="form-group col-lg-3" style="padding-left: 0;">
                            {{ Form::label('car_model', 'Car Model', ['class' => 'col-4 col-form-label', 'style' => 'float: left;']) }}
                            <div class="col-8" style="float: left;padding-left: 20px;">
                                {{ Form::select('car_model_id', $carModels ?? [], null, ['class' => 'custom-select col-12', 'placeholder' => 'Select car model',  'id' => 'carModelsList']) }}
                            </div>
                        </div>
                        <div class="form-group col-lg-2" style="padding-left: 0;">
                            {{ Form::label('car_version', 'Year', ['class' => 'col-4 col-form-label', 'style' => 'float: left;']) }}
                            <div class="col-8" style="float: left;padding-left: 20px;">
                                {{ Form::number('car_version', null, ['class' => 'form-control', 'placeholder' => 'eg: 2019', 'min' => 1970, 'step' => '1']) }}
                            </div>
                        </div>
                        <div class="form-group col-lg-2" style="padding-left: 0;">
                            {{ Form::label('car_version', 'To', ['class' => 'col-4 col-form-label', 'style' => 'float: left;']) }}
                            <div class="col-8" style="float: left;">
                                {{ Form::number('version_through', null, ['class' => 'form-control', 'placeholder' => 'eg: 2019', 'min' => 1970, 'step' => '1']) }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-datetime-local-input" class="col-2 col-form-label">Publish Date</label>
                        <div class="col-10">
                            {{ Form::input('date', 'publish_date', $product->publish_date ? \Carbon\Carbon::parse($product->publish_date)->format('Y-m-d'): \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="colors" class="col-2 col-form-label">Select Colors</label>
                        <div class="col-10">
                            <hr class="m-t-0 m-b-40"/>
                            @foreach($colors as $color)
                                <?php
                                $found = $product->colors->where('id', $color->id)->first();
                                $price = 0;
                                if ($found)
                                    $price = $found['price'];
                                ?>
                                <div class="col-lg-6" style="float: left; border-left: 1px solid;">
                                    <div class="col-lg-4"  style="float:left; padding-top: 8px;">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="colors[]" value="{{ json_encode($color) }}" @if($found) checked @endif>
                                            <span class="custom-control-label">{{ $color->title }}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-8" style="float:left;">
                                        {{ Form::label('price', 'Price', ['class' => 'col-4 col-form-label']) }}
                                        <div class="col-8" style="float: right;">
                                            {{ Form::number('color-price-'.$color->id, $price, ['class' => 'form-control', 'placeholder' => 'price', 'min' => 0, 'step' => 1]) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr class="m-t-0 m-b-40"/>
                    <div class="form-group row">
                        <label for="status" class="col-2 col-form-label">Status</label>
                        <div class="col-10">
                            <div class="demo-checkbox">
                                <input type="checkbox" name="status" id="basic_checkbox_2" class="filled-in" @if($product->status) checked @endif />
                                <label for="basic_checkbox_2">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs-right">
                        <button type="submit"  value="0" class="btn btn-info">Save</button>
                        @if(! $product->id)
                            <button type="submit"  value="1" class="btn btn-info">Save and New</button>
                        @endif
                        <button type="reset" class="btn btn-inverse">Cancel</button>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal bs-example-modal-lg" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Select Media</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row el-element-overlay" id="mediaWrapper" style="max-height: 500px; overflow-y: auto;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('footer')
    <script>
        Dropzone.autoDiscover = false;
        var sub_category_list = null;
        var carModelsList = null;
        var media = [];
        var selectedMedia = [];// when user select media, then it is pushed to it.
        var mediaModal = null;
        var mediaWrapper = null;
        var loader = null;

        jQuery(document).ready(function() {

            sub_category_list = $("#sub_category_list");
            carModelsList = $("#carModelsList");
            mediaModal = $("#mediaModal");
            mediaWrapper = $("#mediaWrapper");
            loader = $(".preloader");

            $("#myDropzone").dropzone( {
                url: '/test',
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 6,
                maxFiles: 15,
                maxFilesize: 3,
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                init: function() {
                    this.on('removedfile', function(file) {
                        selectedMedia = selectedMedia.filter(function(image) {
                            return image != file.name;
                        });
                    });

                    @if($product->image)
                        @foreach($product->image as $image)
                            var mockFile = { name: '{{ $image }}', size: 12345 };
                    this.emit("addedfile", mockFile);
                    this.createThumbnailFromUrl(mockFile, '{{ asset('/uploads/'.$image) }}');
                    this.files.push(mockFile);
                            selectedMedia.push('{{ $image }}');
                        @endforeach
                    @endif

                        activateSorting();
                },
                accept: function(file, done) {
                    done();
                    activateSorting();
                }
            });

            $("#myProductForm").on('submit', function (e) {
                e.preventDefault();
                loader.fadeIn();
                var nextAction = $(this).find("button[type=submit]:focus").val();
                var files = [];
                var myDropzone = Dropzone.forElement("#myDropzone");
                myDropzone.getQueuedFiles().forEach(function(f) {
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(f);
                    fileReader.onloadend = function() {
                      files.push(fileReader.result);
                    }
                });

                var description = $('.summernote').summernote('code');

                var selectedMediaWithOrder = {};
                if (selectedMedia.length > 0) {
                    myDropzone.files.forEach(function(file, key) {
                       if (file.name && selectedMedia.includes(file.name))
                           selectedMediaWithOrder[key] = file.name;
                    });
                }//..... end if() .....//

                var $this = this;
                setTimeout(function() {
                    $($this).ajaxSubmit({
                        data: {filesArr: files, description: description, selectedMedia: selectedMediaWithOrder},
                        success: function(response) {
                            loader.fadeOut();
                            toast('success', 'Success', response.message);
                            if (nextAction == 0)
                                window.location.href = '{{ route('products.index') }}';
                            else {
                                $($this).trigger('reset');
                                var uploadzone  = Dropzone.forElement("#myDropzone");
                                uploadzone.removeAllFiles();
                                sub_category_list.html('');
                                $('.summernote').summernote('code', '');
                            }
                        },
                        error: function(err) {
                            console.error(err);
                            loader.fadeOut();
                        }
                    });
                }, 2000);

            });//..... end of form-submit.

            $('.summernote').summernote({
                height: 350, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            $("#mainCategory").on("change", function(e) {
                e.preventDefault();
                var value = $(this).val();
                sub_category_list.html('');
                if (!value)
                    return false;

                $.ajax({
                    url: '{{ route("category.sub.category") }}',
                    type: 'get',
                    data: {id: value},
                    success: function(response) {
                        Object.keys(response).forEach(function(k) {
                            sub_category_list.append(`<option value='${k}'>${response[k]}</option>`);
                        })
                    },
                    error: function (err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while deleting the record.');
                    }
                });
            });


            $("#carBrand").on("change", function(e) {
                e.preventDefault();
                var value = $(this).val();
                carModelsList.html('');
                if (!value)
                    return false;

                $.ajax({
                    url: '{{ route("car.models.list.dropdown") }}',
                    type: 'get',
                    data: {id: value},
                    success: function(response) {
                        Object.keys(response).forEach(function(k) {
                            carModelsList.append(`<option value='${k}'>${response[k]}</option>`);
                        })
                    },
                    error: function (err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while deleting the record.');
                    }
                });
            });

            $("body").on('click', '#browseMedia', function(e) {
                e.preventDefault();
                if (media.length > 0) {
                    populateMediaInModal();
                } else {
                    $.ajax({
                        url: "{{ route('load.products.media') }}",
                        type: 'get',
                        success: function(response) {
                            media = response;
                            populateMediaInModal();
                        },
                        error: function (err) {
                            toast('error', 'Internal Server Error!', 'Error occurred while deleting the record.');
                        }
                    });
                }
            });

            $("body").on('click', '#uploadMedia', function(e) {
                e.preventDefault();
                $('#myDropzone').trigger('click');
            });

            $("body").on('click', '.mediaSelected', function(e) {
                e.preventDefault();
                var image = $(this).attr('data-image');
                if (!selectedMedia.includes(image)) {
                    var myDropzone = Dropzone.forElement("#myDropzone");
                    var mockFile = { name: image, size: 12345 };
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.createThumbnailFromUrl(mockFile,BaseUrl+'/uploads/'+image);
                    myDropzone.files.push(mockFile);
                    selectedMedia.push(image);
                }
            });
        });//..... end of ready() .....//

        function populateMediaInModal() {
            mediaWrapper.html('');
            media.forEach(function(image) {
                mediaWrapper.append(`<div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="el-card-item">
                                    <div class="el-card-avatar el-overlay-1"> <img src="${BaseUrl +'/uploads/'+image}" alt="user">
                                        <div class="el-overlay">
                                            <ul class="el-info">
                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="${BaseUrl +'/uploads/'+image}"><i class="icon-magnifier"></i></a></li>
                                                <li><a class="btn default btn-outline mediaSelected" data-image="${image}" href="javascript:void(0);"><i class="icon-link"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`);
            });

            mediaModal.modal('show');
            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image'
            });
        }//..... end of populateMediaModal() .....//

        function activateSorting() {
            var uploadzone  = Dropzone.forElement("#myDropzone");
            $("#myDropzone").sortable({
                items: '.dz-preview',
                cursor: 'move',
                opacity: 0.5,
                containment: '#myDropzone',
                distance: 20,
                tolerance: 'pointer',
                stop: function () {
                    var queue = uploadzone.files;
                    var newQueue = [];
                    $('#myDropzone .dz-preview .dz-filename [data-dz-name]').each(function (count, el) {
                        var name = el.innerHTML;
                        queue.forEach(function(file) {
                            if (file.name === name) {
                                newQueue.push(file);
                            }
                        });
                    });
                    uploadzone.files = newQueue;
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
