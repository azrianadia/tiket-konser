<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketConfirmationController extends Controller
{
    public function show(Ticket $ticket)
    {
        // Only allow if paid
        if ($ticket->payment_status !== 'paid') {
            abort(403, 'Pembayaran belum selesai');
        }

        // Generate QR if missing
        if (empty($ticket->qr_code_path)) {
            $qrCode = new QrCode($ticket->id);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            
            $path = "storage/qrcodes/{$ticket->id}.png";
            $result->saveToFile(public_path($path));
            $ticket->update(['qr_code_path' => $path]);
        }

        return view('confirmation', compact('ticket'));
    }

    public function downloadPdf(Ticket $ticket)
    {
        // Only allow if paid
        if ($ticket->payment_status !== 'paid') {
            abort(403, 'Pembayaran belum selesai');
        }

        // Generate QR if missing
        if (empty($ticket->qr_code_path)) {
            $qrCode = new QrCode($ticket->id);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            
            $path = "storage/qrcodes/{$ticket->id}.png";
            $result->saveToFile(public_path($path));
            $ticket->update(['qr_code_path' => $path]);
        }

        $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
        return $pdf->download("tiket-{$ticket->id}.pdf");
    }
}
