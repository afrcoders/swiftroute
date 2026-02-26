@extends('layouts.deliveries')

@section('title', 'Your Details')
@section('step', 3)

@section('content')
<div class="tn-card">
    <div class="tn-card-header">
        <h2 class="tn-title">Review &amp; Submit</h2>
        <p class="tn-subtitle">Review your delivery details and provide your contact information.</p>
    </div>

    {{-- Summary --}}
    <div class="tn-summary">
        <div class="tn-summary-header">
            <span>Summary</span>
            <a href="{{ route('deliveries.index') }}" class="tn-edit-link">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>

        <div class="tn-summary-total">
            <span>Total cost</span>
            <span class="tn-summary-total-amount">${{ number_format($pricing['total_price'], 2) }}</span>
        </div>

        <hr class="tn-divider">

        <div class="tn-summary-details">
            <div class="tn-summary-row">
                <strong>Pickup date:</strong>
                <span>{{ \Carbon\Carbon::parse($sessionData['step1']['pickup_date'])->format('l j F Y') }}</span>
            </div>
            <div class="tn-summary-row">
                <strong>Pickup time:</strong>
                <span>{{ $timeSlot->label }}</span>
            </div>

            @foreach($sessionData['step1']['pickup_locations'] as $i => $loc)
                <div class="tn-summary-row">
                    <strong>Pickup{{ count($sessionData['step1']['pickup_locations']) > 1 ? ' ' . ($i+1) : '' }}:</strong>
                    <span>{{ $loc['address'] }}, {{ $loc['postal_code'] }}</span>
                </div>
            @endforeach

            @foreach($sessionData['step1']['delivery_locations'] as $i => $loc)
                <div class="tn-summary-row">
                    <strong>Delivery{{ count($sessionData['step1']['delivery_locations']) > 1 ? ' ' . ($i+1) : '' }}:</strong>
                    <span>{{ $loc['address'] }}, {{ $loc['postal_code'] }}</span>
                </div>
            @endforeach

            <div class="tn-summary-row">
                <strong>Vehicle type:</strong>
                <span>{{ $vehicleType->label }}</span>
            </div>
            <div class="tn-summary-row">
                <strong>Loading option:</strong>
                <span>{{ $loadingOption->label }}</span>
            </div>
        </div>

        {{-- Price Breakdown --}}
        <div class="tn-price-breakdown">
            <div class="tn-breakdown-row">
                <span>Base delivery fee</span>
                <span>${{ number_format($pricing['base_price'], 2) }}</span>
            </div>
            @if($pricing['vehicle_surcharge'] > 0)
                <div class="tn-breakdown-row">
                    <span>Vehicle surcharge</span>
                    <span>${{ number_format($pricing['vehicle_surcharge'], 2) }}</span>
                </div>
            @endif
            @if($pricing['loading_fee'] > 0)
                <div class="tn-breakdown-row">
                    <span>Loading fee</span>
                    <span>${{ number_format($pricing['loading_fee'], 2) }}</span>
                </div>
            @endif
            @if($pricing['surge_fee'] > 0)
                <div class="tn-breakdown-row">
                    <span>Peak surcharge</span>
                    <span>${{ number_format($pricing['surge_fee'], 2) }}</span>
                </div>
            @endif
            <div class="tn-breakdown-row tn-breakdown-total">
                <strong>Total</strong>
                <strong>${{ number_format($pricing['total_price'], 2) }}</strong>
            </div>
        </div>

        {{-- Items --}}
        @if(!empty($sessionData['step2']['items']))
            @php
                $filteredItems = collect($sessionData['step2']['items'])->filter(fn($item) => !empty($item['name']));
            @endphp
            @if($filteredItems->isNotEmpty())
                <hr class="tn-divider">
                <div class="tn-items-summary">
                    <strong>Items to be delivered:</strong>
                    <ul class="tn-items-list">
                        @foreach($filteredItems as $item)
                            <li>{{ $item['name'] }} &times; {{ $item['quantity'] ?? 1 }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>

    <hr class="tn-divider">

    {{-- Customer Details Form --}}
    <h3 class="h5 fw-semibold mb-3">Your contact details</h3>

    <form method="POST" action="{{ route('deliveries.step3.store') }}" id="step3Form">
        @csrf

        <div class="mb-3">
            <label class="tn-label" for="first_name">First name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control tn-input"
                   value="{{ old('first_name') }}" required>
            @error('first_name') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="tn-label" for="last_name">Last name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control tn-input"
                   value="{{ old('last_name') }}" required>
            @error('last_name') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="tn-label" for="phone">Phone <span class="text-danger">*</span></label>
            <input type="tel" name="phone" id="phone" class="form-control tn-input"
                   placeholder="204-555-0123"
                   value="{{ old('phone') }}" required>
            @error('phone') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="tn-label" for="email">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control tn-input"
                   value="{{ old('email') }}" required>
            @error('email') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-3">
            <a href="{{ route('deliveries.step2') }}" class="tn-btn tn-btn-outline flex-fill">
                <i class="bi bi-arrow-left me-2"></i> Back
            </a>
            <button type="submit" class="tn-btn tn-btn-primary flex-fill" id="submitStep3">
                <span class="tn-btn-text">Submit</span>
                <i class="bi bi-check-lg ms-2"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('step3Form')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitStep3');
        btn.disabled = true;
        btn.querySelector('.tn-btn-text').textContent = 'Submitting...';
    });
</script>
@endpush
