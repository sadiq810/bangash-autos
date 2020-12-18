<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load profile.
     */
    public function index()
    {
        return view('admin.profile.index', [
            'thisMonthOrderCompleted' => Order::where('status', 2)->where('completed_by', auth()->user()->id)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->count(),
            'lastMonthOrderCompleted' => Order::where('status', 2)->where('completed_by', auth()->user()->id)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', today()->subMonth(1)->format('m'))->count(),
        ]);
    }//.... end of index() .....//

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * Change password.
     */
    public function changePassword(Request $request)
    {
        if (!Hash::check($request->oldPassword, auth()->user()->password))
            return redirect()->back()->withErrors(['oldPasswordError' => 'Your old password do not matched, please type the correct one.']);

        auth()->user()->update(['password' => bcrypt($request->newPassword)]);

        return redirect()->back()->with(['success' => 'Your password changed successfully.']);
    }//...... end of changePassword
}
