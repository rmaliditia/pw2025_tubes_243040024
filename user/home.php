<?php
session_start();
require '../function.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] !== 'user') {
    header("Location: auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodflix</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php require '../user/header.php'; ?>
    <div class="container-fluid gx-0">
        <div class="row">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- ITEM 1 -->
                    <div class="carousel-item active position-relative">
                        <img src="../assets/img/carousel(1).png" class="d-block w-100 custom-carousel-img" alt="...">
                        <div class="carousel-caption d-flex flex-column align-items-start justify-content-center h-100 ps-5" style="left:0; right:auto; bottom:0; top:0; background: linear-gradient(90deg,rgba(220,53,69,0.85) 0%,rgba(220,53,69,0.2) 80%,transparent 100%);">
                            <h2 class="fw-bold mb-1" style="color:#fff;">Inception</h2>
                            <h5 class="mb-3" style="color:#fff;">2010</h5>
                            <div class="mb-3">
                                <button class="btn btn-light btn-sm me-2 fw-bold" style="color:#dc3545;">
                                    <i class="bi bi-play-circle me-1"></i> Watch Now
                                </button>
                                <button class="btn btn-outline-light btn-sm me-2 fw-bold" style="color:#fff;">
                                    <i class="bi bi-info-circle me-1"></i> More Info
                                </button>
                                <button class="btn btn-outline-light btn-sm fw-bold" style="color:#fff;">
                                    <i class="bi bi-heart me-1"></i> Add to Watchlist
                                </button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-danger me-1">Action</span>
                                <span class="badge bg-danger me-1">Sci-Fi</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Mind-Bending</span>
                                <span class="badge bg-primary me-1">Thrilling</span>
                            </div>
                            <h6 class="mt-2 mb-0" style="color:#fff;">Rating: <span class="fw-bold">4.5/5.0</span></h6>
                        </div>
                    </div>
                    <!-- ITEM 2 -->
                    <div class="carousel-item position-relative">
                        <img src="../assets/img/carousel(2).png" class="d-block w-100 custom-carousel-img" alt="...">
                        <div class="carousel-caption d-flex flex-column align-items-start justify-content-center h-100 ps-5" style="left:0; right:auto; bottom:0; top:0; background: linear-gradient(90deg,rgba(220,53,69,0.85) 0%,rgba(220,53,69,0.2) 80%,transparent 100%);">
                            <h2 class="fw-bold mb-1" style="color:#fff;">Movie Title 2</h2>
                            <h5 class="mb-3" style="color:#fff;">2023</h5>
                            <div class="mb-3">
                                <button class="btn btn-light btn-sm me-2 fw-bold" style="color:#dc3545;">
                                    <i class="bi bi-play-circle me-1"></i> Watch Now
                                </button>
                                <button class="btn btn-outline-light btn-sm me-2 fw-bold" style="color:#fff;">
                                    <i class="bi bi-info-circle me-1"></i> More Info
                                </button>
                                <button class="btn btn-outline-light btn-sm fw-bold" style="color:#fff;">
                                    <i class="bi bi-heart me-1"></i> Add to Watchlist
                                </button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-danger me-1">Drama</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Emotional</span>
                            </div>
                            <h6 class="mt-2 mb-0" style="color:#fff;">Rating: <span class="fw-bold">4.7/5.0</span></h6>
                        </div>
                    </div>
                    <!-- ITEM 3 -->
                    <div class="carousel-item position-relative">
                        <img src="../assets/img/carousel(3).png" class="d-block w-100 custom-carousel-img" alt="...">
                        <div class="carousel-caption d-flex flex-column align-items-start justify-content-center h-100 ps-5" style="left:0; right:auto; bottom:0; top:0; background: linear-gradient(90deg,rgba(220,53,69,0.85) 0%,rgba(220,53,69,0.2) 80%,transparent 100%);">
                            <h2 class="fw-bold mb-1" style="color:#fff;">Movie Title 2</h2>
                            <h5 class="mb-3" style="color:#fff;">2023</h5>
                            <div class="mb-3">
                                <button class="btn btn-light btn-sm me-2 fw-bold" style="color:#dc3545;">
                                    <i class="bi bi-play-circle me-1"></i> Watch Now
                                </button>
                                <button class="btn btn-outline-light btn-sm me-2 fw-bold" style="color:#fff;">
                                    <i class="bi bi-info-circle me-1"></i> More Info
                                </button>
                                <button class="btn btn-outline-light btn-sm fw-bold" style="color:#fff;">
                                    <i class="bi bi-heart me-1"></i> Add to Watchlist
                                </button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-danger me-1">Drama</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Emotional</span>
                            </div>
                            <h6 class="mt-2 mb-0" style="color:#fff;">Rating: <span class="fw-bold">4.7/5.0</span></h6>
                        </div>
                    </div>
                    <!-- ITEM 4 -->
                    <div class="carousel-item position-relative">
                        <img src="../assets/img/carousel(4).png" class="d-block w-100 custom-carousel-img" alt="...">
                        <div class="carousel-caption d-flex flex-column align-items-start justify-content-center h-100 ps-5" style="left:0; right:auto; bottom:0; top:0; background: linear-gradient(90deg,rgba(220,53,69,0.85) 0%,rgba(220,53,69,0.2) 80%,transparent 100%);">
                            <h2 class="fw-bold mb-1" style="color:#fff;">Movie Title 2</h2>
                            <h5 class="mb-3" style="color:#fff;">2023</h5>
                            <div class="mb-3">
                                <button class="btn btn-light btn-sm me-2 fw-bold" style="color:#dc3545;">
                                    <i class="bi bi-play-circle me-1"></i> Watch Now
                                </button>
                                <button class="btn btn-outline-light btn-sm me-2 fw-bold" style="color:#fff;">
                                    <i class="bi bi-info-circle me-1"></i> More Info
                                </button>
                                <button class="btn btn-outline-light btn-sm fw-bold" style="color:#fff;">
                                    <i class="bi bi-heart me-1"></i> Add to Watchlist
                                </button>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-danger me-1">Drama</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-primary me-1">Emotional</span>
                            </div>
                            <h6 class="mt-2 mb-0" style="color:#fff;">Rating: <span class="fw-bold">4.7/5.0</span></h6>
                        </div>
                    </div>
                    <!-- Tambahkan item carousel lain dengan struktur yang sama -->
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>