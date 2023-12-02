<?php

$calibration_document = [
    "two1nine",
    "eightwothree",
    "abcone2threexyz",
    "xtwone3four",
    "4nineeightseven2",
    "zoneight234",
    "7pqrstsixteen",
];

$digit_mapping = [
    'one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 
    'five' => '5', 'six' => '6', 'seven' => '7', 'eight' => '8', 'nine' => '9'
];

function getFirstAndLastDigits($line, $mapping) {
    // Check if the string is purely numeric
    if (is_numeric($line)) {
        $line = (string) $line
        $firstDigit = $line[0];
        $lastDigit = $line[strlen($line) - 1];
        return [$firstDigit, $lastDigit];
    }

    // Reverse mapping for easier lookup
    $reverse_mapping = array_flip($mapping);

    $firstDigit = $lastDigit = null;
    $lineLength = strlen($line);

    // Search for the first digit
    for ($i = 0; $i < $lineLength; $i++) {
        foreach ($mapping as $word => $number) {
            if (substr($line, $i, strlen($word)) === $word) {
                $firstDigit = $number;
                break 2; // Break out of both loops
            }
        }

        if (is_numeric($line[$i])) {
            $firstDigit = $line[$i];
            break;
        }
    }

    // Search for the last digit
    for ($i = $lineLength - 1; $i >= 0; $i--) {
        foreach ($reverse_mapping as $char => $word) {
            if (substr($line, $i - strlen($word) + 1, strlen($word)) === $word) {
                $lastDigit = $char;
                break 2; // Break out of both loops
            }
        }

        if (is_numeric($line[$i])) {
            $lastDigit = $line[$i];
            break;
        }
    }

    return [$firstDigit, $lastDigit];
}

$total_sum = 0;

foreach ($calibration_document as $line) {
    list($firstDigit, $lastDigit) = getFirstAndLastDigits($line, $digit_mapping);

    if ($firstDigit !== null && $lastDigit !== null) {
        $total_sum += intval($firstDigit . $lastDigit);
    }
}

echo $total_sum;

?>
