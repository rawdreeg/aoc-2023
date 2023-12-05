<?php

$scratchcards = [
    "41 48 83 86 17 | 83 86  6 31 17  9 48 53",
    "13 32 20 16 61 | 61 30 68 82 17 32 24 19",
    "1 21 53 59 44 | 69 82 63 72 16 21 14  1",
    "41 92 73 84 69 | 59 84 76 51 58  5 54 83",
    "87 83 26 28 32 | 88 30 70 12 93 22 82 36",
    "31 18 13 56 72 | 74 77 10 23 35 67 36 11"
];

function calculatePoints($scratchcards) {
    $totalPoints = 0;

    foreach ($scratchcards as $card) {
        list($winningNumbers, $elfNumbers) = explode(' | ', $card);
        $winningNumbers = explode(' ', trim($winningNumbers));
        $elfNumbers = explode(' ', trim($elfNumbers));

        $matches = 0;
        foreach ($elfNumbers as $number) {
            if (in_array($number, $winningNumbers)) {
                $matches++;
            }
        }

        $points = $matches > 0 ? pow(2, $matches - 1) : 0;
        $totalPoints += $points;
    }

    return $totalPoints;
}

echo calculatePoints($scratchcards);
?>
