<?php
session_start();
$activePage = 'beranda';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';
include '../process/get_home.php';

$resultKaryawan = getTotalKaryawan();
$resultDivisi = getTotalDivisi();
$resultBirthday = getListBirthday();
$resultCuti = getListCuti();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda</title>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

  <!-- Box Icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

  <link rel="stylesheet" href="../assets/css/style1.css" />

</head>

<body>
  <section class="home" id="beranda">
    <div class="info-header">
      <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
      <h2 class="heading">Halaman <span> Utama</span></h2>
    </div>
    
    <div class="grid">
      <!-- Box 1 -->
      <div class="box box1">
        <div class="card">
          <div class="card-header">
            <span>Total Karyawan</span>
          </div>
          <div class="card-value"><?= $resultKaryawan ?> orang</div>
        </div>
        <div class="card">
          <div class="card-header">
            <span>Total Divisi</span>
          </div>
          <div class="card-value"><?= $resultDivisi ?> divisi</div>
        </div>
      </div>

      <!-- Box 2 -->
      <div class="box box2">
        <h2>Yang Berulang Tahun di Bulan Ini</h2>
        <div class="scrollable-table">
          <table>
            <?php if (mysqli_num_rows($resultBirthday) > 0) { ?>
              <?php while ($row = mysqli_fetch_assoc($resultBirthday)) { ?>
                <tr>
                  <td><?= $row['nama'] ?><br><?= date('d F', strtotime($row['tgl_lahir'])); ?></td>
                  <td><?= $row['nama_divisi'] ?></td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="2">Tidak ada yang berulang tahun di bulan ini.</td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </div>

      <!-- Box 3 -->
      <div class="box box3">
        <h2>Perbandingan Jenis Kelamin</h2>
        <canvas id="barchart"></canvas>
      </div>

      <!-- Box 4 -->
      <div class="box box4" style="grid-column: span 2;">
        <h2>Data Cuti Karyawan</h2>
        <div class="scrollable-table">
          <table>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
              </tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($resultCuti) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($resultCuti)) { ?>
                  <tr>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['nama_divisi'] ?></td>
                    <td><?= date('d F Y', strtotime($row['tanggal_mulai'])) ?></td>
                    <td><?= date('d F Y', strtotime($row['tanggal_selesai'])) ?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="4">Tidak ada data cuti</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Box 5 -->
      <div class="box box5">
        <h2>Data Absensi Karyawan</h2>
        <canvas id="doughnut"></canvas>
      </div>
    </div>
  </section>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../assets/js/chart1.js"></script>
  <script src="../assets/js/chart2.js"></script>
</body>
</html>
