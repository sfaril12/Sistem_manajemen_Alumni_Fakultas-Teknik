<?php
include 'koneksi.php';
mysqli_begin_transaction($conn);

try {
    $id_alumni = $_POST['id_alumni'] ?? null;

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $nama             = $_POST['nama'];
    $nim              = $_POST['nim'];
    $tahun_lulus      = $_POST['tahun_lulus'];
    $program_studi    = $_POST['program_studi'];
    $asal_universitas = $_POST['asal_universitas'];
    $tanggal_lahir    = $_POST['tanggal_lahir'];
    $pekerjaan        = $_POST['pekerjaan'];
    $instansi         = $_POST['instansi'];

    if ($id_alumni) {
        /* ===== EDIT ===== */
        $q = mysqli_query($conn,"SELECT id_user FROM profil_alumni WHERE id_alumni='$id_alumni'");
        $id_user = mysqli_fetch_assoc($q)['id_user'];

        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn,"
                UPDATE users SET 
                username='$username',
                email='$email',
                password='$password'
                WHERE id_user='$id_user'
            ");
        } else {
            mysqli_query($conn,"
                UPDATE users SET 
                username='$username',
                email='$email'
                WHERE id_user='$id_user'
            ");
        }

        mysqli_query($conn,"
            UPDATE profil_alumni SET
            nama='$nama',
            nim='$nim',
            tahun_lulus='$tahun_lulus',
            program_studi='$program_studi',
            asal_universitas='$asal_universitas',
            pekerjaan='$pekerjaan',
            instansi='$instansi',
            tanggal_lahir='$tanggal_lahir'
            WHERE id_alumni='$id_alumni'
        ");

        $msg = "Data alumni berhasil diperbarui";

    } else {
        /* ===== TAMBAH ===== */
        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,"
            INSERT INTO users (username,password,email)
            VALUES ('$username','$password','$email')
        ");
        $id_user = mysqli_insert_id($conn);

        mysqli_query($conn,"
            INSERT INTO profil_alumni
            (id_user,nama,nim,tahun_lulus,program_studi,asal_universitas,pekerjaan,instansi,tanggal_lahir)
            VALUES
            ('$id_user','$nama','$nim','$tahun_lulus','$program_studi',
             '$asal_universitas','$pekerjaan','$instansi','$tanggal_lahir')
        ");

        $msg = "Data alumni berhasil ditambahkan";
    }

    mysqli_commit($conn);
    echo json_encode(["status"=>"success","message"=>$msg]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
?>