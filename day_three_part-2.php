<?php

$schematic = [
    "467..114..",
    "...*......",
    "..35..633.",
    "......#...",
    "617*......",
    ".....+.58.",
    "..592.....",
    "......755.",
    "...$.*....",
    ".664.598.."
];;

function isPartOfNumber($schematic, $y, $x) {
    $width = strlen($schematic[0]);
    return $x >= 0 && $x < $width && is_numeric($schematic[$y][$x]);
}

function getFullNumber($schematic, $y, $x) {
    $width = strlen($schematic[0]);
    $number = '';

    // Move left to the start of the number
    while ($x > 0 && is_numeric($schematic[$y][$x - 1])) {
        $x--;
    }

    // Construct the full number
    while ($x < $width && is_numeric($schematic[$y][$x])) {
        $number .= $schematic[$y][$x];
        $x++;
    }

    return intval($number);
}

function sumGearRatios($schematic) {
    $sum = 0;
    $height = count($schematic);
    $width = strlen($schematic[0]);
    $checkedNumbers = [];

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            if ($schematic[$y][$x] === '*') {
                $partNumbers = [];

                for ($dy = -1; $dy <= 1; $dy++) {
                    for ($dx = -1; $dx <= 1; $dx++) {
                        if ($dy === 0 && $dx === 0) continue;

                        $adjY = $y + $dy;
                        $adjX = $x + $dx;

                        if (isPartOfNumber($schematic, $adjY, $adjX)) {
                            $fullNumber = getFullNumber($schematic, $adjY, $adjX);
                            $numberKey = $adjY . '-' . $adjX;

                            if (!in_array($numberKey, $checkedNumbers)) {
                                $partNumbers[] = $fullNumber;
                                $checkedNumbers[] = $numberKey;
                            }
                        }
                    }
                }
                
                $partNumbers = array_unique($partNumbers);
                $partNumbers = array_values($partNumbers);
                

                if (count($partNumbers) === 2) {
                    $sum += $partNumbers[0] * $partNumbers[1];
                }
            }
        }
    }

    return $sum;
}

echo sumGearRatios($schematic);
?>
