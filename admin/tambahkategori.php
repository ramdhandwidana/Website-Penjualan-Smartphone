<h2>Tambah Kategori</h2>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" name="nama_kategori">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php

if (isset($_POST['save'])) {


    $nama_kategori = $_POST['nama_kategori'];

    $mysqli = "INSERT INTO kategori (nama_kategori)
  VALUES ('$nama_kategori')";

    $result = mysqli_query($koneksi, $mysqli);

    if ($result) {
        echo "<div class='alert alert-info'>Data Tersimpan</div>";
        echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=kategori'>";
    } else {
        echo "Input gagal";
    }
    mysqli_close($koneksi);
}
?>