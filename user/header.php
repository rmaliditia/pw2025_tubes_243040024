<nav class="navbar navbar-expand-lg bg-white navbar px-4">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Kiri: Logo + Search -->
        <div class="d-flex align-items-center me-auto">
            <a class="navbar-brand me-3" href="#">
                <img src="../assets/img/logo.png" alt="Logo" width="140">
            </a>
            <form class="d-flex" role="search">
                <input class="form-control form-control-sm" type="search" placeholder="Search..." aria-label="Search">
            </form>
        </div>

        <!-- Kanan: Menu -->
        <div class="d-flex">
            <ul class="navbar-nav ms-auto gap-3 mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Movie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Watchlist</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-secondary text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                            onclick="event.preventDefault();">
                            <img src="../assets/img/nophoto.jpg" alt="profile" width="32" height="32" class="rounded-circle me-2">
                            <div class="d-flex flex-column">
                                <strong class="profile-name m-0">
                                    <?php echo ucwords($_SESSION["username"]); ?>
                                </strong>
                                <small class="role-name text-muted m-0">
                                    <?php echo ucwords($_SESSION["role"]); ?>
                                </small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end text-small shadow-sm">
                            <li><a class="dropdown-item" href="">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../auth/logout.php">Log out</a></li>
                        </ul>
                    </div>
                </li>
        </div>
        </ul>
    </div>

    </div>
</nav>