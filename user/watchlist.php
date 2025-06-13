<?php
session_start();
require '../function.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($user_id === 0) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data watchlist user dari database
$watchlist = [];
$query = "
    SELECT w.id as watchlist_id, m.*
    FROM watchlist w
    JOIN movies m ON w.movie_id = m.id
    WHERE w.user_id = $user_id
    ORDER BY w.id DESC
";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) $watchlist[] = $row;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Watchlist | Moodflix</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-size: cover;
            background-color: #dc3545;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(220, 53, 69, 0.85), rgba(0, 0, 0, 0.7));
            z-index: -1;
        }

        .card {
            border-radius: 1.1rem !important;
        }

        .card .card-title {
            color: #dc3545;
            font-weight: 700;
        }

        .btn-danger,
        .btn-outline-danger:hover {
            background: #dc3545 !important;
            border-color: #dc3545 !important;
        }
    </style>
</head>

<body>
    <?php require '../user/header.php'; ?>

    <div class="container mt-5 py-5">
        <h1 class="fw-bold mb-4 text-center text-dark">My Watchlist</h1>
        <div class="row g-4">
            <?php if (count($watchlist) > 0): ?>
                <?php foreach ($watchlist as $movie): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <img src="../assets/img/<?= htmlspecialchars($movie['poster'] ?: 'nophoto.jpg') ?>"
                                class="card-img-top rounded-top-4"
                                alt="<?= htmlspecialchars($movie['title']) ?>"
                                style="height:200px; object-fit:cover;">
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title fw-semibold mb-2"><?= htmlspecialchars($movie['title']) ?></h6>
                                <p class="text-muted small mb-3"><?= htmlspecialchars(mb_strimwidth($movie['synopsis'], 0, 60, '...')) ?></p>
                                <div class="d-flex flex-wrap gap-2 mt-auto">
                                    <form action="watch.php" method="post" class="d-inline">
                                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Tonton">
                                            <i class="bi bi-play-circle"></i> Tonton
                                        </button>
                                    </form>
                                    <form action="like.php" method="post" class="d-inline">
                                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Like">
                                            <i class="bi bi-heart"></i> Like
                                        </button>
                                    </form>
                                    <form action="finish_watch.php" method="post" class="d-inline">
                                        <input type="hidden" name="watchlist_id" value="<?= $movie['watchlist_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Selesai Menonton">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </button>
                                    </form>
                                    <form action="delete_watchlist.php" method="post" class="d-inline" onsubmit="return confirm('Hapus dari watchlist?');">
                                        <input type="hidden" name="watchlist_id" value="<?= $movie['watchlist_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p class="text-muted fst-italic">Watchlist kamu masih kosong.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>