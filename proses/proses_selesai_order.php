<?php
// proses/proses_selesai_order.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo 'invalid_request'; exit; }
if (empty($_SESSION['keranjang']))         { echo 'empty';          exit; }

$items = $_SESSION['keranjang']; // tiap item: id, nama_makanan, harga, qty, tanggal (opsional)

$total       = 0;
$total_qty   = 0;
$nama_parts  = [];
$tanggalSet  = [];

foreach ($items as $it) {
    $nm    = $it['nama_makanan'];
    $qty   = isset($it['qty']) ? (int)$it['qty'] : 1;
    $harga = (int)$it['harga'];

    $total     += $qty * $harga;
    $total_qty += $qty;

    // tampilkan "Nama (qty)" agar jelas
    $nama_parts[] = $nm . ' (' . $qty . ')';

    if (!empty($it['tanggal'])) $tanggalSet[] = $it['tanggal'];
}

$nama_gabungan = implode(', ', $nama_parts);

// Tentukan tanggal tampilan
$tanggalSet = array_values(array_unique($tanggalSet));
if (count($tanggalSet) === 1) {
    $tanggal = $tanggalSet[0];
} else {
    $tanggal = date('Y-m-d');
}

// Simpan ke tb_riwayat (1 baris per order)
$stmt = mysqli_prepare($conn, "INSERT INTO tb_riwayat (nama_makanan, quantity, tanggal, total) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sisi", $nama_gabungan, $total_qty, $tanggal, $total);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$ok) { echo 'db_error'; exit; }

// kosongkan keranjang setelah sukses
$_SESSION['keranjang'] = [];

echo 'success';
