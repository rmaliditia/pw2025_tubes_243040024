<!-- MOVIES CODE  -->
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
            <!-- <a href="#" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-sort-alpha-down me-2"></i>Sort By
            </a> -->
            <a href="#" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-download me-2"></i>Export
            </a>
        </div>
        <!-- <form class="d-flex w-25" role="search">
            <input class="form-control form-control" type="search" placeholder="Search" aria-label="Search" />
        </form> -->
    </div>

    <!-- Table -->
    <div class="table-responsive shadow-sm border rounded bg-white pb-3">
        <?php if (count($movies) > 0) : ?>
            <table class="table table-hover align-middle mb-0 table-movies table-striped" id="datatables">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col" style="width: 20%;">Title</th>
                        <th scope="col" style="width: 15%;">Mood</th>
                        <th scope="col" style="width: 15%;">Release Date</th>
                        <th scope="col" style="width: 15%;">Trailer</th>
                        <th scope="col" style="width: 10%;">Ratings</th>
                        <th scope="col" style="width: 10%;">Statistics</th>
                        <th scope="col" style="width: 10%;">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($movies as $movie) : ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td class="text-wrap"><?php echo htmlspecialchars($movie["title"]); ?></td>
                            <td class="text-wrap"><?php echo htmlspecialchars(implode(', ', $movie['moods'])); ?></td>
                            <td class="text-wrap"><?php echo htmlspecialchars($movie["release_date"]); ?></td>
                            <td class="text-wrap">
                                <?php if (!empty($movie["trailer_url"])): ?>
                                    <a href="<?php echo htmlspecialchars($movie["trailer_url"]); ?>" target="_blank">
                                        <small><?php echo htmlspecialchars($movie["trailer_url"]); ?></small>
                                    </a>
                                <?php else: ?>
                                    <small>-</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> <?php echo htmlspecialchars($movie["rating"]); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="bi bi-eye-fill"></i> <?php echo htmlspecialchars($movie["watch_count"]); ?>
                                </span>
                                <span class="badge bg-danger">
                                    <i class="bi bi-heart-fill"></i> <?php echo htmlspecialchars($movie["like_count"]); ?>
                                </span>
                            </td>
                            <td class="custom-button">
                                <button
                                    class="btn btn-sm btn-detail"
                                    data-id="<?= htmlspecialchars($movie['id']); ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#movieDetailModal">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="p-3">
                <p class="mb-0 text-center text-muted">Tidak ada data yang ditemukan.</p>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-between align-items-center mt-3 px-3 flex-wrap">
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
            </div> -->
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