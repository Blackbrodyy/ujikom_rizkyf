<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php 
include "koneksi.php"; // Pastikan koneksi sudah terhubung

$id = intval($_GET['id']); // Sanitasi input untuk ID

$query = mysqli_query($koneksi, "SELECT penjualan.*, pelanggan.nama_pelanggan FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan WHERE id_penjualan = $id");
$data = mysqli_fetch_array($query);
?>

<ol class="breadcrumb mb-4">
    <h1>Detail Penjualan</h1>
</ol>
<a href="?page=pembelian" class="btn btn-danger"><i class="bi bi-backspace"></i></a>
<hr>
<form method="post">
    <table class="table table-bordered bg-secondary">
        <tr>
            <td width="200px">Nama Pelanggan</td>
            <td width="1">:</td>
            <td>
                <select class="form-control form-select" name="id_pelanggan" required>
                    <option value="<?php echo($data['id_pelanggan']); ?>"><?php echo htmlspecialchars($data['nama_pelanggan']); ?></option>
                </select>
            </td>
        </tr>
        <?php 
        $pro = mysqli_query($koneksi, "SELECT * FROM detail_penjualan LEFT JOIN produk ON produk.id_produk = detail_penjualan.id_produk WHERE id_penjualan = $id");
        $total_harga = 0; // Inisialisasi total harga
        while ($produk = mysqli_fetch_array($pro)) {
            $total_harga += $produk['sub_total']; // Menghitung total harga
        ?>
        <tr>
            <td><?php echo ($produk['nama_produk']); ?></td>
            <td>:</td>
            <td>
                Harga : <?php echo($produk['harga']); ?><br>
                Jumlah : <?php echo ($produk['jumlah_produk']); ?><br>
                Sub Total : <?php echo ($produk['sub_total']); ?><br>
            </td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td>Total Harga</td>
            <td>:</td>
            <td id="total-harga"><?php echo number_format($total_harga, 2); ?></td>
        </tr>
        <tr>
            <td>Anggaran</td>
            <td>:</td>
            <td><?php echo number_format($data['anggaran'], 2); ?></td>
        </tr>
        <tr>
            <td>Kembalian</td>
            <td>:</td>
            <td>
                <?php
                $kembalian = $data['anggaran'] - $total_harga;
                echo number_format($kembalian >= 0 ? $kembalian : 0, 2);
                ?>
            </td>
        </tr>
    </table>
</form>
