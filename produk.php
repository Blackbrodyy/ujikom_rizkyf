<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">produk</li>
    </ol>
    <a href="?page=produk_tambah" class="btn btn-primary">+ Tambah data</a>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-dark text-light">Nama produk</th>
                <th class="bg-dark text-light">harga</th>
                <th class="bg-dark text-light">stok</th>
                <th class="bg-dark text-light">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = mysqli_query($koneksi, "SELECT * FROM produk");
                while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['nama_produk']); ?></td>
                    <td><?php echo htmlspecialchars($data['harga']); ?></td>
                    <td><?php echo htmlspecialchars($data['stok']); ?></td>
                    <td>
                        <a href="?page=produk_ubah&id=<?php echo $data['id_produk'];  ?>" class="btn btn-success"><i class="bi bi-pencil-fill"></i></a>
                        <a href="?page=produk_hapus&id=<?php echo $data['id_produk']; ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
