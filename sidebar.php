<?php
// Ambil segment path dari URL
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Kalau kosong, berarti default 'home'
if ($currentPath === '' || $currentPath === basename(__DIR__)) {
    $currentPath = 'home';
}
?>
<div class="col-lg-3">
    <nav class="navbar navbar-expand-lg bg-light rounded border mt-2">
        <div class="container-fluid">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 250px;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav nav-pills flex-column justify-content-end flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= ($currentPath === 'home') ? 'active link-light' : 'link-dark'; ?>" href="/home"><i class="bi bi-house"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= ($currentPath === 'menu') ? 'active link-light' : 'link-dark'; ?>" href="/menu"><i class="bi bi-cart"></i> Daftar Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= ($currentPath === 'order') ? 'active link-light' : 'link-dark'; ?>" href="/order"><i class="bi bi-cart"></i> Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= ($currentPath === 'konfirmasi') ? 'active link-light' : 'link-dark'; ?>" href="/konfirmasi"><i class="bi bi-list-check"></i> Konfirmasi Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= ($currentPath === 'riwayat') ? 'active link-light' : 'link-dark'; ?>" href="/riwayat"><i class="bi bi-book"></i> Riwayat</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
