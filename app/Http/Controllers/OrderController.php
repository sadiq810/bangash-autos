<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Setting;
use App\Models\StaffPerformance;
use App\Models\Voucher;
use App\Notifications\VoucherNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.orders.index', $this->getOrdersStatus());
    }

    /**
     * @return array
     * Get orders count on the basis of status.
     */
    private function getOrdersStatus()
    {
        return [
            'pending'       => Order::where('status', 0)->count(),
            'processing'    => Order::where('status', 1)->count(),
            'completed'     => Order::where('status', 2)->count(),
            'returned'      => Order::where('status', 3)->count(),
        ];
    }

    /**
     * @return array
     * Place order from admin side.
     */
    public function placeAdminOrder()
    {
        $product = Product::find(request()->id);
        if ($product) {
            if ($product->quantity < request()->order_quantity)
                return ['status' => false, 'validationError' => 'Order quantity must not be greater then available quantity.',
                    'message' => 'Invalid quantity'];

            $discount = 0;

            if ($product->discount && $product->discount > 0) {
                if ($product->discount_start_date && $product->discount_end_date) {
                        if (Carbon::parse($product->discount_start_date)->lessThanOrEqualTo(today()) and Carbon::parse($product->discount_end_date)->greaterThanOrEqualTo(today()))
                            $discount = $product->discount;
                } else {
                    $discount = $product->discount;
                }//..... end if-else() .....//
            }//.... end if() .....//

            $details = ['product_id' => $product->id, 'quantity' => request()->order_quantity, 'unit_price' => request()->sale_price, 'discount' => $discount];
            $order = Order::create(['customer_id' => 0, 'total' => $product->sale_price * request()->order_quantity, 'discount' => $discount, 'description' => request()->description,
                            'process_by' => auth()->user()->id, 'completed_by' => auth()->user()->id, 'status' => 2, 'type' => 1, 'payload' => json_encode($details)]);

            OrderDetail::create(array_merge(['order_id' => $order->id], $details));

            $product->update(['quantity' => $product->quantity - request()->order_quantity]);

            return ['status' => true, 'message' => "Order placed successfully."];
        }//..... end if() .....//

        return ['status' => false, 'message' => 'Product not found!.'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function listOrdersForDataTables()
    {
        $orders = Order::query();

        if (request()->statusFilter != '')
            $orders->where('status', request()->statusFilter);
        if (request()->fromDate)
            $orders->whereDate('created_at', '>=', request()->fromDate);
        if (request()->toDate)
            $orders->whereDate('created_at', '<=', request()->toDate);

        return DataTables::of($orders->with('customer'))->addColumn('cname', function($order) {
            return $order->customer ? $order->customer->fname.' '.$order->customer->lname : 'Walking Customer';
        })->addColumn('action', function($order) {
            if (! in_array($order->status, [2,3]))
                return '<a href="javascript: void(0)" data-id="'.$order->id.'" class="remove returnOrder" title="Cancel and Return Order"><i class="fas fa-truck-loading"></i></i></a>
                        &nbsp;|&nbsp;<a href="javascript: void(0)" data-id="'.$order->id.'" class="remove changeStatus" title="Change Order Status"><i class="fa fa-cogs"></i></i></a>
                        &nbsp;|&nbsp;<a href="javascript: void(0)" data-id="'.$order->id.'" class="remove manageReceive" title="Manage Receiving"><i class="fa fa-money-bill-alt"></i></i></a>
                        &nbsp;|&nbsp;<a href="javascript: void(0)" data-id="'.$order->id.'" class="remove manageCourier" title="Manage Courier"><i class="fa fa-truck-moving"></i></i></a>
                        &nbsp;|&nbsp;<a href="'.route('invoice.details', $order->id).'" class="remove" title="View Invoice" target="_blank"><i class="fa fa-list-ol"></i></i></a>';
            else
                return '<a href="'.route('invoice.details', $order->id).'" class="remove" title="View Invoice" target="_blank"><i class="fa fa-list-ol"></i></i></a>
                        &nbsp;|&nbsp;<a href="javascript: void(0)" data-id="'.$order->id.'" class="remove manageReceive" title="Manage Receiving"><i class="fa fa-money-bill-alt"></i></i></a>
                        &nbsp;|&nbsp;<a href="javascript: void(0)" data-id="'.$order->id.'" class="remove manageCourier" title="Manage Courier"><i class="fa fa-truck-moving"></i></i></a>';
        })->addColumn('receivedAmount', function($order) {
            $amount = 0;
            array_map(function($v) use(&$amount) {$amount+=$v['amount'];}, $order->payments);
            return $amount;
        })->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function listOrderDetailsForDataTables(Request $request)
    {
        $orderDetails = OrderDetail::where('order_id', $request->_id)->with('product');
        return DataTables::of($orderDetails)->addColumn('action', function($order) use($request) {
            if (! in_array($order->order->status, [2,3]))
                return '<a href="javascript: void(0)" data-id="'.$order->id.'"  data-quantity="'.$order->quantity.'"   data-return_quantity="'.$order->return_quantity.'" data-main="'.$request->_id.'" class="remove returnItemOfOrder" title="Return Item"><i class="fas fa-truck-loading"></i></i></a>';
            else
                return '';
        })->addColumn('weightInKg', function($order) {
            return $order->quantity * $order->product->weight;
        })->addColumn('totalDimension', function($order) {
            return json_encode(["length" => $order->product->dimension['length'] * $order->quantity, "width" => $order->product->dimension['width'] * $order->quantity, "height" => $order->product->dimension['height'] * $order->quantity]);
        })->make(true);
    }

    /**
     * @return array
     * Return the whole order.
     */
    public function returnOrder()
    {
        $order = Order::whereId(request()->id)->with('detail')->first();

        if ($order) {
            $order->status = 3;
            $order->remarks = request()->remarks;
            $order->save();

            foreach ($order->detail as $detail) {
                $detail->product()->increment('quantity', ($detail->quantity - $detail->return_quantity));
                $detail->sub_total = 0.00;
                $detail->return_quantity = $detail->quantity;
                $detail->save();
            }

            $this->sendNotification($order->id, auth()->user()->id, 'Order Return', 'Complete Order Returned by '.auth()->user()->name.', With Remarks: '.request()->remarks);

            return ['status' => true, 'message' => 'Order returned successfully.'];
        }//.... end if() .....//

        return ['status' => false, 'message' => 'Order not found!.'];
    }//..... end of returnOrder() ......//

    /**
     * @return array
     * Return item of an order.
     */
    public function returnOrderItem()
    {
        if (request()->quantity <= 0)
            return ['status' => false, 'message' => 'Invalid Quantity.'];

        $detail = OrderDetail::where(['id' => request()->id, 'order_id' => request()->order_id])->first();

        if ($detail) {
            $detail->increment('return_quantity', request()->quantity);
            $remainingQuantity = $detail->quantity - request()->quantity;
            $subTotal = ($remainingQuantity * $detail->unit_price) - ($remainingQuantity * $detail->discount);
            $difference = $detail->sub_total - $subTotal;
            $detail->sub_total = $subTotal;
            $detail->save();
            $order = Order::whereId(request()->order_id)->first();

            if ($order) {
                $order->total = $order->total - (request()->quantity * $detail->unit_price);
                $order->discount = $order->discount - ((request()->quantity * $detail->discount));//total discount.
                $order->sub_total = $order->sub_total - $difference;
                $order->save();

                $this->sendNotification($order->id, auth()->user()->id, 'Order Item Return', request()->quantity.' Quantity Returned by '.auth()->user()->name);
            }//..... end if() .....//

            $detail->product()->increment('quantity', request()->quantity);
            return ['status' => true, 'message' => 'Item returned successfully.'];
        }

        return ['status' => false, 'message' => 'Order not found!.'];
    }//..... end of returnOrderItem() ......//

    /**
     * @return array
     * Change order status.
     */
    public function changeOrderStatus()
    {
        $data = ['status' => request()->status];

        $message = 'Order Status Changed to Pending by '.auth()->user()->name;

        if (request()->status == 2) {
            $data['completed_by'] = auth()->user()->id;
            $message = 'Order Status Changed to Completed by '.auth()->user()->name;
            $this->checkIfVoucherIsPending(request()->id);
            $this->logUserPerformanceForOrderCompletion(request()->id, auth()->user()->id);
        }//..... end if() .....//

        if (request()->status == 1) {
            $data['process_by'] = auth()->user()->id;
            $message = 'Order Status Changed to InProcess by '.auth()->user()->name;
        }//..... end if() .....//

        $order = tap(Order::find(request()->id))->update($data);
        $this->sendNotification($order->id, auth()->user()->id, 'Order Status Change', $message);
        return ['status' => true, 'message' => 'Status updated successfully.'];
    }//..... end of changeOrderStatus() .....//

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load specific order invoice.
     */
    public function loadInvoiceDetails($id)
    {
        return view('admin.orders.invoice', [
            'order' => Order::where('id', $id)->with(['detail.product', 'customer'])->first(),
            'phone' => Setting::whereType('phone')->first(),
            'email' => Setting::whereType('contactEmail')->first(),
            'address' => Setting::whereType('officeAddress')->first(),
        ]);
    }//..... end of loadInvoiceDetails() .....//

    /**
     * @param $order_id
     * @param $user_id
     * @param string $title
     * @param string $detail
     */
    private function sendNotification($order_id, $user_id, $title = '', $detail = '')
    {
        Notification::create([
            'user_id'=> $user_id,
            'title'  => $title,
            'detail' => $detail,
            'link'   => route('invoice.details', $order_id)
        ]);
    }//..... end of sendNotification() .....//

    /**
     * @param $order_id
     * Check if there is voucher issuing pending for this order.
     */
    private function checkIfVoucherIsPending($order_id)
    {
        $voucher = Voucher::where('order_id', $order_id)->where('status', 0)->first();

        if ($voucher) {
            $voucher->update(['status' => 1]);
            $voucher->customer->notify(new VoucherNotification($voucher->voucher_code, $voucher->amount));
        }//..... end if() .....//

        return;
    }//..... end of checkIfVoucherIsPending() .....//

    /**
     * Save Advance payment for an order.
     */
    public function saveOrderAdvancePayment()
    {
        $order = Order::where('id', request()->id)->first();

        if ($order) {
            $payments = $order->payments;
            $payments[] = request()->only(['comment', 'amount']);
            $order->payments = json_encode($payments);
            $order->save();
            return ['status' => true, 'message' => 'Payment saved successfully.'];
        }//..... end if() ....//

        return ['status' => false, 'message' => 'Order not found.'];
    }//..... end of saveOrderAdvancePayment() .....//

    /**
     * @return array
     * Set Courier information of an order.
     */
    public function saveOrderCourierInfo()
    {
        $order = Order::where('id', request()->id)->first();

        if ($order) {
            $order->courier = json_encode(request()->only(['name', 'orderId']));
            $order->save();
            return ['status' => true, 'message' => 'Courier Information saved successfully.'];
        }//..... end if() ....//

        return ['status' => false, 'message' => 'Order not found.'];
    }//..... end of saveOrderCourierInfo() .....//

    /**
     * @param $order_id
     * @param $user_id
     * Log user performance.
     */
    private function logUserPerformanceForOrderCompletion($order_id, $user_id)
    {
        $order = Order::find(request()->id);
        StaffPerformance::create(['order_id' => $order_id, 'user_id' => $user_id, 'order_amount' => $order->sub_total]);
    }//..... end of logUserPerformanceForOrderCompletion() .....//
}
