<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "proses/connect.php";

// Ambil semua riwayat
$rows = [];
$res = mysqli_query($conn, "SELECT id, nama_makanan, quantity, tanggal, total FROM tb_riwayat ORDER BY id ASC");
while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;

// Hitung grand total
$grandTotal = 0;
foreach ($rows as $r) $grandTotal += (int)$r['total'];
?>
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header fw-bold d-flex justify-content-between align-items-center">
            <span>Riwayat</span>
            <div class="d-flex align-items-center gap-2">
                <?php if ($grandTotal > 0): ?>
                    <div id="grandTotalBox" class="fw-bold text-end me-2">
                        Grand Total : Rp <span id="grandTotalVal"><?php echo number_format($grandTotal, 0, ',', '.'); ?></span>
                    </div>
                    <!-- Tombol Hapus Semua -->
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusSemua">
                        <i class="bi bi-trash"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>



        <div class="card-body">


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Total</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelRiwayat">
                    <?php if (!empty($rows)): ?>
                        <?php $no = 1;
                        foreach ($rows as $r): ?>
                            <tr data-id="<?php echo $r['id']; ?>">
                                <th scope="row"><?php echo $no++; ?></th>
                                <td><?php echo htmlspecialchars($r['nama_makanan']); ?></td>
                                <td><?php echo (int)$r['quantity']; ?></td>
                                <td><?php echo htmlspecialchars($r['tanggal']); ?></td>
                                <td class="col-total">Rp <?php echo number_format((int)$r['total'], 0, ',', '.'); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger btnHapusRiwayat" data-id="<?php echo $r['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada riwayat</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Modal Hapus Semua Riwayat -->
            <div class="modal fade" id="modalHapusSemua" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Konfirmasi Hapus Semua</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">
                                Tabel riwayat akan terhapus semua<br><br>
                                Yakin ingin menghapus?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="btnConfirmHapusSemua">
                                <i class="bi bi-trash"></i> Hapus Semua
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function renumberRows() {
        const rows = document.querySelectorAll('#tabelRiwayat tr');
        let n = 1;
        rows.forEach(tr => {
            const th = tr.querySelector('th');
            if (th) th.textContent = n++;
        });
    }

    function parseRupiah(text) {
        return parseInt(text.replace(/[^0-9]/g, ''), 10) || 0;
    }

    function formatRupiah(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btnHapusRiwayat');
        if (!btn) return;

        if (!confirm('Hapus riwayat ini?')) return;

        const id = btn.getAttribute('data-id');
        const row = btn.closest('tr');

        // ambil nilai total baris untuk update grand total di UI
        const colTotal = row.querySelector('.col-total');
        const thisTotal = parseRupiah(colTotal.textContent);

        fetch('proses/proses_hapus_riwayat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(res => res.text())
            .then(txt => {
                if (txt.trim() === 'success') {
                    row.remove();
                    renumberRows();

                    const grandEl = document.getElementById('grandTotalVal');
                    if (grandEl) {
                        const before = parseRupiah(grandEl.textContent);
                        const after = Math.max(0, before - thisTotal);
                        grandEl.textContent = formatRupiah(after);
                    }

                    alert('Riwayat berhasil dihapus!');
                } else {
                    alert('Gagal menghapus riwayat.');
                }
            })
            .catch(() => alert('Terjadi kesalahan.'));
    });
</script>

<script>
// HAPUS SEMUA RIWAYAT
document.getElementById('btnConfirmHapusSemua')?.addEventListener('click', function () {
  fetch('proses/proses_hapus_riwayat_all.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'confirm=1'
  })
  .then(res => res.text())
  .then(txt => {
    if (txt.trim() === 'success') {
      // Tutup modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('modalHapusSemua'));
      modal?.hide();

      // Kosongkan tabel & reset nomor
      const tbody = document.getElementById('tabelRiwayat');
      if (tbody) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Belum ada riwayat</td></tr>';
      }

      // Reset grand total
      const grandEl = document.getElementById('grandTotalVal');
      if (grandEl) grandEl.textContent = '0';

      // Optional: sembunyikan tombol hapus semua + box grand total
      document.getElementById('grandTotalBox')?.parentElement?.classList.add('d-none');

      alert('Seluruh riwayat berhasil dihapus!');
    } else {
      alert('Gagal menghapus semua riwayat.');
    }
  })
  .catch(() => alert('Terjadi kesalahan.'));
});
</script>
