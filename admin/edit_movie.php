<?php
require '../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $release_date = $_POST['release_date'];
    $duration = $_POST['duration'];
    $trailer_url = $_POST['trailer_url'];
    $cast = $_POST['cast'];
    $synopsis = $_POST['synopsis'];
    $director_id = $_POST['director_id'];
    // Proses upload poster jika ada
    $poster_sql = '';
    if (!empty($_FILES['poster']['name'])) {
        $poster = uniqid() . '_' . $_FILES['poster']['name'];
        move_uploaded_file($_FILES['poster']['tmp_name'], '../assets/img/' . $poster);
        $poster_sql = ", poster='$poster'";
    }

    // Update movie
    $query = "UPDATE movies SET 
                title='$title',
                release_date='$release_date',
                duration='$duration',
                trailer_url='$trailer_url',
                cast='$cast',
                synopsis='$synopsis',
                director_id='$director_id'
                $poster_sql
              WHERE id=$id";
    mysqli_query($conn, $query);

    // Update mood dan genre (hapus dulu, lalu insert lagi)
    mysqli_query($conn, "DELETE FROM movie_mood WHERE movie_id=$id");
    if (!empty($_POST['mood_ids'])) {
        foreach ($_POST['mood_ids'] as $mood_id) {
            mysqli_query($conn, "INSERT INTO movie_mood (movie_id, mood_id) VALUES ($id, $mood_id)");
        }
    }
    mysqli_query($conn, "DELETE FROM movie_genre WHERE movie_id=$id");
    if (!empty($_POST['genre_ids'])) {
        foreach ($_POST['genre_ids'] as $genre_id) {
            mysqli_query($conn, "INSERT INTO movie_genre (movie_id, genre_id) VALUES ($id, $genre_id)");
        }
    }

    header('Location: index.php?page=movies');
    exit;
}
