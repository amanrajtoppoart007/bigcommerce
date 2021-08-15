<?php



Route::middleware([\App\Http\Middleware\CheckIfHelpCenterHasActiveMembershipPlan::class,\App\Http\Middleware\CheckIfHelpCenterDocumentsAreUploaded::class])->group(function (){
    Route::get('/', 'HelpCenter\HomeController@index')->name("dashboard");
    Route::resource('users', 'HelpCenter\UsersController');
    Route::post('users/add-address', 'HelpCenter\UsersController@addUserAddress')->name('add.user.address');
    Route::get('users/print-kisan-card/{user}', 'HelpCenter\UsersController@printKisanCard')->name('users.print.kisan-card');
    Route::get('products', 'HelpCenter\ProductController@index')->name('products.index');
    Route::get('products/check-stock-status', 'HelpCenter\ProductController@checkStockStatus')->name('check.stock.status');
    Route::post('add-to-cart', [\App\Http\Controllers\HelpCenter\OrderController::class, 'addToCart'])->name('add.to.cart');
    Route::get('carts', [\App\Http\Controllers\HelpCenter\OrderController::class, 'showCarts'])->name('carts');
    Route::post('update-cart-quantity', [\App\Http\Controllers\HelpCenter\OrderController::class, 'updateCartQuantity'])->name('update.cart.quantity');
    Route::post('remove-from-cart', [\App\Http\Controllers\HelpCenter\OrderController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::get('checkout', [\App\Http\Controllers\HelpCenter\OrderController::class, 'showCheckout'])->name('checkout.page');
    Route::post('place-order', [\App\Http\Controllers\HelpCenter\OrderController::class, 'placeOrder'])->name('place.order');
    Route::get('get-user-addresses', [\App\Http\Controllers\HelpCenter\OrderController::class, 'getUserAddresses'])->name('get.user.addresses');
    Route::resource('orders', 'HelpCenter\OrderController');
    Route::post('orders/make-payment', 'HelpCenter\OrderController@makePayment')->name('make.order.payment');
    Route::post('orders/assign', 'HelpCenter\OrderController@assignOrder')->name('orders.assign');
    Route::post('orders/assign-manually', 'HelpCenter\OrderController@assignOrderManually')->name('orders.assign.manually');
    Route::post('orders/generate-invoice', 'HelpCenter\OrderController@generateInvoice')->name('orders.generate.invoice');
    Route::post('orders/verify-payment', 'HelpCenter\OrderController@verifyPayment')->name('orders.verify.payment');
    Route::get('profile', 'HelpCenter\HomeController@showProfileForm')->name('profile');
    Route::post('profile/update', 'HelpCenter\HomeController@updateProfile')->name('update.profile');
    Route::get('change-password', 'HelpCenter\HomeController@showChangePasswordForm')->name('show.change.password.form');
    Route::post('change-password', 'HelpCenter\HomeController@changePassword')->name('change.password');
});

Route::middleware([\App\Http\Middleware\CheckIfHelpCenterHasActiveMembershipPlan::class])->group(function (){
    Route::get('/upload-documents', 'HelpCenter\HomeController@showDocumentsUploadForm')->name("show.upload.documents.form");
    Route::post('/upload-documents', 'HelpCenter\HomeController@uploadDocuments')->name("upload.documents");
    Route::post('/upload-documents/media', 'HelpCenter\HomeController@storeMedia')->name('upload.documents.storeMedia');

});

Route::get('/membership-payment', 'HelpCenter\HomeController@showMembershipPaymentForm')->name("show.membership.payment.form");
Route::post('/membership-store', 'HelpCenter\TransactionController@storeMembership')->name("store.membership");
Route::post('/membership-payment/make', 'HelpCenter\TransactionController@makeMembershipPayment')->name("make.membership.payment");
