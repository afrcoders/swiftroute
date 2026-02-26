<?php

use App\Http\Controllers\Admin\DeliveryAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Protected admin panel routes. Accessible under /admin on the deliveries
| subdomain. Requires auth + is_admin middleware.
|
*/

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', [DeliveryAdminController::class, 'dashboard'])->name('admin.dashboard');

    // Bookings
    Route::get('/bookings', [DeliveryAdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/bookings/export', [DeliveryAdminController::class, 'exportBookings'])->name('admin.bookings.export');
    Route::get('/bookings/{id}', [DeliveryAdminController::class, 'showBooking'])->name('admin.bookings.show');
    Route::patch('/bookings/{id}/status', [DeliveryAdminController::class, 'updateBookingStatus'])->name('admin.bookings.status');
    Route::patch('/bookings/{id}/notes', [DeliveryAdminController::class, 'updateBookingNotes'])->name('admin.bookings.notes');

    // Pricing Rules
    Route::get('/pricing', [DeliveryAdminController::class, 'pricingRules'])->name('admin.pricing');
    Route::patch('/pricing/{id}', [DeliveryAdminController::class, 'updatePricingRule'])->name('admin.pricing.update');

    // Time Slots
    Route::get('/time-slots', [DeliveryAdminController::class, 'timeSlots'])->name('admin.timeslots');
    Route::patch('/time-slots/{id}/toggle', [DeliveryAdminController::class, 'toggleTimeSlot'])->name('admin.timeslots.toggle');

    // Loading Options
    Route::get('/loading-options', [DeliveryAdminController::class, 'loadingOptions'])->name('admin.loading-options');
    Route::patch('/loading-options/{id}', [DeliveryAdminController::class, 'updateLoadingOption'])->name('admin.loading-options.update');
});

// Simple admin login (no Breeze dependency)
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login')->middleware('guest');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        if (!auth()->user()->is_admin) {
            \Illuminate\Support\Facades\Auth::logout();
            return back()->withErrors(['email' => 'You do not have admin access.']);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
})->name('admin.login.submit')->middleware('guest');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout')->middleware('auth');
