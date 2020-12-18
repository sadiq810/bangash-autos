<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\DataTables\Facades\DataTables;

class StaffPerformanceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.staff.index');
    }


    /**
     * @return mixed
     * @throws \Exception
     * Load users list.
     */
    public function usersList()
    {
        $date = request()->date ? explode('-', request()->date) : null;

        return DataTables::of(User::with('role'))
            ->addColumn('orders', function($user) use($date) {
                if ($date and isset($date[0], $date[1]))
                    return $user->ordersPerformance()->whereMonth('created_at', $date[0])->whereYear('created_at', $date[1])->count();

            return $user->ordersPerformance()->count();
        })->addColumn('ordersAmount', function($user) use($date) {
                if ($date and isset($date[0], $date[1]))
                    return $user->ordersPerformance()->whereMonth('created_at', $date[0])->whereYear('created_at', $date[1])->sum('order_amount');
            return $user->ordersPerformance()->sum('order_amount');
        })->make(true);
    }//..... end of usersList() .....//
}
