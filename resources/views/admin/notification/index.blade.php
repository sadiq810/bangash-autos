@extends('admin._partials._master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Notifications</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Notifications List</li>
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
                                    <th>Title</th>
                                    <th>Detail</th>
                                    <th>Date</th>
                                    <th width="100">Link</th>
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
                    "url": "{{ route('datatables.notifications.list') }}",
                    "type": "GET"
                },
                "columns": [
                    {data: "title", name: "title" },
                    {data: "detail", name: "detail" },
                    {data: "created_at", name: "created_at" },
                    {data: 'link', name: 'link', orderable: false, searchable: false, render: function (data) {
                            return `<a href="${data}" class="btn btn-primary" target="_blank">View Invoice</a>`
                        }}
                ]
            });//..... end of dataTables.
        });//.... end of ready function ....//
    </script>
@endsection
