<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Produk</li>
    </ol>

    <!-- Button to add new product -->
   
    <!-- Table to display product data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-dark text-light">Nama Produk</th>
                <th class="bg-dark text-light">Harga</th>
                <th class="bg-dark text-light">Stok</th>
                <th class="bg-dark text-light">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Include database connection file
                include('koneksi.php');

                // Query to fetch product data
                $query = "SELECT * FROM produk";
                $result = mysqli_query($koneksi, $query);

                // Check if query was successful
                if ($result) {
                    // Loop through each product data and display in table
                    while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['nama_produk']); ?></td>
                    <td><?php echo htmlspecialchars($data['harga']); ?></td>
                    <td><?php echo htmlspecialchars($data['stok']); ?></td>
                    <td>
                        <!-- Edit and Delete buttons -->
                        <a href="?page=produk_ubah&id=<?php echo $data['id_produk']; ?>" class="btn btn-success"><i class="bi bi-pencil-fill"></i></a>
                        <a href="?page=produk_hapus&id=<?php echo $data['id_produk']; ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                </tr>
            <?php
                    }
                } else {
                    // If no products are found
                    echo "<tr><td colspan='4'>Data tidak ditemukan</td></tr>";
                }
            ?>
        </tbody>
    </table>

    <!-- Back Button (optional, if necessary) -->
    <div class="row mb-4">
        <div class="col-auto">
            <form action="index.php" method="post">
                <button type="submit" class="btn btn-secondary">Kembali</button>
            </form>
        </div>
    </div>
</div>
