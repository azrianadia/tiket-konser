<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function confirm(Ticket $ticket)
    {
        // Ensure ticket is not already paid
        if ($ticket->payment_status === 'paid') {
            return redirect()->route('ticket.confirmation', $ticket)
                ->with('info', 'Tiket ini sudah dibayar.');
        }

        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$clientKey = config('services.midtrans.client_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Build payload
        $payload = [
            'transaction_details' => [
                'order_id' => $ticket->id,
                'gross_amount' => (int) $ticket->price,
            ],
            'customer_details' => [
                'first_name' => $ticket->name,
                'email' => $ticket->email,
                'phone' => $ticket->phone,
            ],
            'item_details' => [
                [
                    'id' => $ticket->id,
                    'price' => (int) $ticket->price,
                    'quantity' => 1,
                    'name' => "Tiket {$ticket->seat_category}",
                ],
            ],
            'enabled_payments' => ['bank_transfer', 'gopay', 'shopeepay', 'qris'],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            
            // Store snap_token for reference
            $ticket->update(['snap_token' => $snapToken]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat token pembayaran: ' . $e->getMessage());
        }

        return view('checkout_confirm', compact('ticket', 'snapToken'));
    }
}
