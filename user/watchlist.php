<?php
session_start();
require '../function.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($user_id === 0) {
    header("Location: ../index.php");
    exit;
}

// Ambil data watchlist user dari database
$watchlist = [];
$query = "
    SELECT w.id as watchlist_id, w.status, m.*
    FROM watchlist w
    JOIN movies m ON w.movie_id = m.id
    WHERE w.user_id = $user_id
    ORDER BY w.id DESC
";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) $watchlist[] = $row;

$liked_movies = [];
$res = mysqli_query($conn, "SELECT movie_id FROM likes WHERE user_id = $user_id");
while ($row = mysqli_fetch_assoc($res)) $liked_movies[] = $row['movie_id'];
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
        <div class="d-flex flex-column gap-3">
            <?php if (count($watchlist) > 0): ?>
                <?php foreach ($watchlist as $movie): ?>
                    <div class="d-flex align-items-center bg-white rounded-4 shadow-sm px-3 py-2 flex-wrap">
                        <!-- Poster -->
                        <img src="../assets/img/<?= htmlspecialchars($movie['poster'] ?: 'nophoto.jpg') ?>"
                            alt="<?= htmlspecialchars($movie['title']) ?>"
                            class="rounded-3 me-3"
                            style="height:60px; width:45px; object-fit:cover;">

                        <!-- Judul & Status -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold fs-6" style="color:#dc3545;"><?= htmlspecialchars($movie['title']) ?></span>
                                <span class="badge ms-2 <?=
                                                        $movie['status'] === 'Watched' ? 'bg-success' : ($movie['status'] === 'Watching' ? 'bg-warning text-dark' : 'bg-secondary')
                                                        ?>">
                                    <?= htmlspecialchars($movie['status']) ?>
                                </span>
                            </div>
                            <div class="text-muted small"><?= htmlspecialchars(mb_strimwidth($movie['synopsis'], 0, 60, '...')) ?></div>
                        </div>

                        <!-- Tombol-tombol -->
                        <div class="d-flex flex-wrap gap-2 ms-3">
                            <form action="watch.php" method="post" class="d-inline">
                                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Tonton"
                                    <?= $movie['status'] === 'Watched' ? 'disabled' : '' ?>>
                                    <i class="bi bi-play-circle"></i>
                                </button>
                            </form>
                            <!-- like -->
                            <?php $liked = in_array($movie['id'], $liked_movies); ?>
                            <form class="form-like d-inline" data-movie-id="<?= $movie['id'] ?>">
                                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                <button type="submit"
                                    class="btn btn-sm <?= $liked ? 'btn-danger text-white' : 'btn-outline-danger' ?>"
                                    title="Like">
                                    <i class="bi bi-heart<?= $liked ? '-fill' : '' ?>"></i>
                                </button>
                            </form>
                            <!-- like -->
                            <form action="finish_watch.php" method="post" class="d-inline">
                                <input type="hidden" name="watchlist_id" value="<?= $movie['watchlist_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Selesai Menonton"
                                    <?= $movie['status'] !== 'Watching' ? 'disabled' : '' ?>>
                                    <i class="bi bi-check-circle"></i>
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
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted fst-italic py-5">Watchlist kamu masih kosong.</div>
            <?php endif; ?>
        </div>
    </div>


    <script>
        document.addEventListener('submit', async function(e) {
            const form = e.target.closest('.form-like');
            if (form) {
                e.preventDefault();
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                const fd = new FormData(form);
                const res = await fetch('like.php', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();
                btn.disabled = false;
                if (data.status === 'liked') {
                    btn.className = 'btn btn-sm btn-danger text-white';
                    btn.innerHTML = '<i class="bi bi-heart-fill"></i>';
                } else if (data.status === 'unliked') {
                    btn.className = 'btn btn-sm btn-outline-danger';
                    btn.innerHTML = '<i class="bi bi-heart"></i>';
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!-- <span class="badge bg-secondary mb-2">
    <?= htmlspecialchars($movie['status']) ?>
</span> -->
<!-- $query = "
    SELECT w.id as watchlist_id, w.status, m.*
    FROM watchlist w
    JOIN movies m ON w.movie_id = m.id
    WHERE w.user_id = $user_id
    ORDER BY w.id DESC
"; -->