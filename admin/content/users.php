<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="fw-bold">User List</h4>
            <!-- <a href="#" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-plus-circle me-2"></i>
                Add Movie
            </a> -->
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
        <div class="table-responsive shadow-sm border rounded bg-white pb-3 ">
            <table class="table table-hover align-middle mb-0 table-movies">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Photo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Status</th>
                        <th scope="col">Watches</th>
                        <th scope="col">Reviews</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="../assets/img/nophoto.jpg" alt="profile" width="40" height="40" class="rounded-circle shadow-sm">
                        </td>
                        <td>Mark</td>
                        <td>10 Dec 2022</td>
                        <td>5</td>
                        <td>5</td>
                        <td>Active</td>
                        <td class="custom-button">
                            <a href="#" class="btn me-1">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>
                            <a href="#" class="btn">
                                <i class="bi bi-trash fs-5"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3 px-3 flex-wrap">
                <p class="text-muted mb-0">Showing 15 of 57 entries</p>
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

        <!-- Pagination -->
    </div>
</body>

</html>

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
                    <div class="col-md-4 text-center">
                        <img src="../assets/img/inception-poster.jpg" alt="Movie Poster" class="movie-poster shadow">
                    </div>
                    <div class="col-md-8">
                        <h3 class="fw-bold text-danger mb-3">Inception</h3>

                        <div class="row mb-2">
                            <div class="col-4"><strong>Director:</strong></div>
                            <div class="col-8">Christopher Nolan</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4"><strong>Duration:</strong></div>
                            <div class="col-8">148 minutes</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4"><strong>Genre:</strong></div>
                            <div class="col-8">
                                <span class="badge bg-secondary me-1">Science Fiction</span>
                                <span class="badge bg-secondary me-1">Action</span>
                                <span class="badge bg-secondary">Thriller</span>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4"><strong>Release Year:</strong></div>
                            <div class="col-8">2010</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4"><strong>Cast:</strong></div>
                            <div class="col-8">Leonardo DiCaprio, Marion Cotillard, Tom Hardy</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><strong>Statistics:</strong></div>
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

                        <div class="ps-2 mb-3">
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