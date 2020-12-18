@extends('admin._partials._master')
<link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" crossorigin="anonymous">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@section('content')
    <style>
        table{
            margin: 0 auto;
            width: 100%;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap:break-word;
        }
        table.dataTable.nowrap th, table.dataTable.nowrap td {
            white-space: normal;
        }
        .el-element-overlay .el-card-item {
            padding-bottom: 0;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Manage Products Images</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Manage Products Images</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Body Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <select class="custom-select col-12" style="width: 20%" id="mainFilter">
                        <option selected="selected" value="">Filter by status</option>
                        <option value="active">Active Products ({{ $active }})</option>
                        <option value="deActive">De-Active Products ({{ $deActive }})</option>
                        <option value="outOfStock">Out of stock ({{ $outOfStock }})</option>
                        <option value="aboutToOutOfStock">About to Out of Stock ({{ $aboutToOutOfStock }})</option>
                    </select>

                    <select class="custom-select col-12" style="width: 25%" id="categoryFilter">
                        <option selected="selected" value="">Filter by category</option>
                        @foreach($categories as $k => $c)
                            <option value="{{ $k }}">{{ $c }}</option>
                        @endforeach
                    </select>

                    <select class="custom-select col-12" style="width: 25%" id="subCategoryFilter">
                        <option selected="selected" value="">Filter by sub category</option>
                    </select>
                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="30">#</th>
                                <th width="200">Name</th>
                                <th>Images</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Crop Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="img-container">
                                    <img id="image" src="" alt="Image to crop" style="max-height: 500px;"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary waves-effect text-left" id="saveImage">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('footer')
    <script>
        var mainFilter = null;
        var categoryFilter = null;
        var subCategoryFilter = null;
        var assetUrl = "{{ asset('uploads/') }}/";
        var $image = null;
        var imageId = null;
        var imageToEdit = null;
        var largeModal = null;

        $(document).ready(function(e) {
            mainFilter = $("#mainFilter");
            categoryFilter = $("#categoryFilter");
            subCategoryFilter = $("#subCategoryFilter");
            $image = $('#image');
            largeModal = $('#largeModal');

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                stateSave: true,
                "ajax": {
                    "url": "{{ route('datatables.products.list.images') }}",
                    "type": "GET",
                    "data": function(data) {
                        data.mainFilter = mainFilter.val();
                        data.categoryFilterId = categoryFilter.val();
                        data.subCategoryFilterId = subCategoryFilter.val();
                        return data;
                    }
                },
                "columns": [
                    {data: "id", name: "id" },
                    {data: "title", name: "title" },
                    {data: "title", name: "title", searchable: false, filterable: false, render: function (data, type, row) {
                            if (row.image) {
                                var str = '';
                                row.image.forEach(function(img) {
                                    str += `<div class="col-lg-2 col-md-3 item-container" id="${img}">
                                        <div class="el-card-item">
                                            <div class="el-card-avatar el-overlay-1"> <img src="{{ asset('uploads/thumbs') }}/${img}" alt="user">
                                                <div class="el-overlay">
                                                    <ul class="el-info">
                                                        <li><a class="btn default btn-outline image-popup-vertical-fit deleteImage" href="javascript:void(0);" data-id="${row.id}" data-img="${img}"><i class="icon-trash"></i></a></li>
                                                        <li><a class="btn default btn-outline imageSettings" href="javascript:void(0);" data-id="${row.id}" data-img="${img}"><i class="icon-settings"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                       </div>`;
                                });

                                return `<div class="row el-element-overlay sortable sortable-container" data-id="${row.id}">${str}</div>`
                            } else
                                return '';
                        } }
                ],
                "drawCallback": function( settings ) {
                    $( ".sortable" ).sortable({
                        placeholder: "ui-state-highlight",
                        update: function( event, ui ) {
                            var ids = [];
                            var parent = ui.item.parent('.sortable-container');
                            var productId = $(parent).attr('data-id');

                            parent.find('.item-container').each(function(e) {
                                ids.push($(this).attr('id'));
                            });

                            if(ids.length > 0)
                                saveProductImagesOrder(productId, ids);
                        }
                    });
                }
            });//..... end of dataTables.

            $("body").on("change", "#mainFilter",function(e) {
                table.ajax.reload();
            });

            $("body").on("change", "#categoryFilter",function(e) {
                subCategoryFilter.html(``);
                subCategoryFilter.html(`<option selected="selected" value="">Filter by sub category</option>`);
                table.ajax.reload();

                $.ajax({
                    url: '{{ route('category.sub.categories') }}',
                    type: 'get',
                    data: {id: $(this).val()},
                    success: function(response) {
                        Object.keys(response).forEach(function(k) {
                            subCategoryFilter.append(`<option value="${k}">${response[k]}</option>`);
                        });
                    },
                    error: function (err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while getting sub categories.');
                    }
                });
            });

            $("body").on("change", "#subCategoryFilter",function(e) {
                table.ajax.reload();
            });

            $("body").on("click",".deleteImage",function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var image = $(this).attr('data-img');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('delete.product.image') }}',
                            type: 'post',
                            data: {id: id, image:image},
                            success: function(response) {
                                Swal.fire('Deleted!', response.message, 'success');
                                table.ajax.reload();
                            },
                            error: function (err) {
                                toast('error', 'Internal Server Error!', 'Error occurred while deleting the image.');
                            }
                        });
                    }//.... end if() ....//
                });
            });

            $("body").on("click",".imageSettings",function(e) {
                e.preventDefault();
                imageId = $(this).attr('data-id');
                imageToEdit = $(this).attr('data-img');
                if($image.data('cropper')) {
                    $image.data('cropper').replace(assetUrl+imageToEdit);
                    largeModal.modal('show');
                } else {
                    $image.attr('src', assetUrl+imageToEdit);
                    largeModal.modal('show');
                    initCropper();
                }

            });

            $('body').on('click', '#saveImage', function(e) {
                $.ajax({
                    url: '{{ route('change.product.image') }}',
                    type: 'post',
                    data: {id: imageId, image: imageToEdit, newImage: $image.cropper('getCroppedCanvas').toDataURL()},
                    success: function(response) {
                        if (response.status) {
                            toast('success', 'Success', response.message);
                            table.ajax.reload();
                            largeModal.modal('hide');
                           // $image.data('cropper').destroy();
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });
        });//.... end of ready function ....//

        function initCropper() {
            var options = {
                aspectRatio: 1/1,
                crop: function (e) {
                   // console.log('option', e);
                }
            };

            $image.cropper(options);
        }//..... end of initCropper() ....//

        function saveProductImagesOrder(id, images) {
            $.ajax({
                url: '{{ route('save.product.images.order') }}',
                type: 'post',
                data: {id: id, images: images},
                success: function(response) {
                    if (response.status) {
                        toast('success', 'Success', response.message);
                    } else {
                        toast('error', 'Internal Server Error!', response.message);
                    }//..... end of if-else() .....//
                }, error: function(err) {
                    toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                }
            });
        }
    </script>
    <script src="https://unpkg.com/cropperjs/dist/cropper.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/jquery-cropper.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
