<?php
require '../../function.php';

$id = intval($_GET["id"]);
if (deleteUser($id) > 0) {
    echo "
        <script>
            alert('User berhasil dihapus!');
            document.location.href = 'users.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('User gagal dihapus!');
            document.location.href = 'users.php';
        </script>
    ";
}
