<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: loginadmin.php");
    exit;
}

include 'koneksi.php';

$id_kusioner = $_GET['id'] ?? 0;

/* ================= DATA KUESIONER ================= */
$qK = mysqli_prepare($conn,
    "SELECT * FROM kusioner WHERE id_kusioner = ?"
);
mysqli_stmt_bind_param($qK, "i", $id_kusioner);
mysqli_stmt_execute($qK);
$kuesioner = mysqli_fetch_assoc(mysqli_stmt_get_result($qK));

if (!$kuesioner) {
    die("Kuesioner tidak ditemukan");
}

/* ================= PERTANYAAN ================= */
$qP = mysqli_prepare($conn,
    "SELECT * FROM pertanyaan WHERE id_kusioner = ? ORDER BY id_pertanyaan ASC"
);
mysqli_stmt_bind_param($qP, "i", $id_kusioner);
mysqli_stmt_execute($qP);
$pertanyaan = mysqli_stmt_get_result($qP);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Statistik Kuesioner</title>
<link rel="stylesheet" href="lihat_kusioner.css">
</head>
<body>

<nav class="nav-simple">
    <a href="admin.php#contact">← Kembali</a>
</nav>

<div class="dashboard-container">
    <h2><?= htmlspecialchars($kuesioner['judul_kusioner']); ?></h2>
    <p class="section-desc">
        <?= nl2br(htmlspecialchars($kuesioner['deskripsi'])); ?>
    </p>

    <div class="kuesioner-form">

<?php $no = 1; ?>
<?php while ($p = mysqli_fetch_assoc($pertanyaan)) : ?>

<div class="question-card">
    <div class="question-header">
        <div class="question-number"><?= $no++; ?></div>
        <div><?= htmlspecialchars($p['text_pertanyaan']); ?></div>
    </div>

    <?php if ($p['tipe_pertanyaan'] === 'text') : ?>

        <?php
        $qCount = mysqli_prepare($conn,
            "SELECT COUNT(*) AS total FROM jawaban WHERE id_pertanyaan = ?"
        );
        mysqli_stmt_bind_param($qCount, "i", $p['id_pertanyaan']);
        mysqli_stmt_execute($qCount);
        $total = mysqli_fetch_assoc(mysqli_stmt_get_result($qCount))['total'];
        ?>

        <p>🧾 <strong><?= $total; ?></strong> responden menjawab pertanyaan ini</p>

        <details>
            <summary style="cursor:pointer;color:#00ffcc;">
                Lihat Detail Jawaban
            </summary>
            <ul>
                <?php
                $qJ = mysqli_prepare($conn,
                    "SELECT jawaban_pertanyaan FROM jawaban WHERE id_pertanyaan = ?"
                );
                mysqli_stmt_bind_param($qJ, "i", $p['id_pertanyaan']);
                mysqli_stmt_execute($qJ);
                $jawaban = mysqli_stmt_get_result($qJ);

                while ($j = mysqli_fetch_assoc($jawaban)) {
                    echo "<li>" . htmlspecialchars($j['jawaban_pertanyaan']) . "</li>";
                }
                ?>
            </ul>
        </details>

    <?php else : /* RADIO */ ?>

        <?php
        $qO = mysqli_prepare($conn,
            "SELECT 
                o.label_opsi,
                o.value_opsi,
                COUNT(j.id_jawaban) AS total
             FROM opsi_radio o
             LEFT JOIN jawaban j 
                ON j.jawaban_pertanyaan = o.value_opsi
                AND j.id_pertanyaan = o.id_pertanyaan
             WHERE o.id_pertanyaan = ?
             GROUP BY o.id_opsi
             ORDER BY o.urutan ASC"
        );
        mysqli_stmt_bind_param($qO, "i", $p['id_pertanyaan']);
        mysqli_stmt_execute($qO);
        $opsi = mysqli_stmt_get_result($qO);
        ?>

        <?php while ($o = mysqli_fetch_assoc($opsi)) : ?>
            <div class="radio-option">
                <input type="radio" disabled>
                <label>
                    <?= htmlspecialchars($o['label_opsi']); ?>
                    <strong>(<?= $o['total']; ?> respon)</strong>
                </label>
            </div>
        <?php endwhile; ?>

    <?php endif; ?>

</div>

<?php endwhile; ?>

    </div>
</div>

</body>
</html>
