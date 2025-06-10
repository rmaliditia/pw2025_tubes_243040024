<!-- <?php var_dump($movies); ?> -->
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
                        <th scope="col" style="width: 30%;">Title</th>
                        <th scope="col" style="width: 30%;">Mood</th>
                        <th scope="col" style="width: 30%;">Release Date</th>
                        <th scope="col" style="width: 30%;">Trailer</th>
                        <th scope="col" style="width: 15%;">Ratings</th>
                        <th scope="col" style="width: 15%;">Watches</th>
                        <th scope="col" style="width: 15%;">Like</th>
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
                            </td>
                            <td>
                                <span class="badge bg-danger">
                                    <i class="bi bi-heart-fill"></i> <?php echo $movie["like_count"]; ?>
                                </span>
                            </td>
                            <td class="custom-button">
                                <a href=""
                                    class="btn"
                                    data-id:="<?php echo $movie["id"]; ?>"
                                    onclick="showMovieDetail(this)"
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

<!-- <?php
        $result = mysqli_query($conn, "
            SELECT * FROM movies WHERE id = 1");
        $movie = mysqli_fetch_assoc($result);

        echo "
<pre>";
        print_r($movie);
        echo "</pre>";
        ?> -->

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
                        <h3 class="fw-bold text-danger mb-3" id="modalTitle"><?php echo $movie["title"]; ?> </h3>
                        <div class=" row mb-2">
                            <div class="col-4 ps-0"><strong>Director:</strong></div>
                            <div class="col-8"><?php echo $movie["director"]; ?></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 ps-0"><strong>Trailer:</strong></div>
                            <div class="col-8">
                                <a href="https://youtu.be/8hP9D6kZseM?si=TVsT4n0ztdO_gkYh">
                                    <p class="mb-0"><?php echo $movie["trailer_url"]; ?></p>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 ps-0"><strong>Duration:</strong></div>
                            <div class="col-8"><?php echo $movie["duration"]; ?> minutes</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 ps-0"><strong>Mood:</strong></div>
                            <div class="col-8">
                                <span class="badge bg-danger me-1">Happy</span>
                                <span class="badge bg-danger me-1">Thoughtful</span>
                                <span class="badge bg-danger">Scared</span>
                            </div>
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
                            <div class="col-4 ps-0"><strong>Release Date:</strong></div>
                            <div class="col-8"><?php echo $movie["release-date"]; ?></div>
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
</div>

<script>
    // JS MOVIE
    function showMovieDetail(element) {
        const movieId = element.getAttribute("data-id");

        // Lakukan request ke PHP pakai AJAX
        fetch(`get_movie.php?id=${movieId}`)
            .then(response => response.json())
            .then(data => {
                // Masukkan data ke dalam modal
                document.getElementById("modalTitle").innerText = data.title;
                document.getElementById("modalOverview").innerText = data.overview;
                // Tambah lainnya sesuai isi modal kamu
            })
            .catch(error => {
                console.error("Gagal memuat data film:", error);
            });
    }


    // Event listener untuk modal
    document
        .getElementById("movieDetailModal")
        .addEventListener("shown.bs.modal", function() {
            console.log("Modal is fully shown");
        });

    document
        .getElementById("movieDetailModal")
        .addEventListener("hidden.bs.modal", function() {
            console.log("Modal is hidden");
        });

    // Konfirmasi sebelum menyimpan
    document.getElementById("movieForm").addEventListener("submit", function(e) {
        if (!confirm("Simpan perubahan pada film ini?")) {
            e.preventDefault();
        }
    });

    // Konfirmasi sebelum membatalkan
    document.getElementById("cancelBtn").addEventListener("click", function() {
        if (confirm("Yakin batal dan keluar tanpa menyimpan?")) {
            bootstrap.Modal.getInstance(
                document.getElementById("movieDetailModal")
            ).hide();
        }
    });
</script>