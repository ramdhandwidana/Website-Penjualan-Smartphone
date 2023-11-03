<?php
// Include the database connection file
include 'components/connect.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize and store the category ID from the URL
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch the category information from the database
    $select_category = $conn->prepare("SELECT * FROM `kategori` WHERE id_kategori = ?");
    $select_category->execute([$category_id]);
    $category = $select_category->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $category_name = $category['nama_kategori'];

        // Fetch posts that belong to the selected category
        $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id_kategori = ?");
        $select_posts->execute([$category_id]);

        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Category:
                <?= $category_name; ?>
            </title>

            <!-- custom css file link  -->
            <link rel="stylesheet" href="css/style.css">
        </head>

        <body>

            <!-- header section starts  -->
            <?php include 'components/header.php'; ?>
            <!-- header section ends -->


            <!-- Search form section starts -->
            <section class="search-form">
                <div class="heading">
                    <h2>Search Posts</h2>
                </div>
                <form action="pencarian.php" method="GET">
                    <input type="text" name="search_query" placeholder="Search posts...">
                    <button type="submit">Search</button>
                </form>
            </section>
            <!-- Search form section ends -->

            <section class="categories">
                <div class="heading">
                    <h2>Kategori</h2>
                </div>
                <div class="category-container">
                    <?php
                    echo "<a href='all_posts.php' class='category'>All</a>";
                    $select_categories = $conn->prepare("SELECT * FROM `kategori`");
                    $select_categories->execute();
                    while ($category = $select_categories->fetch(PDO::FETCH_ASSOC)) {
                        echo "<a href='category.php?id={$category['id_kategori']}' class='category'>{$category['nama_kategori']}</a>";
                    }
                    ?>
                </div>
            </section>

            <section class="all-posts">
                <div class="heading">
                    <h2>Kategory:
                        <?= $category_name; ?>
                    </h2>
                </div>
                <div class="box-container">
                    <?php
                    if ($select_posts->rowCount() > 0) {
                        while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                            // Display the posts belonging to the selected category
                            $post_id = $fetch_post['id'];

                            $total_ratings = 0;
                            $rating_1 = 0;
                            $rating_2 = 0;
                            $rating_3 = 0;
                            $rating_4 = 0;
                            $rating_5 = 0;

                            $count_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE id = ?");
                            $count_reviews->execute([$post_id]);
                            $avg_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
                            $avg_reviews->execute([$fetch_post['id']]);
                            $total_reviews = $avg_reviews->rowCount();
                            while ($fetch_rating = $avg_reviews->fetch(PDO::FETCH_ASSOC)) {
                                $total_ratings += $fetch_rating['rating'];
                                if ($fetch_rating['rating'] == 1) {
                                    $rating_1 += $fetch_rating['rating'];
                                }
                                if ($fetch_rating['rating'] == 2) {
                                    $rating_2 += $fetch_rating['rating'];
                                }
                                if ($fetch_rating['rating'] == 3) {
                                    $rating_3 += $fetch_rating['rating'];
                                }
                                if ($fetch_rating['rating'] == 4) {
                                    $rating_4 += $fetch_rating['rating'];
                                }
                                if ($fetch_rating['rating'] == 5) {
                                    $rating_5 += $fetch_rating['rating'];
                                }
                            }

                            if ($total_reviews != 0) {
                                $average = round($total_ratings / $total_reviews, 1);
                            } else {
                                $average = 0;
                            }

                            echo "<div class='box'>";
                            echo "<img src='uploaded_files/{$fetch_post['image']}' alt='' class='image'>";
                            echo "<h3 class='title'>{$fetch_post['title']}</h3>";
                            echo "<p class='total-reviews'><i class='fas fa-star'></i> <span>{$average}</span></p>";
                            echo "<a href='view_post.php?get_id={$post_id}' class='inline-btn'>view post</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p class='empty'>No posts found in this category!</p>";
                    }
                    ?>
                </div>
            </section>

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

            <!-- footer section starts -->
            <?php include 'components/footer.php'; ?>
            <!-- footer section ends -->

            <!-- sweetalert cdn link  -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

            <!-- custom js file link  -->
            <script src="js/script.js"></script>

            <?php include 'components/alers.php'; ?>

        </body>

        </html>

        <?php
    } else {
        // Redirect to some error page if the category ID is invalid or not found
        header("Location: error.php");
        exit;
    }
} else {
    // Redirect to some error page if the 'id' parameter is not set in the URL
    header("Location: error.php");
    exit;
}
?>