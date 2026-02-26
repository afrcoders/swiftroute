@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="h3 fw-bold mb-4">Dashboard</h1>

{{-- Status Cards --}}
<div class="row g-3 mb-4">
    @php
        $statuses = [
            'pending' => ['icon' => 'bi-hourglass-split', 'bg' => 'warning', 'label' => 'Pending'],
            'confirmed' => ['icon' => 'bi-check-circle', 'bg' => 'info', 'label' => 'Confirmed'],
            'in_progress' => ['icon' => 'bi-truck', 'bg' => 'primary', 'label' => 'In Progress'],
            'completed' => ['icon' => 'bi-check-all', 'bg' => 'success', 'label' => 'Completed'],
            'cancelled' => ['icon' => 'bi-x-circle', 'bg' => 'danger', 'label' => 'Cancelled'],
        ];
    @endphp

    @foreach($statuses as $key => $meta)
        <div class="col-6 col-md">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi {{ $meta['icon'] }} fs-2 text-{{ $meta['bg'] }}"></i>
                    <h2 class="h4 fw-bold mb-0 mt-2">{{ $statusCounts[$key] ?? 0 }}</h2>
                    <small class="text-muted">{{ $meta['label'] }}</small>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Recent Bookings --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Recent Bookings</h5>
        <a href="{{ route('admin.bookings') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td><code>{{ $booking->booking_reference }}</code></td>
                            <td>{{ $booking->full_name }}</td>
                            <td>{{ $booking->pickup_date->format('M d, Y') }}</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status_badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No bookings yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
