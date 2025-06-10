<?php
require '../function.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "
SELECT 
    m.poster,
    m.id,
    m.title,
    m.trailer_url,
    m.release_date,
    m.synopsis,
    m.duration,
    m.rating,
    m.watch_count,
    m.like_count,
    d.name AS director
FROM movies m
LEFT JOIN director d ON m.director_id = d.id
WHERE m.id = $id
LIMIT 1
";
$result = mysqli_query($conn, $query);
$movie = mysqli_fetch_assoc($result);

$movie['poster'] = $movie['poster'] ? '../assets/img/' . $movie['poster'] : '../assets/img/nophoto.jpg';
// Ambil moods, genre, casts
$moods = [];
$genres = [];
$casts = [];

$res = mysqli_query($conn, "SELECT md.name FROM movie_mood mm JOIN moods md ON md.id = mm.mood_id WHERE mm.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $moods[] = $row['name'];

$res = mysqli_query($conn, "SELECT g.name FROM movie_genre mg JOIN genre g ON g.id = mg.genre_id WHERE mg.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $genres[] = $row['name'];

$res = mysqli_query($conn, "SELECT a.name FROM casts mc JOIN actors a ON a.id = mc.actor_id WHERE mc.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $casts[] = $row['name'];

$movie['moods'] = $moods;
$movie['genres'] = $genres;
$movie['casts'] = $casts;

header('Content-Type: application/json');
echo json_encode($movie);
