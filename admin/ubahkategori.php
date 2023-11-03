<h2>Ubah Ongkir</h2>

<?php
$ambil = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Kategori</label>
        <input type="text" class="form-control" name="nama_kategori" value="<?php echo $pecah['nama_kategori']; ?>">
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>

<?php
if (isset($_POST['ubah'])) {
    $koneksi->query("UPDATE kategori SET nama_kategori='$_POST[nama_kategori]'

		WHERE id_kategori='$_GET[id]'");

    echo "<script>alert('kategori telah diubah');</script>";
    echo "<script>location='index.php?halaman=kategori';</script>";
}
?>