<?php

$calibration_document = [
    "1abc2",
    "pqr3stu8vwx",
    "a1b2c3d4e5f",
    "treb7uchet"
];

$total_sum = 0;

foreach ($calibration_document as $line) {
    preg_match_all('/\d/', $line, $matches);
    if ($matches[0]) {
        $first_digit = $matches[0][0];
        $last_digit = end($matches[0]);
        $two_digit_number = (int)($first_digit . $last_digit);
        $total_sum += $two_digit_number;
    }
}

echo $total_sum;

?>
