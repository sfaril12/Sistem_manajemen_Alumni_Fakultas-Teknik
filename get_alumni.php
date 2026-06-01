<?php
include 'koneksi.php';

$id = $_GET['id'];

$q = mysqli_query($conn, "
    SELECT 
        pa.*,
        u.username,
        u.email
    FROM profil_alumni pa
    JOIN users u ON pa.id_user = u.id_user
    WHERE pa.id_alumni = '$id'
");

$data = mysqli_fetch_assoc($q);

if ($data) {
    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
} else {
    echo json_encode(["status" => "error"]);
}
