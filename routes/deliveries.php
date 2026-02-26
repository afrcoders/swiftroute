<?php

use App\Http\Controllers\Deliveries\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Deliveries Subdomain Routes
|--------------------------------------------------------------------------
|
| Routes registered here respond only to deliveries.experienceterranova.test
| (local) and deliveries.experienceterranova.com (production).
| They use the "web" middleware group.
|
*/

// ── Booking Flow ──────────────────────────────────────────────────────

Route::get('/', [BookingController::class, 'index'])->name('deliveries.index');

Route::post('/step-1', [BookingController::class, 'storeStep1'])
    ->name('deliveries.step1.store')
    ->middleware('throttle:30,1');

Route::get('/step-2', [BookingController::class, 'step2'])->name('deliveries.step2');
Route::post('/step-2', [BookingController::class, 'storeStep2'])->name('deliveries.step2.store');

Route::get('/step-3', [BookingController::class, 'step3'])->name('deliveries.step3');
Route::post('/step-3', [BookingController::class, 'storeStep3'])
    ->name('deliveries.step3.store')
    ->middleware('throttle:10,1');

Route::get('/confirmation/{reference}', [BookingController::class, 'confirmation'])
    ->name('deliveries.confirmation');

// ── AJAX ──────────────────────────────────────────────────────────────

Route::get('/api/time-slots', [BookingController::class, 'getTimeSlotsForDate'])
    ->name('deliveries.api.timeslots');
