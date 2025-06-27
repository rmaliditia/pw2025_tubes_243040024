<?php
session_start();
require '../function.php';

$user_id = $_SESSION['user_id'];
$movie_id = intval($_POST['movie_id']);

// Cek apakah sudah ada di watchlist
$res = mysqli_query($conn, "SELECT id FROM watchlist WHERE user_id = $user_id AND movie_id = $movie_id");
if (mysqli_num_rows($res) > 0) {
    // Remove
    mysqli_query($conn, "DELETE FROM watchlist WHERE user_id = $user_id AND movie_id = $movie_id");
    echo json_encode(['status' => 'removed']);
} else {
    // Add
    mysqli_query($conn, "INSERT INTO watchlist (user_id, movie_id, status, added_at) VALUES ($user_id, $movie_id, 'Not Watched', NOW())");
    echo json_encode(['status' => 'added']);
}
exit;
