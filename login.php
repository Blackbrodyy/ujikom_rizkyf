<?php 
session_start(); // Pastikan session dimulai
include "koneksi.php";

if (isset($_POST['username'])) {
    // Menggunakan prepared statement untuk mencegah SQL injection
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Pastikan hashing aman; pertimbangkan menggunakan password_hash()

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");

    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_array($cek);
        $_SESSION['user'] = $data; // Menyimpan data user dalam session
        echo '<script>alert("Selamat datang di web saya"); location.href = "index.php";</script>';
    } else {
        echo '<script>alert("Username/password salah");</script>'; // Perbaiki penggunaan alert
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login Web Kasir</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-secondary">
    
    <h1 class="text-center mt-5">SMK BAKTI NUSANTARA 666</h1>
    <div class="d-flex justify-content-center">
        <img src="img/bn.png" alt="">
    </div>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-light">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login Web Kasir</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="text" name="username" placeholder="Masukkan username" required />
                                            <label for="inputEmail">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Masukkan password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-floating mb-3">
            </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0 bg-dark">
                                            <button type="submit" class="btn btn-primary w-100">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3 ">
                                    <div class="small"><a href="register.php">Belum punya akun? Register!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
