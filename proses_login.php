<?php
session_start();
require_once "koneksi.php";

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: loginakun.php?error=kosong");
    exit;
}

/* Cari user berdasarkan email */
$query = mysqli_prepare(
    $conn,
    "SELECT id_user, username, password FROM users WHERE email = ?"
);
mysqli_stmt_bind_param($query, "s", $email);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    /* ⚠️ sementara plain-text (sesuai database kamu) */
    if ($password === $user['password']) {

        $_SESSION['login']   = true;
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email']   = $email;

        header("Location: halutama.php");
        exit;

    } else {
        header("Location: loginakun.php?error=password");
        exit;
    }

} else {
    header("Location: loginakun.php?error=email");
    exit;
}
