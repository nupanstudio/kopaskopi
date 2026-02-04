<?php 
  include 'db.php';
  
  // 1. Hitung Total Pendapatan dari pesanan yang sudah 'selesai'
  $s_sales = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM pesanan WHERE status = 'selesai'");
  $d_sales = mysqli_fetch_assoc($s_sales);
  $total_duit = $d_sales['total'] ?? 0;

  // 2. Hitung jumlah pesanan yang sudah berhasil disajikan
  $s_done = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'selesai'");
  $d_done = mysqli_fetch_assoc($s_done);
  $total_selesai = $d_done['total'] ?? 0;

  // 3. Hitung jumlah pesanan yang masih antre (Baru + Proses)
  $s_queue = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status != 'selesai'");
  $d_queue = mysqli_fetch_assoc($s_queue);
  $total_antrean = $d_queue['total'] ?? 0;

  $current_page = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Dashboard | KOPAS KOPI</title>
    <link href="./assets/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./assets/dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        :root { --tblr-border-radius: 16px; }
        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 24px;
        }
        .card { border: none; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .navbar-vertical { background: #fff !important; border-right: 1px solid #f1f1f1; }
        .navbar-vertical .navbar-nav .nav-item.active .nav-link {
            background-color: #f1f5f9;
            color: #206bc4;
            border-radius: 12px;
            margin: 0 10px;
            padding: 10px 15px;
            font-weight: 600;
        }
        .bg-red-lt { background-color: #fef2f2 !important; color: #dc2626 !important; }
        .bg-blue-lt { background-color: #eff6ff !important; color: #2563eb !important; }

.table th, .table td { vertical-align: middle; text-align: left; padding: 12px; }
    .col-id { width: 60px; }
    .col-nama { width: 150px; }
    .col-meja { width: 100px; }
    .col-pesanan { width: auto; }
    .col-qty { width: 60px; }
    .col-total { width: 130px; }
    .col-notes { width: 180px; }
    .col-waktu { width: 100px; }
    .col-action { width: 100px; }
    </style>
</head>
<body>
    <div class="page">
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark mt-2">
                    <a href="."><img src="./assets/static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image"></a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
<ul class="navbar-nav pt-lg-3">
  <li class="nav-item <?= ($current_page == 'admin.php') ? 'active' : '' ?>">
      <a class="nav-link" href="admin.php">
          <span class="nav-link-icon material-symbols-rounded">dashboard</span>
          <span class="nav-link-title">Dashboard</span>
      </a>
  </li> 
  
  <li class="nav-item <?= ($current_page == 'produk.php') ? 'active' : '' ?>">
            <a class="nav-link" href="produk.php">
                <span class="nav-link-icon material-symbols-rounded">coffee</span>
                <span class="nav-link-title">Produk</span>
            </a>
        </li>
</ul>
                </div>
            </div>
        </aside>

        <div class="page-wrapper">
            <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
                <div class="container-xl">
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0">
                                <span class="avatar avatar-sm" style="background-image: url(./assets/static/avatars/000m.jpg)"></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Barista KOPAS</div>
                                    <div class="mt-1 small text-muted">Admin</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <h2 class="page-title">Dashboard Overview</h2>
                    </div>
                </div>
            </header>

            <div class="page-body">
                <div class="container-xl">
<div class="row row-deck row-cards mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm bg-blue-lt">
            <div class="card-body d-flex align-items-center">
                <span class="bg-blue text-white avatar shadow-sm">
                    <span class="material-symbols-rounded">payments</span>
                </span>
                <div class="ms-3">
                    <div class="font-weight-medium">Rp <?= number_format($total_duit) ?></div>
                    <div class="text-secondary">Total Pendapatan</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm bg-yellow-lt">
            <div class="card-body d-flex align-items-center">
                <span class="bg-warning text-white avatar shadow-sm">
                    <span class="material-symbols-rounded">pending_actions</span>
                </span>
                <div class="ms-3">
                    <div class="font-weight-medium"><?= $total_antrean ?> Pesanan</div>
                    <div class="text-secondary">Sedang Antre</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm bg-green-lt">
            <div class="card-body d-flex align-items-center">
                <span class="bg-success text-white avatar shadow-sm">
                    <span class="material-symbols-rounded">check_circle</span>
                </span>
                <div class="ms-3">
                    <div class="font-weight-medium"><?= $total_selesai ?></div>
                    <div class="text-secondary">Pesanan Selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-yellow-lt">
                <h3 class="card-title">
                    <span class="material-symbols-rounded">pending_actions</span>
                    Antrean Pesanan Baru
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-nama">NAMA</th>
                            <th class="col-meja">MEJA</th>
                            <th class="col-pesanan">PESANAN</th>
                            <th class="col-qty">QTY</th>
                            <th class="col-total">TOTAL</th>
                            <th class="col-notes">NOTES</th>
                            <th class="col-waktu">WAKTU</th>
                            <th class="col-action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q_baru = mysqli_query($conn, "SELECT * FROM pesanan WHERE status = 'baru' ORDER BY id ASC");
                        while($row = mysqli_fetch_array($q_baru)) {
                        ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td class="font-weight-bold"><?= $row['nama_pelanggan'] ?></td>
                            <td>Meja <?= $row['no_meja'] ?></td>
                            <td><?= $row['items'] ?></td>
                            <td><?= $row['jumlah_item'] ?></td>
                            <td>Rp <?= number_format($row['total_harga']) ?></td>
                            <td class="text-muted italic"><?= !empty($row['notes']) ? $row['notes'] : '-' ?></td>
                            <td><?= date('H:i', strtotime($row['created_at'])) ?></td>
                            <td>
                                <form action="update_status.php" method="POST" class="m-0">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="proses" class="btn btn-warning btn-sm">Proses</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-green-lt">
                <h3 class="card-title">
                    <span class="material-symbols-rounded">check_circle</span>
                    Sedang Disiapkan
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-nama">NAMA</th>
                            <th class="col-meja">MEJA</th>
                            <th class="col-pesanan">PESANAN</th>
                            <th class="col-qty">QTY</th>
                            <th class="col-total">TOTAL</th>
                            <th class="col-notes">NOTES</th>
                            <th class="col-waktu">WAKTU</th>
                            <th class="col-action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q_proses = mysqli_query($conn, "SELECT * FROM pesanan WHERE status = 'proses' ORDER BY id ASC");
                        while($row = mysqli_fetch_array($q_proses)) {
                        ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td class="font-weight-bold"><?= $row['nama_pelanggan'] ?></td>
                            <td>Meja <?= $row['no_meja'] ?></td>
                            <td><?= $row['items'] ?></td>
                            <td><?= $row['jumlah_item'] ?></td>
                            <td>Rp <?= number_format($row['total_harga']) ?></td>
                            <td class="text-muted italic"><?= !empty($row['notes']) ? $row['notes'] : '-' ?></td>
                            <td><?= date('H:i', strtotime($row['created_at'])) ?></td>
                            <td>
                                <form action="update_status.php" method="POST" class="m-0">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="selesai" class="btn btn-success btn-sm">Selesai</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>

    <script src="./assets/dist/js/tabler.min.js" defer>

let lastCount = -1;

function checkNewOrders() {
    fetch('cek_notif.php')
    .then(res => res.json())
    .then(data => {
        if (lastCount !== -1 && data.count > lastCount) {
            let audio = new Audio('./assets/sound/notification.mp3');
            audio.play();
            alert("Ada Pesanan Baru Masuk, Lur!");
            location.reload();
        }
        lastCount = data.count;
    });
}
setInterval(checkNewOrders, 5000);

    </script>

    
</body>
</html>