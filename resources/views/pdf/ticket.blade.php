<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket - Gempita Musik Akustik 2026</title>
    <style>
        @page { margin: 0; size: A4; }
        body { font-family: 'DejaVu Sans', sans-serif; margin: 0; padding: 20px; background: #f4f4f4; }
        .ticket { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .header .subtitle { margin-top: 8px; opacity: 0.9; font-size: 14px; }
        .status-badge { display: inline-block; background: #16a34a; color: white; padding: 6px 16px; border-radius: 20px; font-weight: 600; font-size: 12px; margin-top: 16px; }
        .content { padding: 30px; }
        .detail-row { display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #6b7280; font-weight: 500; }
        .detail-value { font-weight: 700; text-align: right; color: #111827; }
        .qr-section { text-align: center; margin: 30px 0; padding: 20px; background: #f9fafb; border-radius: 8px; }
        .qr-section img { max-width: 180px; }
        .qr-section p { margin: 12px 0 0; font-size: 12px; color: #6b7280; }
        .event-info { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 20px; }
        .event-info h3 { margin: 0 0 12px; font-size: 16px; color: #1e40af; }
        .event-info p { margin: 6px 0; font-size: 13px; color: #1e3a8a; }
        .footer { text-align: center; padding: 20px; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Gempita Musik Akustik 2026</h1>
            <div class="subtitle">E-Ticket Konfirmasi Pembayaran</div>
            <div class="status-badge">✓ PEMBAYARAN BERHASIL</div>
        </div>

        <div class="content">
            <div class="detail-row">
                <span class="detail-label">ID Tiket</span>
                <span class="detail-value">{{ $ticket->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nama Pemesan</span>
                <span class="detail-value">{{ $ticket->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $ticket->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Kategori Kursi</span>
                <span class="detail-value">{{ $ticket->seat_category }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Harga</span>
                <span class="detail-value">Rp{{ number_format($ticket->price, 0, ',', '.') }}</span>
            </div>

            <div class="qr-section">
                @if($ticket->qr_code_path && file_exists(public_path($ticket->qr_code_path)))
                    <img src="{{ public_path($ticket->qr_code_path) }}" alt="QR Code">
                @else
                    <div style="width: 180px; height: 180px; margin: 0 auto; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280; border-radius: 4px;">
                        QR Code
                    </div>
                @endif
                <p>Tunjukkan QR Code ini saat check-in</p>
            </div>

            <div class="event-info">
                <h3>Informasi Acara</h3>
                <p><strong>Tanggal:</strong> 25 Agustus 2026</p>
                <p><strong>Waktu:</strong> 19:00 - 22:00 WIB</p>
                <p><strong>Lokasi:</strong> Balai Sarbini, Jakarta</p>
            </div>
        </div>

        <div class="footer">
            <p>Tiket ini sah sebagai bukti pembayaran. Simpan dengan baik.</p>
            <p>&copy; 2026 Gempita Musik Indonesia. All rights reserved.</p>
        </div>
    </div>
</body>
</html>