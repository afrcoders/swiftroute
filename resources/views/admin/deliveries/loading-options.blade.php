@extends('layouts.admin')
@section('title', 'Loading Options')

@section('content')
<h1 class="h3 fw-bold mb-4">Loading Options</h1>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Label</th>
                        <th>Description</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($options as $opt)
                        <tr>
                            <td class="fw-semibold">{{ $opt->label }}</td>
                            <td class="text-muted small">{{ $opt->description }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.loading-options.update', $opt->id) }}" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm" style="width: 140px;">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="additional_fee" value="{{ $opt->additional_fee }}"
                                               step="0.01" min="0" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </form>
                            </td>
                            <td>
                                <span class="badge bg-{{ $opt->is_active ? 'success' : 'secondary' }}">
                                    {{ $opt->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">Order: {{ $opt->sort_order }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
