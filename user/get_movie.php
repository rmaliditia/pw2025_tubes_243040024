<?php
require '../function.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = mysqli_query($conn, "SELECT * FROM movies WHERE id = $id");

if ($result && mysqli_num_rows($result) > 0) {
    $movie = mysqli_fetch_assoc($result);
    echo json_encode($movie);
} else {
    echo json_encode(['error' => 'Movie not found']);
}
