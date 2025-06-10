<?php
// connect ke database
$conn = mysqli_connect("localhost", "root", "", "moodflix_db");
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

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
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


function cari($keyword, $awalData = 0, $jumlahDataPerhalaman = 3)
{
    global $awalData, $jumlahDataPerhalaman;

    $query = "SELECT * FROM mahasiswa
    WHERE nama LIKE '%$keyword%'OR
    nrp LIKE '%$keyword%' OR
    email LIKE '%$keyword%' OR
    jurusan LIKE '%$keyword%' LIMIT $awalData, $jumlahDataPerhalaman";
    return query($query);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
    <script>
    alert('Pilih gambar terlebih dahulu!');
    </script>
    ";
        return false;  // return false langsung jika tidak ada file
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
            alert('Yang anda upload bukan gambar!');
            </script>
            ";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "
            <script>
            alert('Ukuran gambar terlalu besar!');
            </script>
            ";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
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
    $query = "INSERT INTO users VALUES(NULL, '$username', '$password', 'user')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
