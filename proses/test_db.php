<?php
require __DIR__.'/proses/connect.php';
echo "Connected!<br>";
$res = mysqli_query($conn, "SHOW TABLES");
while ($r = mysqli_fetch_row($res)) echo $r[0]."<br>";
