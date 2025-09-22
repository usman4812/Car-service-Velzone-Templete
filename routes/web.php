<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

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

    // Manager dashboard
    Route::get('manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');

    // User dashboard
    Route::get('user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
