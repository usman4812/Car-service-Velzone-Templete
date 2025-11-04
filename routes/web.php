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
        Route::get('job-card', [JobCardController::class, 'index'])->name('job-card.index');
        Route::get('job-card/create', [JobCardController::class, 'create'])->middleware('permission:create-job-card')->name('job-card.create');
        Route::post('job-card', [JobCardController::class, 'store'])->middleware('permission:create-job-card')->name('job-card.store');
        Route::get('job-card/{id}', [JobCardController::class, 'show'])->name('job-card.show');
        Route::get('job-card/{id}/edit', [JobCardController::class, 'edit'])->middleware('permission:edit-job-card')->name('job-card.edit');
        Route::put('job-card/{id}', [JobCardController::class, 'update'])->middleware('permission:edit-job-card')->name('job-card.update');
        Route::delete('job-card/{id}', [JobCardController::class, 'destroy'])->middleware('permission:delete-job-card')->name('job-card.destroy');
        Route::get('job-card/{id}/replacement', [JobCardController::class, 'replacement'])->middleware('permission:edit-job-card')->name('job-card.replacement');
        Route::put('job-card/{id}/replacement', [JobCardController::class, 'updateReplacement'])->middleware('permission:edit-job-card')->name('job-card.updateReplacement');
        Route::get('job-card/{id}/invoice', [JobCardController::class, 'showInvoice'])->middleware('permission:view-job-card-invoice')->name('job-card.invoice');
    });

    // Customer Routes
    Route::middleware('permission:view-customer')->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/create', [CustomerController::class, 'create'])->middleware('permission:create-customer')->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->middleware('permission:create-customer')->name('customers.store');
        Route::get('customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->middleware('permission:edit-customer')->name('customers.edit');
        Route::put('customers/{id}', [CustomerController::class, 'update'])->middleware('permission:edit-customer')->name('customers.update');
        Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->middleware('permission:delete-customer')->name('customers.destroy');
    });

    // Category Routes
    Route::middleware('permission:view-category')->group(function () {
        Route::get('categories', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoriesController::class, 'create'])->middleware('permission:create-category')->name('categories.create');
        Route::post('categories', [CategoriesController::class, 'store'])->middleware('permission:create-category')->name('categories.store');
        Route::get('categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');
        Route::get('categories/{id}/edit', [CategoriesController::class, 'edit'])->middleware('permission:edit-category')->name('categories.edit');
        Route::put('categories/{id}', [CategoriesController::class, 'update'])->middleware('permission:edit-category')->name('categories.update');
        Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->middleware('permission:delete-category')->name('categories.destroy');
    });

    // Sub Category Routes
    Route::middleware('permission:view-sub-category')->group(function () {
        Route::get('sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('sub-categories/create', [SubCategoryController::class, 'create'])->middleware('permission:create-sub-category')->name('sub-categories.create');
        Route::post('sub-categories', [SubCategoryController::class, 'store'])->middleware('permission:create-sub-category')->name('sub-categories.store');
        Route::get('sub-categories/{id}', [SubCategoryController::class, 'show'])->name('sub-categories.show');
        Route::get('sub-categories/{id}/edit', [SubCategoryController::class, 'edit'])->middleware('permission:edit-sub-category')->name('sub-categories.edit');
        Route::put('sub-categories/{id}', [SubCategoryController::class, 'update'])->middleware('permission:edit-sub-category')->name('sub-categories.update');
        Route::delete('sub-categories/{id}', [SubCategoryController::class, 'destroy'])->middleware('permission:delete-sub-category')->name('sub-categories.destroy');
    });

    // Car Manufacture Routes
    Route::middleware('permission:view-car-manufacture')->group(function () {
        Route::get('car-manufactures', [CarManufacturesController::class, 'index'])->name('car-manufactures.index');
        Route::get('car-manufactures/create', [CarManufacturesController::class, 'create'])->middleware('permission:create-car-manufacture')->name('car-manufactures.create');
        Route::post('car-manufactures', [CarManufacturesController::class, 'store'])->middleware('permission:create-car-manufacture')->name('car-manufactures.store');
        Route::get('car-manufactures/{id}', [CarManufacturesController::class, 'show'])->name('car-manufactures.show');
        Route::get('car-manufactures/{id}/edit', [CarManufacturesController::class, 'edit'])->middleware('permission:edit-car-manufacture')->name('car-manufactures.edit');
        Route::put('car-manufactures/{id}', [CarManufacturesController::class, 'update'])->middleware('permission:edit-car-manufacture')->name('car-manufactures.update');
        Route::delete('car-manufactures/{id}', [CarManufacturesController::class, 'destroy'])->middleware('permission:delete-car-manufacture')->name('car-manufactures.destroy');
    });

    // Blog Routes
    Route::middleware('permission:view-blog')->group(function () {
        Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('blog/create', [BlogController::class, 'create'])->middleware('permission:create-blog')->name('blog.create');
        Route::post('blog', [BlogController::class, 'store'])->middleware('permission:create-blog')->name('blog.store');
        Route::get('blog/{id}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->middleware('permission:edit-blog')->name('blog.edit');
        Route::put('blog/{id}', [BlogController::class, 'update'])->middleware('permission:edit-blog')->name('blog.update');
        Route::delete('blog/{id}', [BlogController::class, 'destroy'])->middleware('permission:delete-blog')->name('blog.destroy');
    });

    // Product Routes
    Route::middleware('permission:view-product')->group(function () {
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [ProductController::class, 'create'])->middleware('permission:create-product')->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->middleware('permission:create-product')->name('products.store');
        Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->middleware('permission:edit-product')->name('products.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->middleware('permission:edit-product')->name('products.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware('permission:delete-product')->name('products.destroy');
    });

    // Report Routes
    Route::resource('reports', ReportController::class)->middleware('permission:view-report');

    // User Management Routes
    Route::middleware('permission:view-user')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Role Routes
    Route::middleware('permission:view-role')->group(function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->middleware('permission:create-role')->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->middleware('permission:create-role')->name('roles.store');
        Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:edit-role')->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->middleware('permission:edit-role')->name('roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete-role')->name('roles.destroy');
    });

    Route::middleware('permission:view-permission')->group(function () {
        Route::resource('permissions', PermissionController::class);
    });

    // Replacement Routes
    Route::resource('replacements', ReplacementController::class)->middleware('permission:view-replacement');

    // Contact Routes
    Route::resource('contacts', ContactsController::class)->middleware('permission:view-contact');

    // Service Routes
    Route::middleware('permission:view-service')->group(function () {
        Route::get('services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('services/create', [ServiceController::class, 'create'])->middleware('permission:create-service')->name('services.create');
        Route::post('services', [ServiceController::class, 'store'])->middleware('permission:create-service')->name('services.store');
        Route::get('services/{id}', [ServiceController::class, 'show'])->name('services.show');
        Route::get('services/{id}/edit', [ServiceController::class, 'edit'])->middleware('permission:edit-service')->name('services.edit');
        Route::put('services/{id}', [ServiceController::class, 'update'])->middleware('permission:edit-service')->name('services.update');
        Route::delete('services/{id}', [ServiceController::class, 'destroy'])->middleware('permission:delete-service')->name('services.destroy');
    });

    // Sales Person Routes
    Route::middleware('permission:view-sales-person')->group(function () {
        Route::get('sales-persons', [SalePersonController::class, 'index'])->name('sales-persons.index');
        Route::get('sales-persons/create', [SalePersonController::class, 'create'])->middleware('permission:create-sales-person')->name('sales-persons.create');
        Route::post('sales-persons', [SalePersonController::class, 'store'])->middleware('permission:create-sales-person')->name('sales-persons.store');
        Route::get('sales-persons/{id}', [SalePersonController::class, 'show'])->name('sales-persons.show');
        Route::get('sales-persons/{id}/edit', [SalePersonController::class, 'edit'])->middleware('permission:edit-sales-person')->name('sales-persons.edit');
        Route::put('sales-persons/{id}', [SalePersonController::class, 'update'])->middleware('permission:edit-sales-person')->name('sales-persons.update');
        Route::delete('sales-persons/{id}', [SalePersonController::class, 'destroy'])->middleware('permission:delete-sales-person')->name('sales-persons.destroy');
    });

    // Blog Routes
    Route::middleware('permission:view-blog')->group(function () {
        Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('blog/create', [BlogController::class, 'create'])->middleware('permission:create-blog')->name('blog.create');
        Route::post('blog', [BlogController::class, 'store'])->middleware('permission:create-blog')->name('blog.store');
        Route::get('blog/{id}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->middleware('permission:edit-blog')->name('blog.edit');
        Route::put('blog/{id}', [BlogController::class, 'update'])->middleware('permission:edit-blog')->name('blog.update');
        Route::delete('blog/{id}', [BlogController::class, 'destroy'])->middleware('permission:delete-blog')->name('blog.destroy');
    });

    // Worker Routes
    Route::middleware('permission:view-worker')->group(function () {
        Route::get('workers', [WorkerController::class, 'index'])->name('workers.index');
        Route::get('workers/create', [WorkerController::class, 'create'])->middleware('permission:create-worker')->name('workers.create');
        Route::post('workers', [WorkerController::class, 'store'])->middleware('permission:create-worker')->name('workers.store');
        Route::get('workers/{id}', [WorkerController::class, 'show'])->name('workers.show');
        Route::get('workers/{id}/edit', [WorkerController::class, 'edit'])->middleware('permission:edit-worker')->name('workers.edit');
        Route::put('workers/{id}', [WorkerController::class, 'update'])->middleware('permission:edit-worker')->name('workers.update');
        Route::delete('workers/{id}', [WorkerController::class, 'destroy'])->middleware('permission:delete-worker')->name('workers.destroy');
    });

    // Works Routes
    Route::middleware('permission:view-work')->group(function () {
        Route::get('works', [WorksController::class, 'index'])->name('works.index');
        Route::get('works/create', [WorksController::class, 'create'])->middleware('permission:create-work')->name('works.create');
        Route::post('works', [WorksController::class, 'store'])->middleware('permission:create-work')->name('works.store');
        Route::get('works/{id}', [WorksController::class, 'show'])->name('works.show');
        Route::get('works/{id}/edit', [WorksController::class, 'edit'])->middleware('permission:edit-work')->name('works.edit');
        Route::put('works/{id}', [WorksController::class, 'update'])->middleware('permission:edit-work')->name('works.update');
        Route::delete('works/{id}', [WorksController::class, 'destroy'])->middleware('permission:delete-work')->name('works.destroy');
    });

    // Making Quotation Routes
    Route::middleware('permission:view-making-quotation')->group(function () {
        Route::get('making-quotation', [MakingQuotationController::class, 'index'])->name('making-quotation.index');
        Route::get('making-quotation/create', [MakingQuotationController::class, 'create'])->middleware('permission:create-making-quotation')->name('making-quotation.create');
        Route::post('making-quotation', [MakingQuotationController::class, 'store'])->middleware('permission:create-making-quotation')->name('making-quotation.store');
        Route::get('making-quotation/{id}', [MakingQuotationController::class, 'show'])->name('making-quotation.show');
        Route::get('making-quotation/{id}/edit', [MakingQuotationController::class, 'edit'])->middleware('permission:edit-making-quotation')->name('making-quotation.edit');
        Route::put('making-quotation/{id}', [MakingQuotationController::class, 'update'])->middleware('permission:edit-making-quotation')->name('making-quotation.update');
        Route::delete('making-quotation/{id}', [MakingQuotationController::class, 'destroy'])->middleware('permission:delete-making-quotation')->name('making-quotation.destroy');
    });

    // Ajax Routes (these don't need permission checks as they're helper endpoints)
    Route::get('/get-subcategories/{category_id}', [AjaxController::class, 'getSubCategories'])->name('get.subcategories');
    Route::get('/get-products/{subcategory_id}', [AjaxController::class, 'getProducts'])->name('get.products');
    Route::get('/get-product-price/{product_id}', [AjaxController::class, 'getProductPrice'])->name('get.procuct.price');
    Route::get('/get-new-item-row', [AjaxController::class, 'getNewItemRow'])->name('get.new.item.row');
    Route::get('/get-customer-details/{id}', [CustomerController::class, 'getCustomerDetails'])->name('get.customer.details');
});
