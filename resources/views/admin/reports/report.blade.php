<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Report</title>
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('assets/frontend') }}/jquery/jquery-2.1.1.min.js"></script>
</head>

<body class="fix-header card-no-border logo-center">
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body printableArea">
                        <h3><b>Report</b> : <span class="pull-right">{{ $startDate }}  <span style="color: red;">&nbsp;To&nbsp;</span>  {{ $endDate }}</span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">OrderID</th>
                                            <th class="text-right">Purchase Price</th>
                                            <th class="text-right">Total Discount</th>
                                            <th class="text-right">Shipping Cost</th>
                                            <th class="text-right">Net Purchase</th>
                                            <th class="text-right">Sale Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalPurchase = 0;
                                                $totalSale = 0;
                                            @endphp
                                            @foreach($data as $order)
                                                @php
                                                    $discount = $order->discount + $order->promo_discount + $order->voucher_disount;
                                                    $purchasePrice = $order->detail->reduce(function($total, $item) {
                                                        return $total + ($item->purchase_price * $item->quantity);
                                                    });//sum('sub_total');
                                                    $totalPurchase += $purchasePrice + $discount + $order->shipping_cost;
                                                    $totalSale += $order->sub_total;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $order->id }}</td>
                                                    <td class="text-right">{{ $purchasePrice }}</td>
                                                    <td class="text-right">{{ $discount }}</td>
                                                    <td class="text-right">{{ $order->shipping_cost }}</td>
                                                    <td class="text-right">{{ $purchasePrice + $discount + $order->shipping_cost }}</td>
                                                    <td class="text-right"> {{ $order->sub_total }} </td>
                                                </tr>
                                                @if($isDetail)
                                                    <tr>
                                                        <table class="table table-striped table-dark" style="width: 95%; float: right; border: 1px solid gray;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Product</th>
                                                                    <th class="text-right">Quantity</th>
                                                                    <th class="text-right">Purchase Price</th>
                                                                    <th class="text-right">Sale Price</th>
                                                                    <th class="text-right">Discount</th>
                                                                    <th class="text-right">Return Quantity</th>
                                                                    <th class="text-right">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->detail as $detail)
                                                                    <tr>
                                                                        <td class="text-center">{{ optional($detail->product)->title }}</td>
                                                                        <td class="text-center">{{ $detail->quantity }}</td>
                                                                        <td class="text-right">{{ $detail->purchase_price }}</td>
                                                                        <td class="text-right">{{ $detail->unit_price }}</td>
                                                                        <td class="text-right"> {{ $detail->discount }} </td>
                                                                        <td class="text-right">{{ $detail->return_quantity }}</td>
                                                                        <td class="text-right">{{ $detail->sub_total }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pull-right m-t-30 text-right">
                                    <p>Total Purchase: Rs {{ $totalPurchase }}</p>
                                    <p>Total Sale : Rs {{ $totalSale }} </p>
                                    <hr>
                                    <h3><b>Net Income :</b> Rs {{ $totalSale - $totalPurchase }}</h3>
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
        </div>
        <footer class="footer">
            © {{ date('Y') }} BangashAutos.pk
        </footer>
    </div>
</div>
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
