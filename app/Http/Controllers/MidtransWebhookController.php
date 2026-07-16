<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        
        Log::info('Midtrans Webhook Received', $payload);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signatureKey = $payload['signature_key'];
        
        $serverKey = config('services.midtrans.server_key');
        
        // Verify Signature
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($signature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $ticket = Ticket::find($orderId);
        
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'];
        
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $ticket->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
        } elseif ($transactionStatus == 'pending') {
            $ticket->update(['payment_status' => 'pending']);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $ticket->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'Webhook processed']);
    }
}
