<?php
session_start();
require '../function.php';
$movie_id = intval($_POST['movie_id']);
mysqli_query($conn, "UPDATE movies SET watch_count = watch_count + 1 WHERE id = $movie_id");
header('Location: watchlist.php');
exit;
