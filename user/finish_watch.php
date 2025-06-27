<?php
session_start();
require '../function.php';
$watchlist_id = intval($_POST['watchlist_id']);
mysqli_query($conn, "UPDATE watchlist SET status = 'Watched' WHERE id = $watchlist_id");
header('Location: watchlist.php');
exit;