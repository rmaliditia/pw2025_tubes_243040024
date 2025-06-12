<?php
session_start();
require '../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    // Escape semua input!
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $trailer_url = mysqli_real_escape_string($conn, $_POST['trailer_url']);
    $cast = mysqli_real_escape_string($conn, $_POST['cast']);
    $synopsis = mysqli_real_escape_string($conn, $_POST['synopsis']);
    $director_id = mysqli_real_escape_string($conn, $_POST['director_id']);

    // Proses upload poster
    $poster_sql = '';
    if (!empty($_FILES['poster']['name'])) {
        $poster = uploadPoster('poster');
        if (!$poster) {
            $_SESSION['upload_error_edit'] = 'Upload poster gagal! File harus JPG/PNG dan maksimal 2MB.';
            $_SESSION['edit_movie_id'] = $_POST['id'];
            header('Location: index.php?page=movies');
            exit;
        }
        $poster = mysqli_real_escape_string($conn, $poster);
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
            $mood_id = intval($mood_id);
            mysqli_query($conn, "INSERT INTO movie_mood (movie_id, mood_id) VALUES ($id, $mood_id)");
        }
    }
    mysqli_query($conn, "DELETE FROM movie_genre WHERE movie_id=$id");
    if (!empty($_POST['genre_ids'])) {
        foreach ($_POST['genre_ids'] as $genre_id) {
            $genre_id = intval($genre_id);
            mysqli_query($conn, "INSERT INTO movie_genre (movie_id, genre_id) VALUES ($id, $genre_id)");
        }
    }

    header('Location: index.php?page=movies');
    exit;
}