<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php 
if (isset($_POST['nama_produk'])) {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $harga = mysqli_real_escape_string($koneksi, $harga);
    $stok = mysqli_real_escape_string($koneksi, $stok);

   
    $insert = mysqli_query($koneksi, "INSERT INTO produk(nama_produk, harga, stok) VALUES ('$nama', '$harga', '$stok')");

    if ($insert) {
        echo '<script>alert("Berhasil menambah data."); window.location.href="?page=produk";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data.");</script>';
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <a href="?page=produk" class="btn btn-danger"><i class="bi bi-backspace"></i></a>
    <hr>
    <form method="post">
        <table class="table table-bordered bg-secondary text-light">
            <tr>
                <td width="200px">Nama Produk</td>
                <td width="1">:</td>
                <td><input class="form-control" type="text" name="nama_produk" required></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>:</td>
                <td><input class="form-control" type="number" name="harga" required></td>
            </tr>
            <tr>
                <td>Stok</td>
                <td>:</td>
                <td><input class="form-control" type="number" name="stok" required></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i></button>
                </td>
            </tr>
        </table>
    </form>
</div>
