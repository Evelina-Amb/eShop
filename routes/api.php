<?php
use App\Http\Controllers\Api\{
    CountryController, CityController, AddressController,
    CategoryController, ListingPhotoController,
    ReviewController, CartController,
    FavoriteController, OrderController, OrderItemController, 
    UserController, ListingController
};
Route::get('/listings/mine', [ListingController::class, 'mine']);
Route::delete('/cart/item', [CartController::class, 'clearItem']);
Route::delete('/cart/clear', [CartController::class, 'clearAll']);

Route::apiResources([
    'country' => CountryController::class,
    'city' => CityController::class,
    'address' => AddressController::class,
    'category' => CategoryController::class,
    'listingPhoto' => ListingPhotoController::class,
    'review' => ReviewController::class,
    'favorite' => FavoriteController::class,
    'order' => OrderController::class,
    'orderItem' => OrderItemController::class,
    'users' => UserController::class,
    'listing'=> ListingController::class,
]);


