<?php

use App\Http\Controllers\AvarageController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\SettingController;
use Gemini\Enums\Role;

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

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'show'])->name('settings.show');
        Route::post('/update', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/updatebalance', [SettingController::class, 'updateBalance'])->name('balance.update');
        Route::post('/updatepreferences', [SettingController::class, 'updatePreferences'])->name('preferences.update');
        Route::put('/updatecurrency', [SettingController::class, 'updateCurrency'])->name('currency.update');
    });

    // Payments
    Route::prefix('payments')->group(function () {
        Route::get('/', [HomeController::class, 'payments'])->name('payments');
        Route::post('/outgoing/create', [PaymentController::class, 'create'])->name('createOutgoing');
        Route::post('/incoming/create', [IncomingController::class, 'create'])->name('createIncoming');
        Route::delete('/outgoing/{payment}/delete', [PaymentController::class, 'delete'])->name('deleteOutgoing');
        Route::delete('/incoming/{incoming}/delete', [IncomingController::class, 'delete'])->name('deleteIncoming');
    });

    // Goals
    Route::prefix('goals')->group(function () {
        Route::get('/create', [GoalController::class, 'create'])->name('createGoal');
        Route::get('/', [GoalController::class, 'show'])->name('viewGoals');
        Route::delete('/delete/{id}', [GoalController::class, 'delete'])->name('deleteGoal');
        Route::post('/save', [GoalController::class, 'save'])->name('saveGoal');
        Route::post('/generate-content', [GoalController::class, 'generateResponse'])->name('generateResponse');
    });

    // Calendar
    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('showCalendar');
    });

    // Balance
    Route::post('/balance/update', [BalanceController::class, 'update'])->name('updateBalance');

    // Profile
    Route::prefix('profile/{id}')->group(function () {
        Route::get('/settings', [ProfileController::class, 'profileSettings']);
        Route::get('/data', [ProfileController::class, 'profileData']);
    });

    // Averages
    Route::get('/averages', [AvarageController::class, 'index'])->name('averages.index');
});
