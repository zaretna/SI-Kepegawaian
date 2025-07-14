<?php

session_start();
$activePage = 'absensi';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';
include '../process/proses_absen.php';

checkAbsensi([2]);

$id_user = $_SESSION['id'];
$jamMasuk = getAbsenMasuk($id_user);
$jamKeluar = getAbsenKeluar($id_user);
$totalWorkTime = getTotalWorkTime($id_user);

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : date('Y-m-t'); 

$query = "SELECT *, 
          TIMESTAMPDIFF(MINUTE, absen_masuk, absen_keluar) / 60 AS lama_kerja 
          FROM absensi 
          WHERE id_user = $id_user 
          AND DATE(absen_masuk) BETWEEN '$start_date' AND '$end_date'
          ORDER BY absen_masuk DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Absensi Karyawan</title>

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
    <h2 class="heading">Absensi <span> Karyawan</span></h2>
  </div>

  <div class="container">
    <!-- FORM KARYAWAN -->
    <div class="card form-karyawan">
    <h3>Informasi Karyawan</h3>
    <div class="form-group">
        <label>NIP</label>
        <input type="text" value="<?= $_SESSION['nip']; ?>" readonly disabled>
    </div>
    <div class="form-group">
        <label>Nama</label>
        <input type="text" value="<?= $_SESSION['name']; ?>" readonly disabled>
    </div>
    <div class="form-group">
        <label>Divisi</label>
        <input type="text" value="<?= $_SESSION['divisi']; ?>" readonly disabled>
    </div>
    <div class="form-group">
        <label>Jabatan </label>
        <input type="text" value="<?= $_SESSION['jabatan']; ?>" readonly disabled>
    </div>
    </div>

    <!-- LIVE ATTENDANCE -->
    <div class="card absensi-box">
      <h3>Live Attendance</h3>
      <div class="time-now" id="clock">--:--</div>
      <div class="date-now" id="tanggal">--</div>

      <div class="input-time">
        <input type="text" id="clockInTime" placeholder="--:--" readonly value="<?= $jamMasuk ?? '--:--' ?>">
        <input type="text" id="clockOutTime" placeholder="--:--" readonly value="<?= $jamKeluar ?? '--:--' ?>">
      </div>

      <form action="../process/proses_absen.php" method="post">
        <div class="buttons">
          <button class="clock-in" name="clockIn">Clock In</button>
          <button class="clock-out" name="clockOut">Clock Out</button>
        </div>
      </form>
      <div class="duration" id="durationText">Lama bekerja: <?= $totalWorkTime ?? '-:-' ?> Jam</div>
    </div>
  </div>

  <!-- REKAP -->
  <div class="rekap-section card">
    <h3>Rekap Absensi</h3>
    <form action="" method="get">
      <div class="rekap-filter">
        <input type="date" id="startDate" name="start_date" value="<?= $start_date; ?>" required>
        <input type="date" id="endDate" name="end_date" value="<?= $end_date; ?>" required>
        <button type="submit">Cari</button>
        <a href="absensiUser.php" class="btn-reset">Reset</a>
      </div>
    </form>

    <table id="rekapTable">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Masuk</th>
          <th>Pulang</th>
          <th>Lama Kerja</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if(mysqli_num_rows($result) > 0) { ?>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?= date('d F Y', strtotime($row['absen_masuk'])) ?></td>
              <td><?= date('H:i', strtotime($row['absen_masuk'])) ?></td>
              <td><?= $row['absen_keluar'] ? date('H:i', strtotime($row['absen_keluar'])) : '--:--' ?></td>
              <td><?= round($row['lama_kerja'], 2); ?> Jam</td>
              <td><?= $row['status']; ?></td>
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
  </section>
  <script>
  function updateClock() {
      const now = new Date();
      const jam = String(now.getHours()).padStart(2, '0');
      const menit = String(now.getMinutes()).padStart(2, '0');
      document.getElementById('clock').textContent = jam + ":" + menit;
  }
  setInterval(updateClock, 1000);
  updateClock(); // Panggil saat pertama kali load

  function updateTanggal() {
    const now = new Date();

    // Nama hari & bulan dalam bahasa Indonesia
    const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    const hariIni = hari[now.getDay()];
    const tanggal = now.getDate();
    const namaBulan = bulan[now.getMonth()];
    const tahun = now.getFullYear();

    const formatTanggal = `${hariIni}, ${tanggal} ${namaBulan} ${tahun}`;
    document.getElementById('tanggal').textContent = formatTanggal;
  }

updateTanggal();
  </script>
</body>
</html>
