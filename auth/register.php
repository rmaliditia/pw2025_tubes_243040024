<?php
require '../function.php';

if (isset($_POST['register'])) {
    if (register($_POST) > 0) {
        echo "<script>
                alert('User baru berhasil ditambahkan');
            </script>";
        header("Location: ../auth/login.php");
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Moodflix</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center bg-danger justify-content-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow p-4">
                    <form action="" method="post">
                        <h3 class="text-center mb-4 align-items-center fw-semibold">Register for <img src="../assets/img/logo.png" class="logo" width="120"> </h3>

                        <div class="mb-3 d-flex flex-column">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username">
                        </div>

                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control"
                                name="password" required>
                        </div>
                        <div class="mb-2">
                            <label for="password2" class="form-label">Confirm Password</label>
                            <input type="password" id="password2" class="form-control"
                                name="password2" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-danger w-100 mb-2">Register</button>
                        <div class="form-text">
                            Already have an account? <a href="login.php">Log In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>