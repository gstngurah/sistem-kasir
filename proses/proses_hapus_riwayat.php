<?php
// proses/proses_hapus_riwayat.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM tb_riwayat WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo $ok ? 'success' : 'db_error';
    exit;
}
echo 'invalid_request';
