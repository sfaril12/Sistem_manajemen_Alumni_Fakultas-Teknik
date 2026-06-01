<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user          = $_SESSION['id_user'];
$nama             = $_POST['nama'];
$nim              = $_POST['nim'];
$tahun_lulus      = $_POST['tahun_lulus'];
$program_studi    = $_POST['program_studi'];
$asal_universitas = $_POST['asal_universitas'];
$tanggal_lahir    = $_POST['tanggal_lahir'];
$pekerjaan        = $_POST['pekerjaan'] ?: NULL;
$instansi         = $_POST['instansi'] ?: NULL;

// simpan ke profil_alumni
$stmt = mysqli_prepare($conn, "
    INSERT INTO profil_alumni
    (id_user, nama, nim, tahun_lulus, program_studi, asal_universitas, pekerjaan, instansi, tanggal_lahir)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

mysqli_stmt_bind_param(
    $stmt,
    "ississsss",
    $id_user,
    $nama,
    $nim,
    $tahun_lulus,
    $program_studi,
    $asal_universitas,
    $pekerjaan,
    $instansi,
    $tanggal_lahir
);

mysqli_stmt_execute($stmt);

// setelah berhasil
header("Location: halutama.php");
exit;
