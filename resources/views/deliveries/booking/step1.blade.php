@extends('layouts.deliveries')

@section('title', 'Book a Delivery')
@section('step', 1)

@section('content')
<div class="tn-card">
    <div class="tn-card-header">
        <h1 class="tn-title">Fast &amp; Reliable Delivery</h1>
        <p class="tn-subtitle">
            Heavy or bulky items delivered within Winnipeg.<br>
            No payment until your driver has picked up.
        </p>
    </div>

    <div class="tn-features">
        <div class="tn-feature"><i class="bi bi-shop"></i> Store-to-home deliveries</div>
        <div class="tn-feature"><i class="bi bi-cart4"></i> Kijiji &amp; Marketplace finds</div>
        <div class="tn-feature"><i class="bi bi-box-seam"></i> Furniture moves between apartments</div>
        <div class="tn-feature"><i class="bi bi-heart"></i> Thrift store drop-offs</div>
    </div>

    <hr class="tn-divider">

    <form method="POST" action="{{ route('deliveries.step1.store') }}" id="step1Form">
        @csrf

        {{-- Vehicle Type --}}
        <div class="mb-4">
            <label class="tn-label">Select vehicle type <span class="text-danger">*</span></label>
            <div class="tn-vehicle-grid">
                @foreach($vehicleTypes as $vt)
                    <label class="tn-vehicle-option">
                        <input type="radio" name="vehicle_type_id" value="{{ $vt->id }}"
                               {{ old('vehicle_type_id') == $vt->id ? 'checked' : '' }}
                               {{ $loop->first && !old('vehicle_type_id') ? 'checked' : '' }}>
                        <div class="tn-vehicle-card">
                            @if($vt->image_url)
                                <img src="{{ asset($vt->image_url) }}" alt="{{ $vt->label }}">
                            @else
                                <i class="bi bi-truck fs-1"></i>
                            @endif
                            <span class="tn-vehicle-name">{{ $vt->label }}</span>
                            @if($vt->description)
                                <small class="text-muted">{{ $vt->description }}</small>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
            @error('vehicle_type_id') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        {{-- Pickup Locations --}}
        <div class="mb-4" id="pickupLocationsContainer">
            <label class="tn-label">Pickup location(s) <span class="text-danger">*</span></label>
            <div class="tn-location-group" data-index="0">
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" name="pickup_locations[0][address]"
                               class="form-control tn-input address-autocomplete"
                               placeholder="Enter pickup address"
                               value="{{ old('pickup_locations.0.address') }}" required>
                        <input type="hidden" name="pickup_locations[0][place_id]" value="{{ old('pickup_locations.0.place_id') }}">
                        <input type="hidden" name="pickup_locations[0][lat]" value="{{ old('pickup_locations.0.lat') }}">
                        <input type="hidden" name="pickup_locations[0][lng]" value="{{ old('pickup_locations.0.lng') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="pickup_locations[0][postal_code]"
                               class="form-control tn-input postal-code-input"
                               placeholder="Postal code"
                               maxlength="7"
                               value="{{ old('pickup_locations.0.postal_code') }}" required>
                    </div>
                </div>
            </div>
            <button type="button" class="tn-add-btn" onclick="addLocation('pickup')">
                <i class="bi bi-plus-circle"></i> Add a pickup location
            </button>
            @error('pickup_locations') <div class="tn-error">{{ $message }}</div> @enderror
            @error('pickup_locations.*.address') <div class="tn-error">{{ $message }}</div> @enderror
            @error('pickup_locations.*.postal_code') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        {{-- Delivery Locations --}}
        <div class="mb-4" id="deliveryLocationsContainer">
            <label class="tn-label">Delivery location(s) <span class="text-danger">*</span></label>
            <div class="tn-location-group" data-index="0">
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" name="delivery_locations[0][address]"
                               class="form-control tn-input address-autocomplete"
                               placeholder="Enter delivery address"
                               value="{{ old('delivery_locations.0.address') }}" required>
                        <input type="hidden" name="delivery_locations[0][place_id]" value="{{ old('delivery_locations.0.place_id') }}">
                        <input type="hidden" name="delivery_locations[0][lat]" value="{{ old('delivery_locations.0.lat') }}">
                        <input type="hidden" name="delivery_locations[0][lng]" value="{{ old('delivery_locations.0.lng') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="delivery_locations[0][postal_code]"
                               class="form-control tn-input postal-code-input"
                               placeholder="Postal code"
                               maxlength="7"
                               value="{{ old('delivery_locations.0.postal_code') }}" required>
                    </div>
                </div>
            </div>
            <button type="button" class="tn-add-btn" onclick="addLocation('delivery')">
                <i class="bi bi-plus-circle"></i> Add a delivery location
            </button>
            @error('delivery_locations') <div class="tn-error">{{ $message }}</div> @enderror
            @error('delivery_locations.*.address') <div class="tn-error">{{ $message }}</div> @enderror
            @error('delivery_locations.*.postal_code') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        {{-- Pickup Date --}}
        <div class="mb-4">
            <label class="tn-label" for="pickup_date">Pickup date <span class="text-danger">*</span></label>
            <input type="date" name="pickup_date" id="pickup_date"
                   class="form-control tn-input"
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('pickup_date') }}" required>
            @error('pickup_date') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        {{-- Time Slot --}}
        <div class="mb-4">
            <label class="tn-label" for="time_slot_id">Available pickup time <span class="text-danger">*</span></label>
            <select name="time_slot_id" id="time_slot_id" class="form-select tn-input" required>
                <option value="">Select a date first</option>
                @foreach($timeSlots as $slot)
                    <option value="{{ $slot->id }}" {{ old('time_slot_id') == $slot->id ? 'selected' : '' }}>
                        {{ $slot->label }}
                    </option>
                @endforeach
            </select>
            @error('time_slot_id') <div class="tn-error">{{ $message }}</div> @enderror
        </div>

        {{-- Postal code service area errors --}}
        @foreach($errors->all() as $error)
            @if(str_starts_with($error, 'The postal code'))
                <div class="tn-error mb-2">{{ $error }}</div>
            @endif
        @endforeach

        <button type="submit" class="tn-btn tn-btn-primary w-100" id="submitStep1">
            <span class="tn-btn-text">See Price</span>
            <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Dynamic location management
    const locationCounters = { pickup: 1, delivery: 1 };

    function addLocation(type) {
        const container = document.getElementById(type + 'LocationsContainer');
        const idx = locationCounters[type]++;
        const group = document.createElement('div');
        group.classList.add('tn-location-group');
        group.dataset.index = idx;
        group.innerHTML = `
            <div class="row g-2 align-items-start">
                <div class="col-md-7">
                    <input type="text" name="${type}_locations[${idx}][address]"
                           class="form-control tn-input address-autocomplete"
                           placeholder="Enter ${type} address" required>
                    <input type="hidden" name="${type}_locations[${idx}][place_id]">
                    <input type="hidden" name="${type}_locations[${idx}][lat]">
                    <input type="hidden" name="${type}_locations[${idx}][lng]">
                </div>
                <div class="col-md-3">
                    <input type="text" name="${type}_locations[${idx}][postal_code]"
                           class="form-control tn-input postal-code-input"
                           placeholder="Postal code" maxlength="7" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeLocation(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.querySelector('.tn-add-btn').before(group);
        initAutocomplete(group.querySelector('.address-autocomplete'));
    }

    function removeLocation(btn) {
        btn.closest('.tn-location-group').remove();
    }

    // Date-based time slot loading
    const dateInput = document.getElementById('pickup_date');
    const slotSelect = document.getElementById('time_slot_id');

    dateInput?.addEventListener('change', async function() {
        slotSelect.innerHTML = '<option value="">Loading...</option>';
        try {
            const res = await fetch(`{{ route('deliveries.api.timeslots') }}?date=${this.value}`);
            const slots = await res.json();
            slotSelect.innerHTML = '<option value="">Select a time</option>';
            slots.forEach(s => {
                slotSelect.innerHTML += `<option value="${s.id}">${s.label}</option>`;
            });
        } catch(e) {
            slotSelect.innerHTML = '<option value="">Error loading slots</option>';
        }
    });

    // Google Places Autocomplete
    function initAutocomplete(input) {
        if (typeof google === 'undefined') return;

        const autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: 'ca' },
            fields: ['place_id', 'geometry', 'formatted_address', 'address_components'],
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const group = input.closest('.tn-location-group') || input.closest('.row').parentElement;
            const placeIdInput = group.querySelector('[name*="place_id"]');
            const latInput = group.querySelector('[name*="lat"]');
            const lngInput = group.querySelector('[name*="lng"]');
            const postalInput = group.querySelector('.postal-code-input');

            if (placeIdInput) placeIdInput.value = place.place_id;
            if (latInput) latInput.value = place.geometry.location.lat();
            if (lngInput) lngInput.value = place.geometry.location.lng();

            // Auto-fill postal code
            if (postalInput && place.address_components) {
                const postal = place.address_components.find(c => c.types.includes('postal_code'));
                if (postal) postalInput.value = postal.long_name;
            }
        });
    }

    function initAllAutocomplete() {
        document.querySelectorAll('.address-autocomplete').forEach(initAutocomplete);
    }

    // Load Google Maps
    @if(config('services.google.maps_api_key'))
    (function() {
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config("services.google.maps_api_key") }}&libraries=places&callback=initAllAutocomplete';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    })();
    @endif

    // Form submission UX
    document.getElementById('step1Form')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitStep1');
        btn.disabled = true;
        btn.querySelector('.tn-btn-text').textContent = 'Calculating...';
    });
</script>
@endpush
