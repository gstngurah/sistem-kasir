<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil parameter x dari query string atau dari path
$x = null;

// kalau pakai query string biasa (?x=home)
if (isset($_GET['x'])) {
    $x = trim($_GET['x'], '/');
} else {
    // kalau URL bentuknya /home, /order, dll
    $request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $base = basename(__DIR__); // nama folder project, misal 'sistem-kasir'
    
    // hilangkan base folder dari path (kalau ada)
    if (strpos($request, $base) === 0) {
        $request = substr($request, strlen($base));
        $request = trim($request, '/');
    }

    $x = $request !== '' ? $request : 'home';
}

// Debug untuk cek parameter
error_log("DEBUG: masuk index.php, x=" . ($x ?? 'NULL'));

// izinkan halaman login & logout tanpa login
$allowed_public = ['login', 'logout'];

// jika belum login dan bukan membuka halaman login/logout -> paksa ke login
if (empty($_SESSION['username_betutu']) && !in_array($x, $allowed_public, true)) {
    header('Location: /login');
    exit;
}

// Routing halaman
if ($x === 'home') {
    $page = "home.php";
    include "main.php";
} elseif ($x === 'order') {
    $page = "order.php";
    include "main.php";
} elseif ($x === 'konfirmasi') {
    $page = "konfirmasi.php";
    include "main.php";
} elseif ($x === 'menu') {
    $page = "menu.php";
    include "main.php";
} elseif ($x === 'riwayat') {
    $page = "riwayat.php";
    include "main.php";
} elseif ($x === 'login') {
    include "login.php";
} elseif ($x === 'logout') {
    include "proses/proses_logout.php";
} else {
    $page = "home.php";
    include "main.php";
}
