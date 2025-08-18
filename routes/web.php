<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\FileViewController;

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

    // User profile routes
    Route::get('/profile', [UserController::class, 'profile'])
    ->name('profile');


    // Membership main form routes
    Route::get('/membership/form', [MembershipController::class, 'showForm'])->name('membership.form');
    Route::post('/membership/form', [MembershipController::class, 'submitReconfirmation'])->name('membership.submit'); 

    // Membership application upload routes
    Route::get('/membership/formUpload', [MembershipApplicationController::class, 'showForm'])->name('membership.formUpload');
    Route::post('/membership/formUpload', [MembershipApplicationController::class, 'submit'])->name('membership.submitUpload');
    Route::get('/membership/formUpload/{id}', [MembershipApplicationController::class, 'showForm'])->name('membership.formUpload.id');

    // Membership reconfirmation routes (if different from main form)
    Route::get('/membership/reconfirm', [MembershipController::class, 'showFormReconfirm'])->name('membership.reconfirm.form');
    Route::post('/membership/reconfirm', [MembershipController::class, 'submitReconfirmation'])->name('membership.reconfirm.submit');
    
    // Thank you page
    Route::get('/membership/thankyou', [MembershipController::class, 'thankyou'])->name('membership.thankyou');

    // Membership management routes
    Route::get('/admin/show/{id}', [AdminController::class, 'show'])->name('admin.show');

    // Membership export routes
    Route::get('/admin/export/excel', [MembershipController::class, 'exportExcel'])->name('memberships.exportExcel');
    Route::get('/admin/export/pdf', [MembershipController::class, 'exportPDF'])->name('memberships.exportPDF');
    Route::get('/admin/export/word', [MembershipController::class, 'exportWord'])->name('memberships.exportWord');
    Route::get('/file-view/{path}', [FileViewController::class, 'viewFile'])
    ->where('path', '.*')
    ->name('file.view');

});

