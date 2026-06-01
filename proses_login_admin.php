<?php
session_start();
include 'koneksi.php';

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    header("Location: loginadmin.php");
    exit;
}

/* QUERY ADMIN */
$query = mysqli_prepare(
    $conn,
    "SELECT id_admin, nama, pasword FROM admins WHERE email = ? LIMIT 1"
);
mysqli_stmt_bind_param($query, "s", $email);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$admin  = mysqli_fetch_assoc($result);

/* CEK LOGIN */
if ($admin && $password === $admin['pasword']) {

    // SET SESSION
    $_SESSION['admin_login'] = true;
    $_SESSION['admin_id']    = $admin['id_admin'];
    $_SESSION['admin_nama']  = $admin['nama'];

    // REDIRECT KE DASHBOARD
    header("Location: admin.php");
    exit;
}

/* JIKA GAGAL */
header("Location: loginadmin.php?error=1");
exit;
?>