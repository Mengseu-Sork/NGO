<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembershipApplicationController;

// Authentication routes
Route::get('/', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {

    // Admin routes (just examples)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    });

    // Membership main form routes
    Route::get('/membership/form', [MembershipController::class, 'showForm'])->name('membership.form');
    Route::post('/membership/form', [MembershipController::class, 'submitReconfirmation'])->name('membership.submit'); 

    // Membership application upload routes
    Route::get('/membership/formUpload', [MembershipApplicationController::class, 'showForm'])->name('membership.formUpload');
    Route::post('/membership/formUpload', [MembershipApplicationController::class, 'submit'])->name('membership.submitUpload');

    // Membership reconfirmation routes (if different from main form)
    Route::get('/membership/reconfirm', [MembershipController::class, 'showFormReconfirm'])->name('membership.reconfirm.form');
    Route::post('/membership/reconfirm', [MembershipController::class, 'submitReconfirmation'])->name('membership.reconfirm.submit');
    
    // Thank you page
    Route::get('/membership/thankyou', [MembershipController::class, 'thankyou'])->name('membership.thankyou');
});

