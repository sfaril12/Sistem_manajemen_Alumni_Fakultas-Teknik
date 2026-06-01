<?php
session_start();
require_once "koneksi.php";

/* ==== VALIDASI LOGIN ==== */
if (!isset($_SESSION['login'])) {
    header("Location: loginakun.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* ==== VALIDASI DATA POST ==== */
if (
    !isset($_POST['id_kusioner']) ||
    !isset($_POST['jawaban']) ||
    !is_array($_POST['jawaban'])
) {
    die("Data tidak valid.");
}

$id_kusioner = (int) $_POST['id_kusioner'];
$jawaban = $_POST['jawaban'];

/* ==== CEK DUPLIKASI (ANTI ISI 2x) ==== */
$qCek = mysqli_prepare($conn, "
    SELECT COUNT(*) total
    FROM jawaban j
    JOIN pertanyaan p ON j.id_pertanyaan = p.id_pertanyaan
    WHERE p.id_kusioner = ? AND j.id_user = ?
");
mysqli_stmt_bind_param($qCek, "ii", $id_kusioner, $id_user);
mysqli_stmt_execute($qCek);
$cek = mysqli_fetch_assoc(mysqli_stmt_get_result($qCek));

if ($cek['total'] > 0) {
    die("❌ Anda sudah mengisi kuesioner ini.");
}

/* ==== SIMPAN JAWABAN ==== */
$stmt = mysqli_prepare($conn, "
    INSERT INTO jawaban (id_user, id_pertanyaan, jawaban_pertanyaan)
    VALUES (?, ?, ?)
");

foreach ($jawaban as $id_pertanyaan => $isi_jawaban) {
    if (trim($isi_jawaban) === '') {
        continue;
    }

    $id_pertanyaan = (int) $id_pertanyaan;
    $isi_jawaban = trim($isi_jawaban);

    mysqli_stmt_bind_param(
        $stmt,
        "iis",
        $id_user,
        $id_pertanyaan,
        $isi_jawaban
    );

    mysqli_stmt_execute($stmt);
}

/* ==== REDIRECT KE HALAMAN UTAMA ==== */
header("Location: halutama.php#analytics");
exit;
