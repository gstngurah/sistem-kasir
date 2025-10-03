<?php
session_start();

if (isset($_POST['key'])) {
    $key = $_POST['key'];

    if (isset($_SESSION['keranjang'][$key])) {
        unset($_SESSION['keranjang'][$key]);
        // Reindex array biar rapih
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
        echo "success";
    } else {
        echo "not_found";
    }
} else {
    echo "invalid_request";
}
