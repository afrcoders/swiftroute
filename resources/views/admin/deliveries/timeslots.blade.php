@extends('layouts.admin')
@section('title', 'Time Slots')

@section('content')
<h1 class="h3 fw-bold mb-4">Time Slots</h1>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Label</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Day</th>
                        <th>Max Bookings</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                        <tr class="{{ !$slot->is_active ? 'table-secondary' : '' }}">
                            <td>{{ $slot->label }}</td>
                            <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</td>
                            <td>
                                @if($slot->day_of_week !== null)
                                    {{ ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][$slot->day_of_week] }}
                                @else
                                    <span class="text-muted">All days</span>
                                @endif
                            </td>
                            <td>{{ $slot->max_bookings }}</td>
                            <td>
                                <span class="badge bg-{{ $slot->is_active ? 'success' : 'secondary' }}">
                                    {{ $slot->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.timeslots.toggle', $slot->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $slot->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $slot->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
