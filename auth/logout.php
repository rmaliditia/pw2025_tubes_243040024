<?php
session_start();

// Hapus semua data sesi
$_SESSION = [];
session_unset();
session_destroy();

// Hapus cookie "remember me"
setcookie('id', '', time() - 86400); // expired 1 hari yang lalu
setcookie('key', '', time() - 86400);

header("Location: ../auth/login.php");
exit;
