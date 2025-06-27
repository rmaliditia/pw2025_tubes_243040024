<?php
session_start();
require '../function.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] !== 'user') {
    header("Location: ../index.php");
    exit;
}

// Ambil daftar genre dari database
$genreList = [];
$res = mysqli_query($conn, "SELECT name FROM genre ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($res)) $genreList[] = $row['name'];

// Ambil daftar mood dari database
$moodList = [];
$res = mysqli_query($conn, "SELECT name FROM moods ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($res)) $moodList[] = $row['name'];

// Ambil pilihan user
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
$selectedMood = isset($_GET['mood']) ? $_GET['mood'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Query movie sesuai pilihan
$where = [];
if ($selectedGenre) {
    $where[] = "EXISTS (
        SELECT 1 FROM movie_genre mg
        JOIN genre g ON mg.genre_id = g.id
        WHERE mg.movie_id = m.id AND g.name = '" . mysqli_real_escape_string($conn, $selectedGenre) . "'
    )";
}
if ($selectedMood) {
    $where[] = "EXISTS (
        SELECT 1 FROM movie_mood mm
        JOIN moods md ON mm.mood_id = md.id
        WHERE mm.movie_id = m.id AND md.name = '" . mysqli_real_escape_string($conn, $selectedMood) . "'
    )";
}
if ($search) {
    $where[] = "m.title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$query = "SELECT m.id, m.title, m.poster, m.synopsis
          FROM movies m
          $whereSql
          ORDER BY m.watch_count DESC";
$result = mysqli_query($conn, $query);
$movies = [];
while ($row = mysqli_fetch_assoc($result)) $movies[] = $row;

$sectionTitle = [];
if ($selectedGenre) $sectionTitle[] = "Genre: " . htmlspecialchars($selectedGenre);
if ($selectedMood) $sectionTitle[] = "Mood: " . htmlspecialchars($selectedMood);
if ($search) $sectionTitle[] = "Search: " . htmlspecialchars($search);
if (!$sectionTitle) $sectionTitle[] = "All Movie";
$sectionTitle = implode(' &mdash; ', $sectionTitle);

$user_id = $_SESSION['user_id'];
$watchlist = [];
$res = mysqli_query($conn, "SELECT movie_id FROM watchlist WHERE user_id = $user_id");
while ($row = mysqli_fetch_assoc($res)) $watchlist[] = $row['movie_id'];


$liked_movies = [];
$res = mysqli_query($conn, "SELECT movie_id FROM likes WHERE user_id = $user_id");
while ($row = mysqli_fetch_assoc($res)) $liked_movies[] = $row['movie_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Category | Moodflix</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-size: cover;
            background-color: #dc3545;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            box-sizing: border-box;
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

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1) 1px, transparent 1px, transparent 3px);
            z-index: -1;
        }

        .card {
            border-radius: 1.1rem !important;
            box-shadow: 0 4px 24px rgba(220, 53, 69, 0.08);
            background: #fff;
            color: #212529;
            transition: box-shadow 0.3s;
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
        <h1 class="fw-bold mb-4 text-center text-dark">Movie Category</h1>
        <!-- Sort By Filter + Search -->
        <form method="get" class="row g-2 justify-content-center align-items-end mb-4">
            <div class="col-12 col-md-3">
                <label class="form-label mb-1">Sort by Genre</label>
                <select name="genre" class="form-select form-select-sm">
                    <option value="">All Genre</option>
                    <?php foreach ($genreList as $g): ?>
                        <option value="<?= htmlspecialchars($g) ?>" <?= $selectedGenre == $g ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label mb-1">Sort by Mood</label>
                <select name="mood" class="form-select form-select-sm">
                    <option value="">All Mood</option>
                    <?php foreach ($moodList as $m): ?>
                        <option value="<?= htmlspecialchars($m) ?>" <?= $selectedMood == $m ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label mb-1">Search Movie</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by title..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            </div>
            <div class="col-6 col-md-1 d-grid">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="col-6 col-md-1 d-grid">
                <a href="category.php" class="btn btn-sm btn-outline-light">Reset</a>
            </div>
        </form>

        <h2 class="fw-bold mb-4 text-center text-dark"><?= $sectionTitle ?></h2>
        <div class="row g-4">
            <?php if (count($movies) > 0): ?>
                <?php foreach ($movies as $movie): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                        <div class="card border-0 shadow-sm rounded-4 w-100 h-100 d-flex flex-column">
                            <img src="../assets/img/<?= htmlspecialchars($movie['poster'] ?: 'nophoto.jpg') ?>"
                                class="card-img-top rounded-top-4"
                                alt="<?= htmlspecialchars($movie['title']) ?>"
                                style="height:200px; object-fit:cover;">
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title fw-semibold mb-2"><?= htmlspecialchars($movie['title']) ?></h6>
                                <p class="text-muted small mb-3"><?= htmlspecialchars(mb_strimwidth($movie['synopsis'], 0, 60, '...')) ?></p>
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch mt-auto gap-2">
                                    <?php $inWatchlist = in_array($movie['id'], $watchlist); ?>
                                    <form class="form-watchlist w-100 d-inline" data-movie-id="<?= $movie['id'] ?>">
                                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                                        <?php if ($inWatchlist): ?>
                                            <button type="submit" class="btn btn-sm btn-danger d-flex justify-content-center align-items-center w-100 p-1">
                                                <i class="bi bi-dash me-1"></i> Remove Watchlist
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex justify-content-center align-items-center w-100 p-1">
                                                <i class="bi bi-plus me-1"></i> Add Watchlist
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="movie_detail.php?id=<?= $movie['id'] ?>" class="btn btn-outline-danger btn-sm btn-detail w-100 d-flex align-items-center justify-content-center" data-id="<?= $movie['id'] ?>" data-bs-toggle="modal" data-bs-target="#movieDetailModal">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p class="text-muted fst-italic">Tidak ada film untuk kategori ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- Detail Movie Modal -->
    <div class="modal fade" id="movieDetailModal" tabindex="-1" aria-labelledby="movieDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="movieDetailModalLabel">
                        <i class="bi bi-film me-2"></i>Movie Details
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="" alt="" class="movie-poster  shadow">
                        </div>
                        <div class="col-md-7">
                            <h3 class="fw-bold text-danger mb-3"></h3>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Director:</strong></div>
                                <div class="col-8 director"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Trailer:</strong></div>
                                <div class="col-8 trailer">
                                    <a href="#">
                                        <p class="mb-0"></p>
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Duration:</strong></div>
                                <div class="col-8 duration"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Mood:</strong></div>
                                <div class="col-8 moods"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Genre:</strong></div>
                                <div class="col-8 genres"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Release Date:</strong></div>
                                <div class="col-8 release-date"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Cast:</strong></div>
                                <div class="col-8 cast"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 ps-0"><strong>Statistics:</strong></div>
                                <div class="col-8">
                                    <span class="badge bg-warning text-dark me-2 rating"></span>
                                    <span class="badge bg-info me-2 watch-count"></span>
                                    <span class="badge bg-danger like-count"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Synopsis:</strong>
                                <p class="mt-2 text-muted synopsis"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail Movie Modal -->

    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-detail');
            if (btn) {
                e.preventDefault();
                const id = btn.getAttribute('data-id');
                if (!id) {
                    alert('ID tidak ditemukan!');
                    return;
                }
                fetch('../admin/movie_detail.php?id=' + id)
                    .then(res => res.json())
                    .then(data => {
                        // Selector modal
                        document.getElementById('movieDetailModal').setAttribute('data-id', id);
                        document.querySelector('#movieDetailModal .modal-body .movie-poster').src = data.poster;
                        document.querySelector('#movieDetailModal .modal-body .movie-poster').alt = data.title + ' Poster';
                        document.querySelector('#movieDetailModal .modal-body h3').textContent = data.title;
                        document.querySelector('#movieDetailModal .modal-body .director').textContent = data.director;
                        document.querySelector('#movieDetailModal .modal-body .trailer a').href = data.trailer_url;
                        document.querySelector('#movieDetailModal .modal-body .trailer p').textContent = data.trailer_url;
                        document.querySelector('#movieDetailModal .modal-body .duration').textContent = data.duration + ' minutes';
                        document.querySelector('#movieDetailModal .modal-body .release-date').textContent = data.release_date;
                        document.querySelector('#movieDetailModal .modal-body .synopsis').textContent = data.synopsis;
                        document.querySelector('#movieDetailModal .modal-body .cast').textContent = data.cast;
                        let moodHtml = '';
                        data.moods.forEach(m => moodHtml += `<span class="badge bg-danger me-1">${m}</span>`);
                        document.querySelector('#movieDetailModal .modal-body .moods').innerHTML = moodHtml;
                        let genreHtml = '';
                        data.genres.forEach(g => genreHtml += `<span class="badge bg-secondary me-1">${g}</span>`);
                        document.querySelector('#movieDetailModal .modal-body .genres').innerHTML = genreHtml;
                        document.querySelector('#movieDetailModal .modal-body .rating').innerHTML = `<i class="bi bi-star-fill"></i> ${data.rating} Rating`;
                        document.querySelector('#movieDetailModal .modal-body .watch-count').innerHTML = `<i class="bi bi-eye-fill"></i> ${data.watch_count} Watches`;
                        document.querySelector('#movieDetailModal .modal-body .like-count').innerHTML = `<i class="bi bi-heart-fill"></i> ${data.like_count} Likes`;
                    });
            }
        });
    </script>

    <!-- Script untuk toggle watchlist -->
    <script>
        document.addEventListener('submit', async function(e) {
            const form = e.target.closest('.form-watchlist');
            if (form) {
                e.preventDefault();
                const movieId = form.getAttribute('data-movie-id');
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                const fd = new FormData(form);
                const res = await fetch('toggle_watchlist.php', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();
                btn.disabled = false;
                if (data.status === 'added') {
                    btn.className = 'btn btn-sm btn-danger d-flex justify-content-center align-items-center w-100 p-1';
                    btn.innerHTML = '<i class="bi bi-dash me-1"></i> Remove Watchlist';
                } else if (data.status === 'removed') {
                    btn.className = 'btn btn-sm btn-outline-danger d-flex justify-content-center align-items-center w-100 p-1';
                    btn.innerHTML = '<i class="bi bi-plus me-1"></i> Add Watchlist';
                }
            }
        });
    </script>
    <!-- Script untuk toggle watchlist -->

    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>