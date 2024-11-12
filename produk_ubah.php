<?php 
$id = $_GET['id'];

// Pastikan $id adalah angka untuk mencegah SQL Injection
$id = intval($id);

if (isset($_POST['nama_produk'])) {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Pastikan koneksi sudah benar dan menghindari SQL Injection
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $harga = mysqli_real_escape_string($koneksi, $harga);
    $stok = mysqli_real_escape_string($koneksi, $stok);

    $update = mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama', harga='$harga', stok='$stok' WHERE id_produk=$id");

    if ($update) {
        echo '<script>alert("Berhasil mengubah data."); window.location.href="?page=produk";</script>';
    } else {
        echo '<script>alert("Gagal mengubah data.");</script>';
    }
}

// Mengambil data pelanggan
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo '<script>alert("Data tidak ditemukan."); window.location.href="?page=produk";</script>';
    exit;
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <a href="?page=pelanggan" class="btn btn-danger">+ Kembali</a>
    <hr>
    <form method="post">
        <table class="table table-bordered">
            <tr>
                <td width="200px">Nama Produk</td>
                <td width="1">:</td>
                <td><input class="form-control" value="<?php echo htmlspecialchars($data['nama_produk']); ?>" type="text" name="nama_produk" required></td>
            </tr>
            <tr>
                <td>harga</td>
                <td>:</td>
                <td>
                    <textarea name="harga" rows="5" class="form-control" required><?php echo htmlspecialchars($data['harga']); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>stok</td>
                <td>:</td>
                <td><input class="form-control" type="tel" value="<?php echo htmlspecialchars($data['stok']); ?>" name="stok" required></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </td>
            </tr>
        </table>
    </form>
</div>
