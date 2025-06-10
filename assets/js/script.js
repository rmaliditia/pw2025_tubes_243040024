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
