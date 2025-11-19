<?php
use App\Http\Controllers\Api\{
    CountryController, CityController, AddressController,
    CategoryController, ListingPhotoController,
    ReviewController, CartController,
    FavoriteController, OrderController, OrderItemController, 
    UserController, ListingController
};

Route::apiResources([
    'country' => CountryController::class,
    'city' => CityController::class,
    'address' => AddressController::class,
    'category' => CategoryController::class,
    'listingPhoto' => ListingPhotoController::class,
    'review' => ReviewController::class,
    'cart' => CartController::class,
    'favorite' => FavoriteController::class,
    'order' => OrderController::class,
    'orderItem' => OrderItemController::class,
    'users' => UserController::class,
    'listing'=> ListingController::class,
]);
