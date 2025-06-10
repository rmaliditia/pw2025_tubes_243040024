<?php
session_start();
// echo __DIR__;
require '../function.php';

// cek apakah user sudah login
if (!isset($_SESSION["login"]) || $_SESSION["role"] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// mengambil informasi page
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// mengambil data movies
$movies = "
SELECT 
    m.id,
    m.title,
    m.trailer_url,
    m.release_date,
    m.synopsis,
    m.duration,
    m.rating,
    m.watch_count,
    m.like_count,
    d.name AS director,
    md.name AS mood,
    g.name AS genre,
    a.name AS cast
FROM movies m

LEFT JOIN director d ON m.director_id = d.id    

LEFT JOIN movie_mood mm ON m.id = mm.movie_id
LEFT JOIN moods md ON md.id = mm.mood_id

LEFT JOIN movie_genre mg ON m.id = mg.movie_id
LEFT JOIN genre g ON g.id = mg.genre_id

LEFT JOIN casts mc ON m.id = mc.movie_id
LEFT JOIN actors a ON a.id = mc.actor_id

ORDER BY m.id;
";

$result = mysqli_query($conn, $movies);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
$movies = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    if (!isset($movies[$id])) {
        $movies[$id] = [
            'id' => $id,
            'title' => $row['title'],
            'trailer_url' => $row['trailer_url'],
            'release_date' => $row['release_date'],
            'synopsis' => $row['synopsis'],
            'duration' => $row['duration'],
            'rating' => $row['rating'],
            'watch_count' => $row['watch_count'],
            'like_count' => $row['like_count'],
            'director' => $row['director'],
            'moods' => [],
            'genre' => [],
            'casts' => []
        ];
    }

    if ($row['mood'] && !in_array($row['mood'], $movies[$id]['moods'])) {
        $movies[$id]['moods'][] = $row['mood'];
    }

    if ($row['genre'] && !in_array($row['genre'], $movies[$id]['genre'])) {
        $movies[$id]['genre'][] = $row['genre'];
    }

    if ($row['cast'] && !in_array($row['cast'], $movies[$id]['casts'])) {
        $movies[$id]['casts'][] = $row['cast'];
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Moodflix</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="">
    <!-- Sidebar Start -->
    <div class="d-flex flex-column fixed-top flex-shrink-0 p-3 text-bg-light min-vh-100" style="width: 270px;">
        <a href="" class="d-flex align-items-center ms-3 text-secondary text-decoration-none w-100">
            <img src="../assets/img/logo.png" alt="Logo" width="140">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto" id="sidebarNav">
            <li class="nav-item">
                <a href="index.php?page=dashboard" class="nav-link text-secondary <?= $page === 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="index.php?page=movies" class="nav-link text-secondary <?= $page === 'movies' ? 'active' : '' ?>">
                    <i class="bi bi-film me-2"></i>Movies
                </a>
            </li>
            <li>
                <a href="index.php?page=users" class="nav-link text-secondary <?= $page === 'users' ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i>Users
                </a>
            </li>
            <li>
                <a href="index.php?page=reviews" class="nav-link text-secondary <?= $page === 'reviews' ? 'active' : '' ?>">
                    <i class="bi bi-chat-left-dots me-2"></i>Reviews
                </a>
            </li>
        </ul>
    </div>
    <!-- Sidebar End -->

    <div class="main-content p-4">
        <!-- Header Start-->
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 col-md-12 mb-3 mb-lg-0">
                <h2 class="fw-bold mb-1">Moodflix Dashboard</h2>
                <h6 class="text-muted title-sm">Here’s what’s going on at your business right now</h6>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                    <div class="me-4"> <i class="bi bi-bell fs-5 me-3"></i>
                        <i class="bi bi-envelope fs-5"></i>
                    </div>
                    <div class="dropdown">
                        <a href="" class="d-flex align-items-center text-secondary text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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
                </div>
            </div>
        </div>
        <!-- TEMPAT SIMPAN KODE PAGE PHP -->
        <!-- MOVIES CODE START -->
        <div class="container mt-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="fw-bold">Movie List</h4>
                <a href="#" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add Movie
                </a>
            </div>
            <!-- Controls -->
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <div class="d-flex gap-2 mb-2 mb-md-0">
                    <a href="#" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-filter me-2"></i>Filter
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-sort-alpha-down me-2"></i>Sort By
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-download me-2"></i>Export
                    </a>
                </div>
                <form class="d-flex w-25" role="search">
                    <input class="form-control form-control" type="search" placeholder="Search" aria-label="Search" />
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive shadow-sm border rounded bg-white pb-3">
                <?php if (count($movies) > 0) : ?>
                    <table class="table table-hover align-middle mb-0 table-movies table-fixed">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 10%;">No</th>
                                <th scope="col" style="width: 20%;">Title</th>
                                <th scope="col" style="width: 30%;">Mood</th>
                                <th scope="col" style="width: 30%;">Release Date</th>
                                <th scope="col" style="width: 30%;">Trailer</th>
                                <th scope="col" style="width: 15%;">Ratings</th>
                                <th scope="col" style="width: 15%;">Statistics</th>
                                <th scope="col" style="width: 15%;">Details</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        <?php foreach ($movies as $movie) : ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td class="text-wrap"><?php echo $movie["title"]; ?></td>
                                    <td class="text-wrap"><?php echo implode(', ', $movie['moods']) ?></td>
                                    <td class="text-wrap"><?php echo $movie["release_date"]; ?></td>
                                    <td class="text-wrap"><small><?php echo $movie["trailer_url"]; ?></small></td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill"></i> <?php echo $movie["rating"]; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <i class="bi bi-eye-fill"></i> <?php echo $movie["watch_count"]; ?>
                                        </span>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-heart-fill"></i> <?php echo $movie["like_count"]; ?>
                                        </span>
                                    </td>
                                    <td class="custom-button">
                                        <a href="#"
                                            class="btn btn-detail"
                                            data-id="<?= $movie['id']; ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#movieDetailModal">
                                            <i class="bi bi-eye-fill fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Tidak ada data yang ditemukan.</p>
                    <?php endif; ?>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3 px-3 flex-wrap">
                        <p class="text-muted mb-0">Showing 15 of <?php echo count($movies); ?></p>
                        <nav>
                            <ul class="pagination mb-0 d-flex gap-4">
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-caret-left-square-fill"></i>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link text-muted" href="#">1</a></li>
                                <li class="page-item"><a class="page-link text-muted" href="#">2</a></li>
                                <li class="page-item"><a class="page-link text-muted" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-caret-right-square-fill"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
            </div>
        </div>


        <!-- Movie Detail Modal -->
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
                                <img src="../assets/img/inception-poster.jpg" alt="Movie Poster" class="movie-poster shadow">
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
                                    <div class="col-8 casts"></div>
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
                        <button type="button" class="btn btn-danger">
                            <i class="bi bi-pencil-square me-2"></i>Edit Movie
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MOVIES CODE END -->
        <!-- TEMPAT SIMPAN KODE PAGE PHP -->
    </div>
    <!-- Header End-->

    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-detail').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    fetch('movie_detail.php?id=' + id)
                        .then(res => res.json())
                        .then(data => {
                            // Update modal content
                            document.querySelector('#movieDetailModal .modal-body h3').textContent = data.title;
                            document.querySelector('#movieDetailModal .modal-body .director').textContent = data.director;
                            document.querySelector('#movieDetailModal .modal-body .trailer a').href = data.trailer_url;
                            document.querySelector('#movieDetailModal .modal-body .trailer p').textContent = data.trailer_url;
                            document.querySelector('#movieDetailModal .modal-body .duration').textContent = data.duration + ' minutes';
                            document.querySelector('#movieDetailModal .modal-body .release-date').textContent = data.release_date;
                            document.querySelector('#movieDetailModal .modal-body .casts').textContent = data.casts.join(', ');
                            document.querySelector('#movieDetailModal .modal-body .synopsis').textContent = data.synopsis;
                            // Moods
                            let moodHtml = '';
                            data.moods.forEach(m => moodHtml += `<span class="badge bg-danger me-1">${m}</span>`);
                            document.querySelector('#movieDetailModal .modal-body .moods').innerHTML = moodHtml;
                            // Genres
                            let genreHtml = '';
                            data.genres.forEach(g => genreHtml += `<span class="badge bg-secondary me-1">${g}</span>`);
                            document.querySelector('#movieDetailModal .modal-body .genres').innerHTML = genreHtml;
                            // Statistics
                            document.querySelector('#movieDetailModal .modal-body .rating').innerHTML = `<i class="bi bi-star-fill"></i> ${data.rating} Rating`;
                            document.querySelector('#movieDetailModal .modal-body .watch-count').innerHTML = `<i class="bi bi-eye-fill"></i> ${data.watch_count} Watches`;
                            document.querySelector('#movieDetailModal .modal-body .like-count').innerHTML = `<i class="bi bi-heart-fill"></i> ${data.like_count} Likes`;
                        });
                });
            });
        });
    </script>
</body>

</html>