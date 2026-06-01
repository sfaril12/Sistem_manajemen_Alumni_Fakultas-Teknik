<?php
include 'koneksi.php';

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM profil_alumni WHERE id_alumni = '$id'");
$data = mysqli_fetch_assoc($query);

echo json_encode($data);
