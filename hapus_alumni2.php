<?php
include 'koneksi.php';

$id = $_POST['id'];

$q = mysqli_query($conn,"SELECT id_user FROM profil_alumni WHERE id_alumni='$id'");
$data = mysqli_fetch_assoc($q);

if ($data) {
    mysqli_query($conn,"DELETE FROM profil_alumni WHERE id_alumni='$id'");
    mysqli_query($conn,"DELETE FROM users WHERE id_user='{$data['id_user']}'");

    echo json_encode([
        "status" => "success",
        "message" => "Data alumni berhasil dihapus"
    ]);
}
