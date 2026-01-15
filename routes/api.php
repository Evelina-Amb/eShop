<?php
use App\Http\Controllers\Api\{
    CountryController, CityController, AddressController,
    CategoryController, ListingPhotoController,
    ReviewController, CartController,
    FavoriteController, OrderController, OrderItemController, 
    UserController, ListingController, AuthController

};
use App\Models\City;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/listings/mine', [ListingController::class, 'mine']);
Route::delete('/cart/item', [CartController::class, 'clearItem']);
Route::delete('/cart/clear', [CartController::class, 'clearAll']);

Route::post('/users/{id}/ban', [UserController::class, 'ban']);
Route::post('/users/{id}/unban', [UserController::class, 'unban']);
Route::post('/users/{id}/ban', [UserController::class, 'ban'])->middleware('admin');
Route::post('/users/{id}/unban', [UserController::class, 'unban'])->middleware('admin');

Route::get('/favorites/ids', function () {
    return auth()->user()->favorites()->pluck('listing_id');});

    Route::get('/favorites/my', function () {
        return auth()->user()
            ->favoriteListings()
            ->with(['photos', 'category', 'user'])
            ->get();
    });

    Route::post('/favorite', [FavoriteController::class, 'store']);
    Route::delete('/favorite/{listingId}', [FavoriteController::class, 'destroyByListing']);

Route::apiResources([
    'country' => CountryController::class,
    'city' => CityController::class,
    'address' => AddressController::class,
    'category' => CategoryController::class,
    'listingPhoto' => ListingPhotoController::class,
    'review' => ReviewController::class,
    'cart' => CartController::class,
    'order' => OrderController::class,
    'orderItem' => OrderItemController::class,
    'users' => UserController::class,
    'listing'=> ListingController::class,
]);
});

Route::get('/listings/search', [ListingController::class, 'search']);

Route::get('/cities/by-country/{country_id}', function ($countryId) {
    return City::where('country_id', $countryId)->get(['id', 'pavadinimas']);
});

Route::apiResources([
    'country' => CountryController::class,
    'city' => CityController::class,
    'category' => CategoryController::class,
]);


