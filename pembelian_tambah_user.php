<?php 
include('koneksi.php'); // Pastikan koneksi sudah benar

// Inisialisasi
$stmtUpdate = null; // Inisialisasi agar tidak ada error

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pelanggan'], $_POST['produk'])) {
    $id_pelanggan = mysqli_real_escape_string($koneksi, $_POST['id_pelanggan']);
    $produk = $_POST['produk'];
    $total = 0;
    $tanggal = date('Y-m-d H:i:s');

    // Menyimpan data penjualan
    $stmt = $koneksi->prepare("INSERT INTO penjualan (tanggal_penjualan, id_pelanggan) VALUES (?, ?)");
    $stmt->bind_param("si", $tanggal, $id_pelanggan);

    if ($stmt->execute()) {
        $idTerakhir = $koneksi->insert_id;

        // Proses menyimpan detail produk
        foreach ($produk as $key => $val) {
            if ($val > 0) {
                $stmtDetail = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
                $stmtDetail->bind_param("i", $key);
                $stmtDetail->execute();
                $resultDetail = $stmtDetail->get_result();
                $pr = $resultDetail->fetch_array();

                if ($pr) {
                    $sub = $val * $pr['harga'];
                    $total += $sub;

                    // Menyimpan detail penjualan
                    $stmtDetailPenjualan = $koneksi->prepare("INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah_produk, sub_total) VALUES (?, ?, ?, ?)");
                    $stmtDetailPenjualan->bind_param("iiid", $idTerakhir, $key, $val, $sub);
                    if (!$stmtDetailPenjualan->execute()) {
                        echo '<div class="alert alert-danger">Gagal menambah detail penjualan: ' . $stmtDetailPenjualan->error . '</div>';
                        exit;
                    }

                    // Mengurangi stok produk
                    $new_stock = $pr['stok'] - $val;
                    $stmtUpdateStock = $koneksi->prepare("UPDATE produk SET stok = ? WHERE id_produk = ?");
                    $stmtUpdateStock->bind_param("ii", $new_stock, $key);
                    if (!$stmtUpdateStock->execute()) {
                        echo '<div class="alert alert-danger">Gagal memperbarui stok produk: ' . $stmtUpdateStock->error . '</div>';
                        exit;
                    }
                } else {
                    echo '<div class="alert alert-warning">Produk tidak ditemukan.</div>';
                }
            }
        }

        // Memperbarui total harga penjualan
        $stmtUpdate = $koneksi->prepare("UPDATE penjualan SET total_harga = ? WHERE id_penjualan = ?");
        $stmtUpdate->bind_param("di", $total, $idTerakhir);
        if ($stmtUpdate->execute()) {
            $_SESSION['total_harga'] = $total; // Simpan total harga ke sesi
            echo '<div class="alert alert-success">Berhasil menambah data.</div>';
            echo '<script>window.location.href="?page=pembelian";</script>';
        } else {
            echo '<div class="alert alert-danger">Gagal memperbarui total harga: ' . $stmtUpdate->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Gagal menambah data penjualan: ' . $stmt->error . '</div>';
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Pembelian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pembelian</li>
    </ol>
    <a href="?page=pembelian" class="btn btn-danger">+ Kembali</a>
    <hr>
    <form method="post">
        <table class="table table-bordered">
            <tr>
                <td width="200px">Nama Pelanggan</td>
                <td width="1">:</td>
                <td>
                    <select class="form-control form-select" name="id_pelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        <?php 
                        $p = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                        while ($pel = mysqli_fetch_array($p)) {
                        ?>
                            <option value="<?php echo htmlspecialchars($pel['id_pelanggan']); ?>">
                                <?php echo htmlspecialchars($pel['nama_pelanggan']); ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php 
            $pro = mysqli_query($koneksi, "SELECT * FROM produk");
            while ($produk = mysqli_fetch_array($pro)) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($produk['nama_produk']) . ' (stok: ' . htmlspecialchars($produk['stok']) . ', harga: ' . htmlspecialchars($produk['harga']) . ')'; ?></td>
                <td>:</td>
                <td>
                    <input class="form-control" type="number" min="0" max="<?php echo htmlspecialchars($produk['stok']); ?>" 
                           name="produk[<?php echo $produk['id_produk']; ?>]" 
                           value="0" required 
                           oninput="hitungTotal()"
                           data-harga="<?php echo htmlspecialchars($produk['harga']); ?>">
                </td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td>Total Harga</td>
                <td>:</td>
                <td id="total-harga">0.00</td>
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

<script>
function hitungTotal() {
    const totalElement = document.getElementById('total-harga');
    let total = 0;
    const inputs = document.querySelectorAll('input[type="number"]');

    inputs.forEach(input => {
        const jumlah = parseInt(input.value) || 0;
        const harga = parseFloat(input.dataset.harga) || 0;
        total += jumlah * harga;
    });

    totalElement.innerText = total.toFixed(2);
}
</script>

<?php
// Membersihkan sesi untuk total harga setelah transaksi selesai
if (isset($_SESSION['total_harga'])) {
    unset($_SESSION['total_harga']);
}
?>
