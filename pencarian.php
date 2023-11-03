<?php
include 'components/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Rekomendasi</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- header section starts  -->
    <?php include 'components/header.php'; ?>
    <!-- header section ends -->

    <!-- view search results section starts  -->

    <section class="all-posts">
        <div class="heading">
            <h1>Hasil Pencarian</h1>
        </div>

        <div class="box-container">
            <?php
            if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                $search_query = $_GET['search_query'];
                $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE title LIKE ? OR description LIKE ? OR harga LIKE ? OR kategori LIKE ?");
                $select_posts->execute(["%$search_query%", "%$search_query%"]);

                if ($select_posts->rowCount() > 0) {
                    while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                        $post_id = $fetch_post['id'];

                        $count_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
                        $count_reviews->execute([$post_id]);
                        $total_reviews = $count_reviews->rowCount();
                        ?>
                        <div class="box">
                            <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
                            <h3 class="title">
                                <?= $fetch_post['title']; ?>
                            </h3>
                            <p class="total-reviews"><i class="fas fa-star"></i> <span>
                                    <?= $total_reviews; ?>
                                </span></p>
                            <a href="view_post.php?get_id=<?= $post_id; ?>" class="inline-btn">view post</a>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="empty">No posts found for your search query!</p>';
                }
            } else {
                echo '<p class="empty">Please enter a search query!</p>';
            }
            ?>
        </div>
    </section>

    <!-- view search results section ends -->


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php include 'components/footer.php'; ?>


    <!-- sweetalert cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <?php include 'components/alers.php'; ?>
    <?php include 'components/footer.php'; ?>

</body>

</html>