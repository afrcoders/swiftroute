<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\LoadingOption;
use App\Models\PricingRule;
use App\Models\TimeSlot;
use App\Models\VehicleType;
use App\Repositories\Contracts\DeliveryRepositoryInterface;
use Illuminate\Http\Request;

class DeliveryAdminController extends Controller
{
    public function __construct(
        protected DeliveryRepositoryInterface $deliveryRepo,
    ) {}

    /**
     * Dashboard overview.
     */
    public function dashboard()
    {
        $statusCounts = $this->deliveryRepo->countByStatus();
        $recentBookings = Delivery::with(['vehicleType', 'timeSlot'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.deliveries.dashboard', compact('statusCounts', 'recentBookings'));
    }

    /**
     * List all bookings with filters.
     */
    public function bookings(Request $request)
    {
        $filters = $request->only(['status', 'date_from', 'date_to', 'search']);
        $bookings = $this->deliveryRepo->paginate(20, $filters);

        return view('admin.deliveries.bookings', compact('bookings', 'filters'));
    }

    /**
     * View a single booking.
     */
    public function showBooking(int $id)
    {
        $booking = $this->deliveryRepo->find($id);

        if (!$booking) {
            abort(404);
        }

        return view('admin.deliveries.show', compact('booking'));
    }

    /**
     * Update booking status.
     */
    public function updateBookingStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        $this->deliveryRepo->updateStatus($id, $request->status);

        return back()->with('success', 'Booking status updated.');
    }

    /**
     * Update admin notes on booking.
     */
    public function updateBookingNotes(Request $request, int $id)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:5000']);

        Delivery::where('id', $id)->update(['admin_notes' => $request->admin_notes]);

        return back()->with('success', 'Notes updated.');
    }

    // ── Pricing Rules ─────────────────────────────────────

    public function pricingRules()
    {
        $rules = PricingRule::orderBy('key')->get();
        return view('admin.deliveries.pricing', compact('rules'));
    }

    public function updatePricingRule(Request $request, int $id)
    {
        $request->validate([
            'value' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        PricingRule::where('id', $id)->update($request->only(['value', 'is_active']));

        return back()->with('success', 'Pricing rule updated.');
    }

    // ── Time Slots ────────────────────────────────────────

    public function timeSlots()
    {
        $slots = TimeSlot::orderBy('sort_order')->get();
        return view('admin.deliveries.timeslots', compact('slots'));
    }

    public function toggleTimeSlot(int $id)
    {
        $slot = TimeSlot::findOrFail($id);
        $slot->update(['is_active' => !$slot->is_active]);

        return back()->with('success', 'Time slot ' . ($slot->is_active ? 'enabled' : 'disabled') . '.');
    }

    // ── Loading Options ───────────────────────────────────

    public function loadingOptions()
    {
        $options = LoadingOption::orderBy('sort_order')->get();
        return view('admin.deliveries.loading-options', compact('options'));
    }

    public function updateLoadingOption(Request $request, int $id)
    {
        $request->validate([
            'additional_fee' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        LoadingOption::where('id', $id)->update($request->only(['additional_fee', 'is_active']));

        return back()->with('success', 'Loading option updated.');
    }

    // ── Export ─────────────────────────────────────────────

    public function exportBookings(Request $request)
    {
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $query = Delivery::with(['stops', 'vehicleType', 'timeSlot', 'loadingOption']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['date_from'])) {
            $query->where('pickup_date', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->where('pickup_date', '<=', $filters['date_to']);
        }

        $bookings = $query->orderByDesc('created_at')->get();

        $csv = "Booking Ref,Date,Time,Customer,Phone,Email,Vehicle,Loading,Distance,Total,Status\n";

        foreach ($bookings as $b) {
            $csv .= implode(',', [
                $b->booking_reference,
                $b->pickup_date->format('Y-m-d'),
                $b->timeSlot->label ?? '',
                "\"{$b->full_name}\"",
                $b->phone,
                $b->email,
                $b->vehicleType->label ?? '',
                $b->loadingOption->label ?? '',
                $b->distance_km,
                $b->total_price,
                $b->status,
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="deliveries-export-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
