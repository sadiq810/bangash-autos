@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Cities Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Cities Management</li>
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
                                <th>#</th>
                                <th>City Title</th>
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
                    <h4 class="modal-title" id="exampleModalLabel1">Add/Edit City</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('cities.store') }}" method="post" id="addEditForm" class="floating-labels">
                    <div class="modal-body">
                        <div class="form-group m-b-40">
                            <input type="text" name="title" class="form-control input-sm" id="input9" required="required">
                            <span class="bar"></span>
                            <label for="input9">Title</label>
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

        $(document).ready(function(e) {
            addEditModal = $('#addEditModal');
            addEditForm = $("#addEditForm");
            idHdnField = $("#idHdnField");
            errorDiv = $("#errorDiv");

            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.cities.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {data: "id", name: "id"},
                    {data: "title", name: "title"},
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
                addEditModal.modal('show');
            });

            $("body").on("click",".editRecord",function(e) {
                e.preventDefault();
                addEditForm.trigger('reset');
                errorDiv.html('').hide();

                var data = JSON.parse($(this).attr("data-json"));
                var id = $(this).attr('data-id');

                idHdnField.val(id);
                Object.keys(data).forEach(function(key) {
                    $("input[name="+key+"]").val(data[key]).parent().addClass('focused');
                });

                addEditModal.modal('show');
            });

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('cities.destroy', 'xxxx') }}';

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
            });

    </script>
@endsection
