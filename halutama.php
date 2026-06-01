<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: loginakun.php");
    exit;
}

require_once "koneksi.php";

$id_user = $_SESSION['id_user'];

/* Ambil nama alumni dari profil_alumni */
$query = mysqli_prepare(
    $conn,
    "SELECT nama FROM profil_alumni WHERE id_user = ?"
);
mysqli_stmt_bind_param($query, "i", $id_user);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

$data_alumni = mysqli_fetch_assoc($result);
$nama_alumni = $data_alumni['nama'] ?? 'Alumni';
?>

<?php
include 'koneksi.php';

/* Ambil daftar kuesioner */
$qKuesioner = mysqli_query($conn, "
    SELECT 
        id_kusioner,
        judul_kusioner,
        deskripsi,
        terbit_kusioner
    FROM kusioner
    ORDER BY terbit_kusioner DESC
");

/* Jumlah alumni BEKERJA per program studi */
$qKerjaProdi = mysqli_query($conn, "
    SELECT program_studi, COUNT(*) AS total
    FROM profil_alumni
    WHERE pekerjaan IS NOT NULL 
      AND pekerjaan != 'Belum bekerja'
    GROUP BY program_studi
    ORDER BY total DESC
");

$dataKerjaProdi = [];
$maxKerjaProdi = 0;

while ($row = mysqli_fetch_assoc($qKerjaProdi)) {
    $dataKerjaProdi[] = $row;
    if ($row['total'] > $maxKerjaProdi) {
        $maxKerjaProdi = $row['total'];
    }
}

/* Distribusi alumni per program studi */
$qProdi = mysqli_query($conn, "
    SELECT program_studi, COUNT(*) AS total
    FROM profil_alumni
    GROUP BY program_studi
    ORDER BY total DESC
");

$dataProdi = [];
$maxProdi = 0;

while ($row = mysqli_fetch_assoc($qProdi)) {
    $dataProdi[] = $row;
    if ($row['total'] > $maxProdi) {
        $maxProdi = $row['total'];
    }
}

/* Distribusi alumni per tahun lulus */
$qTahunLulus = mysqli_query($conn, "
    SELECT tahun_lulus, COUNT(*) AS total
    FROM profil_alumni
    GROUP BY tahun_lulus
    ORDER BY tahun_lulus ASC
");

$dataTahun = [];
$maxTotal = 0;

while ($row = mysqli_fetch_assoc($qTahunLulus)) {
    $dataTahun[] = $row;
    if ($row['total'] > $maxTotal) {
        $maxTotal = $row['total'];
    }
}

/* Ambil data alumni */
$queryAlumni = mysqli_query($conn, "
    SELECT 
        id_alumni,
        nama,
        nim,
        tahun_lulus,
        program_studi,
        asal_universitas,
        pekerjaan,
        instansi,
        tanggal_lahir
    FROM profil_alumni
    ORDER BY id_alumni DESC
");
?>
<?php

/* Jumlah alumni */
$qTotalAlumni = mysqli_query($conn, "SELECT COUNT(*) AS total FROM profil_alumni");
$totalAlumni = mysqli_fetch_assoc($qTotalAlumni)['total'];

/* Alumni bekerja */
$qBekerja = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM profil_alumni 
     WHERE pekerjaan IS NOT NULL AND pekerjaan != 'Belum bekerja'"
);
$alumniBekerja = mysqli_fetch_assoc($qBekerja)['total'];

/* Alumni tidak bekerja */
$qTidakBekerja = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM profil_alumni 
     WHERE pekerjaan IS NULL OR pekerjaan = 'Belum bekerja'"
);
$alumniTidakBekerja = mysqli_fetch_assoc($qTidakBekerja)['total'];

/* Total kuesioner */
$qTotalKuesioner = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kusioner");
$totalKuesioner = mysqli_fetch_assoc($qTotalKuesioner)['total'];

// grafik lingkaran kerja/tidak bekerja
$totalStatus = $alumniBekerja + $alumniTidakBekerja;

$persenBekerja = $totalStatus > 0 
    ? ($alumniBekerja / $totalStatus) * 100 
    : 0;

$persenTidak = 100 - $persenBekerja;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UHO Alumni</title>
    <link rel="stylesheet" href="halutama.css">
<!-- 

TemplateMo 602 Graph Page

https://templatemo.com/tm-602-graph-page

-->
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <a href="admin.php" class="logo">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/>
                    </svg>
                </div>
                <span class="logo-text">Sistem Informasi Alumni fakultas Teknik</span>
            </a>
            <ul class="nav-links">
                <li><a href="#home" class="active">Utama</a></li>
                <li><a href="#dashboard">Informasi Umum</a></li>
                <li><a href="#analytics">Kusioner</a></li>
                <li><a href="biodata_alumni.php">Biodata Diri</a></li>
                <li><a href="index.php">Log Out</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <ul class="nav-links-mobile" id="navLinksMobile">
            <li><a href="#home" class="active">Utama</a></li>
                <li><a href="#dashboard">Informasi Umum</a></li>
                <li><a href="#analytics">Kusioner</a></li>
                <li><a href="biodata_alumni.php">Biodata Diri</a></li>
                <li><a href="index.php">Log Out</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="geometric-shapes">
            <div class="shape shape1"></div>
            <div class="shape shape2"></div>
            <div class="shape shape3"></div>
            <div class="shape shape4"></div>
            <div class="shape shape5"></div>
            <div class="shape shape6"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-text">
                <h2>Selamat datang</h2>
                <br>
                    <h1><?= htmlspecialchars($nama_alumni); ?></h1>
                <p>website ini untuk memantau keberadaan anda dan alumni-alumni lainnya</p>
                <a href="#dashboard" class="cta-button">cek selengkapnya</a>
            </div>
            
            <div class="hero-visual">
                <div class="city-container">
                    <div class="building building1">
                        <div class="building-fill"></div>
                        <div class="building-windows"></div>
                    </div>
                    <div class="building building2">
                        <div class="building-fill"></div>
                        <div class="building-windows"></div>
                    </div>
                    <div class="building building3">
                        <div class="building-fill"></div>
                        <div class="building-windows"></div>
                    </div>
                    <div class="building building4">
                        <div class="building-fill"></div>
                        <div class="building-windows"></div>
                    </div>
                    <div class="neon-line neon-line1"></div>
                    <div class="neon-line neon-line2"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Section -->
    <section class="dashboard-section" id="dashboard">
        <div class="dashboard-container">
            <h2 class="section-title">Seputar Informasi</h2>
            <!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">👥</div>
            <div class="stat-title">Jumlah Alumni</div>
        </div>
        <div class="stat-value"><?= $totalAlumni; ?> Orang</div>
        <div class="stat-description">Total alumni yang terdaftar dalam sistem dari tahun 2020-2025.</div>
        <div class="stat-chart">
            <canvas class="mini-chart" id="miniChart1"></canvas>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">💼</div>
            <div class="stat-title">Alumni Bekerja</div>
        </div>
        <div class="stat-value"><?= $alumniBekerja; ?> Orang</div>
        <div class="stat-description">Alumni yang telah memiliki pekerjaan sesuai data yang terupdate.</div>
        <div class="stat-chart">
            <canvas class="mini-chart" id="miniChart2"></canvas>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">🎓</div>
            <div class="stat-title">Alumni Tidak Bekerja</div>
        </div>
        <div class="stat-value"><?= $alumniTidakBekerja; ?> Orang</div>
        <div class="stat-description">Alumni yang sedang mencari pekerjaan atau melanjutkan pendidikan.</div>
        <div class="stat-chart">
            <canvas class="mini-chart" id="miniChart3"></canvas>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">📝</div>
            <div class="stat-title">Total Kusioner</div>
        </div>
        <div class="stat-value"><?= number_format($totalKuesioner); ?></div>
        <div class="stat-description">Jumlah kusioner yang telah dibuat dalam sistem.</div>
        <div class="stat-chart">
            <canvas class="mini-chart" id="miniChart4"></canvas>
        </div>
    </div>   
</div>
        </div>
    </section>

    <!-- Analytics Section -->
   <section class="analytics-section" id="analytics">
    <div class="dashboard-container">
        <h2 class="section-title">Daftar Kuesioner</h2>

        <div class="table-container">
            <table class="alumni-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Judul Kuesioner</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Tanggal Terbit</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_prepare($conn, "
                    SELECT 
                        k.id_kusioner,
                        k.judul_kusioner,
                        k.deskripsi,
                        k.terbit_kusioner,
                        COUNT(j.id_jawaban) AS total_jawaban
                    FROM kusioner k
                    LEFT JOIN pertanyaan p ON p.id_kusioner = k.id_kusioner
                    LEFT JOIN jawaban j 
                        ON j.id_pertanyaan = p.id_pertanyaan
                        AND j.id_user = ?
                    GROUP BY k.id_kusioner
                    ORDER BY k.terbit_kusioner DESC
                ");
                mysqli_stmt_bind_param($query, "i", $id_user);
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) :
                    $sudahIsi = $row['total_jawaban'] > 0;
                ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['judul_kusioner']); ?></td>
                        <td><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                        <td class="text-center">
                            <?= date('d M Y', strtotime($row['terbit_kusioner'])); ?>
                        </td>
                        <td class="text-center">
                            <?php if ($sudahIsi): ?>
                                <span class=>Sudah Diisi</span>
                            <?php else: ?>
                                <span class=>Belum Diisi</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if (!$sudahIsi): ?>
                                <a href="isi_kusioner.php?id=<?= $row['id_kusioner']; ?>" 
                                   class="btn-submit">
                                   Isi
                                </a>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p class="copyright">contact admin : safaril@gmail.com . sistem informasi berbasis kusioner 
            | Designed by Kelompok 9</p>
        </div>
    </footer>

<script src="halutama.js"></script>
</body>
</html>