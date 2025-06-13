<?php
session_start();
require '../function.php';
$user_id = $_SESSION['user_id'];
$movie_id = intval($_GET['id']);
mysqli_query($conn, "INSERT IGNORE INTO watchlist (user_id, movie_id) VALUES ($user_id, $movie_id)");
header('Location: watchlist.php');
exit;
