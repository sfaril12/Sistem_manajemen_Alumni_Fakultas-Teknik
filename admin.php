<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: loginadmin.php");
    exit;
}
?>
<?php
include 'koneksi.php';

/* Ambil daftar kuesioner */
$qKuesioner = mysqli_query($conn, "
    SELECT 
        k.id_kusioner,
        k.judul_kusioner,
        k.deskripsi,
        k.terbit_kusioner,
        COUNT(DISTINCT j.id_user) AS total_responden
    FROM kusioner k
    LEFT JOIN pertanyaan p ON p.id_kusioner = k.id_kusioner
    LEFT JOIN jawaban j ON j.id_pertanyaan = p.id_pertanyaan
    GROUP BY k.id_kusioner
    ORDER BY k.terbit_kusioner DESC
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
    <title>Dasboard System alumni Berbasis Kusioner</title>
    <link rel="stylesheet" href="templatemo-graph-page.css">
    <link rel="stylesheet" href="templatemo-graph-page2.css">
<!-- 

TemplateMo 602 Graph Page

https://templatemo.com/tm-602-graph-page

-->
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/>
                    </svg>
                </div>
                <span class="logo-text">Dasboard Admin</span>
            </a>
            <ul class="nav-links">
                <li><a href="#home">Utama</a></li>
                <li><a href="#dashboard">Informasi Umum</a></li>
                <li><a href="#analytics">Analisis</a></li>
                <li><a href="#reports">Data Alumni</a></li>
                <li><a href="#contact">Kusioner</a></li>
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
                <li><a href="#dashboard">Informasi</a></li>
                <li><a href="#analytics">Analisis</a></li>
                <li><a href="#reports">Data Alumni</a></li>
                <li><a href="#contact">Kusioner</a></li>
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
                <h1>Welcome <br> <?= htmlspecialchars($_SESSION['admin_nama']); ?></h1>
                <p>Dashboard untuk monitoring, manajemen, dan memantau keberadaan seluruh alumni di fakultas teknik universitas Halu Oleo .</p>
                <a href="#dashboard" class="cta-button">Cek Selengkapnya</a>
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
            <h2 class="section-title">Informasi Umum</h2>
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
            <div class="stat-title">Alumni Belum Bekerja</div>
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

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">✅</div>
            <div class="stat-title">Didukung oleh </div>
        </div>
        <div class="stat-value">Universitas Halu Oleo</div>
        <div class="stat-description">integritas website telah ditanda tangani oleh universitas.</div>
        <div class="stat-chart">
            <canvas class="mini-chart" id="miniChart5"></canvas>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">📊</div>
            <div class="stat-title">website ini memberikan</div>
        </div>
        <div class="stat-value"> mengenai skema dan grafik dinamika alumni</div>
        <div class="stat-description">sehingga memudahkan untuk pendataan.</div>
        <div class="stat-chart">
            <canvas class="mini-chart" id="miniChart6"></canvas>
        </div>
    </div>

    <div class="stat-card">
    <div class="stat-header">
        <div class="stat-icon">⚡</div>
        <div class="stat-title">System Uptime</div>
    </div>
    <div class="stat-value">99.9%</div>
    <div class="stat-description">Exceptional reliability with minimal downtime ensuring seamless user experience.</div>
    <div class="stat-chart">
        <canvas class="mini-chart" id="miniChart7"></canvas>
    </div>
</div>
</div>
        </div>
    </section>

    <!-- Analytics Section -->
    <section class="analytics-section" id="analytics">
        <div class="dashboard-container">
            <h2 class="section-title">Analisis</h2>

            <!-- Chart Cards -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">📊 Distribusi Alumni per Tahun Lulus</h3>
                        <div class="chart-options">
                            <span class="chart-option active"><?= $totalAlumni; ?> Orang</span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="bar-chart" id="barChart">
                            <?php foreach ($dataTahun as $row): 
                                $height = ($row['total'] / $maxTotal) * 100;
                            ?>
                        <div class="bar" style="height: <?= round($height); ?>%">
                            <span class="bar-value"><?= $row['total']; ?></span>
                            <span class="bar-label"><?= $row['tahun_lulus']; ?></span>
                        </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                       <h3 class="chart-title">📈 Distribusi Kerja Fakultas Teknik</h3>
                        <div class="chart-options">
                            <span class="chart-option active"><?= $alumniBekerja; ?> Orang</span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="bar-chart">

                        <?php
                        $colors = [
                            'linear-gradient(180deg,#00ffcc,#00997a)',
                            'linear-gradient(180deg,#4ecdc4,#44a08d)',
                            'linear-gradient(180deg,#45b7d1,#2980b9)',
                            'linear-gradient(180deg,#ff6b6b,#c0392b)',
                            'linear-gradient(180deg,#f093fb,#8e44ad)'
                        ];

                        $i = 0;
                        foreach ($dataKerjaProdi as $row):
                            $height = $maxKerjaProdi > 0 
                                ? ($row['total'] / $maxKerjaProdi) * 100 
                                : 0;
                            $bg = $colors[$i % count($colors)];
                        ?>
                            <div class="bar" style="height: <?= round($height); ?>%; background: <?= $bg; ?>;">
                                <span class="bar-value"><?= $row['total']; ?></span>
                                <span class="bar-label"><?= htmlspecialchars($row['program_studi']); ?></span>
                            </div>
                        <?php
                        $i++;
                        endforeach;
                        ?>

                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">🎓 Distribusi Program Studi Fakultas Teknik</h3>
                        <div class="chart-options">
                            <span class="chart-option active">Semua Jurusan</span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="bar-chart">
                            <?php
                            $gradients = [
                                'linear-gradient(180deg, #ff6b6b 0%, #ff8e53 100%)',
                                'linear-gradient(180deg, #4ecdc4 0%, #44a08d 100%)',
                                'linear-gradient(180deg, #45b7d1 0%, #96c93d 100%)',
                                'linear-gradient(180deg, #f093fb 0%, #f5576c 100%)',
                                'linear-gradient(180deg, #a8edea 0%, #fed6e3 100%)'
                            ];

                            $i = 0;
                            foreach ($dataProdi as $row):
                                $height = ($row['total'] / $maxProdi) * 100;
                                $bg = $gradients[$i % count($gradients)];
                            ?>
                                <div class="bar" style="height: <?= round($height); ?>%; background: <?= $bg; ?>;">
                                    <span class="bar-value"><?= $row['total']; ?> Alumni</span>
                                    <div class="bar-label-container">
                                        <span class="bar-label"><?= htmlspecialchars($row['program_studi']); ?></span>
                                    </div>
                                </div>
                            <?php 
                            $i++;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title"> 👔 Status Kerja Alumni</h3>
                        <div class="chart-options">
                            <span class="chart-option active">Semua</span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="chart-container" style="display:flex;justify-content:center;align-items:center;">
                            <svg width="200" height="200" viewBox="0 0 36 36" class="pie-chart">

                                <!-- Bekerja -->
                                <path
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#00ffcc"
                                    stroke-width="3.8"
                                    stroke-dasharray="<?= round($persenBekerja,1); ?> <?= round($persenTidak,1); ?>"
                                    stroke-dashoffset="25"
                                />

                                <!-- Tidak Bekerja -->
                                <path
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#ff6b6b"
                                    stroke-width="3.8"
                                    stroke-dasharray="<?= round($persenTidak,1); ?> <?= round($persenBekerja,1); ?>"
                                    stroke-dashoffset="<?= round($persenBekerja + 25,1); ?>"
                                />

                                <!-- Teks tengah -->
                                <text x="18" y="17" text-anchor="middle" font-size="4" fill="#fff">
                                    <?= round($persenBekerja); ?>%
                                </text>
                                <text x="18" y="22" text-anchor="middle" font-size="2.5" fill="#aaa">
                                    Bekerja
                                </text>
                            </svg>
                            </div>

                            <!-- LEGEND -->
                            <div style="display:flex;justify-content:center;gap:20px;">
                                <div>
                                    <span style="color:#00ffcc;">●</span> Bekerja (<?= $alumniBekerja; ?>)
                                </div>
                                <div>
                                    <span style="color:#ff6b6b;">●</span> Tidak Bekerja (<?= $alumniTidakBekerja; ?>)
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- Reports Section -->
<section class="reports-section" id="reports">
        <section class="dashboard-section">
    <div class="dashboard-container">

        <h2 class="section-title">Data Alumni</h2>

        <!-- CANVAS / CARD DATA ALUMNI -->
        <div class="alumni-card">

            <!-- Header (tombol tambah & search) -->
            <div class="alumni-header">
                <button id="btnTambahAlumni" class="cta-button">
                    + Tambah Alumni
                </button>
            </div>

            <!-- FILTER & SEARCH -->
            <div class="filter-container">
                <div class="search-box">
                    <input type="text" id="searchAlumni" placeholder="Cari alumni berdasarkan nama / NIM">
                </div>

                <div class="filter-group">
                    <select id="filterTahun">
                        <option value="">Semua Tahun Lulus</option>
                        <?php
                        $qTahun = mysqli_query($conn, "SELECT DISTINCT tahun_lulus FROM profil_alumni ORDER BY tahun_lulus DESC");
                        while ($t = mysqli_fetch_assoc($qTahun)) {
                            echo "<option value='{$t['tahun_lulus']}'>{$t['tahun_lulus']}</option>";
                        }
                        ?>
                    </select>

                    <select id="filterProdi">
                        <option value="">Semua Program Studi</option>
                        <?php
                        $qProdi = mysqli_query($conn, "SELECT DISTINCT program_studi FROM profil_alumni ORDER BY program_studi ASC");
                        while ($p = mysqli_fetch_assoc($qProdi)) {
                            echo "<option value='{$p['program_studi']}'>{$p['program_studi']}</option>";
                        }
                        ?>
                    </select>

                    <button id="btnResetFilter" class="filter-btn">Reset Filter</button>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-container">
                <table class="alumni-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Tahun Lulus</th>
                            <th>Program Studi</th>
                            <th>Universitas</th>
                            <th>Pekerjaan</th>
                            <th>Instansi</th>
                            <th>Tanggal Lahir</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
<?php $no = 1; ?>
<?php while ($row = mysqli_fetch_assoc($queryAlumni)) : ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($row['nama']); ?></td>
    <td><?= htmlspecialchars($row['nim']); ?></td>
    <td><?= $row['tahun_lulus']; ?></td>
    <td><?= htmlspecialchars($row['program_studi']); ?></td>
    <td><?= htmlspecialchars($row['asal_universitas']); ?></td>
    <td><?= htmlspecialchars($row['pekerjaan']); ?></td>
    <td><?= htmlspecialchars($row['instansi']); ?></td>
    <td><?= date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></td>
    <td class="text-center">
        <button 
            class="btn-edit"
            data-id="<?= $row['id_alumni']; ?>">
            Edit
        </button>
        <button 
            class="btn-delete-alumni"
            data-id="<?= $row['id_alumni']; ?>"
            data-nama="<?= htmlspecialchars($row['nama']); ?>">
            Hapus
        </button>

    </td>
</tr>
<?php endwhile; ?>

</tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="pagination">
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
            </div>

        </div>
        <!-- END CARD -->

    </div>
</section>

</section>

<!-- Modal Tambah/Edit Alumni -->
<div id="modalAlumni" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Data Alumni</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="formAlumni">

                <h4 style="margin-bottom:10px;color:#00ffcc;">Data Akun Alumni</h4>

            <div class="form-row">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" required>
                </div>
            </div>

            <hr style="border:1px solid rgba(255,255,255,.1);margin:15px 0;">
            <h4 style="margin-bottom:10px;color:#00ffcc;">Data Profil Alumni</h4>

                <input type="hidden" id="alumniId" name="id_alumni">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap *</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="nim">NIM *</label>
                        <input type="text" id="nim" name="nim" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tahun_lulus">Tahun Lulus *</label>
                         <input type="text" id="tahun_lulus" name="tahun_lulus" required>
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Program Studi *</label>
                        <select id="program_studi" name="program_studi" required>
                            <option value="">Pilih Program Studi</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Sipil">Teknik Sipil</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Teknik Arsitektur">Teknik Arsitektur</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="asal_universitas">Universitas Asal *</label>
                        <input type="text" id="asal_universitas" name="asal_universitas" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir *</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" id="pekerjaan" name="pekerjaan">
                    </div>
                    <div class="form-group">
                        <label for="instansi">Instansi</label>
                        <input type="text" id="instansi" name="instansi">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel close-modal">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modalDelete" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus data alumni ini?</p>
            <p id="deleteAlumniName" style="font-weight: bold; color: #ff6b6b;"></p>
            <div class="form-actions">
                <button type="button" class="btn-cancel close-modal">Batal</button>
                <button type="button" class="btn-delete-confirm" id="confirmDelete">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

    <!-- Contact Section -->
    <section id="contact">
    <h2 class="section-title">Manajemen Kuesioner</h2>

    <!-- DAFTAR KUESIONER -->
    <div class="kuesioner-card">
        <h3 class="section-title-judul">Daftar Kuesioner</h3>
        <br>
        <div class="filter-kuesioner">
    <select id="filterTahunKuesioner">
        <option value="">Semua Tahun</option>
        <?php
        $qTahun = mysqli_query($conn, "
            SELECT DISTINCT YEAR(terbit_kusioner) AS tahun
            FROM kusioner
            ORDER BY tahun DESC
        ");
        while ($t = mysqli_fetch_assoc($qTahun)) {
            echo "<option value='{$t['tahun']}'>{$t['tahun']}</option>";
        }
        ?>
    </select>
</div>


       <div class="table-container">
    <table class="alumni-table">
        <thead>
<tr>
    <th class="text-center">No</th>
    <th>Judul Kuesioner</th>
    <th>Deskripsi</th>
    <th class="text-center">Tanggal Terbit</th>
    <th class="text-center">Jumlah Responden</th>
    <th class="text-center">Aksi</th>
</tr>
</thead>
        <tbody>
           <?php 
            $no = 1;
            while ($k = mysqli_fetch_assoc($qKuesioner)) : 
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($k['judul_kusioner']); ?></td>
                    <td><?= nl2br(htmlspecialchars($k['deskripsi'])); ?></td>
                    <td class="text-center">
                        <?= date('d-m-Y', strtotime($k['terbit_kusioner'])); ?>
                    </td>

                    <td class="text-center">
                        <strong><?= $k['total_responden']; ?></strong>
                    </td>
                    <td class="text-center aksi-kuesioner">

                        <!-- LIHAT / ISI PERTANYAAN -->
                        <a 
                        href="lihat_kusioner.php?id=<?= $k['id_kusioner']; ?>" 
                        class="btn-aksi btn-lihat">
                        Lihat
                        </a>

                        <!-- HAPUS (NANTI KITA BUATKAN JS-NYA) -->
                        <a 
                            href="#"
                            class="btn-aksi btn-hapus"
                            data-id="<?= $k['id_kusioner']; ?>"
                            data-judul="<?= htmlspecialchars($k['judul_kusioner']); ?>">
                            Hapus
                        </a>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

    </div>

    <!-- TAMBAH KUESIONER -->
    <div class="kuesioner-card">
  <h3 class="card-title">Tambah Kuesioner Baru</h3>

  <form 
    action="isi_pertanyaan_kusioner.php" 
    method="POST" 
    class="kuesioner-form-full">

    <div class="form-group">
      <label>Judul Kuesioner</label>
      <input 
        type="text" 
        name="judul" 
        placeholder="Masukkan judul kuesioner"
        required>
    </div>

    <div class="form-group">
      <label>Deskripsi</label>
      <textarea 
        name="deskripsi" 
        placeholder="Deskripsi kuesioner"
        required></textarea>
    </div>

    <div class="form-group">
      <label>Jumlah Pertanyaan</label>
      <input 
        type="number" 
        name="jumlah" 
        min="1" 
        max="20" 
        placeholder="Contoh: 10"
        required>
    </div>

    <button type="submit" class="btn-submit">
      Lanjut Isi Pertanyaan
    </button>

  </form>
</div>
</section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
             <p class="copyright">contact admin : safaril@gmail.com . sistem informasi berbasis kusioner. 
            | Designed by Kelompok 9</p>
        </div>
    </footer>

<script src="templatemo-graph-script.js"></script>

<script>
function loadAlumni() {
    const search = document.getElementById('searchAlumni').value;
    const tahun  = document.getElementById('filterTahun').value;
    const prodi  = document.getElementById('filterProdi').value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "filter_alumni.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
    if (this.status === 200) {
        const tbody = document.querySelector(".alumni-table tbody");
        tbody.innerHTML = this.responseText;

        // reset focus biar tombol tidak nyangkut
        if (document.activeElement) {
            document.activeElement.blur();
        }
    }
};
    xhr.send(
        "search=" + encodeURIComponent(search) +
        "&tahun=" + encodeURIComponent(tahun) +
        "&prodi=" + encodeURIComponent(prodi)
    );
}

/* EVENTS */
document.getElementById('searchAlumni').addEventListener('keyup', loadAlumni);
document.getElementById('filterTahun').addEventListener('change', loadAlumni);
document.getElementById('filterProdi').addEventListener('change', loadAlumni);

/* RESET */
document.getElementById('btnResetFilter').addEventListener('click', function () {
    document.getElementById('searchAlumni').value = '';
    document.getElementById('filterTahun').value = '';
    document.getElementById('filterProdi').value = '';
    loadAlumni();
});
</script>

<script>
document.getElementById('formAlumni').addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch('tambah_alumni.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);

        if (data.status === "success") {
            this.reset();
            closeAllModals();   // ⬅️ WAJIB
            loadAlumni();       // reload tabel
        }
    })
    .catch(err => {
        alert("Terjadi kesalahan server");
        console.error(err);
    });
});
</script>

<script>
let selectedAlumniId = null;

document.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;

    e.preventDefault();

    const id = btn.dataset.id;

    fetch('get_alumni.php?id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const a = data.data;

                document.getElementById('modalTitle').innerText = 'Edit Data Alumni';
                document.getElementById('alumniId').value = a.id_alumni;

                // akun
                document.querySelector('[name="username"]').value = a.username;
                document.querySelector('[name="email"]').value = a.email;
                document.querySelector('[name="password"]').required = false;

                // profil
                document.getElementById('nama').value = a.nama;
                document.getElementById('nim').value = a.nim;
                document.getElementById('tahun_lulus').value = a.tahun_lulus;
                document.getElementById('program_studi').value = a.program_studi;
                document.getElementById('asal_universitas').value = a.asal_universitas;
                document.getElementById('tanggal_lahir').value = a.tanggal_lahir;
                document.getElementById('pekerjaan').value = a.pekerjaan;
                document.getElementById('instansi').value = a.instansi;

                document.getElementById('modalAlumni').classList.add('show');
            }
        });
});
/* ================= HAPUS ================= */
document.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-delete-alumni');
    if (!btn) return;

    e.preventDefault();

    selectedAlumniId = btn.dataset.id;
    document.getElementById('deleteAlumniName').innerText =
        btn.dataset.nama;

    document.getElementById('modalDelete').classList.add('show');
});

document.getElementById('confirmDelete').addEventListener('click', function(){
    fetch('hapus_alumni2.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + selectedAlumniId
    })
    .then(res => res.json())
    .then(data => {
    alert(data.message);

    if (data.status === 'success') {
        closeAllModals();   // ⬅️ WAJIB
        loadAlumni();       // reload tabel
    }
});
});

/* ================= MODAL CLOSE ================= */
/* ================= MODAL CLOSE (FIXED) ================= */
document.querySelectorAll('.close-modal').forEach(btn => {
    btn.onclick = () => {
        closeAllModals();   // ⬅️ SATU PINTU SAJA
        selectedAlumniId = null;
    };
});
</script>

<script>
// ================= TAMBAH ALUMNI =================
document.getElementById('btnTambahAlumni').addEventListener('click', function () {
    document.getElementById('modalTitle').innerText = 'Tambah Data Alumni';
    document.getElementById('formAlumni').reset();
    document.getElementById('alumniId').value = '';
    document.querySelector('[name="password"]').required = true;
    document.getElementById('modalAlumni').classList.add('show');
});
</script>

<script>
function closeAllModals() {
    document.querySelectorAll('.modal').forEach(m => {
        m.classList.remove('show');
        m.style.removeProperty('display');
    });

    // reset fokus (SANGAT PENTING)
    if (document.activeElement) {
        document.activeElement.blur();
    }

    // paksa browser reset layer (force reflow)
    document.body.offsetHeight;
}
</script>

<script>
let selectedKuesionerId = null;

document.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-hapus');
    if (!btn) return;

    e.preventDefault();

    if (!confirm(
        'Yakin ingin menghapus kuesioner "' + btn.dataset.judul + '"?\n\n' +
        'Semua pertanyaan & jawaban akan ikut terhapus.'
    )) return;

    fetch('hapus_kusioner.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + btn.dataset.id
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
            location.reload(); // refresh tabel kuesioner
        }
    });
});
</script>
<script>
document.getElementById('filterTahunKuesioner').addEventListener('change', function () {
    const tahun = this.value;

    fetch('filter_kuesioner.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'tahun=' + encodeURIComponent(tahun)
    })
    .then(res => res.text())
    .then(html => {
        document.querySelector('.kuesioner-card .alumni-table tbody').innerHTML = html;
    });
});
</script>

</body>
</html>