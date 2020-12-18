<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * @return array
     * Get Cars Brands with models.
     */
    public function __invoke()
    {
        $cars = Car::where('parent', 0)->with('models')->get();

        return ['status' => true, 'data' => $cars];
    }
}
