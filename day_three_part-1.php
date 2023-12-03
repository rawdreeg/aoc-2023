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
];

function isSymbol($char) {
    return $char !== '.' && !is_numeric($char);
}

function sumPartNumbers($schematic) {
    $sum = 0;
    $height = count($schematic);
    $width = strlen($schematic[0]);
    $processed = array_fill(0, $height, array_fill(0, $width, false));

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            if (is_numeric($schematic[$y][$x]) && !$processed[$y][$x]) {
                $number = '';
                $numX = $x;

                // Build the complete number and mark as processed
                while ($numX < $width && is_numeric($schematic[$y][$numX])) {
                    $number .= $schematic[$y][$numX];
                    $processed[$y][$numX] = true;
                    $numX++;
                }

                $numberAdded = false;

                // Check adjacent cells for symbols
                for ($dy = -1; $dy <= 1; $dy++) {
                    for ($dx = -1; $dx <= 1; $dx++) {
                        if ($dy == 0 && $dx == 0) continue;

                        for ($i = 0; $i < strlen($number); $i++) {
                            $adjX = $x + $dx + $i;
                            $adjY = $y + $dy;

                            if ($adjX >= 0 && $adjX < $width && $adjY >= 0 && $adjY < $height && isSymbol($schematic[$adjY][$adjX])) {
                                if (!$numberAdded) {
                                    $sum += intval($number);
                                    $numberAdded = true;
                                }
                                break 2; // Break out of both loops
                            }
                        }
                    }
                }
            }
        }
    }

    return $sum;
}

echo sumPartNumbers($schematic);
?>
