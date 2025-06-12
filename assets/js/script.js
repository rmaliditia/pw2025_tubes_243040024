// SAAT MENU DASHBOARD DI KLIK = ACTIVE
// const navLinks = document.querySelectorAll("#sidebarNav .nav-link");

// navLinks.forEach((link) => {
//   link.addEventListener("click", function () {
//     navLinks.forEach((l) => l.classList.remove("active"));
//     this.classList.add("active");
//   });
// });

// CHART JS
const ctx = document.getElementById("myChart");

new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    datasets: [
      {
        label: "# of Votes",
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});
// JS MOVIE

// Edit Movie JS
document.addEventListener("DOMContentLoaded", function () {
  // Handler tombol Edit Movie di modal detail
  document
    .querySelector(
      '#movieDetailModal .btn-danger[data-bs-target="#editMovieModal"]'
    )
    .addEventListener("click", function () {
      // Ambil ID movie dari attribute data-id pada modal detail
      const movieId = document
        .getElementById("movieDetailModal")
        .getAttribute("data-id");
      if (!movieId) return;

      // tutup modal detail sebelum buka modal edit
      var modalDetail = bootstrap.Modal.getInstance(
        document.getElementById("movieDetailModal")
      );
      if (modalDetail) modalDetail.hide();

      // AJAX ambil data lengkap movie
      fetch("movie_detail.php?id=" + movieId)
        .then((res) => res.json())
        .then((movie) => {
          const modalEdit = document.getElementById("editMovieModal");
          modalEdit.querySelector('input[name="id"]').value = movie.id || "";
          modalEdit.querySelector('input[name="title"]').value =
            movie.title || "";
          modalEdit.querySelector('input[name="release_date"]').value =
            movie.release_date || "";
          modalEdit.querySelector('input[name="duration"]').value =
            movie.duration || "";
          modalEdit.querySelector('input[name="trailer_url"]').value =
            movie.trailer_url || "";
          modalEdit.querySelector('input[name="cast"]').value =
            movie.cast || "";
          modalEdit.querySelector('textarea[name="synopsis"]').value =
            movie.synopsis || "";

          // Director (cocokkan dengan value, bukan nama)
          const directorSelect = modalEdit.querySelector(
            'select[name="director_id"]'
          );
          if (directorSelect && movie.director_id) {
            for (let opt of directorSelect.options) {
              opt.selected = opt.value == movie.director_id;
            }
          }

          // Mood (array of id)
          const moodSelect = modalEdit.querySelector(
            'select[name="mood_ids[]"]'
          );
          if (moodSelect && Array.isArray(movie.mood_ids)) {
            for (let opt of moodSelect.options) {
              opt.selected = movie.mood_ids.includes(opt.value);
            }
          }

          // Genre (array of id)
          const genreSelect = modalEdit.querySelector(
            'select[name="genre_ids[]"]'
          );
          if (genreSelect && Array.isArray(movie.genre_ids)) {
            for (let opt of genreSelect.options) {
              opt.selected = movie.genre_ids.includes(opt.value);
            }
          }
        });
    });
  // buka modal edit
  var bsEditModal = new bootstrap.Modal(modalEdit);
  bsEditModal.show();
});
// Edit Movie JS
