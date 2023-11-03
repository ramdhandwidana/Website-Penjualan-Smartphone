<?php

include 'components/connect.php';

function calculatePearsonCorrelationSimilarity($x, $y)
{
    // Calculate Pearson correlation based similarity between two arrays $x and $y
    $n = count($x);

    // Calculate the average of arrays $x and $y
    $avg_x = array_sum($x) / $n;
    $avg_y = array_sum($y) / $n;

    // Calculate Pearson correlation similarity
    $numerator = 0;
    $denominator_x = 0;
    $denominator_y = 0;

    for ($i = 0; $i < $n; $i++) {
        $x_dev = $x[$i] - $avg_x;
        $y_dev = $y[$i] - $avg_y;
        $numerator += $x_dev * $y_dev;
        $denominator_x += pow($x_dev, 2);
        $denominator_y += pow($y_dev, 2);
    }

    if ($denominator_x == 0 || $denominator_y == 0) {
        return 0;
    }

    $similarity = $numerator / sqrt($denominator_x * $denominator_y);
    return $similarity;
}

// Get all items
$select_items = $conn->prepare("SELECT DISTINCT post_id FROM `reviews`");
$select_items->execute();
$all_items = array();
while ($row = $select_items->fetch(PDO::FETCH_ASSOC)) {
    $all_items[] = $row['post_id'];
}

// Calculate item-item similarity
$item_similarity_scores = array();

foreach ($all_items as $item_A) {
    foreach ($all_items as $item_B) {
        if ($item_A != $item_B) {
            // Get ratings for item A and item B
            $ratings_item_A = array();
            $ratings_item_B = array();

            $select_ratings_A = $conn->prepare("SELECT user_id, rating FROM `reviews` WHERE post_id = ?");
            $select_ratings_A->execute([$item_A]);
            while ($row = $select_ratings_A->fetch(PDO::FETCH_ASSOC)) {
                $ratings_item_A[$row['user_id']] = $row['rating'];
            }

            $select_ratings_B = $conn->prepare("SELECT user_id, rating FROM `reviews` WHERE post_id = ?");
            $select_ratings_B->execute([$item_B]);
            while ($row = $select_ratings_B->fetch(PDO::FETCH_ASSOC)) {
                $ratings_item_B[$row['user_id']] = $row['rating'];
            }

            // Calculate Pearson correlation similarity between item A and item B
            $similarity_score = calculatePearsonCorrelationSimilarity(
                array_values($ratings_item_A),
                array_values($ratings_item_B)
            );

            // Store the similarity score
            $item_similarity_scores[$item_A][$item_B] = $similarity_score;
        }
    }
}

// Now, $item_similarity_scores contains the similarity scores between all pairs of items.

// Define the predictWeightedSum function
function predictWeightedSum($user_ratings, $item_similarity_scores)
{
    $weighted_sum = array();

    foreach ($item_similarity_scores as $item_A => $similarities) {
        $numerator = 0;
        $denominator = 0;

        foreach ($similarities as $item_B => $similarity) {
            if (isset($user_ratings[$item_B])) {
                $numerator += $user_ratings[$item_B] * $similarity;
                $denominator += abs($similarity);
            }
        }

        if ($denominator == 0) {
            $predicted_rating = 0;
        } else {
            $predicted_rating = $numerator / $denominator;
        }

        $weighted_sum[$item_A] = $predicted_rating;
    }

    return $weighted_sum;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- header section starts  -->
    <?php include 'components/header.php'; ?>
    <!-- header section ends -->

    <!-- view recommended posts section starts  -->

    <section class="all-posts">

        <div class="heading">
            <h2>Rekomendasi Smartphone</h2>
            <h3>Beberapa Rekomendasi Smartphone Untuk Anda Berdasarkan Rating Pengguna</h3>
        </div>

        <div class="box-container">

            <?php
            // Session ID Login
            $user_id != '';

            // Get user ratings from the database
            $user_ratings_query = $conn->prepare("SELECT post_id, rating FROM `reviews` WHERE user_id = ?");
            $user_ratings_query->execute([$user_id]);
            $user_ratings = array();

            while ($row = $user_ratings_query->fetch(PDO::FETCH_ASSOC)) {
                $post_id = $row['post_id'];
                $rating = $row['rating'];

                // Check if the post_id exists and if the rating is set
                if (!empty($post_id) && isset($rating)) {
                    $user_ratings[$post_id] = $rating;
                }
            }

            // Check if the user has given any ratings
            if (count($user_ratings) == 0) {
                echo "<p>Anda belum memberi rating pada produk apapun. Silakan beri rating terlebih dahulu untuk menerima rekomendasi.</p>";
            } else {
                // Get item recommendations using predictWeightedSum
                $predicted_ratings = predictWeightedSum($user_ratings, $item_similarity_scores);

                // Sort the predicted ratings in descending order to get recommendations
                arsort($predicted_ratings);

                // Get the top 5 most similar users (users with highest similarity scores)
                $predicted_ratings = array_slice($predicted_ratings, 0, 6, true);

                // Display the recommended items
                foreach ($predicted_ratings as $item_id => $predicted_rating) {
                    $select_item = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
                    $select_item->execute([$item_id]);
                    $fetch_item = $select_item->fetch(PDO::FETCH_ASSOC);

                    echo "<div class='box'>";
                    //echo "<img src='uploaded_files/" . $fetch_item['image'] . "' alt='' class='image'>";
                    //echo "<h3 class='title'>" . $fetch_item['title'] . "</h3>";
                    echo "<p class='predicted-rating'><i class='fas fa-star'></i> <span>" . $predicted_rating . "</span></p>";
                    //echo "<a href='view_post.php?get_id=" . $item_id . "' class='inline-btn'>View Item</a>";
                    echo "</div>";
                }
            }


            ?>

        </div>

    </section>

    <!-- view recommended posts section ends -->

    <!-- sweetalert cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <!-- Lanjutkan kodingan jika ada bagian lainnya -->
</body>

</html>