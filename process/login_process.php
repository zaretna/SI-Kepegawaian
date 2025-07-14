<?php
session_start();

include '../includes/connection.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT u.id, u.username, u.id_role, u.nama, u.nip, j.nama_jabatan, d.nama_divisi  
            FROM user u
            JOIN divisi d ON u.id_divisi = d.id
            JOIN jabatan j ON u.id_jabatan = j.id
            WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_affected_rows($conn);

    if ($count == 1){
        $data_login = mysqli_fetch_assoc($res);

        $_SESSION['id'] = $data_login['id'];
        $_SESSION['name'] = $data_login['nama'];
        $_SESSION['nip'] = $data_login['nip'];
        $_SESSION['jabatan'] = $data_login['nama_jabatan'];
        $_SESSION['divisi'] = $data_login['nama_divisi'];
        $_SESSION['username'] = $data_login['username'];
        $_SESSION['role'] = $data_login['id_role'];

        header("Location: ../pages/beranda.php");
        exit;
    } else {
        $_SESSION['error'] = "Username atau password salah";
        header("Location: ../index.php");
        exit;
    }
    
}
?>