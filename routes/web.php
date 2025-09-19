<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\FamilyMemberManageController;
use App\Http\Controllers\FamilyOwnerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VotingCommentController;
use App\Http\Controllers\VotingPoolController;
use App\Http\Middleware\FamilyOwnerMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
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

Route::get('/familyOwner/tasks', [TaskController::class, 'index'])->name('familyOwner.tasks.index');     // DataTable page
Route::get('/familyOwner/tasks/create', [TaskController::class, 'create'])->name('familyOwner.tasks.create');
Route::post('/familyOwner/tasks', [TaskController::class, 'store'])->name('familyOwner.tasks.store');
Route::get('/familyOwner/tasks/{task}', [TaskController::class, 'show'])->name('familyOwner.tasks.show');
Route::get('/familyOwner/tasks/{task}/edit', [TaskController::class, 'edit'])->name('familyOwner.tasks.edit');
Route::post('/familyOwner/tasks/{task}', [TaskController::class, 'update'])->name('familyOwner.tasks.update_task');
Route::delete('/familyOwner/tasks/{task}', [TaskController::class, 'destroy'])->name('familyOwner.tasks.destroy');
Route::post('/tasks/comment/{task}', [TaskController::class, 'comment_store'])->name('familyOwner.tasks.comment.store');

Route::get('/document-requests/all', [DocumentRequestController::class, 'index'])->name('document.requests.all');
Route::get('/document-requests/create', [DocumentRequestController::class, 'create'])->name('document.requests.create');

Route::post('/document-requests', [DocumentRequestController::class, 'storeRequest'])->name('document.requests.store');
Route::get('/document-requests/{documentRequest}', [DocumentRequestController::class, 'show'])->name('document.requests.show');
Route::post('/document-requests/{documentRequest}/submit', [DocumentRequestController::class, 'submitDocument'])->name('document.requests.submit');
Route::get('/document-requests/{documentRequest}/download', [DocumentRequestController::class, 'download'])->name('document.requests.download');
Route::post('/document-requests/{documentRequest}/cancel', [DocumentRequestController::class, 'cancel'])->name('document.requests.cancel');

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

    Route::get('/familyOwner/index', [ReportController::class, 'index'])->name('familyOwner.report.index');

    Route::get('/familyOwner/download_report', [ReportController::class, 'monthly_report'])->name('familyOwner.download_report');

    Route::get('familyOwner/voting', [VotingPoolController::class, 'index'])->name('familyOwner.pools.index');
    Route::get('familyOwner/voting/data', [VotingPoolController::class, 'data'])->name('familyOwner.pools.data');
    Route::get('familyOwner/voting/create', [VotingPoolController::class, 'create'])->name('familyOwner.pools.create');
    Route::post('familyOwner/voting', [VotingPoolController::class, 'store'])->name('familyOwner.pools.store');
    Route::get('familyOwner/voting/{voting}', [VotingPoolController::class, 'show'])->name('familyOwner.pools.show');
    Route::get('familyOwner/voting/{voting}/edit', [VotingPoolController::class, 'edit'])->name('familyOwner.pools.edit');
    Route::put('familyOwner/voting/{voting}', [VotingPoolController::class, 'update'])->name('familyOwner.pools.update');
    Route::delete('familyOwner/voting/{voting}', [VotingPoolController::class, 'destroy'])->name('familyOwner.pools.destroy');
    Route::post('voting/{voting}/vote', [VoteController::class, 'store'])->name('familyOwner.voting.vote');
    Route::post('voting/{voting}/comment', [VotingCommentController::class, 'store'])->name('familyOwner.voting.comment.store');
    Route::post('voting/{voting}/finalize', [VotingPoolController::class, 'finalize'])->name('familyOwner.voting.finalize');

    Route::get('familyOwner/bills', [BillController::class, 'index'])->name('familyOwner.bills.index');
    Route::get('familyOwner/bills/create', [BillController::class, 'create'])->name('familyOwner.bills.create');
    Route::post('familyOwner/bills', [BillController::class, 'store'])->name('familyOwner.bills.store');
    Route::get('familyOwner/bills/{bill}', [BillController::class, 'show'])->name('familyOwner.bills.show');
    Route::get('familyOwner/bills/{bill}/edit', [BillController::class, 'edit'])->name('familyOwner.bills.edit');
    Route::put('familyOwner/bills/{bill}', [BillController::class, 'update'])->name('familyOwner.bills.update');
    Route::delete('familyOwner/bills/{bill}', [BillController::class, 'destroy'])->name('familyOwner.bills.destroy');
    Route::post('familyOwner/bills/{bill}/submit-payment', [BillController::class, 'submitPayment'])->name('familyOwner.bills.submitPayment');
    Route::post('familyOwner/bill-payments/{payment}/review', [BillController::class, 'reviewPayment'])->name('familyOwner.bills.reviewPayment');
    Route::put('familyOwner/bills/{bill}/approve', [BillController::class, 'approve'])->name('familyOwner.bills.approve');
    Route::put('familyOwner/bills/{bill}/decline', [BillController::class, 'decline'])->name('familyOwner.bills.decline');

});
