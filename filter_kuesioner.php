<?php
include 'koneksi.php';

$tahun = $_POST['tahun'] ?? '';

$where = '';
if ($tahun !== '') {
    $where = "WHERE YEAR(k.terbit_kusioner) = '$tahun'";
}

$query = mysqli_query($conn, "
    SELECT 
        k.id_kusioner,
        k.judul_kusioner,
        k.deskripsi,
        k.terbit_kusioner,
        COUNT(DISTINCT j.id_user) AS total_responden
    FROM kusioner k
    LEFT JOIN pertanyaan p ON p.id_kusioner = k.id_kusioner
    LEFT JOIN jawaban j ON j.id_pertanyaan = p.id_pertanyaan
    $where
    GROUP BY k.id_kusioner
    ORDER BY k.terbit_kusioner DESC
");

$no = 1;
while ($k = mysqli_fetch_assoc($query)) :
?>
<tr>
    <td class="text-center"><?= $no++; ?></td>
    <td><?= htmlspecialchars($k['judul_kusioner']); ?></td>
    <td><?= nl2br(htmlspecialchars($k['deskripsi'])); ?></td>
    <td class="text-center"><?= date('d-m-Y', strtotime($k['terbit_kusioner'])); ?></td>
    <td class="text-center"><strong><?= $k['total_responden']; ?></strong></td>
    <td class="text-center aksi-kuesioner">
        <a href="lihat_kusioner.php?id=<?= $k['id_kusioner']; ?>" class="btn-aksi btn-lihat">Lihat</a>
        <a href="#" class="btn-aksi btn-hapus"
           data-id="<?= $k['id_kusioner']; ?>"
           data-judul="<?= htmlspecialchars($k['judul_kusioner']); ?>">
           Hapus
        </a>
    </td>
</tr>
<?php endwhile; ?>
