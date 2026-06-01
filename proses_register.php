<?php
session_start();
include 'koneksi.php';

$username = trim($_POST['username']);
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

if ($username === '' || $email === '' || $password === '') {
    header("Location: buat_akun.php");
    exit;
}

// cek email sudah ada
$cek = mysqli_prepare($conn, "SELECT id_user FROM users WHERE email = ?");
mysqli_stmt_bind_param($cek, "s", $email);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {
    header("Location: buat_akun.php?error=email");
    exit;
}

// hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// simpan user
$stmt = mysqli_prepare($conn,
    "INSERT INTO users (username, email, password)
     VALUES (?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "sss",
    $username,
    $email,
    $password_hash
);
mysqli_stmt_execute($stmt);

// simpan session
$_SESSION['login']   = true;
$_SESSION['id_user'] = mysqli_insert_id($conn);

// arahkan ke input biodata
header("Location: isi_data_alumni.php");
exit;
