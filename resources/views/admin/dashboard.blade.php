@extends('admin._partials._master')
@section('content')
    @inject('dashboardController', 'App\Http\Controllers\DashboardController')
    @php
      $weeklyChart = $dashboardController->getWeeklyChart();
      $todayChart = $dashboardController->getTodayOrdersChart();
      $monthlyData = $dashboardController->getMonthlyStatistics();
    @endphp
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-8 col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap">
                                        <div>
                                            <h3 class="card-title">Orders Overview</h3>
                                            <h6 class="card-subtitle">Weekly Orders Review</h6> </div>
                                        <div class="ml-auto">
                                            <ul class="list-inline">
                                                <li>
                                                    <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Total Orders</h6> </li>
                                                <li>
                                                    <h6 class="text-muted  text-info"><i class="fa fa-circle font-10 m-r-10"></i>Completed Orders</h6> </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="amp-pxl" style="height: 360px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Today Orders</h3>
                            <h6 class="card-subtitle">Today Orders Statistics</h6>
                            <div id="visitor" style="height:290px; width:100%;"></div>
                        </div>
                        <div>
                            <hr class="m-t-0 m-b-0">
                        </div>
                        <div class="card-body text-center ">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <h6 class="text-muted" style="color: rgb(116, 90, 242) !important;"><i class="fa fa-circle font-10 m-r-10 "></i>Completed</h6> </li>
                                <li>
                                    <h6 class="text-muted  text-primary"><i class="fa fa-circle font-10 m-r-10"></i>Total</h6> </li>
                                <li>
                                    <h6 class="text-muted  text-success"><i class="fa fa-circle font-10 m-r-10"></i>Retured</h6> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                    <div class="card card-inverse card-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h1 class="text-white"><i class="ti-pie-chart"></i></h1></div>
                                <div>
                                    <h3 class="card-title">Total Orders</h3>
                                    <h6 class="card-subtitle">{{ today()->format('M') }}  {{ today()->format('Y') }}</h6> </div>
                            </div>
                            <div class="row">
                                <div class="col-4 align-self-center">
                                    <h2 class="font-light text-white">{{ $monthlyData['total'] }}</h2>
                                </div>
                                <div class="col-8 p-t-10 p-b-20 align-self-center">
                                    <div class="usage chartist-chart" style="height:65px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                    <div class="card card-inverse card-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h1 class="text-white"><i class="icon-cloud-download"></i></h1></div>
                                <div>
                                    <h3 class="card-title">Completed Orders</h3>
                                    <h6 class="card-subtitle">{{ today()->format('M') }}  {{ today()->format('Y') }}</h6> </div>
                            </div>
                            <div class="row">
                                <div class="col-4 align-self-center">
                                    <h2 class="font-light text-white">{{ $monthlyData['completed'] }}</h2>
                                </div>
                                <div class="col-8 p-t-10 p-b-20 text-right">
                                    <div class="spark-count" style="height:65px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                    <div class="card card-inverse" style="background-color: #fc4b6c;">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="m-r-20 align-self-center">
                                    <h1 class="text-white"><i class="icon-action-undo"></i></h1></div>
                                <div>
                                    <h3 class="card-title">Returned Orders</h3>
                                    <h6 class="card-subtitle">{{ today()->format('M') }}  {{ today()->format('Y') }}</h6> </div>
                            </div>
                            <div class="row">
                                <div class="col-4 align-self-center">
                                    <h2 class="font-light text-white">{{ $monthlyData['returned'] }}</h2>
                                </div>
                                <div class="col-8 p-t-10 p-b-20 text-right">
                                    <div class="spark-count" style="height:65px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- Row -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
@endsection
@section('footer')
    <script src="{{ asset('assets/plugins/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 JavaScript -->
    <script src="{{ asset('assets/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/c3-master/c3.min.js') }}"></script>
    <!-- Chart JS -->

    <script>
        var chartData = [];
        var todayData = [];

        todayData.push(['total', {{$todayChart['total']}}]);
        todayData.push(['completed', {{$todayChart['completed']}}]);
        todayData.push(['returned', {{$todayChart['returned']}}]);

        @foreach($weeklyChart as $chart)
            var s = [];
            @foreach($chart as $s)
                s.push({{$s}});
            @endforeach
            chartData.push(s);
        @endforeach
        $('document').ready(function () {
            new Chartist.Bar('.amp-pxl', {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: chartData
            }, {
                axisX: {
                    // On the x-axis start means top and end means bottom
                    position: 'end',
                    showGrid: false
                },
                axisY: {
                    // On the y-axis start means left and end means right
                    position: 'start'
                },
                high:'12',
                low: '0',
                plugins: [
                    Chartist.plugins.tooltip()
                ]
            });

            c3.generate({
                bindto: '#visitor',
                data: {
                    columns: todayData,

                    type : 'donut',
                    onclick: function (d, i) { console.log("onclick", d, i); },
                    onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                    onmouseout: function (d, i) { console.log("onmouseout", d, i); }
                },
                donut: {
                    label: {
                        show: false
                    },
                    title: "Orders Statistics",
                    width:20,

                },

                legend: {
                    hide: true
                    //or hide: 'data1'
                    //or hide: ['data1', 'data2']
                },
                color: {
                    pattern: ['#eceff1', '#745af2', '#26c6da', '#1e88e5']
                }
            });
        });//..... end of ready() .....//
    </script>
@endsection
