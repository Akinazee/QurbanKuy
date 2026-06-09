<?php
// Update status ambil berdasarkan data 'is_used'
mysqli_query($koneksi, "
    UPDATE peserta p
    JOIN data d ON p.id_peserta = d.id_peserta
    SET p.status_ambil = 'sudah'
    WHERE d.is_used = 1
");

// Ambil data peserta dan nama dari warga
$query_pembagian = mysqli_query($koneksi, "
    SELECT p.id_peserta, p.level, p.jumlah_daging_kg, p.status_ambil, w.nama
    FROM peserta p
    JOIN warga w ON p.nik = w.nik
    ORDER BY p.id_peserta ASC
");
?>

<h3 class="text-center"><i class="bi bi-box-seam"></i> Form Pembagian Daging Qurban</h3>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>ID Peserta</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Jumlah Daging (kg)</th>
                <th>Status Ambil</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($query_pembagian)) :
            $daging = htmlspecialchars($row['jumlah_daging_kg']);
        ?>
            <tr>
                <td class="text-center"><?= $row['id_peserta']; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td class="text-center"><?= htmlspecialchars(ucfirst($row['level'])); ?></td>
                <td class="text-center"><?= $daging; ?></td>
                <td class="text-center">
                    <?php if ($row['status_ambil'] === 'sudah') : ?>
                        <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Sudah</span>
                    <?php else : ?>
                        <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Belum</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>