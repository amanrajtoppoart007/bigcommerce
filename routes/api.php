<?php


Route::prefix('v1/user')->group(function (){
    Route::post('access_step_one', [\App\Http\Controllers\Api\V1\User\AuthController::class, 'access_step_one']);
    Route::post('access_step_two', [\App\Http\Controllers\Api\V1\User\AuthController::class, 'access_step_two']);
    Route::post('access_step_three', [\App\Http\Controllers\Api\V1\User\AuthController::class, 'access_step_third']);
    Route::get('get-states', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getStates']);
    Route::get('get-districts', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getDistricts']);
    Route::get('get-blocks', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getBlocks']);
    Route::get('get-pincodes', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getPincodes']);
    Route::get('get-areas', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getAreas']);
    Route::get('get-address-types', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getAddressTypes']);
    Route::get('get-categories', [\App\Http\Controllers\Api\V1\User\CartController::class, 'getCategories']);
    Route::get('get-sub-categories', [\App\Http\Controllers\Api\V1\User\CartController::class, 'getSubCategories']);
    Route::get('get-products', [\App\Http\Controllers\Api\V1\User\CartController::class, 'getProducts']);
    Route::get('get-product-prices', [\App\Http\Controllers\Api\V1\User\CartController::class, 'getProductPrices']);
    Route::get('get-sliders', [\App\Http\Controllers\Api\V1\User\SliderController::class, 'getSliders']);
    Route::get('get-latest-products', [\App\Http\Controllers\Api\V1\User\ProductController::class, 'getLatestProducts']);
    Route::get('get-top-rated-products', [\App\Http\Controllers\Api\V1\User\ProductController::class, 'getTopRatedProducts']);
    Route::get('get-product-details', [\App\Http\Controllers\Api\V1\User\ProductController::class, 'getProductDetails']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::get('get-profile-details', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getProfileDetails']);
        Route::post('update-profile', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'updateProfile']);
        Route::post('add-address', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'addAddress']);
        Route::post('update-address', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'updateAddress']);
        Route::get('get-addresses', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'getAddresses']);
        Route::post('make-default-address', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'makeDefaultAddress']);
        Route::post('remove-address', [\App\Http\Controllers\Api\V1\User\ProfileController::class, 'removeAddress']);
        Route::post('add-to-cart', [\App\Http\Controllers\Api\V1\User\CartController::class, 'addToCart']);
        Route::get('get-carts', [\App\Http\Controllers\Api\V1\User\CartController::class, 'getCarts']);
        Route::post('update-cart-quantity', [\App\Http\Controllers\Api\V1\User\CartController::class, 'updateCartQuantity']);
        Route::post('remove-from-cart', [\App\Http\Controllers\Api\V1\User\CartController::class, 'removeFromCart']);
        Route::post('place-order', [\App\Http\Controllers\Api\V1\User\OrderController::class, 'placeOrder']);
        Route::get('get-orders', [\App\Http\Controllers\Api\V1\User\OrderController::class, 'getOrders']);
        Route::get('get-order-details', [\App\Http\Controllers\Api\V1\User\OrderController::class, 'getOrderDetails']);
        Route::post('cancel-order', [\App\Http\Controllers\Api\V1\User\OrderController::class, 'cancelOrder']);
        Route::post('write-review', [\App\Http\Controllers\Api\V1\User\ProductController::class, 'writeReview']);
        Route::post('add-to-wishlist', [\App\Http\Controllers\Api\V1\User\WishlistController::class, 'addToWishlist']);
        Route::post('remove-from-wishlist', [\App\Http\Controllers\Api\V1\User\WishlistController::class, 'removeFromWishlist']);
        Route::get('get-wishlists', [\App\Http\Controllers\Api\V1\User\WishlistController::class, 'getWishlists']);
        Route::get('get-push-notifications', [\App\Http\Controllers\Api\V1\User\PushNotificationController::class, 'getPushNotifications']);
        Route::get('get-push-notification', [\App\Http\Controllers\Api\V1\User\PushNotificationController::class, 'getPushNotification']);
        Route::post('delete-push-notification', [\App\Http\Controllers\Api\V1\User\PushNotificationController::class, 'deletePushNotification']);
    });
});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Product Categories
    Route::post('product-categories/media', 'ProductCategoryApiController@storeMedia')->name('product-categories.storeMedia');
    Route::apiResource('product-categories', 'ProductCategoryApiController');

    // Product Tags
    Route::apiResource('product-tags', 'ProductTagApiController');

    // Products
    Route::post('products/media', 'ProductApiController@storeMedia')->name('products.storeMedia');
    Route::apiResource('products', 'ProductApiController');

    // Content Categories
    Route::apiResource('content-categories', 'ContentCategoryApiController');

    // Content Tags
    Route::apiResource('content-tags', 'ContentTagApiController');

    // Content Pages
    Route::post('content-pages/media', 'ContentPageApiController@storeMedia')->name('content-pages.storeMedia');
    Route::apiResource('content-pages', 'ContentPageApiController');

    // Faq Categories
    Route::apiResource('faq-categories', 'FaqCategoryApiController');

    // Faq Questions
    Route::apiResource('faq-questions', 'FaqQuestionApiController');

    // Orders
    Route::apiResource('orders', 'OrderApiController');

    // Carts
    Route::apiResource('carts', 'CartApiController');

    // Vendors
    Route::apiResource('vendors', 'VendorApiController');

    // Franchisees
    Route::apiResource('franchisees', 'FranchiseeApiController');

    // Pincodes
    Route::apiResource('pincodes', 'PincodeApiController');

    // States
    Route::apiResource('states', 'StateApiController');

    // Districts
    Route::apiResource('districts', 'DistrictApiController');



    // Blocks
    Route::apiResource('blocks', 'BlockApiController');

    // Areas
    Route::apiResource('areas', 'AreaApiController');

    // Brands
    Route::apiResource('brands', 'BrandApiController');

    // Articles
    Route::post('articles/media', 'ArticleApiController@storeMedia')->name('articles.storeMedia');
    Route::apiResource('articles', 'ArticleApiController');

    // Article Tags
    Route::apiResource('article-tags', 'ArticleTagApiController');

    // Article Comments
    Route::apiResource('article-comments', 'ArticleCommentApiController');

    // Followers
    Route::apiResource('followers', 'FollowerApiController');

    // Article Likes
    Route::apiResource('article-likes', 'ArticleLikeApiController');

    // Logistics
    Route::apiResource('logistics', 'LogisticsApiController');

    // Transactions
    Route::apiResource('transactions', 'TransactionsApiController');

    // User Addresses
    Route::apiResource('user-addresses', 'UserAddressApiController');

    // Settings
    Route::apiResource('settings', 'SettingsApiController');

    // Admins
    Route::apiResource('admins', 'AdminApiController');

    // Cities
    Route::apiResource('cities', 'CityApiController');

    // Help Centers
    Route::apiResource('help-centers', 'HelpCenterApiController');

    // Help Center Profiles
    Route::post('help-center-profiles/media', 'HelpCenterProfileApiController@storeMedia')->name('help-center-profiles.storeMedia');
    Route::apiResource('help-center-profiles', 'HelpCenterProfileApiController');

    // User Profiles
    Route::post('user-profiles/media', 'UserProfileApiController@storeMedia')->name('user-profiles.storeMedia');
    Route::apiResource('user-profiles', 'UserProfileApiController');

    // Crops
    Route::post('crops/media', 'CropApiController@storeMedia')->name('crops.storeMedia');
    Route::apiResource('crops', 'CropApiController');

    // Franchisee Profiles
    Route::post('franchisee-profiles/media', 'FranchiseeProfileApiController@storeMedia')->name('franchisee-profiles.storeMedia');
    Route::apiResource('franchisee-profiles', 'FranchiseeProfileApiController');

    //enquiries

    Route::apiResource('enquiries', 'EnquiryApiController');
});
