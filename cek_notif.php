<?php
include 'db.php';
$q = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'baru'");
$d = mysqli_fetch_assoc($q);
echo json_encode(['count' => $d['total']]);
?>