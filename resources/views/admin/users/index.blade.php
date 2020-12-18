@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Users Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Users Management</li>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
                    <h4 class="modal-title" id="exampleModalLabel1">Add/Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('users.store') }}" method="post" id="addEditForm" class="floating-labels">
                    <div class="modal-body">
                        <div class="form-group m-b-40">
                            <input type="text" name="name" class="form-control input-sm" id="input9" required="required">
                            <span class="bar"></span>
                            <label for="input9">Name</label>
                        </div>
                        <div class="form-group m-b-40">
                            <input type="email" name="email" class="form-control input-sm" id="input1" required="required">
                            <span class="bar"></span>
                            <label for="input1">Email</label>
                        </div>
                        <div class="form-group m-b-40">
                            <input type="password" name="password" minlength="6" class="form-control input-sm pwdField" id="input2" required="required">
                            <span class="bar"></span>
                            <label for="input2">Password</label>
                        </div>
                        <div class="form-group m-b-40">
                            <select name="role_id" class="form-control p-0 input-sm" id="input6" required="required">
                                <option value=""></option>
                                @foreach($roles as $key => $title)
                                    <option value="{{ $key }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <span class="bar"></span>
                            <label for="input6">Select Role</label>
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
        var errorDiv = null;
        var pwdField = null;

        $(document).ready(function(e) {
            addEditModal = $('#addEditModal');
            addEditForm = $("#addEditForm");
            idHdnField = $("#idHdnField");
            errorDiv = $("#errorDiv");
            pwdField = $(".pwdField");

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.users.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {data: "name", name: "name" },
                    {data: "email", name: "email" },
                    {data: "role.title", name: "role.title" },
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
                idHdnField.val('');
                errorDiv.html('').hide();
                pwdField.attr('required', 'required');
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
                var url = '{{ route('users.destroy', 'xxxx') }}';

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
        });//.... end of ready function ....//


    </script>
@endsection
