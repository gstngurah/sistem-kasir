<?php
// proses/proses_hapus_menu.php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    // Hapus file gambar jika ada
    $res = mysqli_query($conn, "SELECT gambar FROM tb_menu WHERE id=$id");
    if ($res && mysqli_num_rows($res)) {
        $row = mysqli_fetch_assoc($res);
        $path = "../uploads/" . $row['gambar'];
        if (!empty($row['gambar']) && file_exists($path)) {
            @unlink($path);
        }
    }

    // Hapus data
    if (mysqli_query($conn, "DELETE FROM tb_menu WHERE id=$id")) {
        echo "success"; // <-- seperti proses_hapus_order.php
    } else {
        echo "error";
    }
} else {
    echo "invalid_request";
}
