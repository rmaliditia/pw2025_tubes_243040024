<?php
require '../function.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "
SELECT 
    m.poster,
    m.id,
    m.title,
    m.director_id,
    m.trailer_url,
    m.release_date,
    m.synopsis,
    m.cast,
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
$mood_ids = [];
$genre_ids = [];

// Ambil moods
$res = mysqli_query($conn, "SELECT md.name FROM movie_mood mm JOIN moods md ON md.id = mm.mood_id WHERE mm.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $moods[] = $row['name'];

// Ambil genre
$res = mysqli_query($conn, "SELECT g.name FROM movie_genre mg JOIN genre g ON g.id = mg.genre_id WHERE mg.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $genres[] = $row['name'];

// Ambil moods id
$res = mysqli_query($conn, "SELECT md.id FROM movie_mood mm JOIN moods md ON md.id = mm.mood_id WHERE mm.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $mood_ids[] = $row['id'];

// Ambil genre id
$res = mysqli_query($conn, "SELECT g.id FROM movie_genre mg JOIN genre g ON g.id = mg.genre_id WHERE mg.movie_id = $id");
while ($row = mysqli_fetch_assoc($res)) $genre_ids[] = $row['id'];

$movie['moods'] = $moods;
$movie['genres'] = $genres;
$movie['mood_ids'] = $mood_ids;
$movie['genre_ids'] = $genre_ids;


header('Content-Type: application/json');
echo json_encode($movie);
