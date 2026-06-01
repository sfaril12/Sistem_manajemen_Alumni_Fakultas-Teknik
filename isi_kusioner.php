<?php
session_start();
require_once "koneksi.php";

/* ==== VALIDASI LOGIN ==== */
if (!isset($_SESSION['login'])) {
    header("Location: loginakun.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* ==== VALIDASI ID KUSIONER ==== */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Kuesioner tidak valid.");
}

$id_kusioner = (int) $_GET['id'];

/* ==== AMBIL DATA KUSIONER ==== */
$qKusioner = mysqli_prepare($conn, "
    SELECT * FROM kusioner WHERE id_kusioner = ?
");
mysqli_stmt_bind_param($qKusioner, "i", $id_kusioner);
mysqli_stmt_execute($qKusioner);
$kusioner = mysqli_fetch_assoc(mysqli_stmt_get_result($qKusioner));

if (!$kusioner) {
    die("Kuesioner tidak ditemukan.");
}

/* ==== CEK APAKAH SUDAH PERNAH ISI ==== */
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

/* ==== AMBIL PERTANYAAN ==== */
$qPertanyaan = mysqli_prepare($conn, "
    SELECT * FROM pertanyaan
    WHERE id_kusioner = ?
    ORDER BY id_pertanyaan ASC
");
mysqli_stmt_bind_param($qPertanyaan, "i", $id_kusioner);
mysqli_stmt_execute($qPertanyaan);
$resultPertanyaan = mysqli_stmt_get_result($qPertanyaan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Isi Kuesioner</title>
    <link rel="stylesheet" href="isi_kusioner.css">
</head>
<body>

<nav class="nav-simple">
    <a href="halutama.php">← Kembali</a>
</nav>

<section class="dashboard-section">
    <div class="dashboard-container">

        <h2 class="section-title"><?= htmlspecialchars($kusioner['judul_kusioner']); ?></h2>
        <p class="section-desc"><?= nl2br(htmlspecialchars($kusioner['deskripsi'])); ?></p>

        <form method="POST" action="simpan_jawaban.php" class="kuesioner-form">

            <input type="hidden" name="id_kusioner" value="<?= $id_kusioner; ?>">

            <?php
            $no = 1;
            while ($p = mysqli_fetch_assoc($resultPertanyaan)) :
            ?>
            <div class="question-card">
                <div class="question-header">
                    <span class="question-number"><?= $no++; ?></span>
                    <span class="question-text">
                        <?= htmlspecialchars($p['text_pertanyaan']); ?>
                    </span>
                </div>

                <div class="question-body">

                <?php if ($p['tipe_pertanyaan'] === 'text'): ?>
                    <textarea 
                        name="jawaban[<?= $p['id_pertanyaan']; ?>]" 
                        required
                        placeholder="Tuliskan jawaban Anda..."
                    ></textarea>

                <?php elseif ($p['tipe_pertanyaan'] === 'radio'): ?>

                    <?php
                    $qOpsi = mysqli_prepare($conn, "
                        SELECT * FROM opsi_radio
                        WHERE id_pertanyaan = ? AND is_active = 1
                        ORDER BY urutan ASC
                    ");
                    mysqli_stmt_bind_param($qOpsi, "i", $p['id_pertanyaan']);
                    mysqli_stmt_execute($qOpsi);
                    $opsi = mysqli_stmt_get_result($qOpsi);

                    while ($o = mysqli_fetch_assoc($opsi)) :
                    ?>
                        <label class="radio-option">
                            <input 
                                type="radio" 
                                name="jawaban[<?= $p['id_pertanyaan']; ?>]" 
                                value="<?= htmlspecialchars($o['value_opsi']); ?>" 
                                required
                            >
                            <span><?= htmlspecialchars($o['label_opsi']); ?></span>
                        </label>
                    <?php endwhile; ?>

                <?php endif; ?>

                </div>
            </div>
            <?php endwhile; ?>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    Kirim Jawaban
                </button>
            </div>

        </form>
    </div>
</section>

</body>
</html>
