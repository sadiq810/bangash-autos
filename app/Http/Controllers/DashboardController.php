<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return array
     * Get Weekly Chart for completed and total order(s).
     */
    public function getWeeklyChart()
    {
        $startOfTheWeek = today()->startOfWeek();
        $endOfTheWeek = today()->endOfWeek();
        $totalOrders = [];
        $completedOrders = [];

        while ($startOfTheWeek->lessThan($endOfTheWeek)) {
            $totalOrders[] = Order::whereDate('created_at', $startOfTheWeek)->count();
            $completedOrders[] = Order::whereDate('updated_at', $startOfTheWeek)->where('status', 2)->count();
            $startOfTheWeek->addDay(1);
        }//..... end of while.

        return [
            $completedOrders,
            $totalOrders
        ];
    }//..... end of getWeeklyChart() .....//

    /**
     * @return array
     * Today orders chart.
     */
    public function getTodayOrdersChart()
    {
        return [
            'total'     => Order::whereDate('created_at', today())->count(),
            'completed' => Order::whereDate('updated_at', today())->where('status', 2)->count(),
            'returned'  => Order::whereDate('updated_at', today())->where('status', 3)->count()
        ];
    }//..... end of getTodayOrdersChart() .....//

    /**
     * @return array
     * Get Monthly Statistics.
     */
    public function getMonthlyStatistics()
    {
        return [
            'total'     => Order::whereMonth('created_at', today()->format('m'))->count(),
            'completed' => Order::whereMonth('updated_at', today()->format('m'))->where('status', 2)->count(),
            'returned'  => Order::whereMonth('updated_at', today()->format('m'))->where('status', 3)->count()
        ];
    }//..... end of getMonthlyStatistics() .....//
}
