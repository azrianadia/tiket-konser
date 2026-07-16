<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'seat_category' => 'required|string'
        ]);

        $prices = [
            'VIP' => 500000,
            'Bawah Panggung' => 350000,
            'Di Tengah' => 200000,
            'Reguler Kanan' => 150000,
            'Reguler Kiri' => 150000,
        ];

        $price = $prices[$validated['seat_category']] ?? 0;

        $ticket = Ticket::create([
            'id' => (string) Str::uuid(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'seat_category' => $validated['seat_category'],
            'price' => $price,
        ]);

        return redirect()->signedRoute('checkout.confirm', $ticket)
            ->with('info', 'Silakan periksa detail pesanan sebelum membayar.');
    }
}
