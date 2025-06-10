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
function showMovieDetail(id) {
  // lakukan AJAX untuk ambil data movie
  console.log("Lihat detail film ID:", id);
}

// Event listener untuk modal
document
  .getElementById("movieDetailModal")
  .addEventListener("shown.bs.modal", function () {
    console.log("Modal is fully shown");
  });

document
  .getElementById("movieDetailModal")
  .addEventListener("hidden.bs.modal", function () {
    console.log("Modal is hidden");
  });

// Konfirmasi sebelum menyimpan
document.getElementById("movieForm").addEventListener("submit", function (e) {
  if (!confirm("Simpan perubahan pada film ini?")) {
    e.preventDefault();
  }
});

// Konfirmasi sebelum membatalkan
document.getElementById("cancelBtn").addEventListener("click", function () {
  if (confirm("Yakin batal dan keluar tanpa menyimpan?")) {
    bootstrap.Modal.getInstance(
      document.getElementById("movieDetailModal")
    ).hide();
  }
});
