<?php
session_start();
$activePage = 'karyawan';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$resSearch = "SELECT u.id, u.nip, u.nama, u.tgl_lahir, j.nama_jabatan, d.nama_divisi, u.no_hp, u.alamat, r.role
            FROM user u 
            JOIN jabatan j ON u.id_jabatan = j.id 
            JOIN divisi d ON u.id_divisi = d.id
            JOIN role r ON u.id_role = r.id
            WHERE status = 1 AND (u.nip LIKE '%$search%' OR u.nama LIKE '%$search%') ORDER BY u.nama ASC";

$result = mysqli_query($conn, $resSearch);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan</title>

    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- box icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>

  <body>
    <section class="home-info" id="karyawan">
      <div class="info-header">
      <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
      <h2 class="heading">Data <span>Karyawan</span></h2>
      </div>
      <div class="kontrol">
        <form action="" method="get">
          <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Searchbar" class="searchbar" />
          <input type="submit" value="Cari" hidden>
        </form>
      </div>

      <div class="table-container">
        <!-- Data Absensi akan tampil di sini -->
        <table>
          <thead>
            <tr>
              <th>Nomor Induk Pegawai</th>
              <th>Nama Lengkap</th>
              <th>Tanggal Lahir</th>
              <th>Divisi</th>
              <th>Jabatan</th>
              <th>No. Handphone</th>
              <th>Alamat Tempat Tinggal</th>
              <th>Role</th>
              <?php if ($_SESSION['role'] == 1) { ?>
                <th>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0) { ?>
              <?php while ($kry = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><?= $kry['nip'] ?></td>
                <td><?= $kry['nama'] ?></td>
                <td><?= formatTanggalIndonesia($kry['tgl_lahir']) ?></td>
                <td><?= $kry['nama_divisi'] ?></td>
                <td><?= $kry['nama_jabatan'] ?></td>
                <td><?= $kry['no_hp'] ?></td>
                <td><?= $kry['alamat'] ?></td>
                <td><?= $kry['role'] ?></td>
                <?php if ($_SESSION['role'] == 1) { ?>
                  <td>
                      <a href="form_editKaryawan.php?id=<?= $kry['id'] ?>" title="Edit">
                        <i class="fas fa-edit icon-edit"></i>
                      </a>
                      &nbsp;&nbsp;
                      <a href="../process/proses_hapusKaryawan.php?id=<?= $kry['id'] ?>" title="Hapus" onclick="return confirm('Yakin ingin hapus?')">
                        <i class="fas fa-trash-alt icon-delete"></i>
                      </a>
                  </td>
                <?php } ?>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td colspan="8" style="text-align: center;">Data tidak ditemukan</td>
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
$resSearch = "SELECT u.id, u.nip, u.nama, u.tgl_lahir, j.nama_jabatan, d.nama_divisi, u.no_hp, u.alamat, r.role
            FROM user u 
            JOIN jabatan j ON u.id_jabatan = j.id 
            JOIN divisi d ON u.id_divisi = d.id
            JOIN role r ON u.id_role = r.id
            WHERE status = 1 AND (u.nip LIKE '%$search%' OR u.nama LIKE '%$search%') ORDER BY u.nama ASC";

$result = mysqli_query($conn, $resSearch);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan</title>

    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- box icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>

  <body>
    <section class="home-info" id="info">
      <div class="info-header">
      <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
      <h2 class="heading">Data <span>Karyawan</span></h2>
      </div>
      <div class="kontrol">
        <form action="" method="get">
          <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Searchbar" class="searchbar" />
          <input type="submit" value="Cari" hidden>
        </form>
      </div>

      <div class="table-container">
        <!-- Data Absensi akan tampil di sini -->
        <table>
          <thead>
            <tr>
              <th>Nomor Induk Pegawai</th>
              <th>Nama Lengkap</th>
              <th>Tanggal Lahir</th>
              <th>Divisi</th>
              <th>Jabatan</th>
              <th>No. Handphone</th>
              <th>Alamat Tempat Tinggal</th>
              <th>Role</th>
              <?php if ($_SESSION['role'] == 1) { ?>
                <th>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0) { ?>
              <?php while ($kry = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><?= $kry['nip'] ?></td>
                <td><?= $kry['nama'] ?></td>
                <td><?= formatTanggalIndonesia($kry['tgl_lahir']) ?></td>
                <td><?= $kry['nama_divisi'] ?></td>
                <td><?= $kry['nama_jabatan'] ?></td>
                <td><?= $kry['no_hp'] ?></td>
                <td><?= $kry['alamat'] ?></td>
                <td><?= $kry['role'] ?></td>
                <?php if ($_SESSION['role'] == 1) { ?>
                  <td>
                      <a href="form_editKaryawan.php?id=<?= $kry['id'] ?>" title="Edit">
                        <i class="fas fa-edit icon-edit"></i>
                      </a>
                      &nbsp;&nbsp;
                      <a href="../process/proses_hapusKaryawan.php?id=<?= $kry['id'] ?>" title="Hapus" onclick="return confirm('Yakin ingin hapus?')">
                        <i class="fas fa-trash-alt icon-delete"></i>
                      </a>
                  </td>
                <?php } ?>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td colspan="8" style="text-align: center;">Data tidak ditemukan</td>
              </tr>
              <?php } ?>
          </tbody>
				</table>
      </div>
    </section>
  </body>
</html>