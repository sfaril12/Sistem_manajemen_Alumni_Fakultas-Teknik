<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: loginakun.php");
    exit;
}

include 'koneksi.php';

$id_user = $_SESSION['id_user'];

/* Ambil data lengkap alumni */
$stmt = mysqli_prepare($conn, "
    SELECT 
        nama,
        nim,
        tahun_lulus,
        program_studi,
        asal_universitas,
        pekerjaan,
        instansi,
        tanggal_lahir
    FROM profil_alumni
    WHERE id_user = ?
");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data alumni tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Biodata Alumni</title>
    <link rel="stylesheet" href="biodata_alumni.css">
</head>
<body>

<nav class="nav-simple">
    <a href="halutama.php">← Kembali</a>
</nav>

<div class="profile-container">
    <h2 class="profile-title">Biodata Diri Alumni</h2>
    <p class="profile-subtitle">
        Informasi pribadi alumni berdasarkan data yang tersimpan di sistem
    </p>

    <div class="profile-card">

        <div class="profile-row">
            <span class="label">Nama Lengkap</span>
            <span class="value"><?= htmlspecialchars($data['nama']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">NIM</span>
            <span class="value"><?= htmlspecialchars($data['nim']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Program Studi</span>
            <span class="value"><?= htmlspecialchars($data['program_studi']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Tahun Lulus</span>
            <span class="value"><?= htmlspecialchars($data['tahun_lulus']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Universitas Asal</span>
            <span class="value"><?= htmlspecialchars($data['asal_universitas']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Tanggal Lahir</span>
            <span class="value">
                <?= date('d M Y', strtotime($data['tanggal_lahir'])); ?>
            </span>
        </div>

        <div class="profile-row">
            <span class="label">Pekerjaan</span>
            <span class="value">
                <?= htmlspecialchars($data['pekerjaan'] ?: 'Belum bekerja'); ?>
            </span>
        </div>

        <div class="profile-row">
            <span class="label">Instansi</span>
            <span class="value">
                <?= htmlspecialchars($data['instansi'] ?: '-'); ?>
            </span>
        </div>

    </div>
</div>

</body>
</html>
