<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Homepage (Frontend)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/verify-email', function () {
    return view('auth.pending-verification');
})->name('verify.notice');

Route::post('/verify-email/resend', [RegisteredUserController::class, 'resend'])
    ->name('verify.resend');

Route::get('/verify/{token}', [RegisteredUserController::class, 'verify'])
    ->name('verify.complete');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// User profile (requires login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';