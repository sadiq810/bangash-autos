<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <title>Invoice</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('assets/frontend') }}/jquery/jquery-2.1.1.min.js"></script>
</head>

<body class="fix-header card-no-border logo-center">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body printableArea">
                        <h3><b>INVOICE</b> <span class="pull-right">#{{ $order->id }}</span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
                                        <h3> &nbsp;
                                            <b class="text-danger">GulAutos.pk</b>
                                        </h3>
                                        <p class="text-muted m-l-5">
                                            Phone: {{ optional($phone)->value }}<br/>
                                            Email: {{ optional($email)->value }} <br/>
                                        </p>
                                        <p class="text-muted m-l-5">
                                            Address: {{ optional($address)->value }}
                                        </p>
                                        <p class="text-muted m-l-5"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> {{ $order->created_at }}</p>
                                    </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
                                        <h3>To,</h3>
                                        <h4 class="font-bold">{{ $order->customer->fname }} {{ $order->customer->lname }}</h4>
                                        <p class="text-muted m-l-30">
                                            Phone: {{ $order->customer->phone }}<br/>
                                            Email: {{ $order->customer->email }} <br/>
                                            City: {{ optional($order->customer->city)->title }} <br/>
                                            Country: {{ $order->country ?? $order->customer->country }}
                                        </p>
                                        <p class="m-t-30">Address: {{ $order->customer->address }}</p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Description</th>
                                            <th>Selected Color</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Return Quantity</th>
                                            <th class="text-right">Unit Cost</th>
                                            <th class="text-right">Discount</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                          $totalReceived = 0;
                                          array_map(function($v) use(&$totalReceived) {$totalReceived+=$v['amount'];}, $order->payments);
                                        @endphp
                                        @foreach($order->detail as $key => $detail)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td>{{ $detail->product->title }} <br />
                                                    <span style="font-size: 13px; color: #868181;">
                                                        Dimension: {{ http_build_query($detail->product->dimension,'',', ') }} <br/>
                                                        Weight: {{ $detail->product->weight }} KG. <br/>
                                                        SKU: {{ $detail->product->sku }}
                                                    </span>
                                                </td>
                                                <td>{{ $detail->options['title'] ?? '' }}</td>
                                                <td class="text-right"> {{ $detail->quantity }} </td>
                                                <td class="text-right"> {{ $detail->return_quantity }} </td>
                                                <td class="text-right">Rs {{ $detail->unit_price }}</td>
                                                <td class="text-right">Rs {{ $detail->discount }}</td>
                                                <td class="text-right"> Rs {{ $detail->sub_total }} </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class=" col-lg-6" style="float: left">
                                    <h3>Order Notes: </h3>
                                    <p>{{ $order->description }}</p>
                                </div>
                                <div class=" m-t-30 text-right col-lg-6" style="float: right;">
                                    <p>Total amount: Rs {{ $order->total }}</p>
                                    <p>Total discount: Rs {{ $order->discount }}</p>
                                    <p>Promotional discount: Rs {{ $order->promo_discount }}</p>
                                    <p>Voucher discount: Rs {{ $order->voucher_discount }}</p>
                                    <p>Sub - Total amount: Rs {{ $order->sub_total }}</p>
                                    <p>FLAT SHIPPING RATE: Rs {{ $order->shipping_cost }}</p>
                                    <p>Received Amount : Rs {{ $totalReceived }} </p>
                                    <hr>
                                    <h3><b>Total :</b> Rs {{ $order->sub_total + $order->shipping_cost - $totalReceived }}</h3>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="text-right">
                                    <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            © {{ date('Y') }} GulAutos.pk
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<script src="{{ asset('assets/js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
<script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>
</body>
</html>
