<?php
// proses/proses_tambah_order.php
session_start();
include "connect.php";

if (isset($_POST['id'])) {
    $id  = mysqli_real_escape_string($conn, $_POST['id']);
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    if ($qty < 1) $qty = 1;

    // Ambil data menu dari DB
    $query = mysqli_query($conn, "SELECT * FROM tb_menu WHERE id = '$id'");
    $menu  = mysqli_fetch_assoc($query);

    if ($menu) {
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        // default tanggal (sementara pakai hari ini)
        $tanggal = date('Y-m-d');

        // Cek apakah item sudah ada di keranjang -> tambah qty
        $found = false;
        foreach ($_SESSION['keranjang'] as &$item) {
            if ($item['id'] == $menu['id']) {
                $item['qty'] += $qty;
                // tanggal bisa di-update sesuai kebutuhan; untuk sekarang biarkan yang lama
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['keranjang'][] = [
                "id"           => $menu['id'],
                "nama_makanan" => $menu['nama_makanan'],
                "harga"        => $menu['harga'],
                "gambar"       => $menu['gambar'],
                "qty"          => $qty,
                "tanggal"      => $tanggal
            ];
        }

        echo "success";
    } else {
        echo "menu_not_found";
    }
} else {
    echo "invalid_request";
}
