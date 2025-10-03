<?php
include "proses/connect.php";
?>
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header fw-bold">
            Order
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM tb_menu");
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="uploads/<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo $row['nama_makanan']; ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $row['nama_makanan']; ?></h5>
                                <p class="card-text text-muted">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>

                                <!-- Qty control -->
                                <div class="input-group input-group-sm mb-2">
                                    <button class="btn btn-outline-secondary btnMinus" type="button">−</button>
                                    <input type="number" class="form-control text-center qtyInput" min="1" value="1">
                                    <button class="btn btn-outline-secondary btnPlus" type="button">+</button>
                                </div>

                                <button
                                    class="btn btn-primary mt-auto btnOrder"
                                    data-id="<?php echo $row['id']; ?>">
                                    Order
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
// Pasang event sekali saat DOM siap
document.addEventListener('DOMContentLoaded', function() {
    // Plus / Minus
    document.querySelectorAll('.card').forEach(card => {
        const minus = card.querySelector('.btnMinus');
        const plus  = card.querySelector('.btnPlus');
        const input = card.querySelector('.qtyInput');
        if (!input) return;

        if (minus && !minus._bound) {
            minus._bound = true;
            minus.addEventListener('click', () => {
                const v = Math.max(1, parseInt(input.value || '1', 10) - 1);
                input.value = v;
            });
        }
        if (plus && !plus._bound) {
            plus._bound = true;
            plus.addEventListener('click', () => {
                const v = Math.max(1, parseInt(input.value || '1', 10) + 1);
                input.value = v;
            });
        }
    });

    // Order (kirim id + qty)
    document.querySelectorAll('.btnOrder').forEach(btn => {
        if (btn._bound) return;
        btn._bound = true;

        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const cardBody = this.closest('.card-body');
            const qtyEl = cardBody ? cardBody.querySelector('.qtyInput') : null;
            const qty = qtyEl ? Math.max(1, parseInt(qtyEl.value || '1', 10)) : 1;

            fetch("proses/proses_tambah_order.php", {
                method: "POST",
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: "id=" + encodeURIComponent(id) + "&qty=" + encodeURIComponent(qty)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Order berhasil ditambahkan!");
                } else if (data.trim() === "menu_not_found") {
                    alert("Menu tidak ditemukan.");
                } else {
                    alert("Gagal menambahkan order.");
                }
            })
            .catch(error => alert("Error: " + error));
        });
    });
});
</script>
