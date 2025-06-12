<?php
$directors = [];
$result = mysqli_query($conn, "SELECT id, name FROM director ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $directors[] = $row;
}

$moods = [];
$result = mysqli_query($conn, "SELECT id, name FROM moods ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $moods[] = $row;
}

$genres = [];
$result = mysqli_query($conn, "SELECT id, name FROM genre ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $genres[] = $row;
}
?>

<!-- MOVIES CODE -->
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold">Movie List</h4>
        <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addMovieModal">
            <i class="bi bi-plus-circle me-2"></i>
            Add Movie
        </a>
    </div>

    <!-- Table -->
    <div class="table-responsive shadow-sm border rounded bg-white">
        <?php if (count($movies) > 0) : ?>
            <table class="table table-bordered align-middle mb-0 table-movies" id="example">
                <thead class="">
                    <tr>
                        <th scope="col" style="width: 5%">No</th>
                        <th scope="col" style="width: 20%;">Title</th>
                        <th scope="col" style="width: 17%;">Mood</th>
                        <th scope="col" style="width: 12%;">Release Date</th>
                        <th scope="col" style="width: 18%;">Trailer</th>
                        <th scope="col" style="width: 8%;">Ratings</th>
                        <th scope="col" style="width: 15%;">Statistics</th>
                        <th scope="col" style="width: 5%;">Details</th>
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
                                <span class="d-print-inline d-none">|</span>
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
                <a href="delete-movie.php?id=<?= htmlspecialchars($movie['id']); ?>" role="button" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus movie ini?');">
                    <i class="bi bi-x-circle me-2"></i>Delete
                </a>
                <button class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#editMovieModal">
                    <i class="bi bi-pencil-square me-2"></i>Edit Movie
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Detail Movie Modal -->

<!-- Add Movie Modal -->
<div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px;max-height: 80vh;">
        <form action="add_movie.php" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header bg-danger text-white py-2">
                <h6 class="modal-title" id="addMovieModalLabel"><i class="bi bi-plus-circle me-2"></i>Add Movie</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label mb-1">Title</label>
                        <input type="text" name="title" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Release Date</label>
                        <input type="date" name="release_date" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Duration (min)</label>
                        <input type="number" name="duration" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="form-label mb-1">Trailer URL</label>
                        <input type="url" name="trailer_url" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Mood</label>
                        <select name="mood_ids[]" class="form-select form-select-sm" multiple required>
                            <?php foreach ($moods as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Tekan Ctrl (Cmd di Mac) untuk memilih lebih dari satu.</small>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Genre</label>
                        <select name="genre_ids[]" class="form-select form-select-sm" multiple required>
                            <?php foreach ($genres as $g): ?>
                                <option value="<?= $g['id']; ?>"><?= htmlspecialchars($g['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Tekan Ctrl (Cmd di Mac) untuk memilih lebih dari satu.</small>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Poster</label>
                        <?php if (isset($_SESSION['upload_error_add'])): ?>
                            <div class="alert alert-danger py-2 px-3 mb-2">
                                <?= $_SESSION['upload_error_add']; ?>
                            </div>
                            <?php unset($_SESSION['upload_error_add']); ?>
                        <?php endif; ?>
                        <input type="file" name="poster" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Director</label>
                        <select name="director_id" id="directorSelect" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Director --</option>
                            <?php foreach ($directors as $d): ?>
                                <option value="<?= $d['id']; ?>"><?= htmlspecialchars($d['name']); ?></option>
                            <?php endforeach; ?>
                            <option value="add_new">+ Tambah director baru...</option>
                        </select>
                        <input type="text" name="director_new" id="directorNewInput" class="form-control form-control-sm mt-2 d-none" placeholder="Nama director baru">
                    </div>
                    <div class="col-12">
                        <label class="form-label mb-1">Cast</label>
                        <input type="text" name="cast" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="form-label mb-1">Synopsis</label>
                        <textarea name="synopsis" class="form-control form-control-sm" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- Add Movie Modal -->


<!-- Edit Movie Modal -->
<div class="modal fade" id="editMovieModal" tabindex="-1" aria-labelledby="editMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px;max-height: 80vh;">
        <form action="edit_movie.php" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header bg-danger text-white py-2">
                <input type="hidden" name="id">
                <h6 class="modal-title" id="editMovieModalLabel"><i class="bi bi-pencil me-2"></i>Edit Movie</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label mb-1">Title</label>
                        <input type="text" name="title" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Release Date</label>
                        <input type="date" name="release_date" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Duration (min)</label>
                        <input type="number" name="duration" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="form-label mb-1">Trailer URL</label>
                        <input type="url" name="trailer_url" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Mood</label>
                        <select name="mood_ids[]" class="form-select form-select-sm" multiple required>
                            <?php foreach ($moods as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Tekan Ctrl (Cmd di Mac) untuk memilih lebih dari satu.</small>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Genre</label>
                        <select name="genre_ids[]" class="form-select form-select-sm" multiple required>
                            <?php foreach ($genres as $g): ?>
                                <option value="<?= $g['id']; ?>"><?= htmlspecialchars($g['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Tekan Ctrl (Cmd di Mac) untuk memilih lebih dari satu.</small>
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Poster</label>
                        <?php if (isset($_SESSION['upload_error_edit']) && isset($_SESSION['edit_movie_id'])): ?>
                            <div class="alert alert-danger py-2 px-3 mb-2">
                                <?= $_SESSION['upload_error_edit']; ?>
                            </div>
                            <?php unset($_SESSION['upload_error_edit'], $_SESSION['edit_movie_id']); ?>
                        <?php endif; ?>
                        <input type="file" name="poster" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label mb-1">Director</label>
                        <select name="director_id" id="directorSelect" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Director --</option>
                            <?php foreach ($directors as $d): ?>
                                <option value="<?= $d['id']; ?>"><?= htmlspecialchars($d['name']); ?></option>
                            <?php endforeach; ?>
                            <option value="add_new">+ Tambah director baru...</option>
                        </select>
                        <input type="text" name="director_new" id="directorNewInput" class="form-control form-control-sm mt-2 d-none" placeholder="Nama director baru">
                    </div>
                    <div class="col-12">
                        <label class="form-label mb-1">Cast</label>
                        <input type="text" name="cast" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="form-label mb-1">Synopsis</label>
                        <textarea name="synopsis" class="form-control form-control-sm" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Movie Modal -->
<!-- MOVIES CODE END -->