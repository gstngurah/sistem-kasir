<?php
include "proses/connect.php";

$res = mysqli_query($conn, "SELECT DATABASE() AS db");
$row = mysqli_fetch_assoc($res);

echo "DEBUG: Saat ini terkoneksi ke database = " . $row['db'];
?>
