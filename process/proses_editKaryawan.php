<?php

include '../includes/connection.php';

$id = $_POST['id'];
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tgl_lahir = $_POST['tgl_lahir'];
$id_jabatan = $_POST['id_jabatan'];
$id_divisi = $_POST['id_divisi'];
$id_role = $_POST['id_role'];
$profile = $_FILES['profile']['name'];

if ($profile != "") {
    $allowed_ext = array('png','jpg', 'jpeg');
    $x = explode('.', $profile);
    $ext = strtolower(end($x));
    $file_tmp = $_FILES['profile']['tmp_name'];
    $randNum     = rand(1,999);
    $profile = $randNum.'-'.$profile;

    if(in_array($ext, $allowed_ext) === true) {
        move_uploaded_file($file_tmp, '../assets/img/'.$profile);
    } else {
        $_SESSION['msg'] = "Format file tidak di perbolehkan";
        header("Location: ../pages/form_editKaryawan.php?id=$id");
    }
} else {
    $profile = $_POST['profile_lama'];
}
var_dump('id: '.$id);

if(isset($_POST['simpan'])) {
    $query = "UPDATE user 
                SET 
                    nip = '$nip',
                    nama = '$nama',
                    alamat = '$alamat',
                    no_hp = '$no_hp',
                    jenis_kelamin = '$jenis_kelamin',
                    tgl_lahir = '$tgl_lahir',
                    id_jabatan = '$id_jabatan',
                    id_divisi = '$id_divisi',
                    id_role = '$id_role',
                    profile = '$profile'
                WHERE id = $id";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $_SESSION['msg'] = "Data berhasil diubah";
    } else {
        $_SESSION['msg'] = "Data gagal diubah";
    }
    
    header("Location: ../pages/form_editKaryawan.php?id=$id");
}

?>