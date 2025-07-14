<?php

session_start();
$activePage = 'karyawan';

include '../includes/connection.php';
include '../includes/auth.php';
include '../includes/role_check.php';
include '../includes/navbar.php';
include '../includes/helpers.php';

$id = $_GET['id'];

if (isset($id)) {
    $query = "SELECT 
                u.id, u.nip, u.nama, u.tgl_lahir, j.nama_jabatan, d.nama_divisi, u.no_hp, u.alamat, u.profile, u.jenis_kelamin, r.role, u.id_divisi, u.id_jabatan, u.id_role, u.profile
                FROM user u 
                JOIN jabatan j ON u.id_jabatan = j.id 
                JOIN divisi d ON u.id_divisi = d.id 
                JOIN role r ON u.id_role = r.id
                WHERE u.id = $id";
    $result = mysqli_query($conn, $query);
    $kry = mysqli_fetch_assoc($result);
}

$sqlGetJabatan = "SELECT * FROM jabatan";
$resJabatan = mysqli_query($conn, $sqlGetJabatan);

$sqlGetDivisi = "SELECT * FROM divisi";
$resDivisi = mysqli_query($conn, $sqlGetDivisi);

$sqlGetRole = "SELECT * FROM role";
$resRole = mysqli_query($conn, $sqlGetRole);

$msg = "";

if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Edit Data Karyawan</title>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <!-- Box Icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
    <div class="form-container" id="karyawan">
        <h2>Form Input Karyawan</h2>
        <a class="back-link" href="karyawan.php">← Kembali ke Data Karyawan</a>

        <?php if (!empty($msg)){ ?>
            <?php var_dump($msg); ?>
            <p style="color: green; margin-top: 5px; text-align: center"><?= $msg; ?></p>
        <?php } ?>

        <form method="post" action="../process/proses_editKaryawan.php" enctype="multipart/form-data">
            <input type="hideen" name="id" value="<?= $kry['id'];?>" hidden>

            

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $kry['nama']; ?>" required>

            <label>Jenis Kelamin</label>
            <div class="gender-group">
                <label><input type="radio" name="jenis_kelamin" value="Laki-laki" <?= ($kry['jenis_kelamin'] == 'Laki-laki' ? 'checked' : '') ?> required> Laki-laki</label>
                <label><input type="radio" name="jenis_kelamin" value="Perempuan" <?= ($kry['jenis_kelamin'] == 'Perempuan' ? 'checked' : '') ?> required> Perempuan</label>
            </div>

            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" value="<?= $kry['tgl_lahir']; ?>" required">

            <label for="nip">NIP</label>
            <input type="text" id="nip" name="nip" placeholder="Masukkan NIP" value="<?= $kry['nip']; ?>" required>

            <label for="divisi">Divisi</label>
            <select id="divisi" name="id_divisi" value="" required>
                <?php while ($divisi =  mysqli_fetch_assoc($resDivisi)) { ?>
                    <option value="<?= $divisi['id'] ?>" <?= ($kry['id_divisi'] == $divisi['id'] ? 'selected' : '') ?> ><?= htmlspecialchars($divisi['nama_divisi']) ?></option>
                <?php } ?>
        </option>
            </select>

            <label for="jabatan">Jabatan</label>
            <select id="jabatan" name="id_jabatan" required>
                <?php while ($jabatan =  mysqli_fetch_assoc($resJabatan)) { ?>
                    <option value="<?= $jabatan['id'] ?>" <?= ($kry['id_jabatan'] == $jabatan['id'] ? 'selected' : '') ?> ><?= htmlspecialchars($jabatan['nama_jabatan']) ?></option>
                <?php } ?>
            </select>

            <label for="role">Role</label>
            <select id="role" name="id_role" required>
                <?php while ($role =  mysqli_fetch_assoc($resRole)) { ?>
                    <option value="<?= $role['id'] ?>" <?= ($kry['id_role'] == $role['id'] ? 'selected' : '') ?> ><?= htmlspecialchars($role['role']) ?></option>
                <?php } ?>
            </select>

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat" required><?= htmlspecialchars($kry['alamat']) ?></textarea>

            <label for="no_hp">No. HP</label>
            <input type="tel" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" value="<?= $kry['no_hp']; ?>" required>

            <label for="foto">Foto</label>
            <div class="foto-container" style="grid-column: 2 / 3;">
                <?php if(!empty($kry['profile'])) { ?>
                        <img id="preview" src="../assets/img/<?= $kry['profile']; ?>" alt="Preview Foto" />
                <?php } else { ?>
                    <img id="preview" src="../assets/img/default.png" alt="Preview Foto" style="display: none;" />
                <?php } ?>
                <input type="file" name="profile" id="foto" accept="image/*" value="<?= $kry['profile']; ?>" onchange="previewFoto(event)">
                <input type="hidden" name="profile_lama" value="<?= $kry['profile'] ?>">
            </div>

            <button type="submit" name="simpan" class="submit-button">Simpan Data</button>
        </form>
    </div>

    <script>
    function previewFoto(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>