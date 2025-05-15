<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\user\HomeController;
use Laravel\Fortify\Fortify;



Route::get('/login', function () {
    return view('auth.login'); // Default login view for users
})->name('login');

// Admin login route
Route::get('/admin/login', function () {
    return view('auth.admin-login'); // Admin-specific login view
})->name('admin.login');

Route::middleware(['auth'])->group(function () {
    Route::get('/',[HomeController::class, 'home'])->name('home');
});



Route::middleware(['auth'])->prefix('admin')->group(function () {
    // This route is only accessible by authenticated organizations with the 'admin' role
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/organizations', [UserController::class, 'index']);
    Route::get('/organizations/list', [UserController::class, 'organizationsList'])->name('organizations.list');
    Route::post('/organizations/store', [UserController::class, 'store'])->name('organizations.store');   
    
    Route::get('/templates', [TemplateController::class, 'index']);
    Route::post('/templates-create', [TemplateController::class, 'create'])->name('template.create');
});
