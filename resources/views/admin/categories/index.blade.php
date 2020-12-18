@extends('admin._partials._master')
@section('content')
    <style>
        .detailGrid {
            border: solid 2px black;
            border-radius: 2%;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Categories Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Categories Management</li>
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
                    <button type="button" id="addNew" class="btn btn-primary btn-circle" style="float: right; right: 30px; margin-right: 29px;" title="Add New">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-circle" style="float: right; right: 30px; margin-right: 29px;" title="Sort Categories" onclick="window.location.href='{{ route("sort.categories") }}';">
                        <i class="fa fas fa-bars"></i>
                    </button>
                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Sub-Categories</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Add-Edit Modal--}}
    <div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add/Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('categories.store') }}" method="post" id="addEditForm" class="floating-labels" enctype="multipart/form-data">
                    <div class="modal-body" style="min-height: 220px;">
                        <div class="form-group m-b-40">
                            <input type="text" name="title" class="form-control input-sm" id="input9" required="required">
                            <span class="bar"></span>
                            <label for="input9">Title</label>
                        </div>

                        <div class="form-group m-b-40">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" accept="image/*">
                                <label class="custom-file-label">Choose Category Image(of size 271*555)</label>
                            </div>
                        </div>

                        <div class="form-group m-b-40">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="status">
                                <span class="custom-control-label">Status</span>
                            </label>
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


    {{--Add-Edit Sub Modal--}}
    <div class="modal fade" id="addEditSubModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel12">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel12">Add/Edit Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('categories.store') }}" method="post" id="addEditSubForm" class="floating-labels" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group m-b-40">
                            <input type="text" name="title" class="form-control input-sm" id="input9" required="required">
                            <span class="bar"></span>
                            <label for="input9">Title</label>
                        </div>

                        <div class="form-group m-b-40">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" accept="image/*">
                                <label class="custom-file-label">Choose Category Image(of size 271*555)</label>
                            </div>
                        </div>

                        <div id="errorSubDiv" class="alert alert-danger" style="display: none;"></div>
                    </div>

                    <input type="hidden" name="id" value="" id="subIdHdnField"/>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="categoryProductsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Select Top 20 products for selected category.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="tablesaw table-bordered table-hover table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="border">&nbsp;</th>
                                        <th scope="col" class="border">Title</th>
                                    </tr>
                                    </thead>
                                    <tbody id="productsContainer"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary waves-effect text-left" id="saveCatProd">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('footer')
    <script>
        var addEditModal = null;
        var addEditForm = null;
        var addEditSubForm = null;
        var idHdnField = null;
        var subIdHdnField = null;
        var errorDiv = null;
        var errorSubDiv = null;
        var mainCategoryId = null;
        var addEditSubModal = null;
        var categoryProductsModal = null;
        var productsContainer = null;
        var selectedCategoryId = null;

        $(document).ready(function(e) {
            addEditModal = $('#addEditModal');
            addEditSubModal = $('#addEditSubModal');
            addEditForm = $("#addEditForm");
            addEditSubForm = $("#addEditSubForm");
            idHdnField = $("#idHdnField");
            subIdHdnField = $("#subIdHdnField");
            errorDiv = $("#errorDiv");
            errorSubDiv = $("#errorSubDiv");
            categoryProductsModal = $("#categoryProductsModal");
            productsContainer = $("#productsContainer");

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.categories.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {
                        "class":          "details-control",
                        "data":           null,
                        "defaultContent": "",
                        orderable: false,
                        searchable: false
                    },
                    {data: "title", name: "title" },
                    {data: "sub_categories_count", name: "sub_categories_count" },
                    {data: "status", name: 'status', orderable: false, searchable: 'false', render: function(d) {
                        return d == 0 ? `<span style="color: red;">DeActive</span>` : `<span style="color: green;">Active</span>`;
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });//..... end of dataTables.

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

            $("body").on("click",".selectCategoryProducts",function(e){
                selectedCategoryId = $(this).attr('data-id');
                productsContainer.html('');
                $.ajax({
                    url: '{{ route('category.products.list') }}',
                    type: 'post',
                    data: {id: selectedCategoryId},
                    success: function(response) {
                        response.data.forEach(function(item) {
                            var str = item.priority == 1 ? `<input type="checkbox" class="catProd" value="${item.id}" checked="checked" />` : `<input type="checkbox" class="catProd" value="${item.id}" />`
                            productsContainer.append(`
                            <tr>
                                <td>
                                    ${str}
                                </td>
                                <td><a href="{{ url('/product') }}/${item.slug}" target="_blank">${item.title}</a></td>
                            </tr>
                            `);
                        });
                    },
                    error: function (err) {
                        toast('error', `Internal Server Error!', 'Error occurred while getting category's products.`);
                        categoryProductsModal.modal('hide');
                    }
                });
                categoryProductsModal.modal('show');
            });

            $('body').on('click', '#saveCatProd', function () {
                var p = [];
                $('.catProd:checked').each(function() {
                    p.push($(this).val());
                });

                $.ajax({
                    url: '{{ route('save.category.products') }}',
                    type: 'post',
                    data: {ids: p, category_id: selectedCategoryId},
                    success: function(response) {
                        categoryProductsModal.modal('hide');
                        Swal.fire('Saved!', response.message, 'success');
                    },
                    error: function (err) {
                        toast('error', `Internal Server Error!', 'Error occurred while saving category's products.`);
                        categoryProductsModal.modal('hide');
                    }
                });
            });

            $("body").on("click","#addNew",function(e){
                addEditForm.trigger('reset');
                addEditForm.find('.form-group').removeClass('focused');
                idHdnField.val('');
                errorDiv.html('').hide();
                addEditModal.modal('show');
            });

            $("body").on("click",".addNewSub",function(e){
                mainCategoryId = $(this).attr('data-id');

                addEditSubForm.trigger('reset');
                addEditSubForm.find('.form-group').removeClass('focused');
                subIdHdnField.val('');
                errorSubDiv.html('').hide();
                addEditSubModal.modal('show');
            });

            $("#addEditSubForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);
                errorSubDiv.hide();

                $(this).ajaxSubmit({
                    data: {parent: mainCategoryId},
                    success: function(response) {
                        if (response.status) {
                            addEditSubModal.modal('hide');
                            $this.trigger('reset');
                            toast('success', 'Success', response.message);
                            $('#dataTable-'+mainCategoryId).DataTable().ajax.reload();
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

            $("body").on("click",".editRecord",function(e) {
                e.preventDefault();
                addEditForm.trigger('reset');
                errorDiv.html('').hide();

                var data = JSON.parse($(this).attr("data-json"));
                var id = $(this).attr('data-id');

                idHdnField.val(id);
                Object.keys(data).forEach(function(key) {
                    if(key == 'status') {
                        if(data[key] == 1)
                         $("input:checkbox[name="+key+"]").attr('checked', true);
                        else
                            $("checkbox[name="+key+"]").attr('checked', false);
                    } else
                        $("input[name="+key+"]").val(data[key]).parent().addClass('focused');
                });

                addEditModal.modal('show');
            });

            $("body").on("click",".editSubRecord",function(e) {
                e.preventDefault();
                addEditSubForm.trigger('reset');
                errorSubDiv.html('').hide();

                var data = JSON.parse($(this).attr("data-json"));
                var id = $(this).attr('data-id');
                mainCategoryId = $(this).attr('data-parent');

                subIdHdnField.val(id);
                Object.keys(data).forEach(function(key) {
                    $("#addEditSubModal input[name="+key+"]").val(data[key]).parent().addClass('focused');
                });

                addEditSubModal.modal('show');
            });

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('categories.destroy', 'xxxx') }}';

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

            $("body").on("click",".deleteSubRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                mainCategoryId = $(this).attr('data-parent');
                var url = '{{ route('categories.destroy', 'xxxx') }}';

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
                                $('#dataTable-'+mainCategoryId).DataTable().ajax.reload();
                            },
                            error: function (err) {
                                toast('error', 'Internal Server Error!', 'Error occurred while deleting the record.');
                            }
                        });
                    }//.... end if() ....//
                });
            });

            // Add event listener for opening and closing details
            $('#dataTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                    initializeDataTable(row.data().id)
                }
            } );
        });//.... end of ready function ....//

        function format ( d ) {
            // `d` is the original data object for the row
            return `
            <div class="card-body detailGrid">
                    <button type="button" data-id='${d.id}' class="btn btn-info btn-circle addNewSub" style="float: right; right: 30px; margin-right: 29px;" title="Add New">
                        <i class="fa fa-plus"></i>
                    </button>
                    <div class="table-responsive m-t-40">
                        <table id="dataTable-${d.id}" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th width="100">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            `;
        }

        function initializeDataTable(id) {
            $('#dataTable-'+id).DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.sub-categories.list') }}",
                    "type": "GET",
                    "data":{_id: id},
                },
                "columns": [
                    {data: "title", name: "title" },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

    </script>
@endsection
