<nav class="navbar navbar-expand navbar-dark bg-primary sticky-top">
    <div class="container">
        <a class="navbar-brand" href="."><i class="bi bi-fork-knife"></i> Ayam Betutu</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                            echo isset($_SESSION['username_betutu']) ? $_SESSION['username_betutu'] : 'Guest';
                        ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Setting</a></li>
                        <li><a class="dropdown-item" href="index.php?x=logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>