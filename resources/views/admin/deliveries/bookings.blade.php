@extends('layouts.admin')
@section('title', 'Bookings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">Bookings</h1>
    <a href="{{ route('admin.bookings.export', request()->query()) }}" class="btn btn-outline-success btn-sm">
        <i class="bi bi-download me-1"></i> Export CSV
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ ($filters['status'] ?? '') === $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">From</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $filters['date_from'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">To</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $filters['date_to'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Name, email, ref..." value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Vehicle</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        <tr>
                            <td><code>{{ $b->booking_reference }}</code></td>
                            <td>{{ $b->full_name }}</td>
                            <td>{{ $b->phone }}</td>
                            <td>{{ $b->pickup_date->format('M d, Y') }}</td>
                            <td>{{ $b->vehicleType->label ?? '—' }}</td>
                            <td>${{ number_format($b->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $b->status_badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $b->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No bookings found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $bookings->withQueryString()->links() }}
</div>
@endsection
