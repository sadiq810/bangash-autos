@extends('admin._partials._master')
@section('content')
    <style>
        .custom-tooltip-content{
            box-shadow: none;
            background: none;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Contact Us Feedback Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Contact Us Feedback Management</li>
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
                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Attachment</th>
                                <th>Detail</th>
                                <th width="100">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var BaseUrl = '<?php echo e(url('/')); ?>';
        $(document).ready(function(e) {
            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('contactus.list') }}",
                    "type": "GET",
                },
                "columns": [
                    {data: "name", name: "name" },
                    {data: "email", name: "email" },
                    {data: "phone", name: "phone" },
                    {data: "image", name: "image", orderable: false, searchable: false, render: function(d) {
                        console.log(d);
                        if(d) {
                            return `<a href="${BaseUrl}/uploads/${d}" target="_blank"><img src="${BaseUrl}/uploads/${d}" width='100' height='100'/></a>`
                        } else
                            return d;
                        } },
                    {data: "detail", name: "detail", orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });//..... end of dataTables.

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('contactus.destroy', 'xxxx') }}';

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
