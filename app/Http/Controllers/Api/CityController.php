<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @return array
     * Load cities list.
     */
    public function listCities()
    {
        $cities = City::select('id', 'title')->get();
        return ['status' => true, 'data' => $cities];
    }
}
