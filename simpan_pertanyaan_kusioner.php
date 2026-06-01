<?php
session_start();
include 'koneksi.php';

$judul      = $_POST['judul'];
$deskripsi  = $_POST['deskripsi'];
$pertanyaan = $_POST['pertanyaan'];

mysqli_begin_transaction($conn);

try {

    /* ================= SIMPAN KUESIONER ================= */
    $stmt = mysqli_prepare($conn,
        "INSERT INTO kusioner (judul_kusioner, deskripsi, terbit_kusioner)
         VALUES (?, ?, NOW())"
    );
    mysqli_stmt_bind_param($stmt, "ss", $judul, $deskripsi);
    mysqli_stmt_execute($stmt);

    $id_kusioner = mysqli_insert_id($conn);

    /* ================= SIMPAN PERTANYAAN ================= */
    foreach ($pertanyaan as $p) {

        $stmt = mysqli_prepare($conn,
            "INSERT INTO pertanyaan 
            (id_kusioner, text_pertanyaan, tipe_pertanyaan)
            VALUES (?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "iss",
            $id_kusioner,
            $p['text'],
            $p['tipe']
        );
        mysqli_stmt_execute($stmt);

        $id_pertanyaan = mysqli_insert_id($conn);

        /* ================= SIMPAN OPSI RADIO ================= */
        if ($p['tipe'] === 'radio') {
            $jumlah_opsi = (int)$p['jumlah_opsi'];

            for ($i = 1; $i <= $jumlah_opsi; $i++) {
                if (!empty($p['opsi'][$i])) {

                    $stmtO = mysqli_prepare($conn,
                        "INSERT INTO opsi_radio
                        (id_pertanyaan, label_opsi, value_opsi, urutan)
                        VALUES (?, ?, ?, ?)"
                    );
                    mysqli_stmt_bind_param(
                        $stmtO,
                        "issi",
                        $id_pertanyaan,
                        $p['opsi'][$i],
                        $p['opsi'][$i],
                        $i
                    );
                    mysqli_stmt_execute($stmtO);
                }
            }
        }
    }

    mysqli_commit($conn);
    header("Location: admin.php#contact");
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Gagal menyimpan kuesioner";
}
