<?php

// use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CareGiverController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\DailyUpdateController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\FamilyMemberManageController;
use App\Http\Controllers\FamilyNoteController;
use App\Http\Controllers\FamilyOwnerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SeniorController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\VoiceJournalController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VotingCommentController;
use App\Http\Controllers\VotingPoolController;
use App\Http\Middleware\CaregiverMiddleware;
use App\Http\Middleware\FamilyMemberMiddleware;
use App\Http\Middleware\FamilyOwnerMiddleware;
use App\Http\Middleware\SeniorMiddleware;
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
Route::get('subscription/packages', [SubscriptionController::class, 'packages'])->name('subscription.packages');
Route::get('subscription/payment', [SubscriptionController::class, 'payment'])->name('subscription.payment');
Route::post('subscription/payment/store', [SubscriptionController::class, 'store'])->name('subscription.payment.store');

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

Route::get('/document/requests/all', [DocumentRequestController::class, 'index'])->name('document.requests.all');
Route::get('/document/requests/create', [DocumentRequestController::class, 'create'])->name('document.requests.create');

Route::post('/document/requests', [DocumentRequestController::class, 'storeRequest'])->name('document.requests.store');
Route::get('/document/requests/{documentRequest}', [DocumentRequestController::class, 'show'])->name('document.requests.show');
Route::post('/document/requests/{documentRequest}/submit', [DocumentRequestController::class, 'submitDocument'])->name('document.requests.submit');
Route::get('/document/requests/{documentRequest}/download', [DocumentRequestController::class, 'download'])->name('document.requests.download');
Route::post('/document/requests/{documentRequest}/cancel', [DocumentRequestController::class, 'cancel'])->name('document.requests.cancel');



Route::get('/message/inbox', [MessageController::class, 'index'])->name('message.index');
Route::get('/message/create_chatroom', [MessageController::class, 'create_chat_room'])->name('message.create_chat_room');
Route::get('/message/family-chat/{room_id}', [MessageController::class, 'family_chat'])->name('message.family_chat');

Route::middleware(SuperAdminMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.index');
});


Route::middleware(CaregiverMiddleware::class)->group(function () {
    Route::get('/caregiver/dashboard', [CareGiverController::class, 'index'])->name('careGiver.index');
    Route::get('/caregiver/daily-updates', [DailyUpdateController::class, 'index'])->name('careGiver.daily-updates.index');
    Route::get('/caregiver/tasks', [TaskController::class, 'index'])->name('careGiver.tasks.index');     // DataTable page
    Route::get('caregiver/family-notes', [FamilyNoteController::class, 'index'])->name('careGiver.family-notes.index');
    Route::get('caregiver/document-requests/all', [DocumentRequestController::class, 'index'])->name('careGiver.document.requests.all');

    Route::get('careGiver/family-notes/create', [FamilyNoteController::class, 'create'])->name('careGiver.family-notes.create');
    Route::post('careGiver/family-notes/store', [FamilyNoteController::class, 'store'])->name('careGiver.family-notes.store');
    Route::get('careGiver/family-notes/{familyNote}', [FamilyNoteController::class, 'show'])->name('careGiver.family-notes.show');
    Route::get('careGiver/family-notes/{familyNote}/edit', [FamilyNoteController::class, 'edit'])->name('careGiver.family-notes.edit');
    Route::post('careGiver/family-notes/{familyNote}/update', [FamilyNoteController::class, 'update'])->name('careGiver.family-notes.update');
    Route::delete('careGiver/family-notes/{familyNote}/delete', [FamilyNoteController::class, 'destroy'])->name('careGiver.family-notes.destroy');


    Route::get('careGiver/bills/index', [BillController::class, 'index'])->name('careGiver.bills.index');
    Route::get('careGiver/bills/create', [BillController::class, 'create'])->name('careGiver.bills.create');
    Route::post('careGiver/bills', [BillController::class, 'store'])->name('careGiver.bills.store');
    Route::get('careGiver/bills/{bill}', [BillController::class, 'show'])->name('careGiver.bills.show');
    Route::get('careGiver/bills/{bill}/edit', [BillController::class, 'edit'])->name('careGiver.bills.edit');
    Route::put('careGiver/bills/{bill}', [BillController::class, 'update'])->name('careGiver.bills.update');
    Route::delete('careGiver/bills/{bill}', [BillController::class, 'destroy'])->name('careGiver.bills.destroy');
    Route::post('careGiver/bills/{bill}/submit-payment', [BillController::class, 'submitPayment'])->name('careGiver.bills.submitPayment');
    Route::post('careGiver/bill-payments/{payment}/review', [BillController::class, 'reviewPayment'])->name('careGiver.bills.reviewPayment');


    Route::get('careGiver/contribution/index', [ContributionController::class, 'index'])->name('careGiver.contribution.index');
    Route::get('careGiver/contribution/create', [ContributionController::class, 'create'])->name('careGiver.contribution.create');
    Route::post('careGiver/contribution/create', [ContributionController::class, 'store'])->name('careGiver.contribution.store');
    Route::get('careGiver/contribution/{contribution}', [ContributionController::class, 'show'])->name('careGiver.contribution.show');
    Route::get('careGiver/contribution/{contribution}/edit', [ContributionController::class, 'edit'])->name('careGiver.contribution.edit');
    Route::put('careGiver/contribution/{contribution}', [ContributionController::class, 'update'])->name('careGiver.contribution.update');
    Route::delete('careGiver/contribution/{contribution}', [ContributionController::class, 'destroy'])->name('careGiver.contribution.destroy');

    Route::get('careGiver/reimbursment/index', [ReimbursementController::class, 'index'])->name('careGiver.reimbursment.index');
    Route::get('careGiver/reimbursment/create', [ReimbursementController::class, 'create'])->name('careGiver.reimbursment.create');
    Route::post('careGiver/reimbursment/store', [ReimbursementController::class, 'store'])->name('careGiver.reimbursment.store');
    Route::get('careGiver/reimbursment/{reimbursement}', [ReimbursementController::class, 'show'])->name('careGiver.reimbursment.show');
    Route::get('careGiver/reimbursment/{reimbursement}/edit', [ReimbursementController::class, 'edit'])->name('careGiver.reimbursment.edit');
    Route::put('careGiver/reimbursment/{reimbursement}', [ReimbursementController::class, 'update'])->name('careGiver.reimbursment.update');
    Route::delete('careGiver/reimbursment/{reimbursement}', [ReimbursementController::class, 'destroy'])->name('careGiver.reimbursment.destroy');


    Route::get('careGiver/voting', [VotingPoolController::class, 'index'])->name('careGiver.pools.index');
    Route::get('careGiver/voting/data', [VotingPoolController::class, 'data'])->name('careGiver.pools.data');
    Route::get('careGiver/voting/{voting}', [VotingPoolController::class, 'show'])->name('careGiver.pools.show');
    Route::put('careGiver/voting/{voting}', [VotingPoolController::class, 'update'])->name('careGiver.pools.update');
    Route::post('careGiver/voting/{voting}/comment', [VotingCommentController::class, 'store'])->name('careGiver.voting.comment.store');
    Route::post('careGiver/voting/{voting}/vote', [VoteController::class, 'store'])->name('careGiver.voting.vote');
});


Route::middleware(FamilyMemberMiddleware::class)->group(function () {

    Route::get('familyMember/meetings', [MeetingController::class, 'index'])->name('familyMember.meetings.index');
    Route::get('familyMember/meetings/create', [MeetingController::class, 'create'])->name('familyMember.meetings.create');
    Route::post('familyMember/meetings/store', [MeetingController::class, 'store'])->name('familyMember.meetings.store');
    Route::get('familyMember/meetings/{meeting}', [MeetingController::class, 'show'])->name('familyMember.meetings.show');
    Route::get('familyMember/meetings/{meeting}/edit', [MeetingController::class, 'edit'])->name('familyMember.meetings.edit');
    Route::put('familyMember/meetings/{meeting}', [MeetingController::class, 'update'])->name('familyMember.meetings.update');
    Route::delete('familyMember/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('familyMember.meetings.destroy');


    Route::get('familyMember/all-members', [FamilyMemberManageController::class, 'index'])->name('familyMember.all_members');
    Route::get('familyMember/create-member', [FamilyMemberManageController::class, 'add_member'])->name('familyMember.add_member');
    Route::post('familyMember/save-member', [FamilyMemberManageController::class, 'save_member'])->name('familyMember.save_member');
    Route::get('familyMember/edit-member/{id}', [FamilyMemberManageController::class, 'edit_member'])->name('familyMember.edit_member');
    Route::post('familyMember/update-member/{id}', [FamilyMemberManageController::class, 'update_member'])->name('familyMember.update_member');
    Route::get('familyMember/delete-member/{id}', [FamilyMemberManageController::class, 'delete_member'])->name('familyMember.delete_member');
    Route::get('familyMember/activate-member/{id}', [FamilyMemberManageController::class, 'active_member'])->name('familyMember.active_member');

    Route::get('/familyMember/dashboard', [FamilyMemberController::class, 'index'])->name('familyMember.index');
    Route::get('/familyMember/daily-updates', [DailyUpdateController::class, 'index'])->name('familyMember.daily-updates.index');
    Route::get('familyMember/voting', [VotingPoolController::class, 'index'])->name('familyMember.pools.index');
    Route::get('familyMember/voting/data', [VotingPoolController::class, 'data'])->name('familyMember.pools.data');
    Route::get('familyMember/voting/{voting}', [VotingPoolController::class, 'show'])->name('familyMember.pools.show');
    Route::put('familyMember/voting/{voting}', [VotingPoolController::class, 'update'])->name('familyMember.pools.update');
    Route::post('familyMember/voting/{voting}/comment', [VotingCommentController::class, 'store'])->name('familyMember.voting.comment.store');
    Route::post('familyMember/voting/{voting}/vote', [VoteController::class, 'store'])->name('familyMember.voting.vote');

    Route::get('familyMember/contribution/index', [ContributionController::class, 'index'])->name('familyMember.contribution.index');
    Route::get('familyMember/contribution/create', [ContributionController::class, 'create'])->name('familyMember.contribution.create');
    Route::post('familyMember/contribution/create', [ContributionController::class, 'store'])->name('familyMember.contribution.store');
    Route::get('familyMember/contribution/{contribution}', [ContributionController::class, 'show'])->name('familyMember.contribution.show');
    Route::get('familyMember/contribution/{contribution}/edit', [ContributionController::class, 'edit'])->name('familyMember.contribution.edit');
    Route::put('familyMember/contribution/{contribution}', [ContributionController::class, 'update'])->name('familyMember.contribution.update');
    Route::delete('familyMember/contribution/{contribution}', [ContributionController::class, 'destroy'])->name('familyMember.contribution.destroy');

    Route::get('familyMember/reimbursment/index', [ReimbursementController::class, 'index'])->name('familyMember.reimbursment.index');
    Route::get('familyMember/reimbursment/create', [ReimbursementController::class, 'create'])->name('familyMember.reimbursment.create');
    Route::post('familyMember/reimbursment/store', [ReimbursementController::class, 'store'])->name('familyMember.reimbursment.store');
    Route::get('familyMember/reimbursment/{reimbursement}', [ReimbursementController::class, 'show'])->name('familyMember.reimbursment.show');
    Route::get('familyMember/reimbursment/{reimbursement}/edit', [ReimbursementController::class, 'edit'])->name('familyMember.reimbursment.edit');
    Route::put('familyMember/reimbursment/{reimbursement}', [ReimbursementController::class, 'update'])->name('familyMember.reimbursment.update');
    Route::delete('familyMember/reimbursment/{reimbursement}', [ReimbursementController::class, 'destroy'])->name('familyMember.reimbursment.destroy');

    Route::get('familyMember/events/index', [VacationController::class, 'index'])->name('familyMember.events.index');
    Route::get('familyMember/events/{vacation}', [VacationController::class, 'show'])->name('familyMember.events.show');

    Route::get('familyMember/family-notes', [FamilyNoteController::class, 'index'])->name('familyMember.family-notes.index');
    Route::get('familyMember/family-notes/create', [FamilyNoteController::class, 'create'])->name('familyMember.family-notes.create');
    Route::post('familyMember/family-notes/store', [FamilyNoteController::class, 'store'])->name('familyMember.family-notes.store');
    Route::get('familyMember/family-notes/{familyNote}', [FamilyNoteController::class, 'show'])->name('familyMember.family-notes.show');
    Route::get('familyMember/family-notes/{familyNote}/edit', [FamilyNoteController::class, 'edit'])->name('familyMember.family-notes.edit');
    Route::put('familyMember/family-notes/{familyNote}/update', [FamilyNoteController::class, 'update'])->name('familyMember.family-notes.update');
    Route::delete('familyMember/family-notes/{familyNote}/delete', [FamilyNoteController::class, 'destroy'])->name('familyMember.family-notes.destroy');
    Route::get('/familyMember/tasks', [TaskController::class, 'index'])->name('familyMember.tasks.index');

    Route::get('familyMember/bills', [BillController::class, 'index'])->name('familyMember.bills.index');
    Route::get('familyMember/bills/create', [BillController::class, 'create'])->name('familyMember.bills.create');
    Route::post('familyMember/bills', [BillController::class, 'store'])->name('familyMember.bills.store');
    Route::get('familyMember/bills/{bill}', [BillController::class, 'show'])->name('familyMember.bills.show');
    Route::get('familyMember/bills/{bill}/edit', [BillController::class, 'edit'])->name('familyMember.bills.edit');
    Route::put('familyMember/bills/{bill}', [BillController::class, 'update'])->name('familyMember.bills.update');
    Route::delete('familyMember/bills/{bill}', [BillController::class, 'destroy'])->name('familyMember.bills.destroy');
    Route::post('familyMember/bills/{bill}/submit-payment', [BillController::class, 'submitPayment'])->name('familyMember.bills.submitPayment');
    Route::post('familyMember/bill-payments/{payment}/review', [BillController::class, 'reviewPayment'])->name('familyMember.bills.reviewPayment');
});

Route::middleware([SeniorMiddleware::class])->group(function () {
    Route::get('/senior/dashboard', [SeniorController::class, 'index'])->name('senior.index');
    Route::get('/senior/daily-updates', [DailyUpdateController::class, 'index'])->name('senior.daily-updates.index');
    Route::get('/senior/voice-journal', [VoiceJournalController::class, 'index'])->name('senior.voice-journal.index');
    Route::get('/senior/voice-journal/create', [VoiceJournalController::class, 'create'])->name('senior.voice-journal.create');
    Route::post('/senior/voice-journal', [VoiceJournalController::class, 'store'])->name('senior.voice-journal.store');

    // List all meetings
    Route::get('senior/meetings', [MeetingController::class, 'index'])->name('senior.meetings.index');
    Route::get('senior/meetings/create', [MeetingController::class, 'create'])->name('senior.meetings.create');
    Route::post('senior/meetings/store', [MeetingController::class, 'store'])->name('senior.meetings.store');
    Route::get('senior/meetings/{meeting}', [MeetingController::class, 'show'])->name('senior.meetings.show');
    Route::get('senior/meetings/{meeting}/edit', [MeetingController::class, 'edit'])->name('senior.meetings.edit');
    Route::put('senior/meetings/{meeting}', [MeetingController::class, 'update'])->name('senior.meetings.update');
    Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('senior.meetings.destroy');

    Route::get('senior/bills', [BillController::class, 'index'])->name('senior.bills.index');
    Route::get('senior/bills/create', [BillController::class, 'create'])->name('senior.bills.create');
    Route::post('senior/bills', [BillController::class, 'store'])->name('senior.bills.store');
    Route::get('senior/bills/{bill}', [BillController::class, 'show'])->name('senior.bills.show');
    Route::get('senior/bills/{bill}/edit', [BillController::class, 'edit'])->name('senior.bills.edit');
    Route::put('senior/bills/{bill}', [BillController::class, 'update'])->name('senior.bills.update');
    Route::delete('senior/bills/{bill}', [BillController::class, 'destroy'])->name('familyOwner.bills.destroy');
    Route::post('senior/bills/{bill}/submit-payment', [BillController::class, 'submitPayment'])->name('senior.bills.submitPayment');
    Route::post('senior/bill-payments/{payment}/review', [BillController::class, 'reviewPayment'])->name('senior.bills.reviewPayment');
    Route::put('senior/bills/{bill}/approve', [BillController::class, 'approve'])->name('senior.bills.approve');
    Route::put('senior/bills/{bill}/decline', [BillController::class, 'decline'])->name('senior.bills.decline');
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

    Route::get('familyOwner/family-notes', [FamilyNoteController::class, 'index'])->name('familyOwner.family-notes.index');
    Route::get('familyOwner/family-notes/create', [FamilyNoteController::class, 'create'])->name('familyOwner.family-notes.create');
    Route::post('familyOwner/family-notes/store', [FamilyNoteController::class, 'store'])->name('familyOwner.family-notes.store');
    Route::get('familyOwner/family-notes/{familyNote}', [FamilyNoteController::class, 'show'])->name('familyOwner.family-notes.show');
    Route::get('familyOwner/family-notes/{familyNote}/edit', [FamilyNoteController::class, 'edit'])->name('familyOwner.family-notes.edit');
    Route::put('familyOwner/family-notes/{familyNote}/update', [FamilyNoteController::class, 'update'])->name('familyOwner.family-notes.update');
    Route::delete('familyOwner/family-notes/{familyNote}/delete', [FamilyNoteController::class, 'destroy'])->name('familyOwner.family-notes.destroy');


    Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::post('/payment-methods/store', [PaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::post('/payment-methods/{id}/set-primary', [PaymentMethodController::class, 'setPrimary'])->name('payment-methods.setPrimary');
    Route::delete('/payment-methods/{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');

    Route::get('/subscription/success', fn() => 'Subscription successful!')->name('subscription.success');
    Route::get('/subscription/cancel', fn() => 'Subscription canceled!')->name('subscription.cancel');

    Route::get('familyOwner/subscriptions', [SubscriptionController::class, 'index'])->name('familyOwner.subscriptions.index');

    // Toggle recurring subscription
    Route::post('/subscriptions/{id}/toggle-recurring', function ($id) {
        $subscription = \App\Models\Subscription::findOrFail($id);
        $subscription->is_recurring = ! $subscription->is_recurring;
        $subscription->save();

        return back()->with('success', 'Recurring setting updated.');
    })->name('subscriptions.toggleRecurring');
});


// Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods.index');
