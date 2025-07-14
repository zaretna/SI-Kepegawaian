<?php
// Pastikan auth sudah dipanggil sebelum ini
if (!isset($_SESSION['role'])) {
    header("Location: ../index.php?page=login");
    exit;
}

// Fungsi untuk membatasi role
function checkCuti($allowed_roles = []) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: ../pages/cuti.php");
    } else {
        
    }
}

function checkAbsensi($allowed_roles = []) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: ../pages/absensi.php");
    } else {

    }
}