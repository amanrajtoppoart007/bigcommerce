<?php



    Route::get('/', 'Admin\HomeController@index')->name('home');
    Route::get('/dashboard', 'Admin\HomeController@index')->name('dashboard');
    // Permissions
    Route::delete('permissions/destroy', 'Admin\PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'Admin\PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'Admin\RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'Admin\RolesController');

    // Users
    Route::delete('users/destroy', 'Admin\UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'Admin\UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'Admin\UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'Admin\UsersController');
    Route::post('users/change/approval/status', 'Admin\UsersController@changeApprovalStatus')->name('users.changeApprovalStatus');
    Route::post('users/change/verification/status', 'Admin\UsersController@changeVerificationStatus')->name('users.changeVerificationStatus');
    Route::get('users/print-kisan-card/{user}', 'Admin\UsersController@printKisanCard')->name('users.print.kisan-card');

    // Product Categories
    Route::delete('product-categories/destroy', 'Admin\ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'Admin\ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'Admin\ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'Admin\ProductCategoryController');

    // Product Tags
    Route::delete('product-tags/destroy', 'Admin\ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'Admin\ProductTagController');
    Route::get('get-product-tag', [\App\Http\Controllers\Admin\ProductTagController::class, 'getProductTag'])->name('get.product-tag');
    Route::post('add-product-tag', [\App\Http\Controllers\Admin\ProductTagController::class, 'addProductTag'])->name('product-tag.add');
    Route::post('update-product-tag', [\App\Http\Controllers\Admin\ProductTagController::class, 'updateProductTag'])->name('product-tag.update');

    // Products
    Route::delete('products/destroy', 'Admin\ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'Admin\ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'Admin\ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::post('products/parse-csv-import', 'Admin\ProductController@parseCsvImport')->name('products.parseCsvImport');
    Route::post('products/process-csv-import', 'Admin\ProductController@processCsvImport')->name('products.processCsvImport');
    Route::resource('products', 'Admin\ProductController');
    Route::post('products/add', 'Admin\ProductController@addProduct')->name('products.add');
    Route::post('products/update', 'Admin\ProductController@updateProduct')->name('products.update');


// User Alerts
    Route::delete('user-alerts/destroy', 'Admin\UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'Admin\UserAlertsController', ['except' => ['edit', 'update']]);
    Route::get('get-user-alert', [\App\Http\Controllers\Admin\UserAlertsController::class, 'getUserAlert'])->name('get.user-alert');
    Route::post('add-user-alert', [\App\Http\Controllers\Admin\UserAlertsController::class, 'addUserAlert'])->name('user-alert.add');
    Route::post('update-user-alert', [\App\Http\Controllers\Admin\UserAlertsController::class, 'updateUserAlert'])->name('user-alert.update');

    // Content Categories
    Route::delete('content-categories/destroy', 'Admin\ContentCategoryController@massDestroy')->name('content-categories.massDestroy');
    Route::resource('content-categories', 'Admin\ContentCategoryController');
    Route::get('get-content-category', [\App\Http\Controllers\Admin\ContentCategoryController::class, 'getCategory'])->name('get.content-category');
    Route::post('add-content-category', [\App\Http\Controllers\Admin\ContentCategoryController::class, 'addCategory'])->name('content-category.add');
    Route::post('update-content-category', [\App\Http\Controllers\Admin\ContentCategoryController::class, 'updateCategory'])->name('content-category.update');

    // Enquiries
    Route::delete('enquiries/destroy', 'Admin\EnquiryController@massDestroy')->name('enquiries.massDestroy');
    Route::resource('enquiries', 'Admin\EnquiryController');

    // Content Tags
    Route::delete('content-tags/destroy', 'Admin\ContentTagController@massDestroy')->name('content-tags.massDestroy');
    Route::resource('content-tags', 'Admin\ContentTagController');
    Route::get('get-content-tag', [\App\Http\Controllers\Admin\ContentTagController::class, 'getTag'])->name('get.content-tag');
    Route::post('add-content-tag', [\App\Http\Controllers\Admin\ContentTagController::class, 'addTag'])->name('content-tag.add');
    Route::post('update-content-tag', [\App\Http\Controllers\Admin\ContentTagController::class, 'updateTag'])->name('content-tag.update');

    // Content Pages
    Route::delete('content-pages/destroy', 'Admin\ContentPageController@massDestroy')->name('content-pages.massDestroy');
    Route::post('content-pages/media', 'Admin\ContentPageController@storeMedia')->name('content-pages.storeMedia');
    Route::post('content-pages/ckmedia', 'Admin\ContentPageController@storeCKEditorImages')->name('content-pages.storeCKEditorImages');
    Route::resource('content-pages', 'Admin\ContentPageController');

    // Faq Categories
    Route::delete('faq-categories/destroy', 'Admin\FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'Admin\FaqCategoryController');
    Route::get('get-faq-category', [\App\Http\Controllers\Admin\FaqCategoryController::class, 'getCategory'])->name('get.faq-category');
    Route::post('add-faq-category', [\App\Http\Controllers\Admin\FaqCategoryController::class, 'addCategory'])->name('faq-category.add');
    Route::post('update-faq-category', [\App\Http\Controllers\Admin\FaqCategoryController::class, 'updateCategory'])->name('faq-category.update');

    // Faq Questions
    Route::delete('faq-questions/destroy', 'Admin\FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::post('faq-questions/parse-csv-import', 'Admin\FaqQuestionController@parseCsvImport')->name('faq-questions.parseCsvImport');
    Route::post('faq-questions/process-csv-import', 'Admin\FaqQuestionController@processCsvImport')->name('faq-questions.processCsvImport');
    Route::resource('faq-questions', 'Admin\FaqQuestionController');

    // Audit Logs
    Route::resource('audit-logs', 'Admin\AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Orders
    Route::delete('orders/destroy', 'Admin\OrderController@massDestroy')->name('orders.massDestroy');
    Route::post('orders/parse-csv-import', 'Admin\OrderController@parseCsvImport')->name('orders.parseCsvImport');
    Route::post('orders/process-csv-import', 'Admin\OrderController@processCsvImport')->name('orders.processCsvImport');
    Route::resource('orders', 'Admin\OrderController');
    Route::post('orders/assign', 'Admin\OrderController@assignOrder')->name('orders.assign');
    Route::post('orders/assign-manually', 'Admin\OrderController@assignOrderManually')->name('orders.assign.manually');
    Route::post('orders/cancel', 'Admin\OrderController@cancelOrder')->name('orders.cancel');
    Route::post('orders/verify-payment', 'Admin\OrderController@verifyPayment')->name('orders.verify.payment');
    Route::post('orders/generate-invoice', 'HelpCenter\OrderController@generateInvoice')->name('orders.generate.invoice');
    Route::post('orders/update-status', 'Admin\OrderController@updateStatus')->name('orders.update.status');
    Route::post('orders/update-stock', 'Admin\OrderController@updateStock')->name('orders.update.stock');

// Carts
    Route::delete('carts/destroy', 'Admin\CartController@massDestroy')->name('carts.massDestroy');
    Route::post('carts/parse-csv-import', 'Admin\CartController@parseCsvImport')->name('carts.parseCsvImport');
    Route::post('carts/process-csv-import', 'Admin\CartController@processCsvImport')->name('carts.processCsvImport');
    Route::resource('carts', 'Admin\CartController');

    // Vendors
    Route::delete('vendors/destroy', 'Admin\VendorController@massDestroy')->name('vendors.massDestroy');
    Route::post('vendors/parse-csv-import', 'Admin\VendorController@parseCsvImport')->name('vendors.parseCsvImport');
    Route::post('vendors/process-csv-import', 'Admin\VendorController@processCsvImport')->name('vendors.processCsvImport');
    Route::resource('vendors', 'Admin\VendorController');

    // Franchisees
    Route::delete('franchisees/destroy', 'Admin\FranchiseeController@massDestroy')->name('franchisees.massDestroy');
    Route::post('franchisees/parse-csv-import', 'Admin\FranchiseeController@parseCsvImport')->name('franchisees.parseCsvImport');
    Route::post('franchisees/process-csv-import', 'Admin\FranchiseeController@processCsvImport')->name('franchisees.processCsvImport');
    Route::resource('franchisees', 'Admin\FranchiseeController');

    // Pincodes
    Route::delete('pincodes/destroy', 'Admin\PincodeController@massDestroy')->name('pincodes.massDestroy');
    Route::post('pincodes/parse-csv-import', 'Admin\PincodeController@parseCsvImport')->name('pincodes.parseCsvImport');
    Route::post('pincodes/process-csv-import', 'Admin\PincodeController@processCsvImport')->name('pincodes.processCsvImport');
    Route::resource('pincodes', 'Admin\PincodeController');
    Route::get('get-pincode', [\App\Http\Controllers\Admin\PincodeController::class, 'getPincode'])->name('get.pincode');
    Route::post('add-pincode', [\App\Http\Controllers\Admin\PincodeController::class, 'addPincode'])->name('pincode.add');
    Route::post('update-pincode', [\App\Http\Controllers\Admin\PincodeController::class, 'updatePincode'])->name('pincode.update');

    // States
    Route::delete('states/destroy', 'Admin\StateController@massDestroy')->name('states.massDestroy');
    Route::post('states/parse-csv-import', 'Admin\StateController@parseCsvImport')->name('states.parseCsvImport');
    Route::post('states/process-csv-import', 'Admin\StateController@processCsvImport')->name('states.processCsvImport');
    Route::resource('states', 'Admin\StateController');
    Route::get('get-state', [\App\Http\Controllers\Admin\StateController::class, 'getState'])->name('get.state');
    Route::post('add-state', [\App\Http\Controllers\Admin\StateController::class, 'addState'])->name('state.add');
    Route::post('update-state', [\App\Http\Controllers\Admin\StateController::class, 'updateState'])->name('state.update');

    // Districts
    Route::delete('districts/destroy', 'Admin\DistrictController@massDestroy')->name('districts.massDestroy');
    Route::post('districts/parse-csv-import', 'Admin\DistrictController@parseCsvImport')->name('districts.parseCsvImport');
    Route::post('districts/process-csv-import', 'Admin\DistrictController@processCsvImport')->name('districts.processCsvImport');
    Route::resource('districts', 'Admin\DistrictController');
    Route::get('get-district', [\App\Http\Controllers\Admin\DistrictController::class, 'getDistrict'])->name('get.district');
    Route::post('add-district', [\App\Http\Controllers\Admin\DistrictController::class, 'addDistrict'])->name('district.add');
    Route::post('update-district', [\App\Http\Controllers\Admin\DistrictController::class, 'updateDistrict'])->name('district.update');

    // Blocks
    Route::delete('blocks/destroy', 'Admin\BlockController@massDestroy')->name('blocks.massDestroy');
    Route::post('blocks/parse-csv-import', 'Admin\BlockController@parseCsvImport')->name('blocks.parseCsvImport');
    Route::post('blocks/process-csv-import', 'Admin\BlockController@processCsvImport')->name('blocks.processCsvImport');
    Route::resource('blocks', 'Admin\BlockController');
    Route::get('get-block', [\App\Http\Controllers\Admin\BlockController::class, 'getBlock'])->name('get.block');
    Route::post('add-block', [\App\Http\Controllers\Admin\BlockController::class, 'addBlock'])->name('block.add');
    Route::post('update-block', [\App\Http\Controllers\Admin\BlockController::class, 'updateBlock'])->name('block.update');

    // Areas
    Route::delete('areas/destroy', 'Admin\AreaController@massDestroy')->name('areas.massDestroy');
    Route::post('areas/parse-csv-import', 'Admin\AreaController@parseCsvImport')->name('areas.parseCsvImport');
    Route::post('areas/process-csv-import', 'Admin\AreaController@processCsvImport')->name('areas.processCsvImport');
    Route::resource('areas', 'Admin\AreaController');
    Route::get('get-area', [\App\Http\Controllers\Admin\AreaController::class, 'getArea'])->name('get.area');
    Route::post('add-area', [\App\Http\Controllers\Admin\AreaController::class, 'addArea'])->name('area.add');
    Route::post('update-area', [\App\Http\Controllers\Admin\AreaController::class, 'updateArea'])->name('area.update');

    // Brands
    Route::delete('brands/destroy', 'Admin\BrandController@massDestroy')->name('brands.massDestroy');
    Route::post('brands/parse-csv-import', 'Admin\BrandController@parseCsvImport')->name('brands.parseCsvImport');
    Route::post('brands/process-csv-import', 'Admin\BrandController@processCsvImport')->name('brands.processCsvImport');
    Route::resource('brands', 'Admin\BrandController');
    Route::get('get-brand', [\App\Http\Controllers\Admin\BrandController::class, 'getBrand'])->name('get.brand');
    Route::post('add-brand', [\App\Http\Controllers\Admin\BrandController::class, 'addBrand'])->name('brand.add');
    Route::post('update-brand', [\App\Http\Controllers\Admin\BrandController::class, 'updateBrand'])->name('brand.update');

    // Articles
    Route::delete('articles/destroy', 'Admin\ArticleController@massDestroy')->name('articles.massDestroy');
    Route::post('articles/media', 'Admin\ArticleController@storeMedia')->name('articles.storeMedia');
    Route::post('articles/ckmedia', 'Admin\ArticleController@storeCKEditorImages')->name('articles.storeCKEditorImages');
    Route::post('articles/parse-csv-import', 'Admin\ArticleController@parseCsvImport')->name('articles.parseCsvImport');
    Route::post('articles/process-csv-import', 'Admin\ArticleController@processCsvImport')->name('articles.processCsvImport');
    Route::resource('articles', 'Admin\ArticleController');

    // Article Tags
    Route::delete('article-tags/destroy', 'Admin\ArticleTagController@massDestroy')->name('article-tags.massDestroy');
    Route::post('article-tags/parse-csv-import', 'Admin\ArticleTagController@parseCsvImport')->name('article-tags.parseCsvImport');
    Route::post('article-tags/process-csv-import', 'Admin\ArticleTagController@processCsvImport')->name('article-tags.processCsvImport');
    Route::resource('article-tags', 'Admin\ArticleTagController');
    Route::get('get-article-tag', [\App\Http\Controllers\Admin\ArticleTagController::class, 'getTag'])->name('get.article-tag');
    Route::post('add-article-tag', [\App\Http\Controllers\Admin\ArticleTagController::class, 'addTag'])->name('article-tag.add');
    Route::post('update-article-tag', [\App\Http\Controllers\Admin\ArticleTagController::class, 'updateTag'])->name('article-tag.update');

    // Article Comments
    Route::delete('article-comments/destroy', 'Admin\ArticleCommentController@massDestroy')->name('article-comments.massDestroy');
    Route::post('article-comments/parse-csv-import', 'Admin\ArticleCommentController@parseCsvImport')->name('article-comments.parseCsvImport');
    Route::post('article-comments/process-csv-import', 'Admin\ArticleCommentController@processCsvImport')->name('article-comments.processCsvImport');
    Route::resource('article-comments', 'Admin\ArticleCommentController');

    // Followers
    Route::delete('followers/destroy', 'Admin\FollowerController@massDestroy')->name('followers.massDestroy');
    Route::post('followers/parse-csv-import', 'Admin\FollowerController@parseCsvImport')->name('followers.parseCsvImport');
    Route::post('followers/process-csv-import', 'Admin\FollowerController@processCsvImport')->name('followers.processCsvImport');
    Route::resource('followers', 'Admin\FollowerController');

    // Article Likes
    Route::delete('article-likes/destroy', 'Admin\ArticleLikeController@massDestroy')->name('article-likes.massDestroy');
    Route::post('article-likes/parse-csv-import', 'Admin\ArticleLikeController@parseCsvImport')->name('article-likes.parseCsvImport');
    Route::post('article-likes/process-csv-import', 'Admin\ArticleLikeController@processCsvImport')->name('article-likes.processCsvImport');
    Route::resource('article-likes', 'Admin\ArticleLikeController');

    // Logistics
    Route::delete('logistics/destroy', 'Admin\LogisticsController@massDestroy')->name('logistics.massDestroy');
    Route::post('logistics/parse-csv-import', 'Admin\LogisticsController@parseCsvImport')->name('logistics.parseCsvImport');
    Route::post('logistics/process-csv-import', 'Admin\LogisticsController@processCsvImport')->name('logistics.processCsvImport');
    Route::resource('logistics', 'Admin\LogisticsController');

    // Transactions
    Route::delete('transactions/destroy', 'Admin\TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'Admin\TransactionsController');

    // User Addresses
    Route::delete('user-addresses/destroy', 'Admin\UserAddressController@massDestroy')->name('user-addresses.massDestroy');
    Route::post('user-addresses/parse-csv-import', 'Admin\UserAddressController@parseCsvImport')->name('user-addresses.parseCsvImport');
    Route::post('user-addresses/process-csv-import', 'Admin\UserAddressController@processCsvImport')->name('user-addresses.processCsvImport');
    Route::resource('user-addresses', 'Admin\UserAddressController');

    // Settings
    Route::delete('settings/destroy', 'Admin\SettingsController@massDestroy')->name('settings.massDestroy');
    Route::post('settings/parse-csv-import', 'Admin\SettingsController@parseCsvImport')->name('settings.parseCsvImport');
    Route::post('settings/process-csv-import', 'Admin\SettingsController@processCsvImport')->name('settings.processCsvImport');
    Route::resource('settings', 'Admin\SettingsController');

    // Admins
    Route::delete('admins/destroy', 'Admin\AdminController@massDestroy')->name('admins.massDestroy');
    Route::post('admins/parse-csv-import', 'Admin\AdminController@parseCsvImport')->name('admins.parseCsvImport');
    Route::post('admins/process-csv-import', 'Admin\AdminController@processCsvImport')->name('admins.processCsvImport');
    Route::resource('admins', 'Admin\AdminController');

    // Cities
    Route::delete('cities/destroy', 'Admin\CityController@massDestroy')->name('cities.massDestroy');
    Route::post('cities/parse-csv-import', 'Admin\CityController@parseCsvImport')->name('cities.parseCsvImport');
    Route::post('cities/process-csv-import', 'Admin\CityController@processCsvImport')->name('cities.processCsvImport');
    Route::resource('cities', 'Admin\CityController');
    Route::get('get-city', [\App\Http\Controllers\Admin\CityController::class, 'getCity'])->name('get.city');
    Route::post('add-city', [\App\Http\Controllers\Admin\CityController::class, 'addCity'])->name('city.add');
    Route::post('update-city', [\App\Http\Controllers\Admin\CityController::class, 'updateCity'])->name('city.update');

    // Help Centers
    Route::delete('help-centers/destroy', 'Admin\HelpCenterController@massDestroy')->name('help-centers.massDestroy');
    Route::post('help-centers/parse-csv-import', 'Admin\HelpCenterController@parseCsvImport')->name('help-centers.parseCsvImport');
    Route::post('help-centers/process-csv-import', 'Admin\HelpCenterController@processCsvImport')->name('help-centers.processCsvImport');
    Route::resource('help-centers', 'Admin\HelpCenterController');

    // Help Center Profiles
    Route::delete('help-center-profiles/destroy', 'Admin\HelpCenterProfileController@massDestroy')->name('help-center-profiles.massDestroy');
    Route::post('help-center-profiles/media', 'Admin\HelpCenterProfileController@storeMedia')->name('help-center-profiles.storeMedia');
    Route::post('help-center-profiles/ckmedia', 'Admin\HelpCenterProfileController@storeCKEditorImages')->name('help-center-profiles.storeCKEditorImages');
    Route::post('help-center-profiles/parse-csv-import', 'Admin\HelpCenterProfileController@parseCsvImport')->name('help-center-profiles.parseCsvImport');
    Route::post('help-center-profiles/process-csv-import', 'Admin\HelpCenterProfileController@processCsvImport')->name('help-center-profiles.processCsvImport');
    Route::resource('help-center-profiles', 'Admin\HelpCenterProfileController');
    Route::post('help-center-profiles/check-profile', 'Admin\HelpCenterProfileController@checkHelpCenterProfile')->name('help-center-profiles.check-profile');


// User Profiles
    Route::delete('user-profiles/destroy', 'Admin\UserProfileController@massDestroy')->name('user-profiles.massDestroy');
    Route::post('user-profiles/media', 'Admin\UserProfileController@storeMedia')->name('user-profiles.storeMedia');
    Route::post('user-profiles/ckmedia', 'Admin\UserProfileController@storeCKEditorImages')->name('user-profiles.storeCKEditorImages');
    Route::resource('user-profiles', 'Admin\UserProfileController');

    // Crops
    Route::delete('crops/destroy', 'Admin\CropController@massDestroy')->name('crops.massDestroy');
    Route::post('crops/media', 'Admin\CropController@storeMedia')->name('crops.storeMedia');
    Route::post('crops/ckmedia', 'Admin\CropController@storeCKEditorImages')->name('crops.storeCKEditorImages');
    Route::resource('crops', 'Admin\CropController');

    // Franchisee Profiles
    Route::delete('franchisee-profiles/destroy', 'Admin\FranchiseeProfileController@massDestroy')->name('franchisee-profiles.massDestroy');
    Route::post('franchisee-profiles/media', 'Admin\FranchiseeProfileController@storeMedia')->name('franchisee-profiles.storeMedia');
    Route::post('franchisee-profiles/ckmedia', 'Admin\FranchiseeProfileController@storeCKEditorImages')->name('franchisee-profiles.storeCKEditorImages');
    Route::post('franchisee-profiles/parse-csv-import', 'Admin\FranchiseeProfileController@parseCsvImport')->name('franchisee-profiles.parseCsvImport');
    Route::post('franchisee-profiles/process-csv-import', 'Admin\FranchiseeProfileController@processCsvImport')->name('franchisee-profiles.processCsvImport');
    Route::resource('franchisee-profiles', 'Admin\FranchiseeProfileController');
    Route::post('franchisee-profiles/check-profile', 'Admin\FranchiseeProfileController@checkFranchiseeProfile')->name('franchisee-profiles.check-profile');

    Route::get('global-search', 'Admin\GlobalSearchController@search')->name('globalSearch');
    Route::get('user-alerts/read', 'Admin\UserAlertsController@read');

    Route::get('unit-types', [\App\Http\Controllers\Admin\UnitTypeController::class, 'index'])->name('unit-types.index');
    Route::get('get-unit-type', [\App\Http\Controllers\Admin\UnitTypeController::class, 'getUnitType'])->name('get.unit-type');
    Route::post('add-unit-type', [\App\Http\Controllers\Admin\UnitTypeController::class, 'addUnitType'])->name('unit-type.add');
    Route::post('update-unit-type', [\App\Http\Controllers\Admin\UnitTypeController::class, 'updateUnitType'])->name('unit-type.update');
    Route::delete('unit-types/destroy', [\App\Http\Controllers\Admin\UnitTypeController::class, 'massDestroy'])->name('unit-types.massDestroy');
    Route::delete('unit-types/destroy/{unitType}', [\App\Http\Controllers\Admin\UnitTypeController::class, 'destroy'])->name('unit-types.destroy');

    Route::get('get-districts-by-state', [\App\Http\Controllers\Admin\DistrictController::class, 'getDistrictsByState'])->name('get.districts.by.state');
    Route::get('get-blocks-by-district', [\App\Http\Controllers\Admin\BlockController::class, 'getBlockByDistrict'])->name('get.blocks.by.district');
    Route::get('get-pincodes-and-areas-by-block', [\App\Http\Controllers\Admin\PincodeController::class, 'getPincodesAndAreasByBlock'])->name('get.pincodes.and.areas.by.block');

    // Product Categories
    Route::delete('product-sub-categories/destroy', 'Admin\ProductSubCategoryController@massDestroy')->name('product-sub-categories.massDestroy');
    Route::post('product-sub-categories/media', 'Admin\ProductSubCategoryController@storeMedia')->name('product-sub-categories.storeMedia');
    Route::post('product-sub-categories/ckmedia', 'Admin\ProductSubCategoryController@storeCKEditorImages')->name('product-sub-categories.storeCKEditorImages');
    Route::resource('product-sub-categories', 'Admin\ProductSubCategoryController');

    // Franchisee Orders
    Route::delete('franchisee-orders/destroy', 'Admin\FranchiseeOrderController@massDestroy')->name('franchisee-orders.massDestroy');
    Route::post('franchisee-orders/parse-csv-import', 'Admin\FranchiseeOrderController@parseCsvImport')->name('franchisee-orders.parseCsvImport');
    Route::post('franchisee-orders/process-csv-import', 'Admin\FranchiseeOrderController@processCsvImport')->name('franchisee-orders.processCsvImport');
    Route::resource('franchisee-orders', 'Admin\FranchiseeOrderController');
    Route::post('franchisee-orders/confirm', 'Admin\FranchiseeOrderController@confirmOrder')->name('franchisee-orders.confirm');
    Route::post('franchisee-orders/verify-payment', 'Admin\FranchiseeOrderController@verifyPayment')->name('franchisee-orders.verify.payment');
    Route::post('franchisee-orders/update-status', 'Admin\FranchiseeOrderController@updateStatus')->name('franchisee-orders.update.status');
    Route::post('franchisee-orders/update-stock', 'Admin\FranchiseeOrderController@updateStock')->name('franchisee-orders.update.stock');

    //SLIDERS
    Route::resource('sliders', 'Admin\SliderController');
    Route::post('sliders/media', 'Admin\SliderController@storeMedia')->name('sliders.storeMedia');

    Route::get('change-password', [\App\Http\Controllers\Admin\ChangePasswordController::class, 'showChangePasswordForm'])->name('show.change.password.form');
    Route::post('change-password', [\App\Http\Controllers\Admin\ChangePasswordController::class, 'changePassword'])->name('change.password');

    //SLIDERS
    Route::resource('site-setting', 'Admin\SiteSettingController');
    Route::post('site-setting/ckmedia', 'Admin\SiteSettingController@storeCKEditorImages')->name('site-setting.storeCKEditorImages');

    //Push Notification

    Route::get('push-notifications', [\App\Http\Controllers\Admin\PushNotificationController::class, 'index'])->name('push-notifications.index');
    Route::post('push-notifications/store', [\App\Http\Controllers\Admin\PushNotificationController::class, 'store'])->name('push-notifications.store');
    Route::post('push-notifications/delete', [\App\Http\Controllers\Admin\PushNotificationController::class, 'destroy'])->name('push-notifications.destroy');
    Route::delete('push-notifications/destroy', [\App\Http\Controllers\Admin\PushNotificationController::class, 'massDestroy'])->name('push-notifications.massDestroy');
    Route::post('push-notifications/media', 'Admin\PushNotificationController@storeMedia')->name('push-notifications.storeMedia');
    Route::post('push-notifications/send', [\App\Http\Controllers\Admin\PushNotificationController::class, 'send'])->name('push-notifications.send');

    //MEMBERSHIP PLANS
    Route::resource('membership-plans', 'Admin\MembershipPlanController');

    //Help Center Memberships
    Route::resource('help-center-memberships', 'Admin\HelpCenterMembershipController');

    //Franchisee Memberships
    Route::resource('franchisee-memberships', 'Admin\FranchiseeMembershipController');

    //BILLS AND STOCK
    Route::resource('bills', 'Admin\BillController');
    Route::resource('master-stocks', 'Admin\MasterStockController');
    Route::post('master-stocks/update-stock', 'Admin\MasterStockController@updateStock')->name('master-stocks.update.stock');
