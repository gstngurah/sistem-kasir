<?php
include "proses/connect.php";
?>
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header fw-bold">
            Daftar Menu
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                    <tbody id="tabelMenu">
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM tb_menu");
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $no++ . "</th>";
                            echo "<td><img src='uploads/" . $row['gambar'] . "' width='80'></td>";
                            echo "<td>" . $row['nama_makanan'] . "</td>";
                            echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                            echo "<td>
                                    <button 
                                        type='button' 
                                        class='btn btn-sm btn-warning btnEdit'
                                        data-id='" . $row['id'] . "'
                                        data-nama='" . $row['nama_makanan'] . "'
                                        data-harga='" . $row['harga'] . "'
                                        data-gambar='" . $row['gambar'] . "'
                                        data-bs-toggle='modal' 
                                        data-bs-target='#editMenuModal'>
                                        <i class='bi bi-pencil-square'></i>
                                    </button>
                                    <button type='button' class='btn btn-sm btn-danger btnDelete' data-id='" . $row['id'] . "'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>

            </table>
        </div>
    </div>

    <!-- Tombol Tambah Menu -->
    <div class="d-flex justify-content-end">
        <button class="btn btn-sm btn-success mt-3" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">
            <i class="bi bi-plus-circle"></i> Tambah Menu
        </button>
    </div>
</div>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-labelledby="tambahMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses/proses_tambah_menu.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahMenuModalLabel">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_makanan" class="form-label">Nama Makanan</label>
                        <input type="text" class="form-control" id="nama_makanan" name="nama_makanan" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses/proses_edit_menu.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">

          <div class="mb-3">
            <label for="edit_nama" class="form-label">Nama Makanan</label>
            <input type="text" class="form-control" name="nama_makanan" id="edit_nama" required>
          </div>

          <div class="mb-3">
            <label for="edit_harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" id="edit_harga" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Gambar (biarkan kosong jika tidak diganti)</label>
            <input type="file" class="form-control" name="gambar">
            <img id="edit_preview" src="" width="100" class="mt-2 rounded">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.querySelectorAll('.btnEdit').forEach(button => {
    button.addEventListener('click', function() {
    document.getElementById('edit_id').value = this.dataset.id;
    document.getElementById('edit_nama').value = this.dataset.nama;
    document.getElementById('edit_harga').value = this.dataset.harga;
    document.getElementById('edit_preview').src = "uploads/" + this.dataset.gambar;
  });
});
</script>

<script>
document.querySelector("#tambahMenuModal form").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("proses/proses_tambah_menu.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload(); // sementara reload, nanti bisa dibuat update tabel tanpa reload
        }
    })
    .catch(err => alert("Error: " + err));
});
</script>

<script>
// fungsi untuk menomori ulang kolom "No" setelah baris dihapus
function renumberRows() {
  const rows = document.querySelectorAll('#tabelMenu tr');
  rows.forEach((tr, i) => {
    const th = tr.querySelector('th');
    if (th) th.textContent = i + 1;
  });
}

// event delegation: tangkap klik pada tombol hapus
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.btnDelete');
  if (!btn) return;

  if (!confirm('Yakin ingin menghapus?')) return;

  const id   = btn.getAttribute('data-id');
  const row  = btn.closest('tr');

  fetch('proses/proses_hapus_menu.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + encodeURIComponent(id)
  })
  .then(res => res.text())
  .then(resp => {
    // samakan gaya response dengan konfirmasi.php: cek string "success"
    if (resp.trim() === 'success') {
      // hapus baris di DOM tanpa reload
      if (row) row.remove();
      // rapikan nomor urut
      renumberRows();
      alert('Menu berhasil dihapus!');
    } else {
      alert('Gagal menghapus menu');
    }
  })
  .catch(() => alert('Terjadi kesalahan saat menghapus'));
});
</script>

<script>
// Format angka ke "Rp 1.234" (gaya Indonesia)
function toRupiah(num) {
  num = Number(num) || 0;
  return 'Rp ' + num.toLocaleString('id-ID');
}

// Cari <tr> dari sebuah id menu
function findRowById(id) {
  const btn = document.querySelector(`.btnEdit[data-id="${id}"]`);
  return btn ? btn.closest('tr') : null;
}

// Bind tombol Edit untuk isi modal (kalau belum ada, aman dipanggil berulang)
function bindEditButtons() {
  document.querySelectorAll('.btnEdit').forEach(button => {
    if (button._bound) return;    // cegah double-binding
    button._bound = true;

    button.addEventListener('click', function() {
      document.getElementById('edit_id').value    = this.dataset.id;
      document.getElementById('edit_nama').value  = this.dataset.nama;
      document.getElementById('edit_harga').value = this.dataset.harga;
      document.getElementById('edit_preview').src = "uploads/" + this.dataset.gambar;
    });
  });
}

// Submit EDIT via fetch (tanpa reload/pindah halaman)
document.querySelector("#editMenuModal form").addEventListener("submit", function(e){
  e.preventDefault();

  const form = this;
  const fd   = new FormData(form);

  const id    = form.querySelector('#edit_id').value;
  const nama  = form.querySelector('#edit_nama').value;
  const harga = form.querySelector('#edit_harga').value;

  fetch("proses/proses_edit_menu.php", { method: "POST", body: fd })
    .then(res => res.text())
    .then(resp => {
      if (resp.trim() === "success") {
        // Tutup modal
        const modalEl = document.getElementById("editMenuModal");
        const modal   = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        // Update row pada tabel (tanpa reload)
        const tr = findRowById(id);
        if (tr) {
          // Kolom: 0=No, 1=Gambar, 2=Nama, 3=Harga, 4=Aksi
          tr.cells[2].textContent = nama;
          tr.cells[3].textContent = toRupiah(harga);

          // Update data-* di tombol edit (biar klik berikutnya ikut berubah)
          const btnEdit = tr.querySelector('.btnEdit');
          if (btnEdit) {
            btnEdit.dataset.nama  = nama;
            btnEdit.dataset.harga = harga;
            // Untuk gambar: kita biarkan seperti sebelumnya (karena filename baru tidak kita terima dari server).
          }
        }

        alert("Menu berhasil diperbarui!");
      } else {
        alert("Gagal memperbarui menu");
      }
    })
    .catch(() => alert("Terjadi kesalahan saat memperbarui"));
});

// Panggil sekali saat halaman siap
document.addEventListener("DOMContentLoaded", function(){
  bindEditButtons();
});
</script>



</div>

