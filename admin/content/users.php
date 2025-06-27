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
        </div>

        <!-- Table -->
        <?php
        // echo '<pre>';
        // var_dump($users);
        // echo '</pre>';
        ?>
        <div class="table-responsive shadow-sm border rounded bg-white">
            <?php if (count($users) > 0) : ?>
                <table class="table table-bordered stack align-middle text-center mb-0 table-movies" id="example2">
                    <thead class="">
                        <tr>
                            <th scope="col" style="width: 8%;">Photo</th>
                            <th scope="col" style="width: 24%;">Name</th>
                            <th scope="col" style="width: 11%;">Created At</th>
                            <th scope="col" style="width: 10%;">Status</th>
                            <th scope="col" style="width: 11%;">Watches</th>
                            <th scope="col" style="width: 11%;">Likes</th>
                            <th scope="col" style="width: 11%;">Reviews</th>
                            <th scope="col" style="width: 14%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td>
                                    <?php if (!empty($user["photo"])): ?>
                                        <img src="../assets/img/<?php echo htmlspecialchars($user["photo"]); ?>" alt="Photo" class="img-fluid rounded-circle" style="width: 50px; height: auto;">
                                    <?php else: ?>
                                        <img src="../assets/img/nophoto.jpg" alt="No Photo" class="img-fluid" style="width: 50px; height: auto;">
                                    <?php endif; ?>
                                </td>
                                <td class="text-wrap"><?php echo htmlspecialchars($user["username"]); ?></td>
                                <td class="text-wrap"><?php echo htmlspecialchars($user["created_at"]); ?></td>
                                <td class="text-wrap">Active</td>
                                <td class="text-wrap"><?php echo htmlspecialchars($user["watches"]); ?></td>
                                <td class="text-wrap"><?php echo htmlspecialchars($user["likes"]); ?></td>
                                <td class="text-wrap">0</td>
                                <td class="text-wrap">
                                    <a href="delete_user.php?id=<?php echo htmlspecialchars($user["id"]); ?>" class="btn btn-sm btn-detail fs-5" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
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
</body>

</html>