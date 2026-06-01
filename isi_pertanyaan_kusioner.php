<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: loginadmin.php");
    exit;
}

include 'koneksi.php';

/* ================= SIMPAN KUESIONER ================= */
$judul   = $_POST['judul'] ?? '';
$desk    = $_POST['deskripsi'] ?? '';
$jumlah  = (int)($_POST['jumlah'] ?? 0);

if ($judul && $desk && $jumlah > 0) {

} else {
    die("Data tidak valid");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Isi Pertanyaan Kuesioner</title>
<link rel="stylesheet" href="isi_pertanyaan_kusioner.css">
</head>
<body>

<nav class="nav-simple">
    <a href="admin.php#contact">← Kembali</a>
</nav>

<div class="dashboard-container">
<h2><?= htmlspecialchars($judul); ?></h2>
<p class="section-desc">Isi pertanyaan kuesioner</p>

<form action="simpan_pertanyaan_kusioner.php" method="POST">
<input type="hidden" name="judul" value="<?= htmlspecialchars($judul); ?>">
<input type="hidden" name="deskripsi" value="<?= htmlspecialchars($desk); ?>">

<div class="kuesioner-form">

<?php for ($i = 1; $i <= $jumlah; $i++) : ?>
<div class="question-card">

    <div class="question-header">
        <div class="question-number"><?= $i; ?></div>
        <strong>Pertanyaan <?= $i; ?></strong>
    </div>

    <textarea 
        name="pertanyaan[<?= $i; ?>][text]" 
        required
        placeholder="Tulis pertanyaan..."></textarea>

    <br><br>

    <label>
        <input type="radio" 
            name="pertanyaan[<?= $i; ?>][tipe]" 
            value="text" checked>
        Jawaban Text
    </label>

    <label style="margin-left:20px;">
        <input type="radio" 
            name="pertanyaan[<?= $i; ?>][tipe]" 
            value="radio">
        Jawaban Radio
    </label>

   <div class="jumlah-opsi-wrap">
    <label>Jumlah Pilihan Radio (1–5)</label>
    <input 
        type="number"
        class="jumlah-opsi-input"
        name="pertanyaan[<?= $i; ?>][jumlah_opsi]"
        min="1"
        max="5">
    </div>

    <div class="opsi-wrap">
<?php for ($o = 1; $o <= 5; $o++) : ?>
    <input 
        type="text"
        name="pertanyaan[<?= $i; ?>][opsi][<?= $o; ?>]"
        placeholder="Opsi <?= $o; ?>">
<?php endfor; ?>
</div>

</div>
<?php endfor; ?>

</div>

<div class="form-actions">
    <button type="submit" class="btn-submit">
        Simpan Pertanyaan
    </button>
</div>

<script>
document.querySelectorAll('.question-card').forEach(card => {

    const radioText   = card.querySelector('input[value="text"]');
    const radioRadio  = card.querySelector('input[value="radio"]');
    const jumlahWrap  = card.querySelector('.jumlah-opsi-wrap');
    const jumlahInput = card.querySelector('.jumlah-opsi-input');
    const opsiWrap    = card.querySelector('.opsi-wrap');
    const opsiInputs  = opsiWrap.querySelectorAll('input');

    function hideAllRadioOptions() {
        jumlahWrap.style.display = 'none';
        opsiWrap.style.display = 'none';
        opsiInputs.forEach(input => input.style.display = 'none');
        jumlahInput.value = '';
    }

    function showJumlahRadio() {
        jumlahWrap.style.display = 'block';
        opsiWrap.style.display = 'none';
        opsiInputs.forEach(input => input.style.display = 'none');
        jumlahInput.value = '';
    }

    /* ===== STATE AWAL SAAT PAGE LOAD ===== */
    if (radioText.checked) {
        hideAllRadioOptions();
    }

    if (radioRadio.checked) {
        showJumlahRadio();
    }

    /* ===== EVENT RADIO ===== */
    radioText.addEventListener('change', () => {
        hideAllRadioOptions();
    });

    radioRadio.addEventListener('change', () => {
        showJumlahRadio();
    });

    /* ===== EVENT JUMLAH OPSI ===== */
    jumlahInput.addEventListener('input', () => {
        const jumlah = parseInt(jumlahInput.value);

        opsiWrap.style.display = 'none';
        opsiInputs.forEach(input => input.style.display = 'none');

        if (jumlah >= 1 && jumlah <= 5) {
            opsiWrap.style.display = 'block';
            for (let i = 0; i < jumlah; i++) {
                opsiInputs[i].style.display = 'block';
            }
        }
    });

});
</script>



</form>
</div>

</body>
</html>
