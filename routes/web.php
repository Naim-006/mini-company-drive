<?php

use App\Http\Controllers\Admin\CompanySettingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Company Website Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [CompanyController::class, 'home'])->name('home');
Route::get('/about', [CompanyController::class, 'about'])->name('about');
Route::get('/services', [CompanyController::class, 'services'])->name('services');
Route::get('/products', [CompanyController::class, 'products'])->name('products.index');
Route::get('/products/{product}', [CompanyController::class, 'productDetail'])->name('products.show');
Route::get('/contact', [CompanyController::class, 'contact'])->name('contact');
Route::post('/contact', [CompanyController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products CRUD
    Route::resource('products', ProductController::class)->except(['show']);

    // Company Settings
    Route::get('/settings', [CompanySettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [CompanySettingController::class, 'update'])->name('settings.update');

    // Customer Inquiries
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/toggle-read', [ContactMessageController::class, 'toggleRead'])->name('messages.toggle');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
});
