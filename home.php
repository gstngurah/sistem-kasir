<?php
// Dashboard (Ringkasan Cepat)
include "proses/connect.php";

// (opsional) pastikan timezone sesuai kebutuhan
// date_default_timezone_set('Asia/Makassar');

$today = date('Y-m-d');

// Total Menu Aktif
$resMenu = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_menu");
$rowMenu = mysqli_fetch_assoc($resMenu);
$totalMenu = (int)($rowMenu['jml'] ?? 0);

// Pesanan Hari Ini (jumlah baris riwayat per tanggal hari ini)
$resTodayCount = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_riwayat WHERE tanggal = '$today'");
$rowTodayCount = mysqli_fetch_assoc($resTodayCount);
$pesananHariIni = (int)($rowTodayCount['jml'] ?? 0);

// Pendapatan Hari Ini (sum total per tanggal hari ini)
$resTodayRevenue = mysqli_query($conn, "SELECT COALESCE(SUM(total),0) AS total FROM tb_riwayat WHERE tanggal = '$today'");
$rowTodayRevenue = mysqli_fetch_assoc($resTodayRevenue);
$pendapatanHariIni = (int)($rowTodayRevenue['total'] ?? 0);

// Grand Total Pendapatan (akumulasi semua total di tb_riwayat)
$resGrand = mysqli_query($conn, "SELECT COALESCE(SUM(total),0) AS grand FROM tb_riwayat");
$rowGrand = mysqli_fetch_assoc($resGrand);
$grandPendapatan = (int)($rowGrand['grand'] ?? 0);

// Total Riwayat Pesanan (jumlah semua transaksi)
$resTotalRiwayat = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM tb_riwayat");
$rowTR = mysqli_fetch_assoc($resTotalRiwayat);
$totalRiwayat = (int)($rowTR['jml'] ?? 0);
?>

<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header fw-bold d-flex justify-content-between align-items-center">
            <span>Dashboard</span>
            <span class="text-muted small"><?php echo date('d M Y'); ?></span>
        </div>

        <div class="card-body mt-2">
            <div class="row g-3">

                <!-- Total Menu Aktif -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-secondary small">Total Menu Aktif</div>
                                    <div class="fs-3 fw-bold"><?php echo $totalMenu; ?></div>
                                </div>
                                <div class="ms-3 text-primary">
                                    <i class="bi bi-list-ul fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pesanan Hari Ini -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-secondary small">Pesanan Hari Ini</div>
                                    <div class="fs-3 fw-bold"><?php echo $pesananHariIni; ?></div>
                                </div>
                                <div class="ms-3 text-primary">
                                    <i class="bi bi-cart-check fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Hari Ini -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-secondary small">Pendapatan Hari Ini</div>
                                    <div class="fs-5 fw-bold">
                                        Rp <?php echo number_format($pendapatanHariIni, 0, ',', '.'); ?>
                                    </div>
                                </div>
                                <div class="ms-3 text-warning">
                                    <i class="bi bi-cash-stack fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grand Total Pendapatan -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-secondary small">Grand Total</div>
                                    <div class="fs-5 fw-bold">
                                        Rp <?php echo number_format($grandPendapatan, 0, ',', '.'); ?>
                                    </div>
                                </div>
                                <div class="ms-3 text-success">
                                    <i class="bi bi-cash-stack fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Total Riwayat Pesanan -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-secondary small">Total Riwayat Pesanan</div>
                                    <div class="fs-3 fw-bold"><?php echo $totalRiwayat; ?></div>
                                </div>
                                <div class="ms-3 text-danger">
                                    <i class="bi bi-clock-history fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Bulanan -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100 clickable-card" data-bs-toggle="modal" data-bs-target="#statistikModal">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-secondary small mb-3">Statistik Bulanan</div>
                                    <div class="fs-6 mb-2">Lihat Statistik</div>
                                </div>
                                <div class="ms-3 text-info">
                                    <i class="bi bi-graph-up fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /row -->
        </div> <!-- /card-body -->

        <?php
        // ====== AGREGASI QTY PER ITEM (PARSE ANGKA DI DALAM KURUNG) ======
        $qtyMap  = [];  // ['NAMA ITEM (normalized)' => total_qty]
        $caseMap = [];  // Simpan label case-asli terpanjang/rapi untuk display

        // 1) Ambil peta harga dari tb_menu (untuk hitung revenue = qty * harga)
        $priceMap = []; // ['NAMA ITEM (normalized)' => harga]
        $resHarga = mysqli_query($conn, "SELECT nama_makanan, harga FROM tb_menu");
        while ($h = mysqli_fetch_assoc($resHarga)) {
            $nm  = trim($h['nama_makanan'] ?? '');
            if ($nm === '') continue;
            $key = preg_replace('/\s+/', ' ', strtoupper($nm));
            $priceMap[$key] = (int)($h['harga'] ?? 0);
            // simpan label rapi
            if (!isset($caseMap[$key]) || strlen($nm) > strlen($caseMap[$key])) {
                $caseMap[$key] = $nm;
            }
        }

        // 2) Agregasi QTY dari tb_riwayat
        $resPie = mysqli_query($conn, "SELECT nama_makanan FROM tb_riwayat");
        while ($row = mysqli_fetch_assoc($resPie)) {
            $namaStr = $row['nama_makanan'] ?? '';
            // ex: "ES TEH (150)" atau "AYAM GORENG (3), BEBEK GORENG (7)"
            $items = array_filter(array_map('trim', explode(',', $namaStr)));
            if (!$items) continue;

            foreach ($items as $raw) {
                if (preg_match('/^(.*)\((\d+)\)\s*$/u', $raw, $m)) {
                    $name  = trim($m[1]);
                    $units = (int)$m[2];
                } else {
                    $name  = trim($raw);
                    $units = 1; // fallback
                }

                $key = preg_replace('/\s+/', ' ', strtoupper($name));
                $qtyMap[$key] = ($qtyMap[$key] ?? 0) + $units;

                // simpan label display yang rapi
                if (!isset($caseMap[$key]) || strlen($name) > strlen($caseMap[$key])) {
                    $caseMap[$key] = $name;
                }
            }
        }

        // 3) Urutkan desc berdasarkan total qty per item
        arsort($qtyMap);

        // 4) Hitung revenue per item: qty * harga dari tb_menu
        $revMap = []; // ['key' => revenue]
        foreach ($qtyMap as $key => $qty) {
            if (isset($priceMap[$key])) {
                $revMap[$key] = (int)$qty * (int)$priceMap[$key];
            } else {
                // jika item sudah tidak ada di tb_menu, set 0 (atau biarkan 0)
                $revMap[$key] = 0;
            }
        }

        // 5) Gunakan Top 5 untuk tabel & grafik
        $topNAssoc = array_slice($qtyMap, 0, 5, true); // key => qty

        $labels    = [];
        $qtyValues = [];
        $revValues = [];
        foreach ($topNAssoc as $key => $q) {
            $labels[]    = $caseMap[$key] ?? $key;   // label tampil
            $qtyValues[] = (int)$q;                  // total qty
            $revValues[] = (int)round($revMap[$key] ?? 0); // total revenue item
        }

        // Untuk tabel Top 5
        $topN = $topNAssoc;
        // label rapi untuk tabel
        $labelsPretty = [];
        foreach ($topN as $k => $q) {
            $labelsPretty[$k] = $caseMap[$k] ?? $k;
        }

        // Total keseluruhan item (semua, bukan hanya Top 5)
        $totalAllQty = array_sum($qtyMap);
        ?>

        <!-- Modal Statistik Bulanan -->
        <div class="modal fade" id="statistikModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formStatistik" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Bulan & Tahun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" min="2000" max="2100" required>
                            </div>
                        </div>
                        <div class="form-text mt-2">Data Top 5 & Grafik akan difilter sesuai bulan/tahun.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="btnResetStatistik">Semua Data</button>
                        <button type="submit" class="btn btn-primary">Lihat Statistik</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-4">

        <!-- ALERT ITEM JIKA BELUM KONFIRMASI PESANAN -->
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $pendingCount = isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0;
        ?>

        <?php if ($pendingCount > 0): ?>
            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-3" role="alert">
                <div>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Ada <strong><?php echo $pendingCount; ?></strong> pesanan yang belum dikonfirmasi.
                </div>
                <a href="konfirmasi" class="btn btn-sm btn-outline-dark">Lihat Konfirmasi</a>
            </div>
        <?php endif; ?>
        <!-- ALERT SELESAI -->

        <div class="row g-3 align-items-stretch">
            <!-- Top 5 -->
            <div class="col-12 col-lg-6 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header fw-bold">Top 5 Menu (Berdasarkan Qty)</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th class="text-end">Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="top5Body">
                                    <?php if (!empty($topN)): ?>
                                        <?php $no = 1;
                                        foreach ($topN as $k => $q): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars($labelsPretty[$k]); ?></td>
                                                <td class="text-end"><?php echo number_format((int)$q, 0, ',', '.'); ?></td>


                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="small mt-3">
                            <span class="text-secondary">Total Penjualan Produk :</span>
                            <strong id="totalAllQty">
                                <?php echo rtrim(rtrim(number_format($totalAllQty, 2, ',', '.'), '0'), ','); ?>
                            </strong>
                            <span class="text-muted">(dari total riwayat)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Penjualan -->
            <div class="col-12 col-lg-6 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header fw-bold">Grafik Penjualan</div>
                    <div class="card-body">
                        <div class="chart-box">
                            <canvas id="pieMenuTerlaris"></canvas>
                        </div>

                        <?php if (empty($labels)): ?>
                            <div class="text-muted small mt-2">Belum ada data riwayat untuk ditampilkan.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>



            <style>
                /* Wadah chart dengan tinggi pasti */
                .chart-box {
                    position: relative;
                    height: 280px;
                    /* atur sesuai selera: 240–320px */
                }

                /* Kanvas isi penuh wadah (bukan max-height) */
                #pieMenuTerlaris {
                    width: 100% !important;
                    height: 100% !important;
                }
            </style>

        </div>


        <!-- Chart.js CDN (sekali saja di halaman, taruh di bawah sebelum penutup body atau di sini) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // ====== CHART SETUP (SIMPAN REFERENSI) ======
            const pieLabelsInit = <?php echo json_encode($labels, JSON_UNESCAPED_UNICODE); ?>;
            const pieQtyInit = <?php echo json_encode($qtyValues, JSON_UNESCAPED_UNICODE); ?>;
            const pieRevInit = <?php echo json_encode($revValues, JSON_UNESCAPED_UNICODE); ?>;

            let pieChart = null;

            function buildPie(labels, qty, rev) {
                const ctx = document.getElementById('pieMenuTerlaris').getContext('2d');
                const totalQty = qty.reduce((a, b) => a + parseFloat(b || 0), 0) || 1;

                if (pieChart) pieChart.destroy();
                pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: qty
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // <— tambahkan baris ini
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const i = context.dataIndex;
                                        const lbl = context.label || '';
                                        const q = parseFloat(qty[i] || 0);
                                        const r = parseFloat(rev[i] || 0);
                                        const pct = (q / totalQty * 100).toFixed(1);
                                        const rIDR = new Intl.NumberFormat('id-ID').format(Math.round(r));
                                        const qFmt = new Intl.NumberFormat('id-ID').format(q);
                                        return `${lbl}: ${pct}% | Qty: ${qFmt} | Pendapatan: Rp ${rIDR}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Build pertama pakai data awal halaman
            if (pieLabelsInit.length > 0) {
                buildPie(pieLabelsInit, pieQtyInit, pieRevInit);
            }

            // ====== HELPER RENDER TOP 5 ======
            function renderTop5(top5) {
                const tbody = document.getElementById('top5Body');
                tbody.innerHTML = '';

                if (!top5 || top5.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>`;
                    return;
                }
                let no = 1;
                top5.forEach(item => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
        <td>${no++}</td>
        <td>${escapeHtml(item.nama)}</td>
        <td class="text-end">${new Intl.NumberFormat('id-ID').format(item.qty)}</td>
      `;
                    tbody.appendChild(tr);
                });
            }

            function escapeHtml(s) {
                return (s ?? '').replace(/[&<>"']/g, m => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [m]));
            }

            // ====== FORM SUBMIT (FILTER BULAN/TAHUN) ======
            document.getElementById('formStatistik').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = new URLSearchParams(new FormData(this)).toString();

                fetch('proses/proses_statistik_bulanan.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: form
                    })
                    .then(r => r.json())
                    .then(json => {
                        if (!json.success) {
                            alert(json.message || 'Gagal memuat data.');
                            return;
                        }
                        // Update Top 5
                        renderTop5(json.top5);
                        // Update Total Semua Item
                        document.getElementById('totalAllQty').textContent = new Intl.NumberFormat('id-ID').format(json.totalAllQty || 0);
                        // Update Pie Chart
                        buildPie(json.labels || [], json.qty || [], json.rev || []);
                        // Tutup modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('statistikModal'));
                        if (modal) modal.hide();
                    })
                    .catch(() => alert('Terjadi kesalahan koneksi.'));
            });

            // ====== RESET (SEMUA DATA) ======
            document.getElementById('btnResetStatistik').addEventListener('click', function() {
                fetch('proses/proses_statistik_bulanan.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'reset=1'
                    })
                    .then(r => r.json())
                    .then(json => {
                        if (!json.success) {
                            alert(json.message || 'Gagal memuat data.');
                            return;
                        }
                        renderTop5(json.top5);
                        document.getElementById('totalAllQty').textContent = new Intl.NumberFormat('id-ID').format(json.totalAllQty || 0);
                        buildPie(json.labels || [], json.qty || [], json.rev || []);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('statistikModal'));
                        if (modal) modal.hide();
                    })
                    .catch(() => alert('Terjadi kesalahan koneksi.'));
            });
        </script>




    </div> <!-- /card -->
</div> <!-- /col-lg-9 -->