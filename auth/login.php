<!-- <?php
        session_start();

        require '../function.php';

        // Cek session setelah login berhasil
        if (isset($_SESSION["login"])) {
            if ($_SESSION["role"] === 'admin') {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../user/home.php");
            }
            exit;
        }

        $error = false;

        if (isset($_POST['login'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $username = htmlspecialchars($username); // Cegah XSS

            $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['login'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['user_id'] = $row['id'];
                    // Redirect sesuai role
                    if ($row["role"] === 'admin') {
                        header("Location: ../admin/index.php");
                    } else {
                        header("Location: ../user/home.php");
                    }
                    exit;
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        }
        ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Moodflix</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center bg-danger justify-content-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow p-4">
                    <form action="" method="post">
                        <h3 class="text-center mb-4 align-items-center fw-semibold">Login to <img src="../assets/img/logo.png" class="logo" width="120"> </h3>
                        <?php
                        if ($error) : ?>
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    Username / Password yang anda masukkan salah
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3 d-flex flex-column">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control"
                                name="password">
                        </div>
                        <button type="submit" name="login" class="btn btn-danger w-100 mb-2">Login</button>
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-muted" for="remember">
                                    <small>Remember Me</small>
                                </label>
                            </div>
                            <div class="form-text">
                                Don't have an account? <a href="register.php">Register</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> -->