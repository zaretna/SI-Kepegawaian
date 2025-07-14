<?php

include '../includes/connection.php';

$sqlGetJabatan = "SELECT * FROM jabatan";
$resJabatan = mysqli_query($conn, $sqlGetJabatan);

$sqlGetDivisi = "SELECT * FROM divisi";
$resDivisi = mysqli_query($conn, $sqlGetDivisi);

$sqlGetRole = "SELECT * FROM role";
$resRole = mysqli_query($conn, $sqlGetRole);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Form Registrasi</title>
    <link rel="stylesheet" href="../assets/css/regist.css" />
</head>
<body>
    <div class="container">
    <div class="regist_container">
        <div class="regist_title">
        <span>Form Registrasi</span>
        </div>
        <form action="../process/register_process.php" method="post" enctype="multipart/form-data">
        <table>
            
            <tr>
                <td><label for="nama">Nama</label></td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama" required></td>
            </tr>
            <tr>
                <td><label>Jenis Kelamin</label></td>
                <td>:</td>
            <td>
                <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label>
                &nbsp;&nbsp;
                <label><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
            </td>
            </tr>
            <tr>
                <td><label for="ttl">Tanggal Lahir</label></td>
                <td>:</td>
                <td><input type="date" id="ttl" name="tgl_lahir" required></td>
            </tr>
            <tr>
                <td><label for="nip">NIP</label></td>
                <td>:</td>
                <td><input type="text" id="nip" name="nip" required></td>
            </tr>
            <tr>
                <td><label for="divisi">Divisi</label></td>
                <td>:</td>
                <td>
                <select id="divisi" name="id_divisi" required>
                    <option value="" disabled selected>-- Pilih Divisi --</option>
                    <?php while ($divisi =  mysqli_fetch_assoc($resDivisi)) { ?>
                    <option value="<?= $divisi['id'] ?>"><?= htmlspecialchars($divisi['nama_divisi']) ?></option>
                    <?php } ?>
                </select>
                </td>
            </tr>
            <tr>
                <td><label for="jabatan">Jabatan</label></td>
                <td>:</td>
                <td>
                <select id="jabatan" name="id_jabatan" required>
                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                    <?php while ($jabatan =  mysqli_fetch_assoc($resJabatan)) { ?>
                    <option value="<?= $jabatan['id'] ?>"><?= htmlspecialchars($jabatan['nama_jabatan']) ?></option>
                    <?php } ?>
                </select>
                </td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td>:</td>
                <td><textarea id="alamat" name="alamat" rows="3" required></textarea></td>
            </tr>
            <tr>
                <td><label for="hp">No. HP</label></td>
                <td>:</td>
                <td><input type="tel" id="hp" name="no_hp" required></td>
            </tr>
            <tr>
                <td><label for="username">Username</label></td>
                <td>:</td>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Katasandi</label></td>
                <td>:</td>
                <td><input type="password" id="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="3" class="submit-row">
                <button type="submit" name="register">Daftar</button>
                </td>
            </tr>
            </table>
        </form>

        <div class="signup">
            <span>Already have an account? <a href="../index.php"> Sign In</a></span>
        </div>

        </div>
    </div>
</body>
</html>
