<?php

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

// Data rating pengguna
$user1_ratings = [
    'Item1' => 5,
    'Item2' => 4,
    'Item3' => 4,
];

$user2_ratings = [
    'Item1' => 5,
    'Item2' => 4,
    'Item3' => 4,
];

$user3_ratings = [
    'Item1' => 5,
    'Item2' => 3,
    'Item3' => 2,
];

$user4_ratings = [
    'Item1' => 4,
    'Item2' => 4,
    'Item3' => 5,
];

$user5_ratings = [
    'Item1' => 4,
    'Item2' => 3,
    'Item3' => 4,
];


// Similaritas antara item dan item lainnya
$item_similarity_scores = [
    'Item1' => [
        'Item2' => 0.166666667,
        'Item3' => 0.666667,
    ],
    'Item2' => [
        'Item1' => 0.166666667,
        'Item3' => -0.588883,
    ],
    'Item3' => [
        'Item1' => 0.666667,
        'Item2' => -0.588883,
    ],
];

$predicted1_ratings = predictWeightedSum($user1_ratings, $item_similarity_scores);
$predicted2_ratings = predictWeightedSum($user2_ratings, $item_similarity_scores);
$predicted3_ratings = predictWeightedSum($user3_ratings, $item_similarity_scores);
$predicted4_ratings = predictWeightedSum($user4_ratings, $item_similarity_scores);
$predicted5_ratings = predictWeightedSum($user5_ratings, $item_similarity_scores);


// Tampilkan hasil prediksi
foreach ($predicted1_ratings as $item => $predicted_rating) {
    echo "$predicted_rating <br>";
}
echo "<br>";

foreach ($predicted2_ratings as $item => $predicted_rating) {
    echo "$predicted_rating <br>";
}
echo "<br>";

foreach ($predicted3_ratings as $item => $predicted_rating) {
    echo "$predicted_rating <br>";
}
echo "<br>";

foreach ($predicted4_ratings as $item => $predicted_rating) {
    echo "$predicted_rating <br>";
}
echo "<br>";

foreach ($predicted5_ratings as $item => $predicted_rating) {
    echo "$predicted_rating <br>";
}

?>