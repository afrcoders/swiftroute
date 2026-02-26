<?php

namespace App\Http\Controllers\Deliveries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deliveries\StoreStep1Request;
use App\Http\Requests\Deliveries\StoreStep2Request;
use App\Http\Requests\Deliveries\StoreStep3Request;
use App\Mail\DeliveryBookingMail;
use App\Models\LoadingOption;
use App\Models\TimeSlot;
use App\Models\VehicleType;
use App\Services\DeliveryBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function __construct(
        protected DeliveryBookingService $bookingService,
    ) {}

    /**
     * Landing / Step 1: Delivery details form.
     */
    public function index()
    {
        $vehicleTypes = VehicleType::active()->get();
        $timeSlots = TimeSlot::active()->get();

        return view('deliveries.booking.step1', compact('vehicleTypes', 'timeSlots'));
    }

    /**
     * Process Step 1: Validate and calculate price.
     */
    public function storeStep1(StoreStep1Request $request)
    {
        $result = $this->bookingService->processStep1($request->validated());

        return redirect()->route('deliveries.step2');
    }

    /**
     * Step 2: Loading options & items.
     */
    public function step2()
    {
        if (!$this->bookingService->canAccessStep(2)) {
            return redirect()->route('deliveries.index')
                ->with('error', 'Please complete the delivery details first.');
        }

        $sessionData = $this->bookingService->getSessionData();
        $loadingOptions = LoadingOption::active()->get();
        $displayPrice = $sessionData['step1']['display_price'];

        return view('deliveries.booking.step2', compact('loadingOptions', 'displayPrice', 'sessionData'));
    }

    /**
     * Process Step 2.
     */
    public function storeStep2(StoreStep2Request $request)
    {
        if (!$this->bookingService->canAccessStep(2)) {
            return redirect()->route('deliveries.index');
        }

        $this->bookingService->processStep2($request->validated());

        return redirect()->route('deliveries.step3');
    }

    /**
     * Step 3: Customer details & submission.
     */
    public function step3()
    {
        if (!$this->bookingService->canAccessStep(3)) {
            return redirect()->route('deliveries.index')
                ->with('error', 'Please complete previous steps first.');
        }

        $sessionData = $this->bookingService->getSessionData();
        $pricing = $sessionData['pricing'];
        $loadingOption = LoadingOption::find($sessionData['step2']['loading_option_id']);
        $vehicleType = VehicleType::find($sessionData['step1']['vehicle_type_id']);
        $timeSlot = TimeSlot::find($sessionData['step1']['time_slot_id']);

        return view('deliveries.booking.step3', compact(
            'sessionData', 'pricing', 'loadingOption', 'vehicleType', 'timeSlot'
        ));
    }

    /**
     * Process Step 3: Create booking.
     */
    public function storeStep3(StoreStep3Request $request)
    {
        if (!$this->bookingService->canAccessStep(3)) {
            return redirect()->route('deliveries.index');
        }

        $delivery = $this->bookingService->processStep3($request->validated());

        // Send admin notification email
        try {
            Mail::to(config('mail.to.address', config('mail.from.address')))
                ->send(new DeliveryBookingMail($delivery));
        } catch (\Exception $e) {
            \Log::error('Failed to send delivery booking email', ['error' => $e->getMessage()]);
        }

        return redirect()->route('deliveries.confirmation', $delivery->booking_reference);
    }

    /**
     * Step 4: Confirmation page.
     */
    public function confirmation(string $reference)
    {
        return view('deliveries.booking.step4', compact('reference'));
    }

    /**
     * API: Get available time slots for a date.
     */
    public function getTimeSlotsForDate(Request $request)
    {
        $request->validate(['date' => 'required|date|after_or_equal:today']);

        $slots = TimeSlot::availableForDate($request->date)->get()
            ->filter(fn ($slot) => $slot->hasCapacityForDate($request->date))
            ->values();

        return response()->json($slots);
    }
}
