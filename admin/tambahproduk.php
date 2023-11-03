<?php
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
	$datakategori[] = $tiap;
}
?>
<h2>Tambah Produk</h2>

<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>ID</label>
		<input type="text" class="form-control" name="id">
	</div>
	<div class="form-group">
		<label>Kategori</label>
		<select class="form-control" name="id_kategori">
			<option value="">Pilih Kategori</option>
			<?php foreach ($datakategori as $key => $value): ?>
				<option value=" <?php echo $value["id_kategori"] ?>"><?php echo $value["nama_kategori"] ?></option>
			<?php endforeach ?>
		</select>
	</div>

	<div class="form-group">
		<label>Nama</label>
		<input type="text" class="form-control" name="title">
	</div>

	<div class="form-group">
		<label>Foto</label>
		<input type="file" class="form-control" name="image">
	</div>
	<div class="form-group">
		<label>Deskripsi</label>
		<textarea class="ckeditor" id="ckeditor" name="description"></textarea>
	</div>

	<div class="form-group">
		<label>Range Harga</label>
		<input type="text" class="form-control" name="harga">
	</div>


	<button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php

if (isset($_POST['save'])) {

	$id = $_POST['id'];
	$id_kategori = $_POST['id_kategori'];
	$title = $_POST['title'];
	$image = $_FILES['image']['name'];
	$lokasi = $_FILES['image']['tmp_name'];

	$description = $_POST['description'];
	$harga = $_POST['harga'];
	move_uploaded_file($lokasi, "../uploaded_files/" . $image);

	$mysqli = "INSERT INTO posts (id,id_kategori,title,image,description,harga)
  VALUES ('$id','$id_kategori', '$title', '$image', '$description', '$harga')";

	$result = mysqli_query($koneksi, $mysqli);

	if ($result) {

		echo "<div class='alert alert-info'>Tersimpan</div>";

		echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";

	} else {

		echo "Input gagal";

	}

	mysqli_close($koneksi);

}

?>



<script type="text/javascript" src="ckeditor/ckeditor.js"></script>