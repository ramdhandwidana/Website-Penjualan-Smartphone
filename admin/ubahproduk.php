<h2>Ubah Produk</h2>

<?php
$ambil = $koneksi->query("SELECT * FROM posts WHERE id='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
?>

<?php
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
	$datakategori[] = $tiap;
}
?>

<form method="post" enctype="multipart/form-data">
	<div class="forms-group">
		<label for="">ID</label>
		<input type="text" class="form-control" name="id" value="<?php echo $pecah['id']; ?>">
	</div>
	<div class="form-group">
		<label>Kategori</label>
		<select class="form-control" name="id_kategori" id="">
			<option value="">Pilih Kategori</option>
			<?php foreach ($datakategori as $key => $value): ?>
				<option value="<?php echo $value["id_kategori"] ?>" <?php if ($pecah["id_kategori"] == $value["id_kategori"]) {
					   echo "selected";
				   } ?>>
					<?php echo $value["nama_kategori"] ?>
				</option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="form-group">
		<label>nama</label>
		<input type="text" class="form-control" name="title" value="<?php echo $pecah['title']; ?>">
	</div>

	<div class="form-group">
		<img src="../uploaded_files/<?php echo $pecah['image'] ?>" width="200">
	</div>
	<div class="form-group">
		<label>Ganti Foto</label>
		<input type="file" class="form-control" name="image">
	</div>

	<div class="form-group">
		<label>Range Harga</label>
		<input type="text" class="form-control" name="harga" value="<?php echo $pecah['harga']; ?>">
	</div>

	<div class="form-group">
		<label>Deskripsi</label>
		<textarea class="ckeditor" id="ckeditor" name="description"><?php echo $pecah['description']; ?></textarea>
	</div>


	<button class="btn btn-primary" name="ubah">Ubah</button>
</form>

<?php
if (isset($_POST['ubah'])) {

	$namafoto = $_FILES['image']['name'];
	$lokasifoto = $_FILES['image']['tmp_name'];

	if (!empty($lokasifoto)) {
		move_uploaded_file($lokasifoto, "../uploaded_files/$namafoto");

		$koneksi->query("UPDATE posts SET id='$_POST[id]',id_kategori='$_POST[id_kategori]',image='$namafoto', title='$_POST[title]', harga='$_POST[harga]',
			description='$_POST[description]'
			WHERE id='$_GET[id]'");
	} else {
		$koneksi->query("UPDATE posts SET id='$_POST[id]',id_kategori='$_POST[id_kategori]', title='$_POST[title]', harga='$_POST[harga]',
			description='$_POST[description]'
			WHERE id='$_GET[id]'");
	}

	echo "<script>alert('dataproduk telah diubah');</script>";
	echo "<script>location='index.php?halaman=produk';</script>";
}

?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>