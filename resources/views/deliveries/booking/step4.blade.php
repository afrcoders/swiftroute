@extends('layouts.deliveries')

@section('title', 'Booking Confirmed')
@section('step', 4)

@section('content')
<div class="tn-card text-center">
    <div class="tn-confirmation-icon">
        <i class="bi bi-check-circle-fill"></i>
    </div>

    <h1 class="tn-title mt-4">Booking Confirmed!</h1>

    <p class="tn-subtitle mb-2">
        Your delivery request has been successfully submitted.
    </p>

    <div class="tn-booking-ref">
        <span class="tn-ref-label">Booking reference</span>
        <span class="tn-ref-code">{{ $reference }}</span>
    </div>

    <p class="text-muted mt-4 mb-4">
        One of our representatives will contact you shortly to confirm the details.<br>
        Thank you for choosing <strong>Terra Nova</strong>.
    </p>

    <div class="d-flex flex-column gap-2 align-items-center">
        <a href="{{ route('deliveries.index') }}" class="tn-btn tn-btn-primary">
            <i class="bi bi-plus-circle me-2"></i> Book Another Delivery
        </a>
        <a href="http://{{ str_replace('deliveries.', '', config('app.deliveries_domain')) }}"
           class="tn-btn tn-btn-outline">
            <i class="bi bi-arrow-left me-2"></i> Back to Main Site
        </a>
    </div>
</div>
@endsection
