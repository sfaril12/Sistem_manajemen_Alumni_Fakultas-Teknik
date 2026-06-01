<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Isi Data Alumni</title>
    <link rel="stylesheet" href="tampilan_isi_biodata.css">
</head>
<body>

<div class="profile-container">
    <h2 class="profile-title">Lengkapi Data Diri Alumni</h2>
    <p class="profile-subtitle">
        Silakan isi biodata diri Anda dengan benar
    </p>

    <form action="proses_simpan_alumni.php" method="POST" class="profile-card">

        <input type="hidden" name="id_user" value="<?= $id_user ?>">

        <div class="profile-row">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>
        </div>

        <div class="profile-row">
            <label>NIM</label>
            <input type="text" name="nim" required>
        </div>

        <div class="profile-row">
            <label>Program Studi</label>
            <select name="program_studi" required>
                <option value="">-- Pilih Program Studi --</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Teknik Elektro">Teknik Elektro</option>
                <option value="Teknik Mesin">Teknik Mesin</option>
                <option value="Teknik Sipil">Teknik Sipil</option>
                <option value="Teknik Arsitektur">Teknik Arsitektur</option>
            </select>
        </div>

        <div class="profile-row">
            <label>Tahun Lulus</label>
            <input type="number" name="tahun_lulus" placeholder="Contoh: 2026" required>
        </div>

        <div class="profile-row">
            <label>Universitas Asal</label>
            <input type="text" name="asal_universitas" required>
        </div>

        <div class="profile-row">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" required>
        </div>

        <div class="profile-row">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan">
        </div>

        <div class="profile-row">
            <label>Instansi</label>
            <input type="text" name="instansi">
        </div>

        <button type="submit" class="login-btn">
            Simpan Data
        </button>

    </form>
</div>

</body>
</html>
