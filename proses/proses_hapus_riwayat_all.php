<?php
// proses/proses_hapus_riwayat_all.php
include "connect.php";

// Hapus semua baris riwayat
// Pakai TRUNCATE untuk cepat & reset auto_increment
// Jika ingin aman (no privilege TRUNCATE), bisa ganti ke: DELETE FROM tb_riwayat
$sql = "TRUNCATE TABLE tb_riwayat";
if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "error";
}
