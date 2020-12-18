<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Promotion;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * Validate voucher.
     */
    public function validateVoucher(Request $request)
    {
        $voucher = Voucher::where('voucher_code', $request->voucher)->where('status', 1)->first();

        return ['status' => $voucher ? true : false, 'message' => $voucher ? 'Voucher is valid.' : 'Invalid voucher.', 'data' => $voucher];
    }//..... end of validateVoucher() .....//

    /**
     * @return array
     * Load active promotions.
     */
    public function loadPromotions()
    {
        $date = today()->format('Y-m-d');
        $promotions = Promotion::where('status', 1)->where('outcome', '!=', 'voucher')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->get();

        return ['status' => true, 'data' => $promotions];
    }//..... end of loadPromotions() .....//
}
