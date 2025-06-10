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
        <?php
        $file = __DIR__ . "/content/$page.php";

        if (file_exists($file)) {
            require($file);
        } else {
            require(__DIR__ . "/content/404.php");
        }
        ?>
    </div>
    <!-- Header End-->

    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>