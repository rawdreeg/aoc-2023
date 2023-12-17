<?php

function hashAlgorithm($string) {
    $currentValue = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        $asciiValue = ord($string[$i]); // Get ASCII code
        $currentValue += $asciiValue;
        $currentValue *= 17;
        $currentValue %= 256; // Remainder when divided by 256
    }
    return $currentValue;
}

function processInitializationSequence($sequence) {
    $steps = explode(',', $sequence); // Split the sequence into steps
    $sum = 0;
    foreach ($steps as $step) {
        $sum += hashAlgorithm($step);
    }
    return $sum;
}

// Example initialization sequence
$initializationSequence = "rn=1,cm-,qp=3,cm=2,qp-,pc=4,ot=9,ab=5,pc-,pc=6,ot=7";

echo "Sum of HASH results: " . processInitializationSequence($initializationSequence) . "\n";

?>
