@extends('layouts.admin')
@section('title', 'Booking ' . $booking->booking_reference)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.bookings') }}" class="text-decoration-none small">
            <i class="bi bi-arrow-left"></i> Back to list
        </a>
        <h1 class="h3 fw-bold mb-0 mt-1">{{ $booking->booking_reference }}</h1>
    </div>
    <span class="badge bg-{{ $booking->status_badge }} fs-6">
        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
    </span>
</div>

<div class="row g-4">
    {{-- Main Info --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Delivery Details</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Pickup Date</div>
                    <div class="col-sm-8 fw-semibold">{{ $booking->pickup_date->format('l, F j, Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Time Slot</div>
                    <div class="col-sm-8">{{ $booking->timeSlot->label ?? '—' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Vehicle</div>
                    <div class="col-sm-8">{{ $booking->vehicleType->label ?? '—' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Loading</div>
                    <div class="col-sm-8">{{ $booking->loadingOption->label ?? '—' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Distance</div>
                    <div class="col-sm-8">{{ $booking->distance_km }} km</div>
                </div>

                <hr>

                <h6 class="fw-semibold mb-2">Stops</h6>
                @foreach($booking->stops as $stop)
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge {{ $stop->type === 'pickup' ? 'bg-success' : 'bg-primary' }}">
                            {{ ucfirst($stop->type) }}
                        </span>
                        <span>{{ $stop->address }}, {{ $stop->postal_code }}</span>
                    </div>
                @endforeach

                @if($booking->items && count($booking->items) > 0)
                    <hr>
                    <h6 class="fw-semibold mb-2">Items</h6>
                    <ul class="mb-0">
                        @foreach($booking->items as $item)
                            @if(!empty($item['name']))
                                <li>{{ $item['name'] }} &times; {{ $item['quantity'] ?? 1 }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                @if($booking->customer_notes)
                    <hr>
                    <h6 class="fw-semibold mb-2">Customer Notes</h6>
                    <p class="mb-0 text-muted">{{ $booking->customer_notes }}</p>
                @endif
            </div>
        </div>

        {{-- Price Breakdown --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Pricing</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Base price</span>
                    <span>${{ number_format($booking->base_price, 2) }}</span>
                </div>
                @if($booking->vehicle_surcharge > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Vehicle surcharge</span>
                        <span>${{ number_format($booking->vehicle_surcharge, 2) }}</span>
                    </div>
                @endif
                @if($booking->loading_fee > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Loading fee</span>
                        <span>${{ number_format($booking->loading_fee, 2) }}</span>
                    </div>
                @endif
                @if($booking->surge_fee > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Surge fee</span>
                        <span>${{ number_format($booking->surge_fee, 2) }}</span>
                    </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>${{ number_format($booking->total_price, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-md-4">
        {{-- Customer Info --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Customer</div>
            <div class="card-body">
                <p class="mb-1 fw-semibold">{{ $booking->full_name }}</p>
                <p class="mb-1"><i class="bi bi-telephone me-1"></i> {{ $booking->phone }}</p>
                <p class="mb-0"><i class="bi bi-envelope me-1"></i> {{ $booking->email }}</p>
            </div>
        </div>

        {{-- Status Update --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Update Status</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.status', $booking->id) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select mb-2">
                        @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $s)) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Update</button>
                </form>
            </div>
        </div>

        {{-- Admin Notes --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Admin Notes</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.notes', $booking->id) }}">
                    @csrf
                    @method('PATCH')
                    <textarea name="admin_notes" class="form-control mb-2" rows="4" placeholder="Internal notes...">{{ $booking->admin_notes }}</textarea>
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">Save Notes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
