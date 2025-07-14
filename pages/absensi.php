<?php
session_start();
$activePage = 'absensi';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : date('Y-m-t');

$query = "SELECT u.nip, u.nama, a.absen_masuk, a.absen_keluar, a.status, TIMESTAMPDIFF(MINUTE, absen_masuk, absen_keluar) / 60 AS lama_kerja 
            FROM absensi a
            JOIN user u ON a.id_user = u.id
            WHERE (u.nip LIKE '%$search%' OR u.nama LIKE '%$search%' OR a.status LIKE '%$search%')
            AND DATE(absen_masuk) BETWEEN '$start_date' AND '$end_date'
            ORDER BY absen_masuk DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Absensi Karyawan</title>

    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- box icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <section class="home-info" id="absensi">
    <div class="info-header">
        <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
        <h2 class="heading">Data <span> Absensi Karyawan</span></h2>
    </div>
    
    <div class="kontrol">
        <form action="" method="get">
            <div class="rekap-filter">
                <input type="date" id="startDate" name="start_date" value="<?= $start_date; ?>" required>
                <input type="date" id="endDate" name="end_date" value="<?= $end_date; ?>" required>
                <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Searchbar" class="searchbar" />
                <input type="submit" value="Cari" hidden>
                <button type="submit">Cari</button>
                <a href="absensi.php" class="btn-reset">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-container">
        <!-- Data Absensi akan tampil di sini -->
        <table>
            <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="row-<?=strtolower($row['status']);?>">
                            <td><?= $row['nip']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= date('d F Y', strtotime($row['absen_masuk'])); ?></td>
                            <td><?= date('H:i', strtotime($row['absen_masuk'])); ?></td>
                            <td><?= date('H:i', strtotime($row['absen_keluar'])); ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                    <td colspan="6">Tidak ada data</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    </section>
</body>
</html><?php
session_start();
include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : date('Y-m-t');

$query = "SELECT u.nip, u.nama, a.absen_masuk, a.absen_keluar, a.status, TIMESTAMPDIFF(MINUTE, absen_masuk, absen_keluar) / 60 AS lama_kerja 
            FROM absensi a
            JOIN user u ON a.id_user = u.id
            WHERE (u.nip LIKE '%$search%' OR u.nama LIKE '%$search%' OR a.status LIKE '%$search%')
            AND DATE(absen_masuk) BETWEEN '$start_date' AND '$end_date'
            ORDER BY absen_masuk DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Absensi Karyawan</title>

    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- box icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <section class="home-info" id="info">
    <div class="info-header">
    <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
    <h2 class="heading">Data <span> Absensi Karyawan</span></h2>
    </div>
    
    <div class="kontrol">
        <form action="" method="get">
            <div class="rekap-filter">
                <input type="date" id="startDate" name="start_date" value="<?= $start_date; ?>" required>
                <input type="date" id="endDate" name="end_date" value="<?= $end_date; ?>" required>
                <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Searchbar" class="searchbar" />
                <input type="submit" value="Cari" hidden>
                <button type="submit">Cari</button>
                <a href="absensi.php" class="btn-reset">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-container">
        <!-- Data Absensi akan tampil di sini -->
        <table>
            <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="row-<?=strtolower($row['status']);?>">
                            <td><?= $row['nip']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= date('d F Y', strtotime($row['absen_masuk'])); ?></td>
                            <td><?= date('H:i', strtotime($row['absen_masuk'])); ?></td>
                            <td><?= date('H:i', strtotime($row['absen_keluar'])); ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                    <td colspan="6">Tidak ada data</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    </section>
</body>
</html>