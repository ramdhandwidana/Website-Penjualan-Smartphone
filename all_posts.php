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

   <!-- view all posts section starts  -->

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
         <h2>Smartphone</h2>
      </div>


      <div class="box-container">

         <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts`");
         $select_posts->execute();
         if ($select_posts->rowCount() > 0) {
            while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {

               $post_id = $fetch_post['id'];

               $total_ratings = 0;
               $rating_1 = 0;
               $rating_2 = 0;
               $rating_3 = 0;
               $rating_4 = 0;
               $rating_5 = 0;

               $count_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
               $count_reviews->execute([$fetch_post['id']]);
               $total_reviews = $count_reviews->rowCount();
               while ($fetch_rating = $count_reviews->fetch(PDO::FETCH_ASSOC)) {
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
               ?>
               <div class="box">
                  <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
                  <h3 class="title">
                     <?= $fetch_post['title']; ?>
                  </h3>
                  <p class="total-reviews"><i class="fas fa-star"></i> <span>
                        <?= $average; ?>
                     </span></p>
                  <a href="view_post.php?get_id=<?= $post_id; ?>" class="inline-btn">view post</a>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty">no posts added yet!</p>';
         }
         ?>

      </div>

   </section>

   <!-- view all posts section ends -->



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

</body>

</html>