<?php

use App\Http\Controllers\Admin\AjaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\WorksController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\JobCardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\SalePersonController;
use App\Http\Controllers\Admin\ReplacementController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\CarManufacturesController;

// Route::get('/', function () {
//     return view('pages.dashboard');
// });
// Route::get('/', function () {
//     return redirect()->route('admin.login');
// });
// Route::any('login', [AuthController::class, 'login'])->name('admin.login');


// Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
// });

Route::middleware('auth')->group(function () {
   Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('sales-persons',SalePersonController::class);

    // Manager dashboard
    Route::get('manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');

    // User dashboard
    Route::get('user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('job-card',JobCardController::class);
    Route::resource('customers',CustomerController::class);
    Route::resource('categories',CategoriesController::class);
    Route::resource('sub-categories',SubCategoryController::class);
    Route::resource('car-manufactures',CarManufacturesController::class);
    Route::resource('blog',BlogController::class);
    Route::resource('products',ProductController::class);
    Route::resource('Report',ReportController::class);
    Route::resource('replacement',ReplacementController::class);
    Route::resource('contacts',ContactsController::class);
    Route::resource('services',ServiceController::class);
    Route::resource('workers',WorkerController::class);
    Route::resource('works',WorksController::class);

    Route::get('/get-subcategories/{category_id}', [AjaxController::class, 'getSubCategories'])->name('get.subcategories');

});
