<?php
use App\Http\Controllers\Api\{
    CountryController, CityController, AddressController,
    CategoryController, ListingPhotoController,
    ReviewController, CartController,
    FavoriteController, OrderController, OrderItemController, 
    UserController, ListingController
};

Route::apiResources([
    'salis' => CountryController::class,
    'miestai' => CityController::class,
    'adresai' => AddressController::class,
    'kategorijos' => CategoryController::class,
    'nuotraukos' => ListingPhotoController::class,
    'atsiliepimai' => ReviewController::class,
    'krepselis' => CartController::class,
    'isiminti' => FavoriteController::class,
    'pirkimai' => OrderController::class,
    'pirkimo-prekes' => OrderItemController::class,
    'users' => UserController::class,
    'skelbimai'=> ListingController::class,
]);
