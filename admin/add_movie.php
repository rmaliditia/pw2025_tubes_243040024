<?php
session_start();
require '../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape semua input
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $trailer_url = mysqli_real_escape_string($conn, $_POST['trailer_url']);
    $director_id = mysqli_real_escape_string($conn, $_POST['director_id']);
    $director_new = mysqli_real_escape_string($conn, trim($_POST['director_new']));
    $cast = mysqli_real_escape_string($conn, $_POST['cast']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $synopsis = mysqli_real_escape_string($conn, $_POST['synopsis']);

    // upload poster
    $poster = '';
    if (!empty($_FILES['poster']['name'])) {
        $poster = uploadPoster('poster');
        if (!$poster) {
            $_SESSION['upload_error_add'] = 'Upload poster gagal! File harus JPG/PNG dan maksimal 2MB.';
            $_SESSION['show_add_modal'] = true;
            header('Location: index.php?page=movies');
            exit;
        }
    }

    // Jika tambah director baru
    if ($director_id === 'add_new' && $director_new !== '') {
        mysqli_query($conn, "INSERT INTO director (name) VALUES ('$director_new')");
        $director_id = mysqli_insert_id($conn);
    }

    // Simpan ke database
    $query = "INSERT INTO movies (title, release_date, trailer_url, director_id, cast, duration, synopsis, poster)
              VALUES ('$title', '$release_date', '$trailer_url', '$director_id', '$cast', '$duration', '$synopsis', '$poster')";
    mysqli_query($conn, $query);

    // Setelah insert ke tabel movies
    $movie_id = mysqli_insert_id($conn);

    // Insert mood
    if (!empty($_POST['mood_ids'])) {
        foreach ($_POST['mood_ids'] as $mood_id) {
            $mood_id = intval($mood_id);
            mysqli_query($conn, "INSERT INTO movie_mood (movie_id, mood_id) VALUES ($movie_id, $mood_id)");
        }
    }

    // Insert genre
    if (!empty($_POST['genre_ids'])) {
        foreach ($_POST['genre_ids'] as $genre_id) {
            $genre_id = intval($genre_id);
            mysqli_query($conn, "INSERT INTO movie_genre (movie_id, genre_id) VALUES ($movie_id, $genre_id)");
        }
    }

    header('Location: index.php?page=movies');
    exit;
}
