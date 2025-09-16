<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FamilyMemberManageController;
use App\Http\Controllers\FamilyOwnerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\CaregiverMiddleware;
use App\Http\Middleware\FamilyMemberMiddleware;
use App\Http\Middleware\FamilyOwnerMiddleware;
use App\Http\Middleware\SeniorMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
//     Route::get('/check_role', [HomeController::class, 'check_role'])->name('check_role');

// Route::middleware('guest')->group(function () {

Route::get('/check_role', [HomeController::class, 'check_role'])->name('check_role');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/register', [RegisterController::class, 'register'])->name('register');
// Route::get('/login', [LoginController::class, 'login'])->name('login');
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(SuperAdminMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.index');
});

Route::middleware([FamilyOwnerMiddleware::class])->group(function () {
    Route::get('/familyOwner/dashboard', [FamilyOwnerController::class, 'index'])->name('familyOwner.index');
    Route::get('/familyOwner/all-members', [FamilyMemberManageController::class, 'index'])->name('familyOwner.all_members');
    Route::get('/familyOwner/create-member', [FamilyMemberManageController::class, 'add_member'])->name('familyOwner.add_member');
    Route::post('/familyOwner/save-member', [FamilyMemberManageController::class, 'save_member'])->name('familyOwner.save_member');
    Route::get('/familyOwner/edit-member/{id}', [FamilyMemberManageController::class, 'edit_member'])->name('familyOwner.edit_member');
    Route::post('/familyOwner/update-member/{id}', [FamilyMemberManageController::class, 'update_member'])->name('familyOwner.update_member');
    Route::get('/familyOwner/delete-member/{id}', [FamilyMemberManageController::class, 'delete_member'])->name('familyOwner.delete_member');
    Route::get('/familyOwner/activate-member/{id}', [FamilyMemberManageController::class, 'active_member'])->name('familyOwner.active_member');


    Route::get('/familyOwner/action-logs', [LogController::class, 'logs'])->name('familyOwner.logs');

    Route::get('/familyOwner/tasks', [TaskController::class, 'index'])->name('familyOwner.tasks.index');     // DataTable page
    Route::get('/familyOwner/tasks/create', [TaskController::class, 'create'])->name('familyOwner.tasks.create');
    Route::post('/familyOwner/tasks', [TaskController::class, 'store'])->name('familyOwner.tasks.store');
    Route::get('/familyOwner/tasks/{task}', [TaskController::class, 'show'])->name('familyOwner.tasks.show');
    Route::get('/familyOwner/tasks/{task}/edit', [TaskController::class, 'edit'])->name('familyOwner.tasks.edit');
    Route::post('/familyOwner/tasks/{task}', [TaskController::class, 'update'])->name('familyOwner.tasks.update_task');
    Route::delete('/familyOwner/tasks/{task}', [TaskController::class, 'destroy'])->name('familyOwner.tasks.destroy');

    Route::post('/tasks/comment/{task}', [TaskController::class, 'comment_store'])->name('familyOwner.tasks.comment.store');

});
