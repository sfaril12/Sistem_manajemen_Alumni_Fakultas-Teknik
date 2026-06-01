<?php
include 'koneksi.php';

$where = [];
$params = [];

/* SEARCH */
if (!empty($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $where[] = "(nama LIKE '%$search%' OR nim LIKE '%$search%')";
}

/* FILTER TAHUN */
if (!empty($_POST['tahun'])) {
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $where[] = "tahun_lulus = '$tahun'";
}

/* FILTER PRODI */
if (!empty($_POST['prodi'])) {
    $prodi = mysqli_real_escape_string($conn, $_POST['prodi']);
    $where[] = "program_studi = '$prodi'";
}

/* QUERY FINAL */
$sql = "
SELECT 
    id_alumni,
    nama,
    nim,
    tahun_lulus,
    program_studi,
    asal_universitas,
    pekerjaan,
    instansi,
    tanggal_lahir
FROM profil_alumni
";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY id_alumni DESC";

$query = mysqli_query($conn, $sql);

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($row['nama']); ?></td>
    <td><?= htmlspecialchars($row['nim']); ?></td>
    <td><?= $row['tahun_lulus']; ?></td>
    <td><?= htmlspecialchars($row['program_studi']); ?></td>
    <td><?= htmlspecialchars($row['asal_universitas']); ?></td>
    <td><?= htmlspecialchars($row['pekerjaan']); ?></td>
    <td><?= htmlspecialchars($row['instansi']); ?></td>
    <td><?= date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></td>
    <td class="text-center">
    <!-- Tombol EDIT (boleh tetap) -->
    <button 
        class="btn-edit"
        data-id="<?= $row['id_alumni']; ?>">
        Edit
    </button>

    <!-- Tombol HAPUS (INI YANG PENTING) -->
    <button
        class="btn-delete-alumni"
        data-id="<?= $row['id_alumni']; ?>"
        data-nama="<?= htmlspecialchars($row['nama']); ?>">
        Hapus
    </button>
</td>
</tr>
<?php } ?>
