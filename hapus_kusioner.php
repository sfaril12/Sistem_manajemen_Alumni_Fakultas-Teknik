<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

include 'koneksi.php';

$id = $_POST['id'] ?? 0;

if (!$id) {
    echo json_encode(['status'=>'error','message'=>'ID tidak valid']);
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM kusioner WHERE id_kusioner = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Kuesioner dan seluruh data terkait berhasil dihapus'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menghapus kuesioner'
    ]);
}
