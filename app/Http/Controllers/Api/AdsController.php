<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function loadAds()
    {
        $ads = Ads::select('image', 'url')->where('status', 1)->whereNotNull('image')->get()
        ->each(function($ad) {
            if ($ad->image)
                $ad->image = asset('ads/'.$ad->image);
        });

        return ['status' => $ads->isNotEmpty(), 'data' => $ads];
    }
}
