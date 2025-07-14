<?php

function formatTanggalIndonesia($tanggal) {
    $bulanIndo = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $dateObj = new DateTime($tanggal);
    $tanggal = $dateObj->format('d');
    $bulan = $bulanIndo[(int)$dateObj->format('m') - 1];
    $tahun = $dateObj->format('Y');

    return "$tanggal $bulan $tahun";
}

?>