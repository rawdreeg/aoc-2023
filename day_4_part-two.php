<?php

$scratchcards = [
    "41 48 83 86 17 | 83 86  6 31 17  9 48 53",
    "13 32 20 16 61 | 61 30 68 82 17 32 24 19",
    "1 21 53 59 44 | 69 82 63 72 16 21 14  1",
    "41 92 73 84 69 | 59 84 76 51 58  5 54 83",
    "87 83 26 28 32 | 88 30 70 12 93 22 82 36",
    "31 18 13 56 72 | 74 77 10 23 35 67 36 11"
];

function calculateMatches($card) {
    // Split the card into two parts: winning numbers and your numbers
    list($winningNumbers, $yourNumbers) = explode('|', $card);

    $winningNumbers = array_map('trim', explode(' ', trim($winningNumbers)));
    $yourNumbers = array_map('trim', explode(' ', trim($yourNumbers)));

    $matches = 0;
    foreach ($winningNumbers as $number) {
        if (in_array($number, $yourNumbers)) {
            $matches++;
        }
    }

    return $matches;
}

$matches = [];
$totalCards = count($scratchcards);
$cardQueue = new SplQueue(); 

foreach ($scratchcards as $index => $card) {
    $matches[$index] = calculateMatches($card); 
    $cardQueue->enqueue($index);
}

$processedCounts = array_fill(0, $totalCards, 0); 

while (!$cardQueue->isEmpty()) {
    $currentIndex = $cardQueue->dequeue();
    $processedCounts[$currentIndex]++;

    $newWins = $matches[$currentIndex];

    for ($i = 1; $i <= $newWins; $i++) {
        if ($currentIndex + $i < $totalCards) {
            $cardQueue->enqueue($currentIndex + $i);
        }
    }
}

$totalScratchcards = array_sum($processedCounts); 
echo $totalScratchcards;
