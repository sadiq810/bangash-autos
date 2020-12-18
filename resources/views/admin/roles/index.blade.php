@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Roles Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Roles Management</li>
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
                    <h4 class="modal-title" id="exampleModalLabel1">Add/Edit Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('roles.store') }}" method="post" id="addEditForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Title:</label>
                            <input type="text" name="title" id="titleField" class="form-control" required="required" placeholder="Enter title"/>
                        </div>
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

    {{--Roles Menus Modal--}}
    <div class="modal fade" id="rolesMenusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel11">Assign Menus To Rule</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('roles.assign.menus') }}" method="post" id="assignMenusForm">
                    <div class="modal-body">
                        <div class="demo-checkbox">
                            @foreach($menus as $m)
                                <input type="checkbox" name="menus[]" value="{{ $m->id }}" id="md_checkbox_{{ $m->id }}" class="chk-col-teal menusToAssign" />
                                <label for="md_checkbox_{{ $m->id }}">{{ $m->title }}</label>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="id" value="" id="roleIdHdnField"/>
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
        var roleIdHdnField = null;
        var rolesMenusModal = null;

        $(document).ready(function(e) {
            addEditModal = $('#addEditModal');
            addEditForm = $("#addEditForm");
            idHdnField = $("#idHdnField");
            roleIdHdnField = $("#roleIdHdnField");
            rolesMenusModal = $("#rolesMenusModal");

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.roles.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {data: "title", name: "title" },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });//..... end of dataTables.

            $("#addEditForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);

                $(this).ajaxSubmit({
                    success: function(response) {
                        if (response.status) {
                            addEditModal.modal('hide');
                            $this.trigger('reset');
                            toast('success', 'Success', response.message);
                            table.ajax.reload();
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });

            $("#assignMenusForm").on("submit", function(e) {
                e.preventDefault();
                var $this = $(this);

                $(this).ajaxSubmit({
                    success: function(response) {
                        if (response.status) {
                            rolesMenusModal.modal('hide');
                            $this.trigger('reset');
                            toast('success', 'Success', response.message);
                            table.ajax.reload();
                        } else {
                            toast('error', 'Internal Server Error!', response.message);
                        }//..... end of if-else() .....//
                    }, error: function(err) {
                        toast('error', 'Internal Server Error!', 'Error occurred while saving the record.');
                    }
                });
            });

            $("body").on("click","#addNew",function(e){
                addEditForm.trigger('reset');
                idHdnField.val('');
                addEditModal.modal('show');
            });

            $("body").on("click",".assignMenus",function(e) {
                $(".menusToAssign").attr('checked', false);
                roleIdHdnField.val($(this).attr('data-id'));
                var data = JSON.parse($(this).attr("data-json"));
                data.forEach(function (m) {
                    $("#md_checkbox_"+m.id).attr('checked', true);
                });

                $("#rolesMenusModal").modal('show');
            });

            $("body").on("click",".editRecord",function(e) {
                e.preventDefault();
                addEditForm.trigger('reset');
                var data = JSON.parse($(this).attr("data-json"));

                idHdnField.val(data.id);
                $("#titleField").val(data.title);
                addEditModal.modal('show');
            });

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('roles.destroy', 'xxxx') }}';

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
