<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load report view.
     */
    public function index()
    {
        return view('admin.reports.index', [
            'customers' => Customer::select('id','fname', 'lname', 'email')->get()
        ]);
    }//..... end of index() .....//

    /**
     * Generate and Download report.
     */
    public function downloadReport(Request $request)
    {
        $customerId = $request->customerId;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $detail = $request->detail;

        if ($startDate == null || $endDate == null)
            $startDate = $endDate = today()->format('Y-m-d');

        $orders = Order::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);

        if ($customerId)
            $orders->where('customer_id', $customerId);

        if ($detail == 0)
            $orders->with('detail');
        else
            $orders->with('detail.product');

        return view('admin.reports.report', ['data' => $orders->get(), 'isDetail' => $detail == 1, 'startDate' => $startDate, 'endDate' => $endDate]);
    }//..... end of downloadReport() ......//
}
