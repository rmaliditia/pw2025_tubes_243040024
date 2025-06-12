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


function tambah($data)
{
    global $conn;
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $gambar = htmlspecialchars($data["gambar"]);

    $query = "INSERT INTO mahasiswa (nama, nrp, email, jurusan, gambar)
          VALUES ('$nama', '$nrp', '$email', '$jurusan', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}




function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // Cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama; // Gunakan gambar lama jika tidak ada upload baru
    } else {
        // Jika ada gambar baru diupload
        $gambar = upload();

        // Jika upload gagal, kembalikan false
        if (!$gambar) {
            return false;
        }

        // Hapus file gambar lama jika berhasil upload gambar baru
        // dan gambarLama bukan gambar default
        if ($gambarLama != 'default.jpg' && file_exists('img/' . $gambarLama)) {
            unlink('img/' . $gambarLama);
        }
    }

    // $gambar = htmlspecialchars($data["gambar"]);

    $query = "UPDATE mahasiswa SET
            nama = '$nama',
            nrp = '$nrp',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar' WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}




function register($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users
    WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('Username sudah terdaftar!');
        </script>
        ";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "
        <script>
        alert('Konfirmasi password tidak sesuai!');
        </script>
        ";
        return false;
    }

    // enskripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    $query = "INSERT INTO users VALUES(NULL, '$username', '$password', 'user', '1000-10-10', NULL, NULL)";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
