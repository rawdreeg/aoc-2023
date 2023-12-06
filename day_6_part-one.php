<?php

function calculateMaxDistance($holdTime, $totalTime) {
    $travelTime = $totalTime - $holdTime;
    return $holdTime * $travelTime;
}

function findWaysToWin($races) {
    $totalWays = 1;

    foreach ($races as $race) {
        $waysToWin = 0;
        for ($holdTime = 0; $holdTime <= $race['time']; $holdTime++) {
            if (calculateMaxDistance($holdTime, $race['time']) > $race['record']) {
                $waysToWin++;
            }
        }
        $totalWays *= $waysToWin;
    }

    return $totalWays;
}

// Define the races
$races = [
    ['time' => 7, 'record' => 9],
    ['time' => 15, 'record' => 40],
    ['time' => 30, 'record' => 200]
];

// Calculate and output the result
echo "Total ways to win: " . findWaysToWin($races);
