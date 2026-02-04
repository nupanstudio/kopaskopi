<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Pembayaran - KOPAS KOPI</title>
    <link href="./assets/dist/css/tabler.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;800&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        :root { --primary-orange: #FF8A08; --dark-bg: #1A1A1A; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--dark-bg); color: white; height: 100vh; display: flex; align-items: center; }
        .pay-card { background: #242424; border-radius: 35px; border: 1px solid #333; padding: 40px 30px; text-align: center; width: 100%; }
        .total-box { background: rgba(255,138,8,0.1); border: 2px dashed var(--primary-orange); border-radius: 20px; padding: 20px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="pay-card">
                    <span class="material-symbols-rounded text-orange" style="font-size: 64px;">check_circle</span>
                    <h2 class="fw-800 mt-3 mb-1">Konfirmasi Pesanan</h2>
                    <p class="opacity-50">Silahkan lakukan pembayaran di Kasir atau melalui scan QRIS di meja.</p>
                    
                    <div class="total-box">
                        <p class="mb-1">Total Tagihan</p>
                        <h1 class="fw-800 mb-0 text-orange" id="p_total">Rp 0</h1>
                    </div>

                    <button id="btnSelesai" onclick="kirimPesanan()" class="btn btn-primary w-100 py-3 fw-800" style="background: var(--primary-orange); border:none; border-radius: 50px;">KONFIRMASI SEKARANG</button>
                    <a href="checkout.php" class="btn btn-link text-white opacity-50 mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const cart = JSON.parse(localStorage.getItem('kopas_cart')) || [];
        const total = cart.reduce((sum, i) => sum + (i.harga * i.qty), 0);
        document.getElementById('p_total').innerText = 'Rp ' + total.toLocaleString();

        function kirimPesanan() {
            const btn = document.getElementById('btnSelesai');
            btn.disabled = true;
            btn.innerText = "Mengirim...";

            const payload = {
                customer: localStorage.getItem('kopas_customer'),
                meja: localStorage.getItem('kopas_meja'),
                total: total,
                cart: cart
            };

            fetch('proses_pesanan.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    localStorage.removeItem('kopas_cart');
                    alert("Pesanan diterima Barista! Mohon tunggu ya.");
                    window.location.href = "index.php";
                }
            });
        }
    </script>
</body>
</html>