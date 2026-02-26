<?php

namespace App\Mail;

use App\Models\Delivery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeliveryBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Delivery $delivery,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Delivery Booking: ' . $this->delivery->booking_reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.delivery-booking',
            with: [
                'delivery' => $this->delivery->load(['stops', 'vehicleType', 'timeSlot', 'loadingOption']),
            ],
        );
    }
}
