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
Route::get('/listings/search', [ListingController::class, 'search']);
Route::post('/users/{id}/ban', [UserController::class, 'ban']);
Route::post('/users/{id}/unban', [UserController::class, 'unban']);
Route::post('/users/{id}/ban', [UserController::class, 'ban'])->middleware('admin');
Route::post('/users/{id}/unban', [UserController::class, 'unban'])->middleware('admin');

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


