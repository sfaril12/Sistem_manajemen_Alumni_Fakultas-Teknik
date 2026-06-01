<?php
include 'koneksi.php';

$id = intval($_POST['id_alumni']);
$query = mysqli_query($conn, "DELETE FROM profil_alumni WHERE id_alumni='$id'");

echo $query ? "success" : "error";
