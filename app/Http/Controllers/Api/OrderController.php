<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Voucher;
use App\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * Place order.
     * handle order placing from frontend.
     */
    public function saveOrder(Request $request)
    {
        $user = $this->updateOrCreateUser($request->user);

        if ($user && $user instanceof Customer) {
            $voucher = ($request->has('voucher') and $request->voucher and is_array($request->voucher)) ? $this->validateVoucher($request->voucher) : null;

            $orderData = collect($request->orderData);
            $products = $this->getProductsByIDs($orderData->pluck('id')->toArray());
            $shippingCostMethod = Setting::where(['type' => 'shipCostMethod'])->value('value');
            $perKgCharges = Setting::where(['type' => 'perKgCharges'])->value('value');

            $total = 0;
            $discount = 0;
            $sub_total = 0;
            $orderDetails = [];
            $shippingCost = 0;

            $products->each(function($prd) use($orderData, &$total, &$discount, &$sub_total, $user, $request, &$orderDetails, &$shippingCost, $shippingCostMethod, $perKgCharges) {
                $others = $orderData->where('id', '=',$prd->id)->first();
                $prd->orderQuantity = $others['orderQuantity'] ?? 1;
                $prd->selectedColor = $others['selectedColor'] ?? [];

                $total += $prd->orderQuantity * ($prd->sale_price + ($prd->selectedColor['price'] ?? 0));
                $discount += $prd->orderQuantity * $prd->discount;
                $sub_total += $prd->orderQuantity * ($prd->final_price + ($prd->selectedColor['price'] ?? 0));

                if ($shippingCostMethod == 2) {
                    $weightInGrams = $prd->weight * 1000;
                    if ($perKgCharges)
                        $shippingCost += ceil(($weightInGrams/1000)) * $perKgCharges;
                    else {
                        if ($weightInGrams <= 500)
                            $shippingCost += 190;
                        elseif($weightInGrams <= 1000)
                            $shippingCost += 220;
                        else {
                            $shippingCost += 220;
                            $remainingWeightInGrams = $weightInGrams - 1000;
                            $remainingWeightInKg = $remainingWeightInGrams/1000;
                            $shippingCost += ($remainingWeightInKg * 150);
                        }//.... end if-else() .....//
                    }
                } else
                    $shippingCost += $prd->orderQuantity * ($prd->dimension['length'] * $prd->dimension['width'] * $prd->dimension['height'] /5000);

                $orderDetails[] = new OrderDetail([
                    'product_id' => $prd->id,
                    'quantity' => $prd->orderQuantity,
                    'unit_price' => $prd->sale_price + ($prd->selectedColor['price'] ?? 0),
                    'purchase_price' => $prd->purchase_price,
                    'discount' => $prd->discount,
                    'return_quantity' => 0,
                    'sub_total' => $prd->orderQuantity * ($prd->final_price  + ($prd->selectedColor['price'] ?? 0)),
                    'options' => json_encode($prd->selectedColor)
                ]);
            });

            $promotionalDiscount = $this->checkForPromotionalDiscount($total);
            $promotionalFreeDelivery = $this->checkForPromotionalFreeDelivery($total);

            if ($voucher) { //.... apply and redeem voucher.
                $sub_total -= $voucher->amount;
                $voucher->update(['status' => 2]);
            }//..... end if() .....//

            if ($promotionalDiscount) {
                $sub_total -= $promotionalDiscount;
            }//..... end if() .....//

            $order = Order::create([
                'customer_id' => $user->id,
                'total' => $total,
                'discount' => $discount,
                'voucher_discount' => $voucher->amount ?? 0,
                'promo_discount' => $promotionalDiscount ?? 0,
                'voucher_id' => $voucher->id ?? null,
                'sub_total' => $sub_total,
                'description' => $request->user['notes'] ?? '',
                'status' => 0,
                'type' => 0,
                'payload' => json_encode($products->toArray()),
                'country' => $request->user['country'] ?? '',
                'shipping_cost' => $promotionalFreeDelivery ? 0 : $shippingCost
            ]);

            $order->detail()->saveMany($orderDetails);
            $this->issueVoucherIfApplicable($user->id, $sub_total, $order->id);
            $this->sendNotification($order);

            return ['status' => true, 'data' => $user];
        }//.... end if() .....//

        return ['status' => false, 'message' => $user];
    }//..... end of saveOrder() .....//

    /**
     * @param array $ids
     * @return \Illuminate\Support\Collection
     * Get products by ids.
     */
    private function getProductsByIDs($ids = [])
    {
        $products = Product::active()->published()->whereIn('id', $ids)->get();

        return (new ProductController())->validateDiscount($products);
    }

    /**
     * @param $userData
     * @return string
     * UpdateOrCreateUser.
     */
    private function updateOrCreateUser($userData)
    {
        if (isset($userData['id']) and $userData['id']) {
            $user = Customer::find($userData['id']);
            if ($user) {
                $user->fname = $userData['fname'];
                $user->lname = $userData['lname'];
                $user->phone = $userData['phone'];
                $user->city_id = $userData['city_id'];
                $user->address = $userData['address'];
                $user->country = $userData['country'];
                $user->save();
                $user->access_token = Crypt::encryptString($user->email);
                return $user;
            }
        } else {
            $validator = Validator::make($userData, [
                'email' => 'required|unique:customers,email',
                'password' => 'required|min:5'
            ]);

            if ($validator->fails())
                return implode(', ', $validator->getMessageBag()->all());

            $user = Customer::create([
                'fname' => $userData['fname'],
                'lname' => $userData['lname'],
                'email' => $userData['email'],
                'password' => bcrypt($userData['password']),
                'phone' => $userData['phone'],
                'city_id' => $userData['city_id'],
                'address' => $userData['address'],
                'country' => $userData['country']
            ]);

            $user->access_token = Crypt::encryptString($user->email);

            return $user;
        }//..... end of if-else() .....//
    }//..... end of updateOrCreateUser() .....//

    /**
     * @return array
     * Get user orders.
     */
    public function loadUserOrders()
    {
        try {
            $limit = 20;

            $email = Crypt::decryptString(request()->hash);
            $user = Customer::whereEmail($email)->first();
            if ($user) {
                $orders = Order::with('detail.product')
                    ->where('customer_id', $user->id);

                $total = $orders->count();

                    $orders = $orders->orderBy('id', 'desc')
                    ->skip(request()->skip)
                    ->limit($limit)
                    ->get()->each(function($order) {
                        $order->date = $order->created_at->toFormattedDateString();
                    });

                return ['status' => true, 'data' => ['orders' => $orders, 'total' => $total, 'loaded' => request()->skip + $orders->count()]];
            }

            return ['status' => false, 'message' => 'User details not found!.'];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => 'Internal server error occurred, please try later.'];
        }
    }//..... end of loadUserOrders() .....//

    /**
     * @param Order $order
     * send and save notification.
     */
    private function sendNotification(Order $order)
    {
        Notification::create([
            'user_id'=> $order->customer_id,
            'title'  => 'New Order',
            'detail' => 'New Order Received',
            'link'   => route('invoice.details', $order->id)
        ]);
    }//..... end of sendNotification() .....//

    /**
     * @param $voucher
     * Validate voucher.
     * @return null
     */
    private function validateVoucher($voucher)
    {
        if (isset($voucher['id'])) {
            return Voucher::where('status', 1)->where('id', $voucher['id'])->first();
        }//..... end if() ....//

        return null;
    }//..... end of validateVoucher() .....//

    /**
     * @param $totalOrderAmount
     * Check if there is any promotion active.
     * @return int
     */
    private function checkForPromotionalDiscount($totalOrderAmount)
    {
        $date = today()->format('Y-m-d');

        $discount = Promotion::whereStatus(1)->where('outcome', 'discount')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->where('trigger_amount', '<=', $totalOrderAmount)->first();

        return $discount ? $discount->amount : 0;
    }//..... end of checkForPromotionalDiscount() .....//

    /**
     * @param $totalOrderAmount
     * Check for free delivery.
     * if there is promotional active.
     * @return bool
     */
    private function checkForPromotionalFreeDelivery($totalOrderAmount)
    {
        $date = today()->format('Y-m-d');

        $freeDelivery = Promotion::whereStatus(1)->where('outcome', 'free_delivery')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->where('trigger_amount', '<=', $totalOrderAmount)
            ->first();

        return $freeDelivery ? true: false;
    }//..... end of checkForPromotionalFreeDelivery() ......//

    /**
     * @param $user_id
     * @param $totalOrderAmount
     * @param $orderId
     * Issue voucher if there is promotion active.
     */
    private function issueVoucherIfApplicable($user_id, $totalOrderAmount, $orderId)
    {
        $date = today()->format('Y-m-d');

        $voucher = Promotion::whereStatus(1)->where('outcome', 'voucher')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->where('trigger_amount', '<=', $totalOrderAmount)
            ->first();

        if ($voucher) {
            $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $voucherCode = substr(str_shuffle($str), 0, 8);
            Voucher::create(['user_id' => $user_id, 'voucher_code' => $voucherCode, 'amount' => $voucher->amount, 'order_id' => $orderId, 'status' => 0]);
        }//..... end if() .....//

        return;
    }//..... end of issueVoucherIfApplicable() .....//
}
