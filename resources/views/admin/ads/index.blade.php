@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Ads Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Ads Management</li>
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
                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Ads Url</th>
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
                    <h4 class="modal-title" id="exampleModalLabel1">Add New Ads</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('ads.store') }}" method="post" id="addEditForm" class="floating-labels" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group m-b-40">
                            <input type="text" name="title" class="form-control input-sm" id="input9" required="required">
                            <span class="bar"></span>
                            <label for="input9">Title</label>
                        </div>
                        <div class="form-group m-b-40">
                            <input type="url" name="url" class="form-control input-sm" id="input9" required="required">
                            <span class="bar"></span>
                            <label for="input9">Url</label>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" name="image" accept="image/png, image/jpeg"/>
                            <p>Select image of width 270 and height could be variable</p>
                        </div>
                        <div class="form-group m-b-40">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="status" checked="checked">
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


@endsection
@section('footer')
    <script>
        var addEditModal = null;
        var addEditForm = null;
        var errorDiv = null;

        $(document).ready(function(e) {
            addEditModal = $('#addEditModal');
            addEditForm = $("#addEditForm");
            errorDiv = $("#errorDiv");

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.ads.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {data: "title", name: "title" },
                    {data: "image", name: "image", searchable: false, orderable: false, render: function (data) {
                            return `<img src="${BaseUrl}/ads/${data}" width="100" height="100"/>`;
                        } },
                    {data: "url", name: "url" },
                    {data: "status", name: "status", render: function(data, type, row) {
                            return `<div class="switch">
                                    <label>
                                       <input type="checkbox" ${data == 1 ? 'checked' : ''} class="changeStatus" data-id="${row.id}">
                                       <span class="lever switch-col-deep-purple "></span>
                                    </label>
                                </div>`;
                        } },
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

            $("body").on("click","#addNew",function(e){
                addEditForm.trigger('reset');
                addEditForm.find('.form-group').removeClass('focused');
                errorDiv.html('').hide();
                addEditModal.modal('show');
            });

            $("body").on("click",".editRecord",function(e) {
                e.preventDefault();
                addEditForm.trigger('reset');
                pwdField.removeAttr('required');
                errorDiv.html('').hide();

                var data = JSON.parse($(this).attr("data-json"));
                var id = $(this).attr('data-id');

                idHdnField.val(id);
                Object.keys(data).forEach(function(key) {
                    if (key == 'role_id')
                        $("select[name="+key+"]").val(data[key]).parent().addClass('focused');
                    else
                        $("input[name="+key+"]").val(data[key]).parent().addClass('focused');
                });

                addEditModal.modal('show');
            });

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('ads.destroy', 'xxxx') }}';

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

            $("body").on("click", ".changeStatus",function(e) {
                var id = $(this).attr('data-id');
                var status = 0;

                if ($(this).is(':checked'))
                    status = 1;

                $.ajax({
                    url: '{{ route('change.ads.status') }}',
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
        });//.... end of ready function ....//
    </script>
@endsection
