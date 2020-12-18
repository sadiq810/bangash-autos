@extends('admin._partials._master')
@section('content')
    <style>
        .custom-tooltip-content{
            box-shadow: none;
            background: none;
        }
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
        .tooltip-item {
            background: none !important;
        }
        .editableform .control-group{
            z-index: 100;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Products Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Products Management</li>
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

                    <a href="{{ route('products.create') }}" type="button" class="btn btn-primary btn-circle" style="float: right; right: 30px; margin-right: 29px;" title="Add New">
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="30">#</th>
                                <th width="200">Name</th>
                                <th>SKU</th>
                                <th>Created</th>
                                <th>Retail Price</th>
                                <th>Discount</th>
                                <th>Purchase Price</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th width="90">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Plcae Order Modal--}}
    <div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Place Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.place.order') }}" method="post" id="addEditForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="control-label">Product Name:</label>
                            <input type="text" name="title" id="titleField" class="form-control" readonly placeholder="title"/>
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="control-label">Available Quantity:</label>
                            <input type="number" name="quantity" id="quantityField" class="form-control" readonly placeholder="quantity"/>
                        </div>

                        <div class="form-group">
                            <label for="order_quantity" class="control-label">Quantity:</label>
                            <input type="number" name="order_quantity" id="order_quantityField" min="1" class="form-control" placeholder="Enter quantity"/>
                        </div>

                        <div class="form-group">
                            <label for="order_quantity" class="control-label">DiscountedProducts Price:</label>
                            <input type="number" name="sale_price" id="sale_priceField" min="1" class="form-control" placeholder="Enter sale price"/>
                        </div>

                        <div class="form-group">
                            <label for="order_quantity" class="control-label">Description:</label>
                            <textarea name="description" id="descriptionField" class="form-control" cols="10" rows="2" placeholder="Order description" required="required"></textarea>
                        </div>
                        <div id="errorDiv" class="alert alert-danger" style="display: none;"></div>
                    </div>

                    <input type="hidden" name="id" value="" id="idHdnField"/>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var addEditModal = null;
        var addEditForm = null;
        var idHdnField = null;
        var mainFilter = null;
        var categoryFilter = null;
        var subCategoryFilter = null;
        var titleField = null;
        var quantityField = null;
        var selectProductForOrder = null;
        var errorDiv = null;
        var sale_priceField = null;

        $(document).ready(function(e) {
            addEditModal = $('#addEditModal');
            addEditForm = $("#addEditForm");
            idHdnField = $("#idHdnField");
            mainFilter = $("#mainFilter");
            categoryFilter = $("#categoryFilter");
            subCategoryFilter = $("#subCategoryFilter");
            titleField = $("#titleField");
            quantityField = $("#quantityField");
            errorDiv = $("#errorDiv");
            sale_priceField = $("#sale_priceField");

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                stateSave: true,
                "ajax": {
                    "url": "{{ route('datatables.products.list') }}",
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
                    {data: "title", name: "title", render: function (data, type, row) {
                        if (row.image) {
                            var image = row.image[0];
                            return `<span class="mytooltip tooltip-effect-5">
                                    <span class="tooltip-item">${data}</span>
                                      <span class="tooltip-content clearfix custom-tooltip-content">
                                      <img src="{{ asset('uploads/thumbs') }}/${image}" />
                                    </span>
                                   </span>`
                        } else
                            return '';
                        } },
                    {data: "sku", name: "sku" },
                    {data: "created_at", name: "created_at" },
                    {data: "sale_price", name: "sale_price" },
                    {data: "discount", name: "discount" },
                    {data: "purchase_price", name: "purchase_price", render: function(data, type, row) {
                        return `<a href="#" class="editPurchasePrice" data-name="purchase_price" data-type="number" data-pk="${row.id}" data-title="Enter purchase price">${data}</a>`;
                    } },
                    {data: "quantity", name: "quantity", render: function(data, type, row) {
                            return `<a href="#"  class="editPurchasePrice" data-name="quantity" data-type="number" data-pk="${row.id}" data-title="Enter quantity">${data}</a>`;
                        } },
                    {data: "status", name: "status", render: function(data, type, row) {
                        return `<div class="switch">
                                    <label>
                                       <input type="checkbox" ${data == 1 ? 'checked' : ''} class="changeStatus" data-id="${row.id}">
                                       <span class="lever switch-col-deep-purple "></span>
                                    </label>
                                </div>`;
                        } },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "drawCallback": function( settings ) {
                    $('.editPurchasePrice').editable({
                        mode: 'inline',
                        url: '{{ route('update.product.field') }}',
                        success: function(response, newValue) {
                            //if(response.status == 'error') return response.msg; //msg will be shown in editable form
                            toast('success', 'Success', response.message);
                        }
                    });
                }
            });//..... end of dataTables.

            $("body").on("click", ".changeStatus",function(e) {
                var id = $(this).attr('data-id');
                var status = 0;

                if ($(this).is(':checked'))
                    status = 1;

                $.ajax({
                    url: '{{ route('change.product.status') }}',
                    type: 'get',
                    data: {id: id, status: status},
                    success: function(response) {
                        if (response.status) {
                            toast('success', 'Success', response.message);
                            //table.ajax.reload();
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });

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

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('products.destroy', 'xxxx') }}';

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
                            url: url.replace('xxxx', id),
                            type: 'delete',
                            success: function(response) {
                                Swal.fire('Deleted!', response.message, 'success');
                                table.ajax.reload();
                            },
                            error: function (err) {
                                toast('error', 'Internal Server Error!', 'Error occurred while deleting the record.');
                            }
                        });
                    }//.... end if() ....//
                });
            });

            $("body").on("click",".placeOrder",function(e) {
                e.preventDefault();

                var data = table.row( $(this).parents('tr') ).data();

                idHdnField.val(data.id);
                titleField.val(data.title);
                quantityField.val(data.quantity);
                sale_priceField.val(data.sale_price);
                selectProductForOrder = data;
                errorDiv.html('').hide();
                addEditModal.modal('show');
            });

            $("#addEditForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);
                errorDiv.hide();

                $(this).ajaxSubmit({
                    success: function(response) {
                        if (response.status) {
                            addEditModal.modal('hide');
                            $this.trigger('reset');
                            toast('success', 'Success', response.message);
                            table.ajax.reload();
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                            if (response.validationError)
                                errorDiv.html(response.validationError).show();
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });
        });//.... end of ready function ....//
    </script>
@endsection
