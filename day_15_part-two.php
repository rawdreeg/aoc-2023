<?php

function hashAlgorithm($string) {
    $currentValue = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        $asciiValue = ord($string[$i]);
        $currentValue += $asciiValue;
        $currentValue *= 17;
        $currentValue %= 256;
    }
    return $currentValue;
}

function processInitializationSequence($sequence) {
    $steps = explode(',', $sequence);
    $boxes = array_fill(0, 256, []); // Initialize 256 boxes

    foreach ($steps as $step) {
        preg_match('/([a-z]+)([-=])(\d*)/', $step, $matches);
        $label = $matches[1];
        $operation = $matches[2];
        $focalLength = isset($matches[3]) ? intval($matches[3]) : null;

        $boxIndex = hashAlgorithm($label);
        
        if ($operation == '-') {
            // Remove lens if exists
            if (isset($boxes[$boxIndex][$label])) {
                unset($boxes[$boxIndex][$label]);
            }
        } else {
            // Add or replace lens
            $boxes[$boxIndex][$label] = $focalLength;
        }
    }

    return $boxes;
}

function calculateFocusingPower($boxes) {
    $totalPower = 0;
    foreach ($boxes as $boxIndex => $lenses) {
        $slotNumber = 1;
        foreach ($lenses as $focalLength) {
            $totalPower += ($boxIndex + 1) * $slotNumber * $focalLength;
            $slotNumber++;
        }
    }
    return $totalPower;
}

// Example initialization sequence
$initializationSequence = "rn=1,cm-,qp=3,cm=2,qp-,pc=4,ot=9,ab=5,pc-,pc=6,ot=7";

$boxes = processInitializationSequence($initializationSequence);
echo "Focusing Power: " . calculateFocusingPower($boxes) . "\n";

?>
