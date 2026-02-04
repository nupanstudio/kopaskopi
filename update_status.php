<?php
include 'db.php';
if(isset($_POST['proses'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "UPDATE pesanan SET status = 'proses' WHERE id = '$id'");
}
if(isset($_POST['selesai'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "UPDATE pesanan SET status = 'selesai' WHERE id = '$id'");
}
header("Location: admin.php");
?>