<?php

session_start();
include '../includes/connection.php';

function insertLeave($id_user, $tanggal_pengajuan, $tanggal_mulai, $tanggal_selesai, $alasan, $status) {
    global $conn;

    $query = "INSERT INTO cuti (id_user, tanggal_pengajuan, tanggal_mulai, tanggal_selesai, alasan, status) 
                VALUES ($id_user, '$tanggal_pengajuan', '$tanggal_mulai', '$tanggal_selesai', '$alasan', '$status')";
    $result = mysqli_query($conn, $query);
    if($result) {
        $_SESSION['msg'] = "Pengajuan cuti berhasil dikirim";
        header("Location: ../pages/cutiUser.php");
    } else {
        $_SESSION['msg'] = "Pengajuan cuti gagal dikirim";
        header("Location: ../pages/cutiUser.php");
    }
}

if(isset($_POST['submit'])) {
    date_default_timezone_set('Asia/Jakarta');
    $currentDatetime = date('Y-m-d H:i:s');

    $id_user = $_SESSION['id'];
    $tanggal_pengajuan = $currentDatetime;
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $alasan = $_POST['alasan'];
    $status = 'Menunggu';

    if (strtotime($tanggal_selesai) <= strtotime($tanggal_mulai)) {
        $_SESSION['msg'] = "Tanggal selesai harus lebih besar dari tanggal mulai";
        header("Location: ../pages/cutiUser.php");
        exit();
    }

    insertLeave($id_user, $tanggal_pengajuan, $tanggal_mulai, $tanggal_selesai, $alasan, $status);
}

function cancelLeave($id) {
    global $conn;

    $query = "UPDATE cuti SET status = 'Dibatalkan' WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if($result) {
        $_SESSION['msg'] = "Pengajuan cuti berhasil dibatalkan";
        header("Location: ../pages/cutiUser.php");
    } else {
        $_SESSION['msg'] = "Pengajuan cuti gagal dibatalkan";
        header("Location: ../pages/cutiUser.php");
    }
}

if(isset($_POST['cancel'])) {
    $id = $_POST['id'];
    cancelLeave($id);
}

function approveLeave($id) {
    global $conn;

    $query = "UPDATE cuti SET status = 'Disetujui' WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if($result) {
        $_SESSION['msg'] = "Pengajuan cuti berhasil disetujui";
        header("Location: ../pages/cuti.php");
    } else {
        $_SESSION['msg'] = "Pengajuan cuti gagal disetujui";
        header("Location: ../pages/cuti.php");
    }
}

if(isset($_POST['approve'])) {
    $id = $_POST['id'];
    approveLeave($id);
}

function rejectLeave($id) {
    global $conn;

    $query = "UPDATE cuti SET status = 'Ditolak' WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if($result) {
        $_SESSION['msg'] = "Pengajuan cuti berhasil ditolak";
        header("Location: ../pages/cuti.php");
    } else {
        $_SESSION['msg'] = "Pengajuan cuti gagal ditolak";
        header("Location:../pages/cuti.php");
    }
}

if(isset($_POST['reject'])) {
    $id = $_POST['id'];
    rejectLeave($id);
}

?>