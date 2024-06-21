<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //Settings
    Route::get('/settings', [SettingController::class, 'show'])->name('settings.show');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    //Create or view payments
    Route::get('/payments', [HomeController::class, 'payments'])->name('payments');

    //Goals
    Route::get('/goals/create', [GoalController::class, 'create'])->name('createGoal');
    Route::get('/goals', [GoalController::class, 'show'])->name('viewGoals');
    Route::post('/goals/delete/{id}', [GoalController::class, 'delete'])->name('deleteGoal');
    Route::get('/goals/{id}', [GoalController::class, 'view'])->name('showGoal');
    Route::post('/goals/save', [GoalController::class, 'save'])->name('saveGoal');

    //Balance
    Route::post('/balance/update', [BalanceController::class, 'update'])->name('updateBalance');

    //Profile
    Route::get('/profile/{id}/settings', [ProfileController::class, 'profileSettings']);
    Route::get('/profile/{id}/data', [ProfileController::class, 'profileData']);

    //Payments
    Route::post('/outgoing/create', [PaymentController::class, 'create'])->name('createOutgoing');
    Route::post('/incoming/create', [IncomingController::class, 'create'])->name('createIncoming');

    // Ai response to goal recommendation
    Route::post('/generate-content', [GoalController::class, 'generateResponse'])->name('generateResponse');
});
