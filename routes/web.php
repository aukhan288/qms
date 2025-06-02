<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\NewsletterController;
use App\Http\Controllers\admin\TemplateController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DocumentController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/documents/{category}', [DocumentController::class, 'documents'])->name('documents');




Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/download-file',[TemplateController::class, 'downloadFile'])->name('download-file');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // This route is only accessible by authenticated organizations with the 'admin' role
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/organizations', [UserController::class, 'index']);
    Route::get('/organizations/list', [UserController::class, 'organizationsList'])->name('organizations.list');
    Route::post('/organizations/store', [UserController::class, 'store'])->name('organizations.store');   
    
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::get('/newsletters/list', [NewsletterController::class, 'newslettersList'])->name('admin.newsletters.list');
    Route::post('/newsletters-create', [NewsletterController::class, 'create'])->name('admin.newsletter.create');
    
    Route::get('/templates', [TemplateController::class, 'index']);
    Route::get('/templates/list', [TemplateController::class, 'templatesList'])->name('templates.list');
    Route::get('/template/{id?}', [TemplateController::class, 'showTemplateForm'])->name('template');
    Route::post('/template-create/{id?}', [TemplateController::class, 'create'])->name('template.create');
});