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
    m.cast,
    m.duration,
    m.rating,
    m.watch_count,
    m.like_count,
    d.name AS director,
    md.name AS mood,
    g.name AS genre
FROM movies m

LEFT JOIN director d ON m.director_id = d.id    

LEFT JOIN movie_mood mm ON m.id = mm.movie_id
LEFT JOIN moods md ON md.id = mm.mood_id

LEFT JOIN movie_genre mg ON m.id = mg.movie_id
LEFT JOIN genre g ON g.id = mg.genre_id

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
            'image' => $row['image'] ?? '../assets/img/nophoto.jpg',
            'title' => $row['title'],
            'trailer_url' => $row['trailer_url'],
            'release_date' => $row['release_date'],
            'synopsis' => $row['synopsis'],
            'cast' => $row['cast'],
            'duration' => $row['duration'],
            'rating' => $row['rating'],
            'watch_count' => $row['watch_count'],
            'like_count' => $row['like_count'],
            'director' => $row['director'],
            'moods' => [],
            'genre' => [],
        ];
    }

    if ($row['mood'] && !in_array($row['mood'], $movies[$id]['moods'])) {
        $movies[$id]['moods'][] = $row['mood'];
    }

    if ($row['genre'] && !in_array($row['genre'], $movies[$id]['genre'])) {
        $movies[$id]['genre'][] = $row['genre'];
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
            if (isset($_GET['page'])) {
                echo ucwords($_GET['page']);
            } else {
                echo 'Dashboard';
            }
            ?> | Moodflix</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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
                </div>
            </div>
        </div>
        <!-- TEMPAT SIMPAN KODE PAGE PHP -->
        <?php
        $file = __DIR__ . "/content/$page.php";

        if (file_exists($file)) {
            require($file);
        } else {
            require(__DIR__ . "/content/404.php");
        }
        ?>
        <!-- TEMPAT SIMPAN KODE PAGE PHP -->
    </div>
    <!-- Header End-->

    <!-- MY JS -->
    <script src="../assets/js/script.js"></script>


    <!-- DATA MODAL/MOVIE JS -->
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
                fetch('movie_detail.php?id=' + id)
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

    <!-- INPUT DIRECTOR JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('directorSelect');
            const input = document.getElementById('directorNewInput');
            if (select) {
                select.addEventListener('change', function() {
                    if (this.value === 'add_new') {
                        input.classList.remove('d-none');
                        input.required = true;
                    } else {
                        input.classList.add('d-none');
                        input.required = false;
                    }
                });
            }
        });
    </script>


    <!-- DATATABLES BOOTSTRAP 5 -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                dom: '<"d-flex justify-content-between align-items-center datatables-top-menu"lfB>rt<"d-flex justify-content-between align-items-center datatables-bottom-menu"ip>',
                buttons: [{
                    extend: 'print',
                    text: '<i class="bi bi-printer me-2"></i>Print',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    customize: function(win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css({
                                'font-size': 'inherit',
                                'border': '1px solid #000'
                            });
                        $(win.document.body).find('thead').css({
                            'background-color': '#dc3545',
                            'color': '#fff'
                        });
                    }
                }],
                responsive: true,
                language: {
                    lengthMenu: "Show&nbsp; _MENU_ movies per page",
                    search: "",
                    searchPlaceholder: "Search movies..."
                },
                lengthMenu: [5, 10, 20, 50, -1],
                columns: [{
                        orderable: true,
                        searchable: true
                    },
                    {
                        orderable: true,
                        searchable: true
                    },
                    {
                        orderable: true,
                        searchable: true
                    },
                    {
                        orderable: true,
                        searchable: true
                    },
                    {
                        orderable: true,
                        searchable: true
                    },
                    {
                        orderable: true,
                        searchable: false
                    },
                    {
                        orderable: true,
                        searchable: false
                    },
                    {
                        orderable: false,
                        searchable: false
                    } // kolom detail (tidak di-print)
                ],
                order: [
                    [0, 'asc']
                ]
            });
        });
    </script>

</body>

</html>