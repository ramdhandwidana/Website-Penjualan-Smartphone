<?php
include 'koneksi.php';
?>

<h2> Data Produk </h2>


<a href="index.php?halaman=tambahproduk" class="btn btn-primary">Tambah Data</a>
<br><br>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>ID</th>
			<th>Kategori</th>
			<th>Nama</th>

			<th>Foto</th>
			<th>Deskripsi</th>

			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor = 1; ?>
		<?php $ambil = $koneksi->query("SELECT * FROM posts LEFT JOIN kategori ON posts.id_kategori=kategori.id_kategori"); ?>
		<?php while ($pecah = $ambil->fetch_assoc()) { ?>
			<tr>
				<td>
					<?php echo $nomor; ?>
				</td>
				<td>
					<?php echo $pecah["id"]; ?>
				</td>
				<td>
					<?php echo $pecah["nama_kategori"]; ?>
				</td>
				<td>
					<?php echo $pecah['title']; ?>
				</td>
				<td>
					<img src="../uploaded_files/<?php echo $pecah['image']; ?>" width="100">
				</td>

				<td>
					<?php echo $pecah['description']; ?>
				</td>

				<td>
					<a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id']; ?>" class="btn-danger btn">hapus</a>
					<a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id']; ?>" class="btn btn-warning">ubah</a>
				</td>

			</tr>
			<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>