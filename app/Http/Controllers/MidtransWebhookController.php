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

        $orderId = $payload['order_id'] ?? null;
        $statusCode = (string)($payload['status_code'] ?? '');
        $grossAmount = (string)($payload['gross_amount'] ?? '');
        $signatureKey = $payload['signature_key'] ?? null;
        
        $serverKey = config('services.midtrans.server_key');
        
        Log::info('Webhook verification data', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'server_key_configured' => !empty($serverKey),
            'signature_key_present' => !empty($signatureKey),
        ]);

        if (!$orderId || !$signatureKey) {
            Log::warning('Missing required webhook fields');
            return response()->json(['message' => 'Missing required fields'], 400);
        }

        // Verify Signature
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        
        Log::info('Signature comparison', [
            'expected' => $signature,
            'received' => $signatureKey,
            'match' => $signature === $signatureKey,
        ]);

        if ($signature !== $signatureKey) {
            Log::warning('Invalid webhook signature');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $ticket = Ticket::find($orderId);
        
        if (!$ticket) {
            Log::warning('Ticket not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        
        Log::info('Processing transaction status', [
            'ticket_id' => $ticket->id,
            'status' => $transactionStatus,
            'current_payment_status' => $ticket->payment_status,
        ]);

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $ticket->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
            Log::info('Ticket marked as paid', ['ticket_id' => $ticket->id]);
        } elseif ($transactionStatus == 'pending') {
            $ticket->update(['payment_status' => 'pending']);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $ticket->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'Webhook processed']);
    }
}
