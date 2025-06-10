<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body> -->
<div class="row mb-4 gx-0">
    <div class="col-lg-8 mb-3 mb-lg-0 pe-2">
        <div class="row mb-2">
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-3">
                        <i class="bi bi-film fs-1 text-danger mb-2"></i>
                        <p class="mb-1 title-sm text-muted">Total Movies</p>
                        <h4 class="fw-bold m-0">234</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-3">
                        <i class="bi bi-people fs-1 text-primary mb-2"></i>
                        <p class="mb-1 title-sm text-muted">Total Users</p>
                        <h4 class="fw-bold m-0">234</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-3">
                        <i class="bi bi-chat-left-dots fs-1 text-success mb-2"></i>
                        <p class="mb-1 title-sm text-muted">Total Reviews</p>
                        <h4 class="fw-bold m-0">234</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-3">
                        <i class="bi bi-exclamation-triangle fs-1 text-warning mb-2"></i>
                        <p class="mb-1 title-xs text-muted">Total Pending Reviews</p>
                        <h4 class="fw-bold m-0">234</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Movie Views Trend
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between bg-danger text-light">
                <h5 class="align-items-center mb-1 mt-2 fw-normal">Recent Activity</h5>
                <div class="dropdown-center">
                    <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Filters
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="">All</a></li>
                        <li><a class="dropdown-item" href="">Rating</a></li>
                        <li><a class="dropdown-item" href="">Reviews</a></li>
                        <li><a class="dropdown-item" href="">Like</a></li>
                        <li><a class="dropdown-item" href="">Watch</a></li>
                    </ul>
                </div>
            </div>
            <ul class="list-group list-group-flush recent-activity-list">
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-play-circle me-3 text-danger fs-5"></i>
                    <div>
                        <strong>Amanda</strong> watched <em>Inception</em><br>
                        <small class="text-muted">2 minutes ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-star-fill me-3 text-warning fs-5"></i>
                    <div>
                        <strong>Reiza</strong> rated <em>Oppenheimer</em> <strong>5 stars</strong><br>
                        <small class="text-muted">10 minutes ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-chat-dots me-3 text-info fs-5"></i>
                    <div>
                        <strong>Munawar</strong> commented on <em>Interstellar</em><br>
                        <small class="text-muted">20 minutes ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-heart-fill me-3 text-danger fs-5"></i>
                    <div>
                        <strong>Yusuf</strong> liked <em>Spider-Man: No Way Home</em><br>
                        <small class="text-muted">1 hour ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-heart-fill me-3 text-danger fs-5"></i>
                    <div>
                        <strong>Toni</strong> liked <em>Do You See What I See (2024)</em><br>
                        <small class="text-muted">2 hour ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-chat-dots me-3 text-info fs-5"></i>
                    <div>
                        <strong>Bella</strong> commented on <em>Interstellar</em><br>
                        <small class="text-muted">3 hour ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-play-circle me-3 text-danger fs-5"></i>
                    <div>
                        <strong>Nichola</strong> watched <em>Another Movie</em><br>
                        <small class="text-muted">4 hours ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-star-fill me-3 text-warning fs-5"></i>
                    <div>
                        <strong>UserA</strong> rated <em>Some Film</em> <strong>4 stars</strong><br>
                        <small class="text-muted">5 hours ago</small>
                    </div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-star-fill me-3 text-warning fs-5"></i>
                    <div>
                        <strong>UserY</strong> rated <em>Some Film</em> <strong>4 stars</strong><br>
                        <small class="text-muted">5 hours ago</small>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- <div class="row gx-0">
        <div class="align-items-center pt-3 pb-3">
            <h4 class="fw-bold table-title">Top Active Users</h4>
        </div>
        <div class=" shadow-sm border border-1">


            <table class="table table-top-users align-middle">
                <thead>
                    <tr>
                        <th class="text-muted" scope="col">Photo</th>
                        <th class="text-muted" scope="col">Name</th>
                        <th class="text-muted" scope="col" class="">Watches</th>
                        <th class="text-muted" scope="col" class="">Ratings</th>
                        <th class="text-muted" scope="col" class="">Reviews</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="../assets/img/nophoto.jpg" alt="profile" width="40" height="40" class="rounded-circle shadow-sm">
                        </td>
                        <td class="">Mark</td>
                        <td class="">10</td>
                        <td class="">5</td>
                        <td class="">3</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div> -->
<script>
    // Movie VIew Trend Start
    const ctx = document.getElementById('myChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Views',
                    data: [100, 190, 130, 150, 120, 230, 170, 180, 150, 160, 190, 210],
                    borderColor: 'rgba(220, 53, 69, 1)', // Bootstrap danger color
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.3, // Smoother lines
                    fill: true,
                    pointBackgroundColor: 'rgba(220, 53, 69, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: 'rgba(220, 53, 69, 1)',
                    pointRadius: 5,

                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)' // Lighter grid lines
                        }
                    },
                    x: {
                        grid: {
                            display: false // Hide x-axis grid lines
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom', // Legend at bottom
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 10,
                        cornerRadius: 3
                    }
                },
                interaction: { // For better hover effects
                    mode: 'index',
                    intersect: false,
                },
            }
        });
    }
    // Movie View Trend End
</script>

<!-- <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- </body>

</html> -->