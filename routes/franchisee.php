<?php

Route::middleware([ \App\Http\Middleware\CheckIfFranchiseeHasActiveMembershipPlan::class, \App\Http\Middleware\CheckIfFranchiseeDocumentsAreUploaded::class,])->group(function () {
    Route::get('/', 'Franchisee\HomeController@index')->name("dashboard");
    Route::resource('orders', 'Franchisee\OrderController');
    Route::post('cancel-order', [\App\Http\Controllers\Franchisee\OrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('get-product-prices-by-product', [\App\Http\Controllers\Franchisee\ProductController::class, 'getProductPricesByProduct'])->name('get.product.prices.by.product');
    Route::post('orders/make-payment', 'Franchisee\OrderController@makePayment')->name('make.order.payment');
    Route::get('profile', 'Franchisee\HomeController@showProfileForm')->name('profile');
    Route::post('profile/update', 'Franchisee\HomeController@updateProfile')->name('update.profile');
    Route::get('change-password', 'Franchisee\HomeController@showChangePasswordForm')->name('show.change.password.form');
    Route::post('change-password', 'Franchisee\HomeController@changePassword')->name('change.password');
    Route::resource('assigned-orders', 'Franchisee\AssignedOrderController');
    Route::post('assigned-orders/update-status', 'Franchisee\AssignedOrderController@updateStatus')->name('assigned-orders.update.status');
    Route::post('assigned-orders/confirm', 'Franchisee\AssignedOrderController@confirmOrder')->name('assigned-orders.confirm');
    Route::get('service-area', 'Franchisee\HomeController@showServiceAreaForm')->name('show.service.area.form');
    Route::post('save-service-area', 'Franchisee\HomeController@saveServiceArea')->name('service.area.save');
    Route::resource('product-stocks', 'Franchisee\ProductStockController');
});

Route::get('/upload-documents', 'Franchisee\HomeController@showDocumentsUploadForm')->name("show.upload.documents.form");
Route::post('/upload-documents', 'Franchisee\HomeController@uploadDocuments')->name("upload.documents");
Route::get('/membership-payment', 'Franchisee\HomeController@showMembershipPaymentForm')->name("show.membership.payment.form");
Route::post('/membership-store', 'Franchisee\TransactionController@storeMembership')->name("store.membership");
Route::post('/membership-payment/make', 'Franchisee\TransactionController@makeMembershipPayment')->name("make.membership.payment");
