<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Gempita Musik Akustik 2026</title>
    <style>
        :root {
            --primary: #2563eb;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        body { font-family: sans-serif; background: var(--light); color: var(--dark); padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background: var(--white); padding: 30px; border-radius: 12px; box-shadow: var(--shadow); }
        h1 { font-size: 1.5rem; margin-bottom: 20px; text-align: center; }
        .summary { margin-bottom: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
        .item { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .label { font-weight: 600; color: #64748b; }
        .value { font-weight: 700; }
        .total { border-top: 2px solid #e2e8f0; margin-top: 20px; padding-top: 15px; font-size: 1.25rem; }
        .btn-pay { width: 100%; padding: 16px; background: #16a34a; color: var(--white); border: none; border-radius: 8px; font-size: 1.125rem; font-weight: 700; cursor: pointer; margin-top: 20px; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #64748b; text-decoration: none; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ringkasan Pesanan</h1>
        
        <div class="summary">
            <div class="item">
                <span class="label">Nama Pemesan</span>
                <span class="value">{{ $ticket->name }}</span>
            </div>
            <div class="item">
                <span class="label">Email</span>
                <span class="value">{{ $ticket->email }}</span>
            </div>
            <div class="item">
                <span class="label">No. Telepon</span>
                <span class="value">{{ $ticket->phone }}</span>
            </div>
            <div class="item">
                <span class="label">Kategori Kursi</span>
                <span class="value">{{ $ticket->seat_category }}</span>
            </div>
            <div class="item total">
                <span class="label">Total Bayar</span>
                <span class="value">Rp{{ number_format($ticket->price, 0, ',', '.') }}</span>
            </div>
        </div>

        <button id="pay-button" class="btn-pay">Bayar Sekarang</button>
        <a href="/" class="btn-back">Batal & Kembali</a>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ URL::signedRoute('ticket.confirmation', $ticket) }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</body>
</html>