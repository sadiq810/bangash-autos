@extends('admin._partials._master')
@section('content')
    <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Reports</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Reports</li>
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
                    <h4 class="card-title">Apply Filters</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Date Range *</label>
                                <input type='text' id="dateRange" class="form-control daterange" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select customer</label>
                                <select class="custom-select col-12" id="customer">
                                    <option selected="" value="">Choose...</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ ($customer->fname) ? $customer->fname.' '.$customer->lname : $customer->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="checkbox" name="detail" id="md_checkbox_1" class="chk-col-red">
                            <label for="md_checkbox_1">Detail Report</label>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10" id="printBtn">Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var startDate = null,
            endDate = null;

        $(document).ready(function(e) {
            $('.daterange').daterangepicker();

            $('.daterange').on('apply.daterangepicker', function(ev, picker) {
                startDate = picker.startDate.format('YYYY-MM-DD');
                endDate = picker.endDate.format('YYYY-MM-DD');
            });

            $('body').on('click', '#printBtn', function() {
                var customer = $('#customer').val();
                var detail = $('#md_checkbox_1').is(':checked') ? 1 : 0;
                window.open('{{ route('print.report') }}' +`?startDate=${startDate}&endDate=${endDate}&customerId=${customer}&detail=${detail}`, '_blank');
            });
        });//.... end of ready function ....//
    </script>

    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
@endsection
