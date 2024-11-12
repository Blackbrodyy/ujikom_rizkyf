<?php 
$id = $_GET['id'];

// Pastikan $id adalah angka untuk mencegah SQL Injection
$id = intval($id);

if (isset($_POST['nama_pelanggan'])) {
    $nama = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    // Pastikan koneksi sudah benar dan menghindari SQL Injection
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $alamat = mysqli_real_escape_string($koneksi, $alamat);
    $no_telepon = mysqli_real_escape_string($koneksi, $no_telepon);

    $update = mysqli_query($koneksi, "UPDATE pelanggan SET nama_pelanggan='$nama', alamat='$alamat', no_telepon='$no_telepon' WHERE id_pelanggan=$id");

    if ($update) {
        echo '<script>alert("Berhasil mengubah data."); window.location.href="?page=pelanggan";</script>';
    } else {
        echo '<script>alert("Gagal mengubah data.");</script>';
    }
}

// Mengambil data pelanggan
$query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = $id");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo '<script>alert("Data tidak ditemukan."); window.location.href="?page=pelanggan";</script>';
    exit;
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
        <table class="table table-bordered">
            <tr>
                <td width="200px">Nama Pelanggan</td>
                <td width="1">:</td>
                <td><input class="form-control" value="<?php echo htmlspecialchars($data['nama_pelanggan']); ?>" type="text" name="nama_pelanggan" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="alamat" rows="5" class="form-control" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>:</td>
                <td><input class="form-control" type="tel" value="<?php echo htmlspecialchars($data['no_telepon']); ?>" name="no_telepon" required></td>
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
