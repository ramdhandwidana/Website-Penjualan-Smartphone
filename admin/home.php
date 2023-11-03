<?php

include 'koneksi.php'
    ?>

<?php

$ambil1 = $koneksi->query("SELECT * FROM users");
$count1 = mysqli_num_rows($ambil1);

$ambil2 = $koneksi->query("SELECT * FROM posts");
$count2 = mysqli_num_rows($ambil2);

$ambil3 = $koneksi->query("SELECT * FROM reviews");
$count3 = mysqli_num_rows($ambil3);



$id_admin = $_SESSION["admin"]["id_admin"];
$ambil = $koneksi->query("SELECT * FROM admin WHERE id_admin='$id_admin' ");
$detail = $ambil->fetch_assoc();
?>

<h2>Selamat Datang,
    <?php echo $detail["username"]; ?>
</h2>

<!-- /. ROW  -->
<hr />
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-6">
        <a href="index.php?halaman=users">
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-envelope-o"></i>
                </span>
                <div class="text-box">
                    <p class="main-text">
                        <?php echo $count1; ?>
                    </p>
                    <p class="text-muted">Pengguna</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
        <a href="index.php?halaman=produk">
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                <div class="text-box">
                    <p class="main-text">
                        <?php echo $count2; ?>
                    </p>
                    <p class="text-muted">Produk</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
        <a href="">
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box">
                    <p class="main-text">
                        <?php echo $count3; ?>
                    </p>
                    <p class="text-muted">Reviews</p>
                </div>
            </div>
        </a>
    </div>

</div>