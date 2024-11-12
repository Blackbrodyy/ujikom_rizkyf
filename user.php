<?php
session_start(); // Start the session
include "koneksi.php";

// Redirect if no session or invalid role
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
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
    <title>Web Kasir</title>
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Custom Styles -->
    <style>
        /* Change primary color */
        .bg-primary {
            background-color: #1a202c !important; /* Darker color for sidebar */
        }

        /* Navbar Styling */
        .navbar {
            background-color: #e03a3e; /* Slightly lighter red */
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: #ff4c4c; /* Hover effect for menu items */
            color: white;
        }

        /* Footer Styling */
        footer {
            background-color: #f0ad4e;
            color: #fff;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            color: #f8f9fa;
        }

        /* Button Styles */
        .btn {
            border-radius: 30px;
        }

        /* Sidebar Hover Animation */
        .sb-sidenav-menu-heading {
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* Custom Sidenav Item Hover */
        .sb-nav-link-icon {
            transition: transform 0.2s;
        }

        .sb-nav-link:hover .sb-nav-link-icon {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <a class="navbar-brand ps-3" href="index.php">Web Kasir</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Side Navigation -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-secondary bg-primary text-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Navigasi</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="?page=pelanggan">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Pelanggan
                        </a>
                        <a class="nav-link" href="?page=produk">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Produk
                        </a>
                        <a class="nav-link" href="?page=pembelian">
                            <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                            Pembelian
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer bg-primary">
                    <div class="small">Logged in as:</div>
                    <?php echo htmlspecialchars($_SESSION['user']['nama']); ?>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <?php
                    // Including dynamic page based on the URL parameter
                    $page = isset($_GET['page']) ? $_GET['page'] : 'home_user';
                    include $page . '.php';
                ?>
            </main>

            <!-- Footer -->
            <footer class="py-5 bg-secondary mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Web Kasir 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
