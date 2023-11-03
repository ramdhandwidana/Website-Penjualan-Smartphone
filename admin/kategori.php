<h3>Kategori</h3>
<hr>

<?php
$semuadata = array();
$ambil = $koneksi->query("SELECT * FROM kategori ");
while ($tiap = $ambil->fetch_assoc()) {
    $semuadata[] = $tiap;
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <td>Kategori</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($semuadata as $key => $value): ?>
            <tr>
                <td>
                    <?php echo $key + 1 ?>
                </td>
                <td>
                    <?php echo $value["nama_kategori"] ?>
                </td>
                <td>
                    <a href="index.php?halaman=ubahkategori&id=<?php echo $value['id_kategori']; ?>"
                        class="btn btn-warning">ubah</a>
                    <a href="index.php?halaman=hapuskategori&id=<?php echo $value['id_kategori']; ?>"
                        class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<a href="index.php?halaman=tambahkategori" class="btn btn-default">Tambah Data</a>