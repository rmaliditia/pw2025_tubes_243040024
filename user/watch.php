<?php
session_start();
require '../function.php';
$movie_id = intval($_POST['movie_id']);
$user_id = $_SESSION['user_id'];

// Update status di watchlist
mysqli_query($conn, "UPDATE watchlist SET status = 'Watching' WHERE user_id = $user_id AND movie_id = $movie_id");

// Tambah watch_count di movies
mysqli_query($conn, "UPDATE movies SET watch_count = watch_count + 1 WHERE id = $movie_id");

header('Location: watchlist.php');
exit;
