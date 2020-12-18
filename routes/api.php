<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\{VoucherController, AdsController};
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PagesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::get('products/{category_id}', 'ProductController@getCategoryProducts');
    Route::post('products-paginate', 'ProductController@getCategoryProductsPaginate');
    Route::post('discounted-products-paginate', 'ProductController@getDiscountedProductsPaginate');
    Route::post('new-arrivals-paginate', 'ProductController@newArrivalsPaginate');
    Route::post('filtered-products-paginate', 'ProductController@filteredProductsPaginate');
    Route::post('get-product-by-slug', 'ProductController@getProductBySlug');
    Route::post('categories-products', 'ProductController@getCategoriesProducts');
    Route::get('cities', 'CityController@listCities');
    Route::post('user', 'CustomerController@register');
    Route::post('change-password', 'CustomerController@changePassword');
    Route::post('update-customer-profile', 'CustomerController@updateProfile');
    Route::post('user/login', 'CustomerController@login');
    Route::post('user/forgot-password', 'CustomerController@sendNewPassword');
    Route::post('place-order-adjust-user', 'OrderController@saveOrder');
    Route::post('user/orders', 'OrderController@loadUserOrders');
    Route::get('slider', 'SliderController@loadSlider');
    Route::get('car-brands-models', 'CarsController');
    Route::get('search', 'ProductController@searchProduct');
    Route::post('save-contact-us', [ContactUsController::class, 'saveContactUsFeedback']);
    Route::post('get-page-detail', [PagesController::class, 'getPageDetailBySlug']);
    Route::post('validate-voucher', [VoucherController::class, 'validateVoucher']);
    Route::post('load-promotions', [VoucherController::class, 'loadPromotions']);
    Route::get('load-ads', [AdsController::class, 'loadAds']);
});
