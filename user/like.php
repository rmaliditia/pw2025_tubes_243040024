<?php
session_start();
require '../function.php';
$user_id = $_SESSION['user_id'];
$movie_id = intval($_POST['movie_id']);

// Cek apakah user sudah like film ini
$res = mysqli_query($conn, "SELECT id FROM likes WHERE user_id = $user_id AND movie_id = $movie_id");
if (mysqli_num_rows($res) === 0) {
    // Belum like, tambahkan like
    mysqli_query($conn, "INSERT INTO likes (user_id, movie_id) VALUES ($user_id, $movie_id)");
    mysqli_query($conn, "UPDATE movies SET like_count = like_count + 1 WHERE id = $movie_id");
    echo json_encode(['status' => 'liked']);
} else {
    // Sudah like, hapus like (unlike)
    mysqli_query($conn, "DELETE FROM likes WHERE user_id = $user_id AND movie_id = $movie_id");
    mysqli_query($conn, "UPDATE movies SET like_count = IF(like_count > 0, like_count - 1, 0) WHERE id = $movie_id");
    echo json_encode(['status' => 'unliked']);
}
exit;
