@extends('layouts.deliveries')

@section('title', 'Loading Options')
@section('step', 2)

@section('content')
<div class="tn-card">
    <div class="tn-card-header">
        <div class="tn-price-display">
            <span class="tn-price-label">Delivery fee</span>
            <span class="tn-price-amount">${{ number_format($displayPrice, 2) }}</span>
        </div>
    </div>

    <p class="text-muted mb-4">
        If the delivery price above is acceptable and you wish to proceed, select a loading option,
        list your items, and click Next.
    </p>

    <form method="POST" action="{{ route('deliveries.step2.store') }}" id="step2Form">
        @csrf

        {{-- Loading Options --}}
        <div class="mb-4">
            <label class="tn-label">Loading &amp; offloading <span class="text-danger">*</span></label>
            <div class="tn-loading-options">
                @foreach($loadingOptions as $opt)
                    <label class="tn-loading-option">
                        <input type="radio" name="loading_option_id" value="{{ $opt->id }}"
                               {{ old('loading_option_id') == $opt->id ? 'checked' : '' }}
                               data-fee="{{ $opt->additional_fee }}">
                        <div class="tn-loading-card">
                            <div class="tn-loading-content">
                                <strong>{{ $opt->label }}</strong>
                                <p class="mb-0 text-muted small">{{ $opt->description }}</p>
                            </div>
                            <div class="tn-loading-fee">
                                @if($opt->additional_fee > 0)
                                    <span class="text-primary fw-bold">+${{ number_format($opt->additional_fee, 2) }}</span>
                                @else
                                    <span class="text-success fw-bold">No extra fee</span>
                                @endif
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            @error('loading_option_id') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        <hr class="tn-divider">

        {{-- Items --}}
        <div class="mb-4" id="itemsContainer">
            <label class="tn-label">Items to be delivered</label>
            <p class="text-muted small mb-3">List the items and quantities you need delivered.</p>

            <div class="tn-item-row" data-index="0">
                <div class="row g-2">
                    <div class="col-8">
                        <input type="text" name="items[0][name]" class="form-control tn-input"
                               placeholder="Item description" value="{{ old('items.0.name') }}">
                    </div>
                    <div class="col-4">
                        <input type="number" name="items[0][quantity]" class="form-control tn-input"
                               placeholder="Qty" min="1" value="{{ old('items.0.quantity', 1) }}">
                    </div>
                </div>
            </div>

            <button type="button" class="tn-add-btn" onclick="addItem()">
                <i class="bi bi-plus-circle"></i> Add item &amp; qty
            </button>
        </div>

        {{-- Notes --}}
        <div class="mb-4">
            <label class="tn-label" for="customer_notes">Special notes (optional)</label>
            <textarea name="customer_notes" id="customer_notes" class="form-control tn-input" rows="3"
                      placeholder="Any special instructions for the driver...">{{ old('customer_notes') }}</textarea>
        </div>

        {{-- Updated Total --}}
        <div class="tn-total-bar mb-4" id="totalBar">
            <span>Estimated total:</span>
            <span class="tn-total-amount" id="totalAmount">${{ number_format($displayPrice, 2) }}</span>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-3">
            <a href="{{ route('deliveries.index') }}" class="tn-btn tn-btn-outline flex-fill">
                <i class="bi bi-arrow-left me-2"></i> Back
            </a>
            <button type="submit" class="tn-btn tn-btn-primary flex-fill">
                <span>Next</span>
                <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let itemCounter = 1;

    function addItem() {
        const container = document.getElementById('itemsContainer');
        const idx = itemCounter++;
        const row = document.createElement('div');
        row.classList.add('tn-item-row');
        row.dataset.index = idx;
        row.innerHTML = `
            <div class="row g-2 align-items-start">
                <div class="col-6">
                    <input type="text" name="items[${idx}][name]" class="form-control tn-input" placeholder="Item description">
                </div>
                <div class="col-3">
                    <input type="number" name="items[${idx}][quantity]" class="form-control tn-input" placeholder="Qty" min="1" value="1">
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="this.closest('.tn-item-row').remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.querySelector('.tn-add-btn').before(row);
    }

    // Update total when loading option changes
    const basePrice = {{ $displayPrice }};

    document.querySelectorAll('input[name="loading_option_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const fee = parseFloat(this.dataset.fee) || 0;
            const total = basePrice + fee;
            document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
        });
    });
</script>
@endpush
