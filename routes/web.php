<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Authentication routes
Route::get('/', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    });
    Route::get('/membership', [MembershipController::class, 'showForm'])->name('membership.form');
    Route::post('/membership', [MembershipController::class, 'submitForm'])->name('membership.submit'); 
    // If you want to handle the initial form submit, create submitForm() method similarly

    Route::get('/membership/reconfirm', [MembershipController::class, 'showForm'])->name('membership.form');
    Route::post('/membership/reconfirm', [MembershipController::class, 'submitReconfirmation'])->name('membership.reconfirm.submit');
    Route::get('/membership/thankyou', [MembershipController::class, 'thankyou'])->name('membership.thankyou');
});
