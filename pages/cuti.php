<?php

session_start();
$activePage = 'cuti';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';

$searchPendingCuti = isset($_GET['searchPendingCuti']) ? $_GET['searchPendingCuti'] : '';
$resSearchPendingCuti = "SELECT c.id, c.tanggal_pengajuan, c.tanggal_mulai, c.tanggal_selesai, c.alasan, u.nama, u.nip, c.status
                          FROM cuti c
                          JOIN `user` u ON c.id_user = u.id 
                          WHERE c.status = 'Menunggu' AND 
                          (u.nip LIKE '%$searchPendingCuti%' OR u.nama LIKE '%$searchPendingCuti%') 
                          ORDER BY c.tanggal_pengajuan ASC";
$result = mysqli_query($conn, $resSearchPendingCuti);

$searchFinalStatusCuti = isset($_GET['searchFinalStatusCuti']) ? $_GET['searchFinalStatusCuti'] : '';
$resSearchFinalStatusCuti = "SELECT
                                c.tanggal_pengajuan,
                                c.tanggal_mulai,
                                c.tanggal_selesai,
                                c.alasan,
                                u.nama,
                                u.nip,
                                c.status
                              FROM
                                cuti c
                              JOIN `user` u ON
                                c.id_user = u.id
                              WHERE
                                (u.nip LIKE '%$searchFinalStatusCuti%' OR u.nama LIKE '%$searchFinalStatusCuti%')
                              AND
                                c.status IN ('Disetujui', 'Ditolak', 'Dibatalkan')
                              ORDER BY
                                c.tanggal_pengajuan ASC";
$resultFinal = mysqli_query($conn, $resSearchFinalStatusCuti);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Cuti Karyawan</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
  <section class="home-info" id="cuti">
    <div class="info-header">
      <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Absensi Icon" class="icon">
      <h2 class="heading">Data <span>Cuti Karyawan</span></h2>
    </div>

    <div class="kontrol">
      <form action="" method="get">
        <input type="text" name="searchPendingCuti" value="<?= htmlspecialchars($searchPendingCuti); ?>" placeholder="Searchbar" class="searchbar" />
        <input type="submit" value="Cari" hidden>
      </form>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nomor Induk Pegawai</th>
            <th>Nama Lengkap</th>
            <th>Tanggal Pengajuan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Alasan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if(mysqli_num_rows($result) > 0) { ?>
            <?php while($cuti = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><?= $cuti['nip'] ?></td>
                <td><?= $cuti['nama'] ?></td>
                <td><?= formatTanggalIndonesia($cuti['tanggal_pengajuan']) ?></td>
                <td><?= formatTanggalIndonesia($cuti['tanggal_mulai']) ?></td>
                <td><?= formatTanggalIndonesia($cuti['tanggal_selesai']) ?></td>
                <td><?= $cuti['alasan'] ?></td>
                <td>
                  <form action="../process/proses_pengajuanCuti.php" method="post">
                    <input type="hidden" name="id" value="<?= $cuti['id']; ?>">
                    <button type="submit" name="approve" class="btn-approve">SETUJU</button>
                    <button type="submit" name="reject" class="btn-reject">TOLAK</button>
                  </form>
                </td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="7" style="text-align: center;">Data tidak ditemukan</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="kontrol1">
      <form action="" method="get">
        <input type="text" name="searchFinalStatusCuti" value="<?= htmlspecialchars($searchFinalStatusCuti); ?>" placeholder="Searchbar" class="searchbar" />
        <input type="submit" value="Cari" hidden>
      </form>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nomor Induk Pegawai</th>
            <th>Nama Lengkap</th>
            <th>Tanggal Pengajuan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Alasan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if(mysqli_num_rows($resultFinal) > 0) { ?>
            <?php while($finalStatusCuti = mysqli_fetch_assoc($resultFinal)) { ?>
              <tr>
                <td><?= $finalStatusCuti['nip'] ?></td>
                <td><?= $finalStatusCuti['nama'] ?></td>
                <td><?= formatTanggalIndonesia($finalStatusCuti['tanggal_pengajuan']) ?></td>
                <td><?= formatTanggalIndonesia($finalStatusCuti['tanggal_mulai']) ?></td>
                <td><?= formatTanggalIndonesia($finalStatusCuti['tanggal_selesai']) ?></td>
                <td><?= $finalStatusCuti['alasan'] ?></td>
                <td><span class="badge status-<?= strtolower($finalStatusCuti['status']); ?>"><?= $finalStatusCuti['status'] ?></span></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="7" style="text-align: center;">Data tidak ditemukan</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>
</body>
</html>
