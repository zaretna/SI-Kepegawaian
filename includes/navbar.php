<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan</title>

    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- box icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>

  <body>
    <!-- Header Design -->
    <header class="header">
      <a href="#" class="logo">Sistem Informasi Kepegawaian</a>

      <nav class="navbar">
        <a href="../pages/beranda.php" class="<?= ($activePage == 'beranda') ? 'active' : '' ?>">BERANDA</a>
        <a href="../pages/karyawan.php" class="<?= ($activePage == 'karyawan') ? 'active' : '' ?>">KARYAWAN</a>
        <a href="../pages/absensiUser.php" class="<?= ($activePage == 'absensi') ? 'active' : '' ?>">ABSENSI</a>
        <a href="../pages/cutiUser.php" class="<?= ($activePage == 'cuti') ? 'active' : '' ?>">CUTI</a>
        <a href="../process/logout_process.php" class="logout"><i class='bx bx-log-out'></i></a>
      </nav>

      <div class="bx bx-menu" id="menu-icon"></div>

    </header>
    <!-- CDN ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    
    <script src="../assets/js/script.js"></script>
  </body>
</html>