<?php

function calculateMaxDistance($holdTime, $totalTime) {
    $travelTime = $totalTime - $holdTime;
    return $holdTime * $travelTime;
}

function findWaysToWinSingleRace($time, $record) {
    $waysToWin = 0;
    for ($holdTime = 0; $holdTime <= $time; $holdTime++) {
        if (calculateMaxDistance($holdTime, $time) > $record) {
            $waysToWin++;
        }
    }
    return $waysToWin;
}

// Define the single race details
$time = 71530;       // Total time of the race in milliseconds
$record = 940200;    // Record distance to beat in millimeters

// Calculate and output the result
echo "Ways to win the race: " . findWaysToWinSingleRace($time, $record);
