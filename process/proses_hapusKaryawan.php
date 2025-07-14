<?php

include '../includes/connection.php';

$id = $_GET['id'];

if (isset($id)) {
    $query = "UPDATE user SET status = 0 WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: ../pages/karyawan.php");
} else {
    echo "ID tidak ditemukan";
    header("Location: ../pages/karyawan.php");
}

?>