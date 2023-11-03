<?php

function calculatePearsonCorrelationSimilarity($product1, $product2)
{
    $n = count($product1);

    // Calculate the average rating for each product
    $avg_product1 = array_sum($product1) / $n;
    $avg_product2 = array_sum($product2) / $n;

    // Calculate Pearson correlation similarity
    $numerator = 0;
    $denominator_x = 0;
    $denominator_y = 0;

    for ($i = 0; $i < $n; $i++) {
        $x_dev = $product1[$i] - $avg_product1;
        $y_dev = $product2[$i] - $avg_product2;
        $numerator += $x_dev * $y_dev;
        $denominator_x += pow($x_dev, 2);
        $denominator_y += pow($y_dev, 2);
    }

    $denominator = sqrt($denominator_x * $denominator_y);

    if ($denominator == 0) {
        return 0;
    }

    $similarity = $numerator / $denominator;
    return $similarity;
}

// Fungsi untuk menghitung prediksi weighted sum
function predictWeightedSum($user_ratings, $correlations, $product_ratings)
{
    $numerator = 0;
    $denominator = 0;

    for ($i = 0; $i < count($correlations); $i++) {
        if ($user_ratings[$i] != 0) {
            $numerator += $correlations[$i] * $user_ratings[$i];
            $denominator += abs($correlations[$i]);
        }
    }

    if ($denominator == 0) {
        return 0; // Handle division by zero
    }

    return $numerator / $denominator;
}

// Data rating produk
$rating_produk_1 = [5, 5, 5, 4, 4];
$rating_produk_2 = [4, 4, 3, 4, 3];
$rating_produk_3 = [4, 4, 2, 5, 4];

// Korelasi antara produk 1 dan produk 2, produk 1 dan produk 3, produk 2 dan produk 3 (dalam urutan yang sama)
$correlation_12 = calculatePearsonCorrelationSimilarity($rating_produk_1, $rating_produk_2);
$correlation_13 = calculatePearsonCorrelationSimilarity($rating_produk_1, $rating_produk_3);
$correlation_23 = calculatePearsonCorrelationSimilarity($rating_produk_2, $rating_produk_3);

echo $correlation_12 . "<br>";
echo $correlation_13 . "<br>";
echo $correlation_23 . "<br>";


?>