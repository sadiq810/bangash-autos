@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Promotions Management</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Promotions Management</li>
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
                    <a href="{{ route('add.promotion') }}" class="btn btn-primary btn-circle" style="float: right; right: 30px; margin-right: 29px;" title="Add New">
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                {{--<th>Category</th>--}}
                                <th>Threshold Amount</th>
                                <th>Award Amount(Rs)</th>
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
@endsection
@section('footer')
    <script>
        $(document).ready(function(e) {
            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.promotions.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {data: "title", name: "title" },
                    {data: "outcome", name: "outcome" },
                   /* {data: "category_id", name: "category_id", render: function(d, type, row) {
                        return row.category ? row.category.title : '';
                        } },*/
                    {data: "trigger_amount", name: "trigger_amount" },
                    {data: "amount", name: "amount" },
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

            $("body").on("click",".deleteRecord",function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var url = '{{ route('promotion.destroy', 'xxxx') }}';

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
                    url: '{{ route('change.promotion.status') }}',
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
