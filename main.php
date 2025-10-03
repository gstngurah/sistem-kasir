<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// kalau belum login, arahkan ke login
if (empty($_SESSION['username_betutu'])) {
    header('Location:login');
    exit;
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendataan Penjualan Betutu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
    /* Sidebar link */
    .nav-link {
        transition: background-color 0.3s, color 0.3s;
        border-radius: 8px; /* biar kelihatan lebih modern */
    }

    /* Hover effect */
    .nav-link:hover {
        background-color: #9eabbeff; /* warna primary Bootstrap */
        color: #fff !important;
    }

    /* Biar ikon juga ikut putih pas hover */
    .nav-link:hover i {
        color: #fff !important;
    }

    /* Link aktif */
    .nav-link.active {
        background-color: #9eabbeff;
        color: #fff !important;
    }

    .nav-link.active i {
        color: #fff !important;
    }
</style>

</head>

<body style="height: 3000px;">
    <!-- Header -->
    <?php include "header.php"; ?>
    <!-- End Header -->

    <div class="container lg">
        <div class="row">
            <!-- Side Bar -->
            <?php include "sidebar.php"; ?>
            <!-- End Side Bar -->

            <!-- Content -->
            <?php
            if (isset($page) && file_exists($page)) {
                include $page;
            } else {
                echo "<div class='alert alert-danger mt-3'>Halaman tidak ditemukan</div>";
            }
            ?>

            <!-- End Content -->
        </div>

        <div class="fixed-bottom text-center mb-2">
            Copyright 2025 Ngurah Pratama
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>