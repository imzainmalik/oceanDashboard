<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CareGiverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Middleware\FamilyMemberMiddleware;
use App\Http\Middleware\FamilyOwnerMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
//     Route::get('/check_role', [HomeController::class, 'check_role'])->name('check_role');

// Route::withoutMiddleware([SuperAdminController::class])->group(function () {
    Route::get('/check_role', [HomeController::class, 'check_role'])->name('check_role');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(SuperAdminMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', [SuperAdminController::class, 'index'])->name('superAdmin.index');
});

Route::middleware(['caregiver'])->group(function () {
    Route::get('/caregiver/dashboard', [CareGiverController::class, 'index'])->name('careGiver.index');
});