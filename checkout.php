<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Keranjang - KOPAS KOPI</title>
    <link href="./assets/dist/css/tabler.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        :root { --primary-orange: #FF8A08; --soft-bg: #FDF7F0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--soft-bg); animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .nav-cart { padding: 20px; display: flex; align-items: center; gap: 15px; background: white; }
        .cart-card { background: white; border-radius: 20px; border: none; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden; }
        .btn-qty { width: 30px; height: 30px; border-radius: 10px; border: 1px solid #ddd; background: white; display: flex; align-items: center; justify-content: center; }
        .footer-checkout { position: fixed; bottom: 0; left: 0; right: 0; background: white; padding: 20px; border-radius: 30px 30px 0 0; box-shadow: 0 -10px 20px rgba(0,0,0,0.05); }
        .text-orange { color: var(--primary-orange); }
    </style>
</head>
<body>
    <div class="nav-cart">
        <a href="index.php" class="text-dark"><span class="material-symbols-rounded">arrow_back_ios</span></a>
        <h2 class="mb-0 fw-800">Keranjang Kamu</h2>
    </div>

    <div class="container py-3" style="padding-bottom: 150px;">
        <div id="cartItems"></div>
    </div>

    <div class="footer-checkout">
        <div class="d-flex justify-content-between mb-3 px-2">
            <span class="text-muted fw-bold">Total Pembayaran</span>
            <h2 class="fw-800 text-orange" id="totalBayar">Rp 0</h2>
        </div>
        <button onclick="window.location.href='pembayaran.php'" class="btn btn-primary w-100 py-3 fw-800" style="background: var(--primary-orange); border:none; border-radius: 50px;">LANJUT PEMBAYARAN</button>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('kopas_cart')) || [];

        function renderCart() {
            const container = document.getElementById('cartItems');
            if(cart.length === 0) {
                container.innerHTML = '<div class="text-center py-5"><h3 class="text-muted">Keranjang masih kosong...</h3><a href="index.php" class="btn btn-orange mt-3">Pesan Sekarang</a></div>';
                return;
            }

            let html = '';
            let total = 0;
            cart.forEach((item, index) => {
                total += item.harga * item.qty;
                html += `
                <div class="cart-card">
                    <div class="p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-4"><img src="${item.img}" class="img-fluid rounded-4"></div>
                            <div class="col-8">
                                <h4 class="mb-1 fw-bold">${item.nama}</h4>
                                <h4 class="text-orange mb-2">Rp ${(item.harga * item.qty).toLocaleString()}</h4>
                                <input type="text" class="form-control form-control-sm mb-2" value="${item.note}" onchange="updateNote(${index}, this.value)" placeholder="Catatan...">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn-qty" onclick="updateQty(${index}, -1)">-</button>
                                        <span class="fw-bold">${item.qty}</span>
                                        <button class="btn-qty" onclick="updateQty(${index}, 1)">+</button>
                                    </div>
                                    <button class="btn btn-sm text-danger border-0 ms-auto" onclick="hapusItem(${index})"><span class="material-symbols-rounded">delete</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
            container.innerHTML = html;
            document.getElementById('totalBayar').innerText = 'Rp ' + total.toLocaleString();
        }

        function updateQty(i, v) { cart[i].qty += v; if(cart[i].qty < 1) return hapusItem(i); save(); }
        function updateNote(i, v) { cart[i].note = v; save(); }
        function hapusItem(i) { cart.splice(i, 1); save(); }
        function save() { localStorage.setItem('kopas_cart', JSON.stringify(cart)); renderCart(); }
        renderCart();
    </script>
</body>
</html>