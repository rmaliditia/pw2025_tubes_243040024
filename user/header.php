<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<nav class="navbar m-3 rounded-3 navbar-expand-lg bg-light px-3 py-1">
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="d-flex align-items-center">
            <a class="navbar-brand me-3" href="#">
                <img src="../assets/img/logo.png" alt="Logo" width="140">
            </a>
        </div>
        <ul class="navbar-nav flex-row gap-lg-4 gap-md-2 mb-2 mb-lg-0 text-secondary align-items-center">
            <li class="nav-item">
                <a class="nav-link px-3" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="category.php">Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="watchlist.php">Watchlist</a>
            </li>
        </ul>
        <div class="nav-item dropdown">
            <a href="#" class="d-flex align-items-center text-secondary text-decoration-none dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../assets/img/nophoto.jpg" alt="profile" width="32" height="32" class="rounded-circle me-2">
                <div class="d-flex flex-column">
                    <small class="profile-name fw-semibold text-muted m-0">
                        <?php echo ucwords($_SESSION["username"]); ?>
                    </small>
                    <small class="role-name text-muted m-0">
                        <?php echo ucwords($_SESSION["role"]); ?>
                    </small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end text-small shadow-sm" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../auth/logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>