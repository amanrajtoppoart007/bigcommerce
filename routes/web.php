<?php
Route::get('test/sms/api','TestController');
Route::post('submit/enquiry/form','Guest\EnquiryController@store')->name('store.guest.enquiry');

Route::group(['prefix' => 'help-center'], function () {
    Route::get('login', 'HelpCenter\LoginController@index')->name("helpCenter.login");
    Route::post('login', 'HelpCenter\LoginController@login')->name("helpCenter.login.check");
    Route::post('logout', 'HelpCenter\LoginController@logout')->name("helpCenter.logout");
    Route::get('password/reset', 'HelpCenter\ForgotPasswordController@showLinkRequestForm')->name("helpCenter.password.request");
    Route::post('password/email', 'HelpCenter\ForgotPasswordController@sendResetLinkEmail')->name("helpCenter.password.email");
    Route::post('password/reset', 'HelpCenter\ResetPasswordController@reset')->name("helpCenter.password.update");
    Route::get('password/reset/{token}', 'HelpCenter\ResetPasswordController@showResetForm')->name("helpCenter.password.reset");
});
Route::group(['prefix' => 'franchisee'], function () {
    Route::get('login', 'Franchisee\LoginController@index')->name("franchisee.login");
    Route::post('login', 'Franchisee\LoginController@login')->name("franchisee.login.check");
    Route::post('logout', 'Franchisee\LoginController@logout')->name("franchisee.logout");
    Route::get('password/reset', 'Franchisee\ForgotPasswordController@showLinkRequestForm')->name("franchisee.password.request");
    Route::post('password/email', 'Franchisee\ForgotPasswordController@sendResetLinkEmail')->name("franchisee.password.email");
    Route::post('password/reset', 'Franchisee\ResetPasswordController@reset')->name("franchisee.password.update");
    Route::get('password/reset/{token}', 'Franchisee\ResetPasswordController@showResetForm')->name("franchisee.password.reset");
});
Route::group(['prefix' => 'logistics'], function () {
    Route::get('login', 'LogisticsAuth\LoginController@index')->name("logistics.login");
    Route::post('login', 'LogisticsAuth\LoginController@login')->name("logistics.login.check");
    Route::post('logout', 'LogisticsAuth\LoginController@logout')->name("logistics.logout");
    Route::get('password/reset', 'LogisticsAuth\ForgotPasswordController@showLinkRequestForm')->name("logistics.password.request");
    Route::post('password/email', 'LogisticsAuth\ForgotPasswordController@sendResetLinkEmail')->name("logistics.password.email");
    Route::post('password/reset', 'LogisticsAuth\ResetPasswordController@reset')->name("logistics.password.update");
    Route::get('password/reset/{token}', 'LogisticsAuth\ResetPasswordController@showResetForm')->name("logistics.password.reset");
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'AdminAuth\LoginController@login')->name('admin.login.check');
    Route::post('logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
    Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name("admin.password.request");
    Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name("admin.password.email");
    Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset')->name("admin.password.update");
    Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name("admin.password.reset");
});

Route::prefix('ajax')->group(function(){
   Route::post('get/states', 'Ajax\RegionController@getDistricts')->name('ajax.district.list');
   Route::post('get/blocks', 'Ajax\RegionController@getBlockList')->name('ajax.block.list');
   Route::post('get/pincodes', 'Ajax\RegionController@getPincodeList')->name('ajax.pincode.list');
   Route::post('get/areas', 'Ajax\RegionController@getAreaList')->name('ajax.area.list');
   Route::get('get-pincodes-and-areas-by-block', [\App\Http\Controllers\Ajax\RegionController::class, 'getPincodesAndAreasByBlock'])->name('ajax.pincodes.and.areas.list');
   Route::get('products-search-select2', [\App\Http\Controllers\Ajax\ProductController::class, 'productSearchSelect2'])->name('ajax.products.search.select2');
   Route::get('product-price-by-product', [\App\Http\Controllers\Ajax\ProductController::class, 'productPriceByProduct'])->name('ajax.products.price.by.product');
});

Route::get('/', 'Guest\HomeController@index')->name('guest.home');
Route::get('/solution/{entity}', 'Guest\HomeController@solution')->name('solutions');
Route::get('/services', 'Guest\HomeController@services')->name('services');
Route::get('/career', 'Guest\HomeController@career')->name('career');
Route::get('/about', 'Guest\HomeController@about')->name('about');
Route::get('/contact', 'Guest\HomeController@contact')->name('contact');
Route::get('/privacy-policy', 'Guest\HomeController@privacy')->name('privacy');
Route::get('/terms-conditions', 'Guest\HomeController@terms')->name('terms');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Route::get('/web-view-terms-conditions', 'Guest\HomeController@webViewTerms');
Route::get('/web-view-about', 'Guest\HomeController@webViewAbout');
Route::get('/web-view-privacy-policy', 'Guest\HomeController@webViewPrivacyPolicy');
Auth::routes();


Route::prefix('registration')->group(function () {
     Route::get('/farmer', 'Auth\RegisterController@farmer')->name("farmer.register");
     Route::post('/farmer/store', 'Auth\RegisterController@storeFarmer')->name("store.farmer.register");
     Route::get('/help-center', 'Auth\RegisterController@helpCenter')->name("helpCenter.register");
     Route::post('/help-center/store', 'Auth\RegisterController@storeHelpCenter')->name("store.helpCenter.register");
     Route::get('/franchisee', 'Auth\RegisterController@franchisee')->name("franchisee.register");
     Route::post('upload/media', 'Auth\RegisterController@storeMedia')->name('registration.storeMedia');
     Route::post('/franchisee/store', 'Auth\RegisterController@storeFranchisee')->name("store.franchisee.register");

     Route::get('/message/{user}/{entity_id}/{token}', 'Auth\RegisterController@message')->name("registration.message");
     Route::post('/make-help-center-payment', 'HelpCenter\TransactionController@store')->name("helpCenter.make.payment");
     Route::post('/make-franchisee-payment', 'Franchisee\TransactionController@store')->name("franchisee.make.payment");
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Categories
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tags
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Products
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Content Categories
    Route::delete('content-categories/destroy', 'ContentCategoryController@massDestroy')->name('content-categories.massDestroy');
    Route::resource('content-categories', 'ContentCategoryController');

    // Content Tags
    Route::delete('content-tags/destroy', 'ContentTagController@massDestroy')->name('content-tags.massDestroy');
    Route::resource('content-tags', 'ContentTagController');

    // Content Pages
    Route::delete('content-pages/destroy', 'ContentPageController@massDestroy')->name('content-pages.massDestroy');
    Route::post('content-pages/media', 'ContentPageController@storeMedia')->name('content-pages.storeMedia');
    Route::post('content-pages/ckmedia', 'ContentPageController@storeCKEditorImages')->name('content-pages.storeCKEditorImages');
    Route::resource('content-pages', 'ContentPageController');

    // Faq Categories
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Questions
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Orders
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');

    // Carts
    Route::delete('carts/destroy', 'CartController@massDestroy')->name('carts.massDestroy');
    Route::resource('carts', 'CartController');

    // Vendors
    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::resource('vendors', 'VendorController');

    // Franchisees
    Route::delete('franchisees/destroy', 'FranchiseeController@massDestroy')->name('franchisees.massDestroy');
    Route::resource('franchisees', 'FranchiseeController');

    // Pincodes
    Route::delete('pincodes/destroy', 'PincodeController@massDestroy')->name('pincodes.massDestroy');
    Route::resource('pincodes', 'PincodeController');

    // States
    Route::delete('states/destroy', 'StateController@massDestroy')->name('states.massDestroy');
    Route::resource('states', 'StateController');

    // Districts
    Route::delete('districts/destroy', 'DistrictController@massDestroy')->name('districts.massDestroy');
    Route::resource('districts', 'DistrictController');

    // Blocks
    Route::delete('blocks/destroy', 'BlockController@massDestroy')->name('blocks.massDestroy');
    Route::resource('blocks', 'BlockController');

    // Areas
    Route::delete('areas/destroy', 'AreaController@massDestroy')->name('areas.massDestroy');
    Route::resource('areas', 'AreaController');

    // Brands
    Route::delete('brands/destroy', 'BrandController@massDestroy')->name('brands.massDestroy');
    Route::resource('brands', 'BrandController');

    // Articles
    Route::delete('articles/destroy', 'ArticleController@massDestroy')->name('articles.massDestroy');
    Route::post('articles/media', 'ArticleController@storeMedia')->name('articles.storeMedia');
    Route::post('articles/ckmedia', 'ArticleController@storeCKEditorImages')->name('articles.storeCKEditorImages');
    Route::resource('articles', 'ArticleController');

    // Article Tags
    Route::delete('article-tags/destroy', 'ArticleTagController@massDestroy')->name('article-tags.massDestroy');
    Route::resource('article-tags', 'ArticleTagController');

    // Article Comments
    Route::delete('article-comments/destroy', 'ArticleCommentController@massDestroy')->name('article-comments.massDestroy');
    Route::resource('article-comments', 'ArticleCommentController');

    // Followers
    Route::delete('followers/destroy', 'FollowerController@massDestroy')->name('followers.massDestroy');
    Route::resource('followers', 'FollowerController');

    // Article Likes
    Route::delete('article-likes/destroy', 'ArticleLikeController@massDestroy')->name('article-likes.massDestroy');
    Route::resource('article-likes', 'ArticleLikeController');

    // Logistics
    Route::delete('logistics/destroy', 'LogisticsController@massDestroy')->name('logistics.massDestroy');
    Route::resource('logistics', 'LogisticsController');

    // Transactions
    Route::delete('transactions/destroy', 'TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'TransactionsController');

    // User Addresses
    Route::delete('user-addresses/destroy', 'UserAddressController@massDestroy')->name('user-addresses.massDestroy');
    Route::resource('user-addresses', 'UserAddressController');

    // Settings
    Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');
    Route::resource('settings', 'SettingsController');

    // Admins
    Route::delete('admins/destroy', 'AdminController@massDestroy')->name('admins.massDestroy');
    Route::resource('admins', 'AdminController');

    // Cities
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CityController');

    // Help Centers
    Route::delete('help-centers/destroy', 'HelpCenterController@massDestroy')->name('help-centers.massDestroy');
    Route::resource('help-centers', 'HelpCenterController');

    // Help Center Profiles
    Route::delete('help-center-profiles/destroy', 'HelpCenterProfileController@massDestroy')->name('help-center-profiles.massDestroy');
    Route::post('help-center-profiles/media', 'HelpCenterProfileController@storeMedia')->name('help-center-profiles.storeMedia');
    Route::post('help-center-profiles/ckmedia', 'HelpCenterProfileController@storeCKEditorImages')->name('help-center-profiles.storeCKEditorImages');
    Route::resource('help-center-profiles', 'HelpCenterProfileController');

    // User Profiles
    Route::delete('user-profiles/destroy', 'UserProfileController@massDestroy')->name('user-profiles.massDestroy');
    Route::post('user-profiles/media', 'UserProfileController@storeMedia')->name('user-profiles.storeMedia');
    Route::post('user-profiles/ckmedia', 'UserProfileController@storeCKEditorImages')->name('user-profiles.storeCKEditorImages');
    Route::resource('user-profiles', 'UserProfileController');

    // Crops
    Route::delete('crops/destroy', 'CropController@massDestroy')->name('crops.massDestroy');
    Route::post('crops/media', 'CropController@storeMedia')->name('crops.storeMedia');
    Route::post('crops/ckmedia', 'CropController@storeCKEditorImages')->name('crops.storeCKEditorImages');
    Route::resource('crops', 'CropController');

    // Franchisee Profiles
    Route::delete('franchisee-profiles/destroy', 'FranchiseeProfileController@massDestroy')->name('franchisee-profiles.massDestroy');
    Route::post('franchisee-profiles/media', 'FranchiseeProfileController@storeMedia')->name('franchisee-profiles.storeMedia');
    Route::post('franchisee-profiles/ckmedia', 'FranchiseeProfileController@storeCKEditorImages')->name('franchisee-profiles.storeCKEditorImages');
    Route::resource('franchisee-profiles', 'FranchiseeProfileController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});

Route::middleware([\App\Http\Middleware\AuthCommonRouteMiddleware::class])->group(function (){
    Route::get('print-invoice/{invoiceNo}', 'InvoiceController@printInvoice')->name('orders.print.invoice');
});
