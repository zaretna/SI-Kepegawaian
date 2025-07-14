<?php

session_start();
$activePage = 'cuti';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';

checkCuti([2]);

$id_user = $_SESSION['id'];
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : date('Y-m-t');

$query = "SELECT *
          FROM cuti 
          WHERE id_user = $id_user 
          AND DATE(tanggal_pengajuan) BETWEEN '$start_date' AND '$end_date'
          ORDER BY tanggal_pengajuan DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Cuti Karyawan</title>

    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- box icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css" />
    
  </head>

  <body>
    <section class="home-info" id="cuti">
    
      <div class="info-header">
        <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
        <h2 class="heading">Pengajuan <span>Cuti Karyawan</span></h2>
      </div>

      <div class="container">
      <!-- FORM CUTI -->
      <div class="form-cuti">
        <h3>Form Pengajuan Cuti</h3>
        <form action="../process/proses_pengajuanCuti.php" method="post">
          <div class="form-row">
            <label for="nip">NIP</label>
            <input type="text" id="nip" name="nip" value="<?=  $_SESSION['nip']; ?>" required disabled />
          </div>
          <div class="form-row">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?=  $_SESSION['name']; ?>" required disabled />
          </div>
          <div class="form-row">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required />
          </div>
          <div class="form-row">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required />
          </div>
          <div class="form-row">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="alasan" rows="3" required></textarea>
          </div>
          <div class="form-row-button">
            <button type="submit" name="submit">Ajukan Cuti</button>
          </div>
        </form>
      </div>

      <div class="tablecuti-container">
        <h3>Status Pengajuan Cuti Saya</h3>
      <!-- SEARCH DAN TABEL -->
        <form action="" method="get">
          <div class="rekap-filter">
            <input type="date" id="startDate" name="start_date" value="<?= $start_date; ?>" required>
            <input type="date" id="endDate" name="end_date" value="<?= $end_date; ?>" required>
            <button type="submit">Cari</button>
            <a href="cutiUser.php" class="btn-reset">Reset</a>
          </div>
        </form>
        <table>
          <thead>
            <tr>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Keterangan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0) { ?>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>
                  <td><?= date('d F Y', strtotime($row['tanggal_selesai'])) ?></td>
                  <td><?= $row['alasan']; ?></td>
                  <td><span class="badge status-<?= strtolower($row['status']); ?>"><?= $row['status']; ?></span></td>
                  <td>
                    <?php if ($row['status'] === 'Menunggu') { ?>
                      <form action="../process/proses_pengajuanCuti.php" method="post">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>" hidden>
                        <button type="submit" name="cancel" class="btn-cancel">Batal</button>
                      </form>
                    <?php } else {?>
                      <strong>-</strong>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="5" style="text-align: center;">Data tidak ditemukan</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    </section>
    <script src="js/script.js"></script>
  </body>
</html>
