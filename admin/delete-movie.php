<?php 
require '../function.php';

$id = $_GET["id"];
if (deleteMovie($id) > 0) {
    echo "
        <script>
            alert('data berhasil dihapus!');
            document.location.href = 'index.php?page=movies';
        </script>
    ";
} else {
    echo "
        <script>
            alert('data gagal dihapus!');
            document.location.href = 'index.php?page=movies';
        </script>
    ";
}