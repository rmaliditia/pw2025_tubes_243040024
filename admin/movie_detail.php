<?php
require '../function.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$movie = getMovieDetail($conn, $id);

header('Content-Type: application/json');
echo json_encode($movie);
if (!$movie) {
    http_response_code(404);
    echo json_encode(['error' => 'Movie not found']);
    exit;
}
