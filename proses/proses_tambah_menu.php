<?php
include "connect.php";
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_makanan = mysqli_real_escape_string($conn, $_POST['nama_makanan']);
    $harga        = mysqli_real_escape_string($conn, $_POST['harga']);

    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
                $gambar = $fileName;
            } else {
                $response['message'] = "Upload gambar gagal";
                echo json_encode($response); exit;
            }
        } else {
            $response['message'] = "Format file tidak valid!";
            echo json_encode($response); exit;
        }
    }

    $sql = "INSERT INTO tb_menu (gambar, nama_makanan, harga) VALUES ('$gambar', '$nama_makanan', '$harga')";
    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = "Menu berhasil ditambahkan!";
    } else {
        $response['message'] = "Gagal menambahkan menu: " . mysqli_error($conn);
    }
}

echo json_encode($response);
