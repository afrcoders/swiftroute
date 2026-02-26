<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #000015; color: #fff; padding: 20px 30px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0 0; opacity: 0.7; font-size: 13px; }
        .body { padding: 30px; }
        .ref { background: #f0f7ff; border: 1px solid #d0e3ff; border-radius: 6px; padding: 12px 16px; text-align: center; margin-bottom: 20px; }
        .ref-code { font-size: 24px; font-weight: bold; color: #2c5aa0; }
        .section { margin-bottom: 20px; }
        .section h3 { font-size: 14px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 6px; }
        .detail-row { display: flex; padding: 4px 0; }
        .detail-label { color: #666; width: 140px; flex-shrink: 0; }
        .detail-value { font-weight: 600; }
        .price { font-size: 28px; font-weight: bold; color: #2c5aa0; }
        .stop { background: #f8f9fa; padding: 8px 12px; border-radius: 4px; margin-bottom: 4px; }
        .stop-type { font-size: 11px; font-weight: bold; text-transform: uppercase; color: #fff; padding: 2px 8px; border-radius: 3px; display: inline-block; margin-right: 8px; }
        .stop-pickup { background: #28a745; }
        .stop-delivery { background: #007bff; }
        table.breakdown { width: 100%; border-collapse: collapse; }
        table.breakdown td { padding: 6px 0; }
        table.breakdown .total td { border-top: 2px solid #333; font-weight: bold; font-size: 16px; }
        .footer { background: #f8f9fa; padding: 15px 30px; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Delivery Booking</h1>
            <p>Terra Nova Property Services — Winnipeg Deliveries</p>
        </div>

        <div class="body">
            <div class="ref">
                <div style="font-size: 12px; color: #666;">Booking Reference</div>
                <div class="ref-code">{{ $delivery->booking_reference }}</div>
            </div>

            <div class="section">
                <h3>Customer</h3>
                <table width="100%">
                    <tr><td class="detail-label">Name</td><td class="detail-value">{{ $delivery->full_name }}</td></tr>
                    <tr><td class="detail-label">Phone</td><td class="detail-value">{{ $delivery->phone }}</td></tr>
                    <tr><td class="detail-label">Email</td><td class="detail-value">{{ $delivery->email }}</td></tr>
                </table>
            </div>

            <div class="section">
                <h3>Delivery Details</h3>
                <table width="100%">
                    <tr><td class="detail-label">Pickup Date</td><td class="detail-value">{{ $delivery->pickup_date->format('l, F j, Y') }}</td></tr>
                    <tr><td class="detail-label">Time</td><td class="detail-value">{{ $delivery->timeSlot->label ?? '—' }}</td></tr>
                    <tr><td class="detail-label">Vehicle</td><td class="detail-value">{{ $delivery->vehicleType->label ?? '—' }}</td></tr>
                    <tr><td class="detail-label">Loading</td><td class="detail-value">{{ $delivery->loadingOption->label ?? '—' }}</td></tr>
                    <tr><td class="detail-label">Distance</td><td class="detail-value">{{ $delivery->distance_km }} km</td></tr>
                </table>
            </div>

            <div class="section">
                <h3>Stops</h3>
                @foreach($delivery->stops as $stop)
                    <div class="stop">
                        <span class="stop-type {{ $stop->type === 'pickup' ? 'stop-pickup' : 'stop-delivery' }}">
                            {{ $stop->type }}
                        </span>
                        {{ $stop->address }}, {{ $stop->postal_code }}
                    </div>
                @endforeach
            </div>

            @if($delivery->items && count($delivery->items) > 0)
                <div class="section">
                    <h3>Items</h3>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($delivery->items as $item)
                            @if(!empty($item['name']))
                                <li>{{ $item['name'] }} &times; {{ $item['quantity'] ?? 1 }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($delivery->customer_notes)
                <div class="section">
                    <h3>Customer Notes</h3>
                    <p style="margin: 0; color: #555;">{{ $delivery->customer_notes }}</p>
                </div>
            @endif

            <div class="section">
                <h3>Pricing</h3>
                <table class="breakdown">
                    <tr><td>Base price</td><td align="right">${{ number_format($delivery->base_price, 2) }}</td></tr>
                    @if($delivery->vehicle_surcharge > 0)
                        <tr><td>Vehicle surcharge</td><td align="right">${{ number_format($delivery->vehicle_surcharge, 2) }}</td></tr>
                    @endif
                    @if($delivery->loading_fee > 0)
                        <tr><td>Loading fee</td><td align="right">${{ number_format($delivery->loading_fee, 2) }}</td></tr>
                    @endif
                    @if($delivery->surge_fee > 0)
                        <tr><td>Surge fee</td><td align="right">${{ number_format($delivery->surge_fee, 2) }}</td></tr>
                    @endif
                    <tr class="total">
                        <td>Total</td>
                        <td align="right">${{ number_format($delivery->total_price, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Terra Nova Property Services. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
