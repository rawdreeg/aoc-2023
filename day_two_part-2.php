<?php

$games = [
    "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green",
    "Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue",
    "Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red",
    "Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red",
    "Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green"
];

function parseGame($game) {
    preg_match_all('/(\d+) (red|green|blue)/', $game, $matches, PREG_SET_ORDER);
    $cubes = ['red' => 0, 'green' => 0, 'blue' => 0];

    foreach ($matches as $match) {
        $number = intval($match[1]);
        $color = $match[2];
        $cubes[$color] = max($cubes[$color], $number);
    }

    return $cubes;
}

$totalPower = 0;

foreach ($games as $game) {
    $cubes = parseGame($game);
    $power = $cubes['red'] * $cubes['green'] * $cubes['blue'];
    $totalPower += $power;
}

echo $totalPower;
?>
