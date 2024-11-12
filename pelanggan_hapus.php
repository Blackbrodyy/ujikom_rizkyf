<?php
$id = $_GET['id'];


$query = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan = $id");

if ($query) {
    echo '<script>alert("Berhasil menghapus data."); window.location.href="?page=pelanggan";</script>';
} else {
    echo '<script>alert("Gagal menghapus data.");</script>';
}
?>
