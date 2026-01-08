<?php
include '../conn/koneksi.php'; // Sesuaikan dengan lokasi file koneksi

// Query untuk menghapus semua data aspirasi
$query = "DELETE FROM aspirasi";

if (mysqli_query($koneksi, $query)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($koneksi)]);
}
?>
