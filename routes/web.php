<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
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
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SalePersonController;
use App\Http\Controllers\Admin\ReplacementController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\CarManufacturesController;
use App\Http\Controllers\Admin\MakingQuotationController;

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
    // Dashboard Routes
    Route::middleware('permission:view-dashboard')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');
        Route::get('user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Job Card Routes
    Route::middleware('permission:view-job-card')->group(function () {
        Route::resource('job-card', JobCardController::class);
        Route::get('job-card/{id}/replacement', [JobCardController::class, 'replacement'])->name('job-card.replacement');
        Route::put('job-card/{id}/replacement', [JobCardController::class, 'updateReplacement'])->name('job-card.updateReplacement');
        Route::get('job-card/{id}/invoice', [JobCardController::class, 'showInvoice'])->middleware('permission:view-job-card-invoice')->name('job-card.invoice');
    });

    // Customer Routes
    Route::resource('customers', CustomerController::class)->middleware('permission:view-customer');

    // Category Routes
    Route::middleware('permission:view-category')->group(function () {
        Route::resource('categories', CategoriesController::class);
    });

    // Sub Category Routes
    Route::middleware('permission:view-sub-category')->group(function () {
        Route::resource('sub-categories', SubCategoryController::class);
    });

    // Car Manufacture Routes
    Route::resource('car-manufactures', CarManufacturesController::class)->middleware('permission:view-car-manufacture');

    // Blog Routes
    Route::resource('blog', BlogController::class)->middleware('permission:view-blog');

    // Product Routes
    Route::resource('products', ProductController::class)->middleware('permission:view-product');

    // Report Routes
    Route::resource('reports', ReportController::class)->middleware('permission:view-report');

    // User Management Routes
    Route::middleware('permission:view-user')->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware('permission:view-role')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    Route::middleware('permission:view-permission')->group(function () {
        Route::resource('permissions', PermissionController::class);
    });

    // Replacement Routes
    Route::resource('replacements', ReplacementController::class)->middleware('permission:view-replacement');

    // Contact Routes
    Route::resource('contacts', ContactsController::class)->middleware('permission:view-contact');

    // Service Routes
    Route::resource('services', ServiceController::class)->middleware('permission:view-service');

    // Worker Routes
    Route::resource('workers', WorkerController::class)->middleware('permission:view-worker');

    // Work Routes
    Route::resource('works', WorksController::class)->middleware('permission:view-work');

    // Sales Person Routes
    Route::resource('sales-persons', SalePersonController::class)->middleware('permission:view-sales-person');
    // Making Quotation Routes
    Route::resource('making-quotation', MakingQuotationController::class)->middleware('permission:view-making-quotation');

    // Ajax Routes (these don't need permission checks as they're helper endpoints)
    Route::get('/get-subcategories/{category_id}', [AjaxController::class, 'getSubCategories'])->name('get.subcategories');
    Route::get('/get-products/{subcategory_id}', [AjaxController::class, 'getProducts'])->name('get.products');
    Route::get('/get-product-price/{product_id}', [AjaxController::class, 'getProductPrice'])->name('get.procuct.price');
    Route::get('/get-new-item-row', [AjaxController::class, 'getNewItemRow'])->name('get.new.item.row');
    Route::get('/get-customer-details/{id}', [CustomerController::class, 'getCustomerDetails'])->name('get.customer.details');
});
