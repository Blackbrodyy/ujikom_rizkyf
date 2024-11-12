<?php 
if (isset($_POST['nama_pelanggan'])) {
    $nama = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    // Pastikan koneksi sudah benar dan menghindari SQL Injection
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $alamat = mysqli_real_escape_string($koneksi, $alamat);
    $no_telepon = mysqli_real_escape_string($koneksi, $no_telepon);

    $insert = mysqli_query($koneksi, "INSERT INTO pelanggan(nama_pelanggan, alamat, no_telepon) VALUES ('$nama', '$alamat', '$no_telepon')");

    if ($insert) {
        echo '<script>alert("Berhasil menambah data."); window.location.href="?page=pelanggan";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data.");</script>';
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pelanggan</li>
    </ol>
    <a href="?page=pelanggan" class="btn btn-danger">+ Kembali</a>
    <hr>
    <form method="post">
        <table class="table table-bordered bg-secondary text-light">
            <tr>
                <td width="200px">Nama Pelanggan</td>
                <td width="1">:</td>
                <td><input class="form-control" type="text" name="nama_pelanggan" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="alamat" rows="5" class="form-control" required></textarea>
                </td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>:</td>
                <td><input class="form-control" type="tel" name="no_telepon" required></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </td>
            </tr>
        </table>
    </form>
</div>
