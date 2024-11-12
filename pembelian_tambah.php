<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pelanggan'], $_POST['produk'], $_POST['anggaran'])) {
    $id_pelanggan = mysqli_real_escape_string($koneksi, $_POST['id_pelanggan']);
    $produk = $_POST['produk'];
    $anggaran = floatval($_POST['anggaran']); // Menangani nilai anggaran
    $total = 0;
    $tanggal = date('Y-m-d H:i:s');

    // Menyimpan data penjualan, termasuk anggaran
    $stmt = $koneksi->prepare("INSERT INTO penjualan (tanggal_penjualan, id_pelanggan, anggaran) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $tanggal, $id_pelanggan, $anggaran);
    
    if ($stmt->execute()) {
        $idTerakhir = $koneksi->insert_id;

        foreach ($produk as $key => $val) {
            if ($val > 0) { 
                $stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
                $stmt->bind_param("i", $key);
                $stmt->execute();
                $result = $stmt->get_result();
                $pr = $result->fetch_array();

                if ($pr) {
                    $sub = $val * $pr['harga'];
                    $total += $sub;

                    // Menyimpan detail penjualan
                    $stmtDetail = $koneksi->prepare("INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah_produk, sub_total) VALUES (?, ?, ?, ?)");
                    $stmtDetail->bind_param("iiid", $idTerakhir, $key, $val, $sub);
                    if (!$stmtDetail->execute()) {
                        echo '<div class="alert alert-danger">Gagal menambah detail penjualan: ' . $stmtDetail->error . '</div>';
                        exit;
                    }

                    // Mengurangi stok produk
                    $new_stok = $pr['stok'] - $val;
                    $stmtUpdateStok = $koneksi->prepare("UPDATE produk SET stok = ? WHERE id_produk = ?");
                    $stmtUpdateStok->bind_param("ii", $new_stok, $key);
                    if (!$stmtUpdateStok->execute()) {
                        echo '<div class="alert alert-danger">Gagal memperbarui stok produk: ' . $stmtUpdateStok->error . '</div>';
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
    <h1 class="mt-4">Tambah Penjualan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Penjualan</li>
    </ol>
    <a href="?page=pembelian" class="btn btn-danger"><i class="bi bi-backspace"></i></a>
    <hr>
    <form method="post">
        <table class="table table-bordered bg-secondary text-light">
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
                <td>Anggaran (Uang Pelanggan)</td>
                <td>:</td>
                <td>
                    <input class="form-control" type="number" name="anggaran" id="anggaran" required min="0" value="0" oninput="hitungKembalian()">
                </td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td>:</td>
                <td id="kembalian">0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-basket3-fill"></i></button>
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
    hitungKembalian(); // Update kembalian setiap kali total harga dihitung ulang
}

function hitungKembalian() {
    const totalHarga = parseFloat(document.getElementById('total-harga').innerText) || 0;
    const anggaran = parseFloat(document.getElementById('anggaran').value) || 0;
    const kembalian = anggaran - totalHarga;

    document.getElementById('kembalian').innerText = kembalian >= 0 ? kembalian.toFixed(2) : '0.00';
}
</script>
