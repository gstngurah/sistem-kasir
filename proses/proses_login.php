<?php
// Aktifkan debug error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "connect.php";

$username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
$password = isset($_POST['password']) ? htmlentities($_POST['password']) : "";

if (!empty($_POST['submit_validate'])) {
    $query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username' AND password = '$password'");

    if (!$query) {
        die("Query error: " . mysqli_error($conn)); // tampilkan error SQL jika ada
    }

    $hasil = mysqli_fetch_array($query);
    if ($hasil) {
        // simpan username dari database ke session (bukan dari inputan)
        $_SESSION['username_betutu'] = $hasil['username'];
        // redirect ke home
        header("Location: ../index.php?x=home");
        exit;
    } else {
        echo "<script>
                alert('Username / Password salah!');
                window.location='../index.php?x=login';
              </script>";
        exit;
    }
}
?>
