<?php
// proses/proses_statistik_bulanan.php
session_start();
header('Content-Type: application/json');
include "connect.php";

// Ambil input
$reset = isset($_POST['reset']) ? true : false;
$bulan = isset($_POST['bulan']) ? (int)$_POST['bulan'] : 0;
$tahun = isset($_POST['tahun']) ? (int)$_POST['tahun'] : 0;

$where = "1=1";
$paramsInfo = "Semua data";
if (!$reset && $bulan >= 1 && $bulan <= 12 && $tahun >= 2000 && $tahun <= 2100) {
    $where = "MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun";
    $paramsInfo = "Bulan $bulan / $tahun";
}

// Ambil data riwayat sesuai filter
$sql = "SELECT nama_makanan, total FROM tb_riwayat WHERE $where";
$res = mysqli_query($conn, $sql);

$qtyMap  = []; // ['NAMA ITEM NORMALIZED' => total_qty]
$revMap  = []; // ['NAMA ITEM NORMALIZED' => revenue]
$caseMap = []; // tampilkan label paling rapi

while ($row = mysqli_fetch_assoc($res)) {
    $namaStr = $row['nama_makanan'] ?? '';
    $totalTr = (int)($row['total'] ?? 0);

    $items = array_filter(array_map('trim', explode(',', $namaStr)));
    if (!$items) continue;

    $unitsThisRow = 0;
    $parsed = []; // [key => units] untuk baris ini

    foreach ($items as $raw) {
        if (preg_match('/^(.*)\((\d+)\)\s*$/u', $raw, $m)) {
            $name  = trim($m[1]);
            $units = (int)$m[2];
        } else {
            $name  = trim($raw);
            $units = 1;
        }

        $key = preg_replace('/\s+/', ' ', strtoupper($name));
        $parsed[$key] = ($parsed[$key] ?? 0) + $units;
        $unitsThisRow += $units;

        if (!isset($caseMap[$key]) || strlen($name) > strlen($caseMap[$key])) {
            $caseMap[$key] = $name;
        }
    }

    foreach ($parsed as $key => $units) {
        $qtyMap[$key] = ($qtyMap[$key] ?? 0) + $units;
        if ($unitsThisRow > 0) {
            $portion = $totalTr * ($units / $unitsThisRow);
            $revMap[$key] = ($revMap[$key] ?? 0) + $portion;
        }
    }
}

// Urutkan & ambil Top 5
arsort($qtyMap);
$topNAssoc = array_slice($qtyMap, 0, 5, true);

// Siapkan output untuk chart & tabel
$labels = [];
$qty    = [];
$rev    = [];
$top5   = []; // [{nama, qty}]

foreach ($topNAssoc as $key => $q) {
    $labels[] = $caseMap[$key] ?? $key;
    $qty[]    = (int)$q;
    $rev[]    = round($revMap[$key] ?? 0, 2);

    $top5[] = [
        'nama' => $caseMap[$key] ?? $key,
        'qty'  => (int)$q
    ];
}

// total semua item (bukan cuma top 5)
$totalAllQty = 0;
foreach ($qtyMap as $q) $totalAllQty += (int)$q;

echo json_encode([
    'success'      => true,
    'message'      => 'OK',
    'params'       => $paramsInfo,
    'labels'       => $labels,
    'qty'          => $qty,
    'rev'          => $rev,
    'top5'         => $top5,
    'totalAllQty'  => $totalAllQty
]);
