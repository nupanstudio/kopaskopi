<?php 
include 'db.php';
$data_meja = [
    ['no' => '01', 'status' => 'available'],
    ['no' => '02', 'status' => 'occupied'], 
    ['no' => '03', 'status' => 'available'],
    ['no' => '04', 'status' => 'available'],
    ['no' => '05', 'status' => 'occupied'], 
];
$categories = [
    'signature' => 'Signature',
    'manual-brew' => 'Manual Brew',
    'based-coffee' => 'Based Coffee',
    'milky-sparkling' => 'Milky & Sparkling',
    'snack' => 'Snack',
    'dessert' => 'Dessert',
    'foods' => 'Foods'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>KOPAS KOPI - Official Store</title>
    
    <link href="./assets/dist/css/tabler.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* IMPORT FONT ALINSA LOKAL */
        @font-face {
            font-family: 'Alinsa';
            src: url('./assets/fonts/alinsa.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        :root { --primary-orange: #FF8A08; --dark-bg: #1A1A1A; --soft-bg: #FDF7F0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--soft-bg); margin: 0; overflow-x: hidden; }
        
        /* Menghilangkan Underline pada Link */
        a { text-decoration: none !important; }

        /* LOGO STYLING (ALINSA) */
        .logo-container { display: flex; flex-direction: column; line-height: 1; }
        .logo-text { 
            font-family: 'Alinsa', sans-serif; 
            font-size: 35px; 
            font-style: italic; /* Sesuai logo resmi yang miring */
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .logo-text b { color: var(--primary-orange); font-weight: normal; }
        .logo-text span { color: white; }
        .logo-slogan { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 5px; 
            font-weight: 800; 
            color: var(--primary-orange); 
            letter-spacing: 1.2px; 
            margin-top: -2px;
            display: flex; /* Menggunakan flex agar garis sejajar teks */
            align-items: center;
            gap: 8px; /* Jarak antara teks dan garis */
            text-transform: uppercase;
        }
        .logo-slogan::after {
            content: "";
            flex: 1; /* Membuat garis mengisi sisa ruang yang ada */
            height: 1.5px; /* Ketebalan garis */
            background-color: var(--primary-orange); /* Warna garis */
            min-width: 15px; /* Panjang minimal garis */
        }

        .navbar-custom { position: absolute; top: 0; left: 0; right: 0; z-index: 1000; padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; }
        .nav-icon { color: white; background: none; border: none; padding: 8px; display: flex; align-items: center; cursor: pointer; position: relative; }
        
        .hero-section { height: 60vh; min-height: 400px; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.2)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white; padding: 20px; }
        .hero-section h1 { font-size: clamp(2.5rem, 10vw, 5rem); font-weight: 800; line-height: 1; margin-bottom: 20px; }
        
        .search-area { padding: 0 20px; margin-top: -30px; position: relative; z-index: 10; }
        .search-box { background: white; border-radius: 15px; padding: 10px 20px; display: flex; align-items: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .search-box input { border: none; outline: none; width: 100%; padding: 10px; }
        
        .badge-cart { position: absolute; top: 2px; right: 2px; background: #FF0000; color: white; font-size: 11px; min-width: 20px; height: 20px; border-radius: 50%; display: none; font-weight: 800; border: 2px solid #1a1a1a; align-items: center; justify-content: center; z-index: 1001; }
        .fly-item { position: fixed; z-index: 9999; width: 60px; height: 60px; object-fit: cover; border-radius: 50%; pointer-events: none; transition: all 1.2s cubic-bezier(0.1, 0.5, 0.1, 1); border: 3px solid var(--primary-orange); }

        .meja-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .meja-opt { border: 2px solid #eee; border-radius: 15px; padding: 15px 5px; text-align: center; cursor: pointer; font-weight: 800; transition: 0.3s; }
        .meja-opt.selected { border-color: var(--primary-orange); background: #FFF4E6; color: var(--primary-orange); }
        .meja-opt.disabled { background: #f5f5f5; color: #ccc; cursor: not-allowed; }
        .meja-indicator { background: var(--primary-orange); color: white; padding: 6px 15px; border-radius: 50px; font-weight: 800; font-size: 12px; margin-top: 10px; display: inline-block; cursor: pointer; }

        /* FOOTER HITAM TOTAL */
        footer { background-color: var(--primary-orange); color: #000000 !important; padding: 60px 20px 30px; border-radius: 40px 40px 0 0; margin-top: 50px; }
        
        /* Maksa semua text di footer jadi Hitam */
        footer .logo-text b, 
        footer .logo-text span, 
        footer .logo-slogan,
        footer h4, 
        footer p, 
        footer .copyright-text { 
            color: #000000 !important; 
        }

        /* KHUSUS: Garis Slogan di Footer harus Hitam agar Muncul */
        footer .logo-slogan::after {
            background-color: #000000 !important;
            display: inline-block !important; /* Memastikan render */
            visibility: visible !important;
        }
        .social-btn { width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #FFFFFF !important; background: #000000; transition: 0.3s; }
        .social-btn:hover { background: white; color: var(--primary-orange) !important; }
        .copyright-text { border-top: 1px solid rgba(0,0,0,0.1); margin-top: 30px; padding-top: 20px; font-size: 0.75rem; text-align: center; color: #000000; }
    </style>
</head>
<body>
    <div class="modal fade" id="modalPilihMeja" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="border-radius: 30px;">
                <div class="modal-body p-4 text-center">
                    <h2 class="fw-800 mb-2">Selamat Datang!</h2>
                    <p class="text-muted small mb-3">Silahkan isi nama dan pilih meja.</p>
                    <input type="text" id="global_customer" class="form-control mb-3 text-center fw-bold py-2" placeholder="Tulis Nama Anda..." style="border-radius: 12px;">
                    <div class="meja-grid mb-4">
                        <?php foreach($data_meja as $m): ?>
                            <div class="meja-opt <?= ($m['status'] == 'occupied') ? 'disabled' : '' ?>" onclick="<?= ($m['status'] == 'available') ? "selectMeja('".$m['no']."', this)" : "" ?>">
                                <?= $m['no'] ?>
                                <div style="font-size: 8px; font-weight: 400;"><?= ($m['status'] == 'occupied') ? 'FULL' : 'READY' ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button id="btnMulai" class="btn btn-primary w-100 py-3 fw-800" style="border-radius: 50px; background: var(--primary-orange); border:none;" disabled onclick="mulaiOrder()">MULAI PESAN</button>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center gap-3">
        <!-- Burger Menu   
        <button class="nav-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#sideMenu">
                <span class="material-symbols-rounded" style="font-size: 32px;">menu</span>
            </button>
        -->
            <div class="logo-container">
                <div class="logo-text"><b>KOPAS</b></div>
                <div class="logo-slogan">KOPI PAS, HARGA PAS </div>
            </div>
        </div>
        <a href="checkout.php" class="nav-icon" id="cartIcon">
            <span class="material-symbols-rounded" style="font-size: 32px;">shopping_bag</span>
            <span id="cartBadge" class="badge-cart">0</span>
        </a>
    </nav>

    <section class="hero-section">
        <p class="text-uppercase fw-bold mb-2" style="letter-spacing: 5px; font-size: 0.8rem;">Exclusive Coffee House</p>
        <h1>Better Beans <br><span style="color: var(--primary-orange);">Better Days.</span></h1>
        <div id="displayMeja" class="meja-indicator" style="display:none" onclick="changeMeja()">Meja --</div>
    </section>

    <div class="search-area container">
        <div class="search-box">
            <span class="material-symbols-rounded text-muted">search</span>
            <input type="text" id="searchInput" placeholder="Cari menu..." onkeyup="searchMenu()">
        </div>
    </div>

    <div id="menu" class="container-fluid py-4">
        <div class="row g-3">
            <?php
            $items = [
                ['id'=>1, 'cat'=>'signature', 'nama'=>'KOPAS-UP', 'harga'=>18000, 'img'=>'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=600'],
                ['id'=>2, 'cat'=>'based-coffee', 'nama'=>'Americano Ice', 'harga'=>18000, 'img'=>'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=600']
            ];
            foreach($items as $i): ?>
            <div class="col-6 menu-item" data-category="<?= $i['cat'] ?>">
                <div class="card border-0 shadow-sm" onclick="openDetail(<?= htmlspecialchars(json_encode($i)) ?>)" style="border-radius: 20px; overflow: hidden; cursor: pointer;">
                    <img src="<?= $i['img'] ?>" style="height: 160px; object-fit: cover;">
                    <div class="p-3">
                        <h3 class="mb-1 fw-bold h4"><?= $i['nama'] ?></h3>
                        <p class="fw-bold mb-0" style="color: var(--primary-orange);">Rp <?= number_format($i['harga']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="logo-container mb-3">
                    <div class="logo-text">KOPAS</div>
                    <div class="logo-slogan">KOPI PAS, HARGA PAS</div>
                </div>
                    <p class="opacity-75">Jl. Pepaya No.20, Nagasari, Kec. Karawang Barat, Karawang, Jawa Barat 41314.</p>
                </div>
                <div class="col-md-4 text-md-center">
                    <h4 class="mb-4">CONTACT US</h4>
                    <div class="d-flex justify-content-md-center gap-3">
                        <a href="https://instagram.com/kopas.kopi" target="_blank" class="social-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <a href="https://wa.me/6282151613902" target="_blank" class="social-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="height: 150px; border-radius: 15px; overflow: hidden;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3051772445836!2d107.29742617482928!3d-6.223434693764724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6977df7902d26f%3A0xe54d6f85d26a27e!2sJl.%20Pepaya%20No.20%2C%20Nagasari%2C%20Kec.%20Karawang%20Bar.%2C%20Karawang%2C%20Jawa%20Barat%2041314!5e0!3m2!1sid!2sid!4v1707044155823!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
            <div class="copyright-text">© 2026 <b>KOPAS KOPI</b>. All Rights Reserved.</div>
        </div>
    </footer>

    <div class="modal fade" id="modalMenu" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 25px;">
                <div class="modal-body p-4 text-center">
                    <h2 class="fw-800 mb-3" id="m_nama"></h2>
                    <img src="" id="m_img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 15px; margin-bottom: 15px;">
                    <p class="fs-2 fw-800 mb-3" id="m_harga" style="color: var(--primary-orange);"></p>
                    <input type="number" id="m_qty" class="form-control mb-3 text-center" value="1" min="1" style="border-radius: 10px;">
                    <button class="btn btn-primary w-100 py-3 fw-800" onclick="handleAddToCart()" style="background: var(--primary-orange); border:none; border-radius: 50px;">TAMBAH KE KERANJANG</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/dist/js/tabler.min.js"></script>
    <script>
        let cart = JSON.parse(localStorage.getItem('kopas_cart')) || [];
        let selectedMeja = localStorage.getItem('kopas_meja') || null;
        let customerName = localStorage.getItem('kopas_customer') || '';
        let currentItem = null;

        function checkMeja() {
            if (!selectedMeja || !customerName) {
                const modalObj = new bootstrap.Modal(document.getElementById('modalPilihMeja'));
                modalObj.show();
            } else {
                $("#displayMeja").text(`Meja ${selectedMeja} - ${customerName}`).show();
            }
        }

        function selectMeja(no, el) {
            $(".meja-opt").removeClass("selected");
            $(el).addClass("selected");
            selectedMeja = no;
            $("#btnMulai").prop("disabled", false);
        }

        function mulaiOrder() {
            const inputNama = $("#global_customer").val().trim();
            if(!inputNama) return alert('Isi Nama Lur!');
            localStorage.setItem('kopas_meja', selectedMeja);
            localStorage.setItem('kopas_customer', inputNama);
            location.reload();
        }

        function changeMeja() { 
            localStorage.removeItem('kopas_meja');
            localStorage.removeItem('kopas_customer');
            location.reload();
        }

        function searchMenu() {
            let val = $("#searchInput").val().toLowerCase();
            $(".menu-item").each(function() {
                let name = $(this).find('h3').text().toLowerCase();
                $(this).toggle(name.includes(val));
            });
        }

        function updateCartBadge() {
            const total = cart.reduce((sum, item) => sum + parseInt(item.qty), 0);
            $("#cartBadge").text(total).toggle(total > 0).css("display", total > 0 ? "flex" : "none");
        }

        function openDetail(item) {
            currentItem = item;
            $("#m_nama").text(item.nama);
            $("#m_img").attr("src", item.img);
            $("#m_harga").text('Rp ' + item.harga.toLocaleString());
            new bootstrap.Modal(document.getElementById('modalMenu')).show();
        }

        function handleAddToCart() {
            const qty = parseInt($("#m_qty").val());
            cart.push({ ...currentItem, qty });
            localStorage.setItem('kopas_cart', JSON.stringify(cart));
            updateCartBadge();
            bootstrap.Modal.getInstance(document.getElementById('modalMenu')).hide();
        }

        $(document).ready(function() { 
            checkMeja(); 
            updateCartBadge(); 
        });
    </script>
</body>
</html>