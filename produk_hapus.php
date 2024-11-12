<?php
$id = $_GET['id'];


$query = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = $id");

if ($query) {
    echo '<script>alert("Berhasil menghapus data."); window.location.href="?page=produk";</script>';
} else {
    echo '<script>alert("Gagal menghapus data.");</script>';
}
?>
