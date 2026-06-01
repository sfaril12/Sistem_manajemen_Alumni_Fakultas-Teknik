<?php
include 'koneksi.php';

$id = intval($_POST['id_alumni']);

$query = mysqli_query($conn, "
    UPDATE profil_alumni SET
        nama = '$_POST[nama]',
        nim = '$_POST[nim]',
        tahun_lulus = '$_POST[tahun_lulus]',
        program_studi = '$_POST[program_studi]',
        asal_universitas = '$_POST[asal_universitas]',
        pekerjaan = '$_POST[pekerjaan]',
        instansi = '$_POST[instansi]',
        tanggal_lahir = '$_POST[tanggal_lahir]'
    WHERE id_alumni = '$id'
");

echo $query ? "success" : "error";
