<?php
session_start();
include '../includes/connection.php';

function insertClockIn($id_user) {
    global $conn;

    date_default_timezone_set('Asia/Jakarta');

    $currentDateTime = date('Y-m-d H:i:s');
    $currentTime = date('H:i:s');

    $status = ($currentTime > '09:00') ? 'Terlambat' : 'Tepat Waktu';

    $query = "INSERT INTO absensi (id_user, absen_masuk, absen_keluar, status) 
                VALUES ($id_user, '$currentDateTime', NULL, '$status')";

    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: ../pages/absensiUser.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

function checkClockIn($id_user) {
    global $conn;

    $currentDate = date('Y-m-d');

    $query = "SELECT * 
                FROM absensi 
                WHERE id_user = $id_user AND DATE(absen_masuk) = '$currentDate' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function insertClockOut($id_user) {
    global $conn;

    date_default_timezone_set('Asia/Jakarta');
    
    $currentDateTime = date('Y-m-d H:i:s');
    $currentDate = date('Y-m-d');

    $query = "UPDATE absensi 
                SET absen_keluar = '$currentDateTime' 
                WHERE id_user = $id_user AND DATE(absen_masuk) = '$currentDate'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: ../pages/absensiUser.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

function checkClockOut($id_user) {
    global $conn;

    date_default_timezone_set('Asia/Jakarta');

    $currentDate = date('Y-m-d');

    $query = "SELECT * 
                FROM absensi 
                WHERE id_user = $id_user 
                AND DATE(absen_masuk) = '$currentDate' 
                LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if($row['absen_keluar'] == null) {
            return false;
        }
        return true;
    }
}

function getTotalWorkTime($id_user) {

    $getClockIn = getAbsenMasuk($id_user);
    $getClockOut = getAbsenKeluar($id_user);

    if($getClockOut == null || $getClockIn == "") {
        return;
    }

    $absenMasuk = strtotime($getClockIn);
    $absenKeluar = strtotime($getClockOut);
    $totalWorkTime = $absenKeluar - $absenMasuk;
    $jam = $totalWorkTime / 3600;
    var_dump($jam);
    $res = round($jam, 2);
    return $res ? $res : null;
}

function getAbsenMasuk($id_user) {
    global $conn;

    date_default_timezone_set('Asia/Jakarta');
    $currentDate = date('Y-m-d');
    
    $query = "SELECT DATE_FORMAT(absen_masuk, '%H:%i') as jam_masuk FROM absensi WHERE id_user = $id_user AND DATE(absen_masuk) = '$currentDate' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row['jam_masuk'] : null;
}

function getAbsenKeluar($id_user) {
    global $conn;

    date_default_timezone_set('Asia/Jakarta');
    $currentDate = date('Y-m-d');

    $query = "SELECT DATE_FORMAT(absen_keluar, '%H:%i') as jam_keluar FROM absensi WHERE id_user = $id_user AND DATE(absen_keluar) = '$currentDate' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row['jam_keluar'] : null;
}

function getListAbsenByUserId($id) {
    global $conn;

    $query = "SELECT a.absen_masuk, a.absen_keluar, a.status, a.lama_bekerja, u.nama
                FROM absensi a
                JOIN  user u ON a.id_user = u.id
                WHERE a.id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

if(isset($_POST['clockIn'])) {
    $id_user = $_SESSION['id'];
    if(checkClockIn($id_user)) {
        $_SESSION['msg'] = "Anda sudah melakukan absen masuk";
        header("Location: ../pages/absensiUser.php");
        return;
    }
    insertClockIn($id_user);
} 

if (isset($_POST['clockOut'])) {
    $id_user = $_SESSION['id'];
    if(checkClockOut($id_user)) {
        $_SESSION['msg'] = "Anda sudah melakukan absen keluar";
        header("Location: ../pages/absensiUser.php");
        return;
    }
    insertClockOut($id_user);
}


?>