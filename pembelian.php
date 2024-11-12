<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="container-fluid px-4">
    <h1 class="mt-4">Pembelian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pembelian</li>
    </ol>
    <a href="?page=pembelian_tambah" class="btn btn-primary"><i class="bi bi-bag-plus"></i></a>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-dark text-light">Tanggal Pembelian</th>
                <th class="bg-dark text-light">Pelanggan</th>
                <th class="bg-dark text-light">Total Harga</th>
                <th class="bg-dark text-light">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Pastikan koneksi sudah ada
        if ($koneksi) {
            $query = mysqli_query($koneksi, "SELECT penjualan.*, pelanggan.nama_pelanggan FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan");

            if (!$query) {
                die("Query failed: " . mysqli_error($koneksi));
            }

            // Loop untuk menampilkan data
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo isset($data['tanggal_penjualan']) ? $data['tanggal_penjualan'] : 'Tidak ada'; ?></td>
                    <td><?php echo isset($data['nama_pelanggan']) ? $data['nama_pelanggan'] : 'Tidak ada'; ?></td>
                    <td><?php echo isset($data['total_harga']) ? $data['total_harga'] : 'Tidak ada'; ?></td>
                    <td>
                        <a href="?page=penjualan_ubah&id=<?php echo $data['id_penjualan']; ?>" class="btn btn-secondary"><i class="bi bi-search"></i></a>
                        <a href="?page=penjualan_hapus&id=<?php echo $data['id_penjualan']; ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="4">Gagal terhubung ke database.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>