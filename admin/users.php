<h2> Data Pengguna </h2>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>

			<th>Email</th>

			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor = 1; ?>
		<?php $ambil = $koneksi->query("SELECT * FROM users"); ?>
		<?php while ($pecah = $ambil->fetch_assoc()) { ?>
			<tr>
				<td>
					<?php echo $nomor; ?>
				</td>
				<td>
					<?php echo $pecah['name']; ?>
				</td>

				<td>
					<?php echo $pecah['email']; ?>
				</td>

				<td>
					<a href="index.php?halaman=hapususers&id=<?php echo $pecah['id']; ?>" class="btn-danger btn">hapus</a>
				</td>

			</tr>
			<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>