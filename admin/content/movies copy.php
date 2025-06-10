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
    <?php if (count($movies) > 0) : ?>
        <div class="table-responsive shadow-sm border rounded bg-white pb-3" style="overflow-x: auto;">
            <table class="table table-hover align-middle mb-0 table-movies" style="min-width: 1200px;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Title</th><div class="table-responsive shadow-sm border rounded bg-white pb-3" style="overflow-x: auto;">
    <table class="table table-hover align-middle mb-0 table-movies" style="min-width: 1200px;">
        <thead class="table-light">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Title</th>
                <th style="width: 10%;">Mood</th>
                <th style="width: 10%;">Genre</th>
                <th style="width: 10%;">Release Date</th>
                <th style="width: 10%;">Trailer</th>
                <th style="width: 10%;">Duration</th>
                <th style="width: 15%;">Synopsis</th>
                <th style="width: 5%;">Ratings</th>
                <th style="width: 5%;">Statistics</th>
                <th style="width: 10%;">Action</th>
            </tr>
        </thead>
                        <th style="width: 10%;">Mood</th>
                        <th style="width: 10%;">Genre</th>
                        <th style="width: 10%;">Release Date</th>
                        <th style="width: 10%;">Trailer</th>
                        <th style="width: 10%;">Duration</th>
                        <th style="width: 15%;">Synopsis</th>
                        <th style="width: 5%;">Ratings</th>
                        <th style="width: 5%;">Statistics</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($movies as $movie) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td class="text-wrap"><?= $movie["title"]; ?></td>
                            <td class="text-wrap"><?= implode(', ', $movie['moods']) ?></td>
                            <td class="text-wrap"><?= implode(', ', $movie['genre']) ?></td>
                            <td class="text-wrap"><?= $movie["release_date"]; ?></td>
                            <td class="text-wrap"><small><?= $movie["trailer_url"]; ?></small></td>
                            <td class="text-wrap"><small><?= $movie["duration"]; ?> minutes</small></td>
                            <td class="text-wrap"><small><?= $movie["synopsis"]; ?></small></td>
                            <td><span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> <?= $movie["rating"]; ?></span></td>
                            <td>
                                <span class="badge bg-info"><i class="bi bi-eye-fill"></i> <?= $movie["watch_count"]; ?></span>
                                <span class="badge bg-danger"><i class="bi bi-heart-fill"></i> <?= $movie["like_count"]; ?></span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#" role="button">Edit</a>
                                <a class="btn btn-sm btn-primary" href="#" role="button">Delete</a>

                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="p-3">Tidak ada data yang ditemukan.</p>
        <?php endif; ?>
        </div>

</div>

<!-- <?php
        $result = mysqli_query($conn, "
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

WHERE id = $id");
        $movie = mysqli_fetch_assoc($result);

        echo "
<pre>";
        print_r($movie);
        echo "</pre>";
        ?> -->
<!-- Movie Detail Modal -->
<!-- <div class="modal fade" id="movieDetailModal" tabindex="-1" aria-labelledby="movieDetailModalLabel" aria-hidden="true">
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
</div> -->

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