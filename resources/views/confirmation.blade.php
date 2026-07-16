<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - Gempita Musik Akustik 2026</title>
    <style>
        :root {
            --primary: #2563eb;
            --success: #16a34a;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        body { font-family: sans-serif; background: var(--light); color: var(--dark); padding: 40px 20px; }
        .container { max-width: 500px; margin: 0 auto; background: var(--white); padding: 30px; border-radius: 12px; box-shadow: var(--shadow); }
        .ticket-header { text-align: center; border-bottom: 2px solid var(--primary); padding-bottom: 20px; margin-bottom: 20px; }
        .ticket-header h1 { font-size: 1.5rem; margin-bottom: 5px; }
        .ticket-header .subtitle { color: #64748b; font-size: 0.875rem; }
        .status-badge { display: inline-block; background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.875rem; margin-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #64748b; font-weight: 500; }
        .detail-value { font-weight: 700; text-align: right; }
        .qr-section { text-align: center; margin: 30px 0; padding: 20px; background: #f1f5f9; border-radius: 8px; }
        .qr-section img { max-width: 200px; }
        .qr-section p { margin-top: 10px; font-size: 0.75rem; color: #64748b; }
        .event-info { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 15px; margin-top: 20px; }
        .event-info h3 { margin-bottom: 10px; font-size: 1rem; }
        .event-info p { margin: 5px 0; font-size: 0.875rem; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.75rem; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="ticket-header">
            <h1>Gempita Musik Akustik 2026</h1>
            <div class="subtitle">E-Ticket Konfirmasi</div>
        </div>

        <div class="status-badge">✓ PEMBAYARAN BERHASIL</div>

        <div class="detail-row">
            <span class="detail-label">ID Tiket</span>
            <span class="detail-value">{{ $ticket->id }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Nama</span>
            <span class="detail-value">{{ $ticket->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $ticket->email }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Kategori</span>
            <span class="detail-value">{{ $ticket->seat_category }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Harga</span>
            <span class="detail-value">Rp{{ number_format($ticket->price, 0, ',', '.') }}</span>
        </div>

        <div class="qr-section">
            @if($ticket->qr_code_path)
                <img src="{{ asset($ticket->qr_code_path) }}" alt="QR Code" />
            @else
                <div style="width: 200px; height: 200px; margin: 0 auto; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b;">
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

        <div class="footer">
            <a href="{{ URL::signedRoute('ticket.download-pdf', $ticket) }}" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: var(--primary); color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">Unduh PDF</a>
            <p style="margin-top: 20px;">Tiket ini sah sebagai bukti pembayaran. Simpan dengan baik.</p>
            <p>&copy; 2026 Gempita Musik Indonesia</p>
        </div>
    </div>
</body>
</html>