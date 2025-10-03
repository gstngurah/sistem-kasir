<?php
// proses/proses_edit_menu.php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id           = mysqli_real_escape_string($conn, $_POST['id']);
    $nama_makanan = mysqli_real_escape_string($conn, $_POST['nama_makanan']);
    $harga        = mysqli_real_escape_string($conn, $_POST['harga']);

    $gambarUpdate = "";

    // Jika user upload gambar baru (opsional)
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes) && move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
            // (opsional) hapus gambar lama biar rapi
            $old = mysqli_query($conn, "SELECT gambar FROM tb_menu WHERE id='$id' LIMIT 1");
            if ($old && mysqli_num_rows($old)) {
                $o = mysqli_fetch_assoc($old);
                $oldPath = "../uploads/" . $o['gambar'];
                if (!empty($o['gambar']) && file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            $gambarUpdate = ", gambar='$fileName'";
        } else {
            echo "error"; exit;
        }
    }

    $sql = "UPDATE tb_menu SET nama_makanan='$nama_makanan', harga='$harga' $gambarUpdate WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid_request";
}
