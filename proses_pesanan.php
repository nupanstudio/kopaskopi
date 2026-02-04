<?php
include 'db.php';
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $nama = $data['customer'];
    $meja = $data['meja'];
    $total = $data['total'];
    $items = [];
    $jml = 0;
    $notes = [];

    foreach ($data['cart'] as $i) {
        $items[] = $i['nama'] . " x" . $i['qty'];
        $jml += $i['qty'];
        if($i['note']) $notes[] = $i['nama'].": ".$i['note'];
    }

    $items_fix = implode(", ", $items);
    $notes_fix = implode(" | ", $notes);

    $q = "INSERT INTO pesanan (nama_pelanggan, no_meja, items, jumlah_item, total_harga, notes, status) 
          VALUES ('$nama', '$meja', '$items_fix', '$jml', '$total', '$notes_fix', 'baru')";
    
    if(mysqli_query($conn, $q)) echo json_encode(['status' => 'success']);
}
?>