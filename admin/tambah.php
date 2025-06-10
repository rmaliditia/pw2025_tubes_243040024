<?php
require 'function.php';
//cek apakah tombol submit sudah ditekan atau belum

if (isset($_POST["submit"])) {

    // ambil data dari tiap elemen dalam form
    // $nrp = $_POST["nrp"];
    // $nama = $_POST["nama"];
    // $email = $_POST["email"];
    // $jurusan = $_POST["jurusan"];
    // $gambar = $_POST["gambar"];

    // query insert data
    // $query = "INSERT INTO mahasiswa (nama, nrp, email, jurusan, gambar)
    //       VALUES ('$nama', '$nrp', '$email', '$jurusan', '$gambar')";
    // mysqli_query($conn, $query);

    // apakah berhasil ditambahkan atau tidak

    if (tambah($_POST) > 0) {
        echo "
        <script>
        alert('Data Berhasil Ditambahkan');
        document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data Gagal Ditambahkan');
        document.location.href = 'index.php';
        </script>
        ";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
</head>

<body>

    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul style="list-style: none;">
            <li style="margin-bottom: 10px;" ;>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required>
            </li>
            <li style="margin-bottom: 10px;">
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li style="margin-bottom: 10px;">
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required>
            </li>
            <li style="margin-bottom: 10px;">
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li style="margin-bottom: 10px;">
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data!</button>
            </li>
        </ul>
    </form>

</body>

</html>