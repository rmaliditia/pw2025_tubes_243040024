<?php
// connect ke database
$conn = mysqli_connect("localhost", "root", "", "moodflix_db");

function uploadPoster($inputName = 'poster')
{
    $namaFile = $_FILES[$inputName]['name'];
    $ukuranFile = $_FILES[$inputName]['size'];
    $error = $_FILES[$inputName]['error'];
    $tmpName = $_FILES[$inputName]['tmp_name'];

    if ($error === 4) {
        // echo "Tidak ada file diupload";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        // echo "Ekstensi tidak valid";
        return false;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $file_type = mime_content_type($tmpName);
    if (!in_array($file_type, $allowed_types)) {
        // echo "Tipe file tidak valid: $file_type";
        return false;
    }

    if ($ukuranFile > 2000000) {
        // echo "Ukuran file terlalu besar";
        return false;
    }

    $namaFileBaru = uniqid() . '_' . $namaFile;
    move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}

function deleteMovie($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM movies WHERE `movies`.`id` = $id");
    return mysqli_affected_rows($conn);
}




function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getMovieDetail($conn, $id)
{
    $id = intval($id);
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

    $res = mysqli_query($conn, "SELECT md.name FROM movie_mood mm JOIN moods md ON md.id = mm.mood_id WHERE mm.movie_id = $id");
    while ($row = mysqli_fetch_assoc($res)) $moods[] = $row['name'];

    $res = mysqli_query($conn, "SELECT g.name FROM movie_genre mg JOIN genre g ON g.id = mg.genre_id WHERE mg.movie_id = $id");
    while ($row = mysqli_fetch_assoc($res)) $genres[] = $row['name'];

    $res = mysqli_query($conn, "SELECT md.id FROM movie_mood mm JOIN moods md ON md.id = mm.mood_id WHERE mm.movie_id = $id");
    while ($row = mysqli_fetch_assoc($res)) $mood_ids[] = $row['id'];

    $res = mysqli_query($conn, "SELECT g.id FROM movie_genre mg JOIN genre g ON g.id = mg.genre_id WHERE mg.movie_id = $id");
    while ($row = mysqli_fetch_assoc($res)) $genre_ids[] = $row['id'];

    $movie['moods'] = $moods;
    $movie['genres'] = $genres;
    $movie['mood_ids'] = $mood_ids;
    $movie['genre_ids'] = $genre_ids;

    return $movie;
}

// CARA PENGGUNAAN DI HALAMAN LAIN
// $movie = getMovieDetail($conn, $id);
// lalu tampilkan data movie di halaman