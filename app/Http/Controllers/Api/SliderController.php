<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * @return array
     * Load Slider image.
     */
    public function loadSlider()
    {
        $slider = Slider::whereStatus(1)->get();

        return ['status' => true, 'data' => $slider];
    }
}
