<?php

use Intervention\Image\Facades\Image;
use App\Http\Controllers\{ReportController, StaffPerformanceController, PromotionsController, ContactUsController, PagesController,
    NotificationController, ProfileController, OrderController, ProductsController, SettingsController, ColorsController};

Route::get('create-water-mark', function () {
    $canvas = Image::canvas(600, 600);
    $canvas->text('GulAutos.pk', 100, 100, function($font) {
        $font->file(public_path('assets/css/icons/font-awesome/webfonts/fa-solid-900.ttf'));
        $font->size(50);
        $font->color('#000');
        $font->align('center');
        $font->valign('middle');
       // $font->angle(45);
    })->save(public_path('uploads/watermark.png'));
});

Route::group(['prefix' => 'admin'], function () {

    Auth::routes();
    Route::get('export-products', [ProductsController::class, 'export'])->name('export.products.list');
    Route::group(['middleware' => ['auth', 'roleMenu']], function () {

        Route::view('/', 'admin.dashboard')->name('dashboard');

        //.... Roles routes
        Route::resource('roles', 'RolesController');
        Route::get('datatables-roles-list', 'RolesController@rolesList')->name('datatables.roles.list');
        Route::post('roles-assign-menus', 'RolesController@assignMenus')->name('roles.assign.menus');

        //.... Users routes
        Route::resource('users', 'UsersController');
        Route::get('datatables-users-list', 'UsersController@usersList')->name('datatables.users.list');

        //..... Categories routes
        Route::resource('categories', 'CategoriesController');
        Route::get('sort-categories', 'CategoriesController@loadCategorySortingView')->name('sort.categories');
        Route::get('datatables-categories-list', 'CategoriesController@listCategories')->name('datatables.categories.list');
        Route::get('datatables-sub-categories-list', 'CategoriesController@listSubCategories')->name('datatables.sub-categories.list');
        Route::post('categories-sort-save', 'CategoriesController@saveSorting')->name('categories.sort.save');
        Route::get('category-sub-categories', 'CategoriesController@loadCategorySubCategories')->name('category.sub.categories');
        Route::post('category-products-list', 'CategoriesController@loadCategoryProducts')->name('category.products.list');
        Route::post('save-category-products', 'CategoriesController@saveCategoryProducts')->name('save.category.products');

        //.... Products route.
        Route::resource('products', 'ProductsController');
        Route::get('datatables-products-list', 'ProductsController@listProducts')->name('datatables.products.list');
        Route::get('datatables-products-list-images', 'ProductsController@listProductsForImages')->name('datatables.products.list.images');
        Route::get('category-sub-category', 'ProductsController@getSubCategoryList')->name("category.sub.category");
        Route::get('car-models-list-dropdown', 'ProductsController@getCarModelList')->name("car.models.list.dropdown");
        Route::get('load-products-media', 'ProductsController@loadProductsMedia')->name("load.products.media");
        Route::get('change-product-status', 'ProductsController@changeStatus')->name("change.product.status");
        Route::post('update-product-field', 'ProductsController@updateProductField')->name("update.product.field");
        Route::get('manage-products-images', 'ProductsController@manageImages')->name("manage.products.images");
        Route::post('delete-product-image', 'ProductsController@deleteProductImage')->name("delete.product.image");
        Route::post('change-product-image', 'ProductsController@changeProductImage')->name("change.product.image");
        Route::post('save-product-images-order', 'ProductsController@saveProductImagesOrder')->name("save.product.images.order");

        Route::post('place-order-admin', 'OrderController@placeAdminOrder')->name('admin.place.order');
        Route::get('manage-orders', 'OrderController@index')->name('admin.manage.orders');
        Route::get('orders-list-datatables', 'OrderController@listOrdersForDataTables')->name('datatables.admin.order.list');
        Route::get('datatables-orders-details-list', 'OrderController@listOrderDetailsForDataTables')->name('datatables.orders.details.list');
        Route::post('order-return', 'OrderController@returnOrder')->name('order.return');
        Route::post('order-detail-return', 'OrderController@returnOrderItem')->name('order.detail.return');
        Route::post('order-change-status', 'OrderController@changeOrderStatus')->name('order.change.status');
        Route::post('order-payment-received', 'OrderController@saveOrderAdvancePayment')->name('order.payment.received');
        Route::post('save-order-courier', 'OrderController@saveOrderCourierInfo')->name('save.order.courier');

        Route::get('slider', 'SliderController@index')->name('slider.index');
        Route::post('slider', 'SliderController@store')->name('slider.store');
        Route::get('change-slider-status', 'SliderController@changeSliderStatus')->name('change.slider.status');
        Route::get('datatables-slider-list', 'SliderController@sliderList')->name('datatables.slider.list');
        Route::delete('slider/{id}', 'SliderController@destroy')->name('slider.destroy');

        Route::get('ads', 'AdsController@index')->name('ads.index');
        Route::post('ads', 'AdsController@store')->name('ads.store');
        Route::get('change-ads-status', 'AdsController@changeAdsStatus')->name('change.ads.status');
        Route::get('datatables-ads-list', 'AdsController@adsList')->name('datatables.ads.list');
        Route::delete('ads/{id}', 'AdsController@destroy')->name('ads.destroy');

        Route::get('cars', 'CarsController@index')->name('cars.index');
        Route::get('cars-brands', 'CarsController@loadBrands')->name('datatables.cars.brands.list');
        Route::get('cars-models', 'CarsController@loadModels')->name('datatables.car.models.list');

        Route::get('cities', 'CitiesController@index')->name('cities.index');
        Route::get('cities-list', 'CitiesController@loadCities')->name('datatables.cities.list');
        Route::post('cities-post', 'CitiesController@create')->name('cities.store');
        Route::delete('cities/{id}', 'CitiesController@destroy')->name('cities.destroy');

        Route::post('cars-post', 'CarsController@create')->name('brands.store');
        Route::delete('cars/{id}', 'CarsController@destroy')->name('brands.destroy');

        Route::get('colors', [ColorsController::class, 'index'])->name('color.index');
        Route::get('colors-list', [ColorsController::class, 'colorsList'])->name('datatables.colors.list');
        Route::post('save-color', [ColorsController::class, 'save'])->name('color.store');
        Route::delete('color/{id}', [ColorsController::class, 'destroy'])->name('color.destroy');

        Route::get('phone-email-settings', [SettingsController::class, 'phoneEmailSettings'])->name('phone.email.settings');
        Route::post('phone-email-settings', [SettingsController::class, 'savePhoneEmailSettings'])->name('phone.email.settings.save');

        Route::view('product-exports', 'admin.products.export', [
            'categories' => (new ProductsController())->getCategoriesForDropdown()
        ])->name('export.products');

        Route::view('product-discounts', 'admin.products.discount', [
            'categories' => (new ProductsController())->getCategoriesForDropdown()
        ])->name('products.discount');

        Route::get('apply-bulk-discount', [ProductsController::class, 'applyBulkDiscount'])->name('apply.bulk.discount');

        Route::get('invoice/{id}/details', [OrderController::class, 'loadInvoiceDetails'])->name('invoice.details');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('reset.password');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('notifications-list', [NotificationController::class, 'notificationListForDataTables'])->name('datatables.notifications.list');
        Route::get('send-notification', [NotificationController::class, 'loadSendNotificationView'])->name('send.notification.view');
        Route::post('send-web-notification', [NotificationController::class, 'sendPushNotification'])->name('send.web.push');

        Route::get('pages', [PagesController::class, 'index'])->name('pages.index');
        Route::get('pages-list', [PagesController::class, 'listPagesForDataTables'])->name('pages.list');
        Route::get('pages-create', [PagesController::class, 'create'])->name('pages.create');
        Route::post('pages-store', [PagesController::class, 'save'])->name('page.store');
        Route::get('pages-edit/{id}', [PagesController::class, 'edit'])->name('page.edit');
        Route::delete('pages/{id}', [PagesController::class, 'destroy'])->name('pages.destroy');


        Route::get('contact-us-feedback', [ContactUsController::class, 'index'])->name('contact.us.index');
        Route::get('contact-us-list', [ContactUsController::class, 'listContactForDataTables'])->name('contactus.list');
        Route::delete('contact-us/{id}', [ContactUsController::class, 'destroy'])->name('contactus.destroy');

        Route::get('manage-promotions', [PromotionsController::class, 'index'])->name('promotions.index');
        Route::get('datatables-promotions-list', [PromotionsController::class, 'promotionsList'])->name('datatables.promotions.list');
        Route::get('change-promotion-status', [PromotionsController::class, 'changePromotionStatus'])->name('change.promotion.status');
        Route::delete('promotion/{id}', [PromotionsController::class, 'destroy'])->name('promotion.destroy');
        Route::get('new-promotion', [PromotionsController::class, 'create'])->name('add.promotion');
        Route::post('promotion-store', [PromotionsController::class, 'save'])->name('promotion.store');
        Route::get('edit/{id}', [PromotionsController::class, 'edit'])->name('promotion.edit');

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('print-report', [ReportController::class, 'downloadReport'])->name('print.report');

        Route::get('staff-performance', [StaffPerformanceController::class, 'index'])->name('staff.performance');
        Route::get('datatables-staff-performance-list', [StaffPerformanceController::class, 'usersList'])->name('datatables.staff.performance.list');
    });

});//.... end prefix wrapper.

Route::post('save-token', [NotificationController::class, 'saveToken']);

Route::fallback("FrontendController@index");
