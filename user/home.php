<?php
session_start();
require '../function.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($user_id === 0) {
    // Redirect ke login jika user_id tidak ada
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];


// Ambil top 3 movies berdasarkan watch_count atau like_count
$topMovies = [];
$result = mysqli_query($conn, "SELECT id, title, poster, synopsis, watch_count, like_count FROM movies ORDER BY watch_count DESC, like_count DESC LIMIT 3");
while ($row = mysqli_fetch_assoc($result)) {
    $topMovies[] = $row;
}

// Ambil top 4 movies berdasarkan release_date
$newMovies = [];
$result = mysqli_query($conn, "SELECT id, title, poster, synopsis, watch_count, like_count FROM movies ORDER BY release_date DESC LIMIT 4");
while ($row = mysqli_fetch_assoc($result)) {
    $newMovies[] = $row;
}

// Ambil top 4 movies bperdasarkan watch_count atau like_count
$popularMovies = [];
$result = mysqli_query($conn, "SELECT id, title, poster, synopsis, watch_count, like_count FROM movies ORDER BY rating DESC LIMIT 4");
while ($row = mysqli_fetch_assoc($result)) {
    $popularMovies[] = $row;
}

// Ambil data watchlist user
$query = "
    SELECT movie_id FROM watchlist WHERE user_id = $user_id
";
$result = mysqli_query($conn, $query);
$watchlist = [];
while ($row = mysqli_fetch_assoc($result)) $watchlist[] = $row['movie_id'];


$liked_movies = [];
$res = mysqli_query($conn, "SELECT movie_id FROM likes WHERE user_id = $user_id");
while ($row = mysqli_fetch_assoc($res)) $liked_movies[] = $row['movie_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodflix</title>

    <style>
        body {
            /* height: 10000px; */
            background-size: cover;
            background-color: #dc3545;
            color: #ffffff;
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
            background: linear-gradient(to bottom,
                    rgba(220, 53, 69, 0.85),
                    rgba(0, 0, 0, 0.7));
            z-index: -1;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.1),
                    rgba(0, 0, 0, 0.1) 1px,
                    transparent 1px,
                    transparent 3px);
            /* pointer-events: none; */
            z-index: -1;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php require '../user/header.php'; ?>

    <section class="home">
        <div class="container mt-5 ">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="row text-center">
                        <!-- Tagline Start -->
                        <div class="row" data-aos="fade-up" data-aos-duration="900" data-aos-anchor-placement="bottom" data-aos-offset="50" data-aos-once="true">
                            <h1 class="tagline mb-4 fs-1 fs-md-2">
                                Your personalized streaming guide for<br>movies that match your mood
                            </h1>
                            <h5>
                                Explore trending, new, and mood-based films – only on Moodflix.
                            </h5>
                        </div>
                        <!-- Tagline End -->

                        <!-- Get Started Button Start -->
                        <div class="pt-5 pb-3  text-center" data-aos="fade-up" data-aos-duration="2000" data-aos-anchor-placement="bottom" data-aos-offset="100" data-aos-once="true">
                            <button
                                type="button"
                                class="btn btn-danger py-3 px-5 rounded-4 fs-5 fw-semibold"
                                onclick="location.href='category.php'">
                                Get Started
                            </button>
                        </div>

                        <!-- Top 3 Movies Card Start -->
                        <div class="container mt-5">
                            <span class="section__subtitle">Editor's Pick</span>
                            <h2 class="section__title mb-4 bg-danger">Top 3 Movies Trending<span>.</span></h2>

                            <div class="row g-4 justify-content-center">
                                <?php foreach ($topMovies as $movie): ?>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card movie-card border-0 shadow-sm rounded-4 h-100">
                                            <div class="position-relative">
                                                <img src="../assets/img/<?= htmlspecialchars($movie['poster'] ?: 'nophoto.jpg') ?>"
                                                    class="card-img-top rounded-top-4"
                                                    alt="<?= htmlspecialchars($movie['title']) ?>"
                                                    style="height:250px; object-fit:cover;">

                                                <!-- Watch & Like Badges -->
                                                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column align-items-start" style="z-index:2;">
                                                    <span class="badge bg-secondary mb-1 small"><i class="bi bi-eye me-1"></i><?= (int)$movie['watch_count'] ?></span>
                                                    <span class="badge bg-danger small"><i class="bi bi-heart me-1"></i><?= (int)$movie['like_count'] ?></span>
                                                </div>
                                            </div>

                                            <div class="card-body d-flex flex-column p-3">
                                                <h5 class="card-title fw-semibold text-dark mb-2"><?= htmlspecialchars($movie['title']) ?></h5>
                                                <p class="text-muted small mb-3">
                                                    <?= htmlspecialchars(mb_strimwidth($movie['synopsis'], 0, 90, '...')) ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-auto gap-2">
                                                    <?php $inWatchlist = in_array($movie['id'], $watchlist); ?>
                                                    <form class="form-watchlist w-75 d-inline" data-movie-id="<?= $movie['id'] ?>">
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
                                                    <a href="movie_detail.php?id=<?= $movie['id'] ?>" class="btn btn-outline-danger btn-sm btn-detail w-25" data-id="<?= $movie['id'] ?>" data-bs-toggle="modal" data-bs-target="#movieDetailModal">
                                                        Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Top 3 Movies Card End -->

                        <!-- Top 3 Movies New Start -->
                        <div class="container mt-5">
                            <span class="section__subtitle">Editor's Pick</span>
                            <h2 class="section__title mb-4 bg-danger">Now Movie<span>.</span></h2>

                            <div class="row g-4 justify-content-center">
                                <?php foreach ($newMovies as $movie): ?>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="card movie-card border-0 shadow-sm rounded-4 h-100">
                                            <div class="position-relative">
                                                <img src="../assets/img/<?= htmlspecialchars($movie['poster'] ?: 'nophoto.jpg') ?>"
                                                    class="card-img-top rounded-top-4"
                                                    alt="<?= htmlspecialchars($movie['title']) ?>"
                                                    style="height:250px; object-fit:cover;">

                                                <!-- Watch & Like Badges -->
                                                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column align-items-start" style="z-index:2;">
                                                    <span class="badge bg-secondary mb-1 small"><i class="bi bi-eye me-1"></i><?= (int)$movie['watch_count'] ?></span>
                                                    <span class="badge bg-danger small"><i class="bi bi-heart me-1"></i><?= (int)$movie['like_count'] ?></span>
                                                </div>
                                            </div>

                                            <div class="card-body d-flex flex-column p-3">
                                                <h5 class="card-title fw-semibold text-dark mb-2"><?= htmlspecialchars($movie['title']) ?></h5>
                                                <p class="text-muted small mb-3">
                                                    <?= htmlspecialchars(mb_strimwidth($movie['synopsis'], 0, 90, '...')) ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-auto gap-2">
                                                    <?php $inWatchlist = in_array($movie['id'], $watchlist); ?>
                                                    <form class="form-watchlist w-75 d-inline" data-movie-id="<?= $movie['id'] ?>">
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
                                                    <a href="movie_detail.php?id=<?= $movie['id'] ?>" class="btn btn-outline-danger btn-sm btn-detail" data-id="<?= $movie['id'] ?>" data-bs-toggle="modal" data-bs-target="#movieDetailModal">
                                                        Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Top 3 Movies New End -->

                        <!-- Top 3 Movies New Start -->
                        <div class="container mt-5">
                            <span class="section__subtitle">Editor's Pick</span>
                            <h2 class="section__title mb-4 bg-danger">Popular Movies<span>.</span></h2>

                            <div class="row g-4 justify-content-center">
                                <?php foreach ($popularMovies as $movie): ?>
                                    <div class="col-12 col-md-6">
                                        <div class="card movie-card border-0 shadow-sm rounded-4 h-100">
                                            <div class="position-relative">
                                                <img src="../assets/img/<?= htmlspecialchars($movie['poster'] ?: 'nophoto.jpg') ?>"
                                                    class="card-img-top rounded-top-4"
                                                    alt="<?= htmlspecialchars($movie['title']) ?>"
                                                    style="height:250px; object-fit:cover;">

                                                <!-- Watch & Like Badges -->
                                                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column align-items-start" style="z-index:2;">
                                                    <span class="badge bg-secondary mb-1 small"><i class="bi bi-eye me-1"></i><?= (int)$movie['watch_count'] ?></span>
                                                    <span class="badge bg-danger small"><i class="bi bi-heart me-1"></i><?= (int)$movie['like_count'] ?></span>
                                                </div>
                                            </div>

                                            <div class="card-body d-flex flex-column p-3">
                                                <h5 class="card-title fw-semibold text-dark mb-2"><?= htmlspecialchars($movie['title']) ?></h5>
                                                <p class="text-muted small mb-3">
                                                    <?= htmlspecialchars(mb_strimwidth($movie['synopsis'], 0, 90, '...')) ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-auto gap-2">
                                                    <?php $inWatchlist = in_array($movie['id'], $watchlist); ?>
                                                    <form class="form-watchlist w-75 d-inline" data-movie-id="<?= $movie['id'] ?>">
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
                                                    <a href="movie_detail.php?id=<?= $movie['id'] ?>" class="btn btn-outline-danger btn-sm btn-detail w-25" data-id="<?= $movie['id'] ?>" data-bs-toggle="modal" data-bs-target="#movieDetailModal">
                                                        Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Top 3 Movies New End -->
                    </div>
                    <!-- Penutup Home Section -->
                    <div class="container my-5 py-5">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 text-center">
                                <h2 class="fw-bold mb-3" style="color:#212529;">
                                    Find Your Favorite Movies By Category!
                                </h2>
                                <p class="lead text-dark mb-4">
                                    Explore thousands of movies based on your favorite mood, genre, or director.<br>
                                    Find the best recommendations that suit your mood and taste on Moodflix.
                                </p>
                                <a href="category.php" class="btn btn-danger btn-lg px-4 py-2 rounded-pill shadow-sm fw-semibold">
                                    <i class="bi bi-funnel-fill me-2"></i>Explore Categories
                                </a>
                                <div class="mt-4 d-flex justify-content-center gap-2 flex-wrap">
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Action</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Sci-Fi</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Drama</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Fantasy</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Thriller</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Comedy</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Romance</span>
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-2">#Documentry</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                <div class="col-8 trailer"></div>
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
                        // document.querySelector('#movieDetailModal .modal-body .trailer a').href = data.trailer_url;
                        // document.querySelector('#movieDetailModal .modal-body .trailer p').textContent = data.trailer_url;
                        let trailerEmbed = '';
                        if (data.trailer_url && data.trailer_url.includes('youtube.com')) {
                            // Ambil ID video YouTube
                            const ytId = data.trailer_url.split('v=')[1]?.split('&')[0];
                            if (ytId) {
                                trailerEmbed = `<div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/${ytId}" frameborder="0" allowfullscreen></iframe>
        </div>`;
                            } else {
                                trailerEmbed = `<a href="${data.trailer_url}" target="_blank">${data.trailer_url}</a>`;
                            }
                        } else if (data.trailer_url) {
                            trailerEmbed = `<a href="${data.trailer_url}" target="_blank">${data.trailer_url}</a>`;
                        } else {
                            trailerEmbed = '<span class="text-muted">No trailer available</span>';
                        }
                        document.querySelector('#movieDetailModal .modal-body .trailer').innerHTML = trailerEmbed;
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