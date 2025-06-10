<?php
session_start();
require 'function.php';

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
    <?php include 'includes/header.php'; ?>

    <a href="auth/logout.php" class="btn btn-close">Logout</a>

    <!-- INI ADALAH DETAIL MOVIE -->
    <!-- <div class="modal fade" id="movieDetailModal" tabindex="-1" aria-labelledby="movieDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="movieDetailModalLabel">
                        <i class="bi bi-film me-2"></i>Movie Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center d-flex align-items-stretch">
                            <img src="../assets/img/inception-poster.jpg" alt="Movie Poster" class="movie-poster shadow">
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold text-danger mb-3">Inception</h3>

                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Director:</strong></div>
                                <div class="col-8">Christopher Nolan</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Duration:</strong></div>
                                <div class="col-8">148 minutes</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Genre:</strong></div>
                                <div class="col-8">
                                    <span class="badge bg-secondary me-1">Science Fiction</span>
                                    <span class="badge bg-secondary me-1">Action</span>
                                    <span class="badge bg-secondary">Thriller</span>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Release Year:</strong></div>
                                <div class="col-8">2010</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4 ps-0"><strong>Cast:</strong></div>
                                <div class="col-8">Leonardo DiCaprio, Marion Cotillard, Tom Hardy</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 ps-0"><strong>Statistics:</strong></div>
                                <div class="col-8">
                                    <span class="badge bg-warning text-dark me-2">
                                        <i class="bi bi-star-fill"></i> 4.8 Rating
                                    </span>
                                    <span class="badge bg-info me-2">
                                        <i class="bi bi-eye-fill"></i> 1,234 Watches
                                    </span>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-heart-fill"></i> 987 Likes
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Synopsis:</strong>
                                <p class="mt-2 text-muted">
                                    Dom Cobb is a skilled thief, the absolute best in the dangerous art of extraction, stealing valuable secrets from deep within the subconscious during the dream state. Cobb's rare ability has made him a coveted player in this treacherous new world of corporate espionage, but it has also made him an international fugitive and cost him everything he has ever loved.
                                </p>
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
    </div> -->


    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>