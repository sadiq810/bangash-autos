@extends('admin._partials._master')
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/js/MonthPicker.min.css') }}">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Staff Performance</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Staff Performance</li>
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
                    <label class="control-label text-right">Filter by month/year:</label>
                    <input id="monthYearPicker" class='Default' type="text" />

                    <div class="table-responsive m-t-40">
                        <table id="dataTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Total Orders</th>
                                <th>Total Amount</th>
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
        var date = null;

        $(document).ready(function(e) {
            var table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('datatables.staff.performance.list') }}",
                    "type": "GET",
                    "data": function(data) {
                        data.date = date;
                        return data;
                    }
                },
                "columns": [
                    {data: "name", name: "name" },
                    {data: "email", name: "email" },
                    {data: "role.title", name: "role.title" },
                    {data: 'orders', name: 'orders', orderable: false, searchable: false},
                    {data: 'ordersAmount', name: 'ordersAmount', orderable: false, searchable: false}
                ]
            });//..... end of dataTables.

            $('#monthYearPicker').MonthPicker({ Button: false, MonthFormat: 'mm-yy', OnAfterChooseMonth: function(sdate) {
                    date = $(this).MonthPicker('GetSelectedMonthYear').replace('/', '-');
                    table.ajax.reload();
            } });
        });//.... end of ready function ....//
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/js/MonthPicker.min.js') }}"></script>
@endsection
