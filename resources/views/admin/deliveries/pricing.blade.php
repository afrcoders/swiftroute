@extends('layouts.admin')
@section('title', 'Pricing Rules')

@section('content')
<h1 class="h3 fw-bold mb-4">Pricing Rules</h1>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Key</th>
                        <th>Label</th>
                        <th>Value</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rules as $rule)
                        <tr>
                            <td><code>{{ $rule->key }}</code></td>
                            <td>{{ $rule->label }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.pricing.update', $rule->id) }}" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="value" value="{{ $rule->value }}" step="0.01" min="0"
                                           class="form-control form-control-sm" style="width: 120px;">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </form>
                            </td>
                            <td>
                                <span class="badge bg-{{ $rule->is_active ? 'success' : 'secondary' }}">
                                    {{ $rule->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $rule->description }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
