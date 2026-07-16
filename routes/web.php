<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\TicketConfirmationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Registration
Route::post('/register-ticket', [TicketController::class, 'store'])->name('ticket.store');

// Checkout flow
Route::get('/checkout/confirm/{ticket}', [CheckoutController::class, 'confirm'])
    ->name('checkout.confirm')
    ->middleware('signed');

// Midtrans webhook
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle'])
    ->name('midtrans.callback');

// Confirmation after payment
Route::get('/ticket/{ticket}/confirmation', [TicketConfirmationController::class, 'show'])
    ->name('ticket.confirmation')
    ->middleware('signed');

Route::get('/ticket/{ticket}/download-pdf', [TicketConfirmationController::class, 'downloadPdf'])
    ->name('ticket.download-pdf')
    ->middleware('signed');
