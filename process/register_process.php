<?php

include '../includes/connection.php';

if(isset($_POST['register'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $id_jabatan = $_POST['id_jabatan'];
    $id_divisi = $_POST['id_divisi'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO user (username, password, id_role, nip, nama, id_jabatan, tgl_lahir, jenis_kelamin, alamat, no_hp, status, id_divisi) 
                VALUES ('$username', '$password', 2, '$nip', '$nama', '$id_jabatan', '$tgl_lahir', '$jenis_kelamin', '$alamat', '$no_hp', 1, '$id_divisi')";
    mysqli_query($conn, $query);

    header("Location: ../index.php");
} else {
    header("Location: register.php");
}




?>