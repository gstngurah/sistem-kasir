<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header fw-bold">
            Konfirmasi Pesanan
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelKonfirmasi">
                    <?php
                    if (!empty($_SESSION['keranjang'])) {
                        $no = 1;
                        foreach ($_SESSION['keranjang'] as $key => $item) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $no++ . "</th>";
                            echo "<td><img src='uploads/" . $item['gambar'] . "' width='80'></td>";
                            echo "<td>" . $item['nama_makanan'] . "</td>";
                            echo "<td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>";
                            echo "<td>" . (isset($item['qty']) ? (int)$item['qty'] : 1) . "</td>";
                            echo "<td>" . (!empty($item['tanggal']) ? htmlspecialchars($item['tanggal']) : '-') . "</td>";
                            echo "<td>
                                    <button class='btn btn-sm btn-danger btnHapus' data-key='" . $key . "'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Belum ada pesanan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            // Hitung Grand Total (harga x qty)
            $grandTotal = 0;
            if (!empty($_SESSION['keranjang'])) {
                foreach ($_SESSION['keranjang'] as $item) {
                    $qty   = isset($item['qty']) ? (int)$item['qty'] : 1;
                    $harga = (int)$item['harga'];
                    $grandTotal += $harga * $qty;
                }
            }
            ?>

            <?php if ($grandTotal > 0): ?>
                <div class="mt-2 text-end fw-bold">
                    Total : Rp <?= number_format($grandTotal, 0, ',', '.') ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

   <!-- Tombol Pesanan Selesai -->
<div class="d-flex justify-content-end">
  <button id="btnSelesai" class="btn btn-sm btn-success mt-3">
    Pesanan Selesai
  </button>
</div>


<script>
document.querySelectorAll('.btnHapus').forEach(btn => {
    btn.addEventListener('click', function() {
        if(confirm("Hapus pesanan ini?")) {
            let key = this.getAttribute('data-key');

            fetch("proses/proses_hapus_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "key=" + encodeURIComponent(key)
            })
            .then(res => res.text())
            .then(data => {
                if (data === "success") {
                    location.reload(); // (boleh dipertahankan atau diganti update DOM langsung)
                } else {
                    alert("Gagal menghapus pesanan");
                }
            })
        }
    });
});
</script>

<!-- SCRIPT TOMBOL PESANAN SELESAI -->
<script>
document.getElementById('btnSelesai').addEventListener('click', function() {
  if (!confirm('Selesai dan simpan ke Riwayat?')) return;

  fetch('proses/proses_selesai_order.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'submit=1'
  })
  .then(res => res.text())
  .then(txt => {
    if (txt.trim() === 'success') {
      // arahkan ke halaman riwayat
      window.location.href = 'riwayat';
    } else {
      alert('Gagal menyelesaikan pesanan.');
    }
  })
  .catch(() => alert('Terjadi kesalahan.'));
});
</script>
