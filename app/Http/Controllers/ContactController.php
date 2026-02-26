<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();

        // Honeypot
        if (!empty($data['website'])) {
            return response()->json(['ok' => true]);
        }

        $formType = strtolower($data['form_type'] ?? 'contact');

        if (!in_array($formType, ['contact', 'quote'])) {
            return response()->json(['ok' => false, 'error' => 'Invalid form type'], 422);
        }

        try {
            if ($formType === 'contact') {
                $payload = [
                    'name'    => $data['name'] ?? 'N/A',
                    'email'   => $data['email'] ?? 'N/A',
                    'phone'   => $data['phone'] ?? 'N/A',
                    'service' => $data['service'] ?? 'N/A',
                    'message' => $data['message'] ?? 'N/A',
                ];
                $subject = "New Contact Message - " . ($payload['name']) . " - Terra Nova Website";
            } else {
                $payload = [
                    'first_name' => $data['first_name'] ?? 'N/A',
                    'last_name'  => $data['last_name'] ?? 'N/A',
                    'company'    => $data['company'] ?? 'N/A',
                    'email'      => $data['email'] ?? 'N/A',
                    'phone'      => $data['phone'] ?? 'N/A',
                    'address'    => $data['address'] ?? 'N/A',
                    'city'       => $data['city'] ?? 'N/A',
                    'zip'        => $data['zip'] ?? 'N/A',
                    'services'   => is_array($data['services'] ?? null) ? implode(', ', $data['services']) : ($data['services'] ?? 'N/A'),
                    'additional_info' => $data['additional_info'] ?? 'N/A',
                    'how_found'  => $data['how_found'] ?? 'N/A',
                ];
                $subject = "New Quote Request - " . ($payload['first_name'] . ' ' . $payload['last_name']) . " - Terra Nova Website";
            }

            $mail = Mail::to(env('MAIL_TO_ADDRESS', 'info@experienceterranova.com'));
            if (env('MAIL_CC_ADDRESS')) {
                $mail->cc(env('MAIL_CC_ADDRESS'));
            }

            $mail->send(new ContactMail($payload, $subject));

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
