<?php
require '../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $release_date = $_POST['release_date'];
    $trailer_url = $_POST['trailer_url'];
    $director_id = $_POST['director_id'];
    $director_new = trim($_POST['director_new']);
    $cast = $_POST['cast'];
    $duration = $_POST['duration'];
    $synopsis = $_POST['synopsis'];
    // Proses upload poster jika ada
    $poster = '';
    if (!empty($_FILES['poster']['name'])) {
        $poster = uniqid() . '_' . $_FILES['poster']['name'];
        move_uploaded_file($_FILES['poster']['tmp_name'], '../assets/img/' . $poster);
    }

    // Jika tambah director baru
    if ($director_id === 'add_new' && $director_new !== '') {
        mysqli_query($conn, "INSERT INTO director (name) VALUES ('" . mysqli_real_escape_string($conn, $director_new) . "')");
        $director_id = mysqli_insert_id($conn);
    }

    // Simpan ke database (contoh query, sesuaikan dengan struktur tabel kamu)
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
