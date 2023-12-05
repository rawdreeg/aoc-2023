<?php

function parseInput($inputString) {
    $sections = explode("\r\n\r\n", $inputString);

    $seeds = [];
    $maps = [];

    foreach ($sections as $section) {
        $lines = explode("\r\n", trim($section));
        $header = array_shift($lines);

        if (strpos($header, 'seeds:') !== false) {
            $seeds = array_map('intval', explode(' ', str_replace('seeds: ', '', $header)));
        } else {
            $mapName = strtolower(trim(explode(':', $header)[0]));
            $maps[$mapName] = [];

            foreach ($lines as $line) {
                $parts = array_map('intval', explode(' ', $line));
                if (count($parts) === 3) {
                    list($destStart, $sourceStart, $rangeLength) = $parts;
                    $maps[$mapName][] = [$destStart, $sourceStart, $rangeLength];
                }
            }
        }
    }

    return ['seeds' => $seeds, 'maps' => $maps];
}

// Example usage
$inputString = <<<EOT
seeds: 79 14 55 13

seed-to-soil map:
50 98 2
52 50 48

soil-to-fertilizer map:
0 15 37
37 52 2
39 0 15

fertilizer-to-water map:
49 53 8
0 11 42
42 0 7
57 7 4

water-to-light map:
88 18 7
18 25 70

light-to-temperature map:
45 77 23
81 45 19
68 64 13

temperature-to-humidity map:
0 69 1
1 0 69

humidity-to-location map:
60 56 37
56 93 4
EOT;

$data = parseInput($inputString);

// Accessing seeds and maps
$seeds = $data['seeds'];
$maps = $data['maps'];




$seedToSoilMap = $maps['seed-to-soil map'];

// // Maps
$soilToFertilizerMap = $maps['soil-to-fertilizer map'];
$fertilizerToWaterMap = $maps['fertilizer-to-water map'];
$waterToLightMap = $maps['water-to-light map'];
$lightToTemperatureMap = $maps['light-to-temperature map'];
$temperatureToHumidityMap = $maps['temperature-to-humidity map'];
$humidityToLocationMap = $maps['humidity-to-location map'];

function convertNumber($number, $map) {
    foreach ($map as $mapping) {
        list($destStart, $sourceStart, $length) = $mapping;
        if ($number >= $sourceStart && $number < $sourceStart + $length) {
            return $destStart + ($number - $sourceStart);
        }
    }
    return $number;
}

$minLocation = PHP_INT_MAX;

foreach ($seeds as $seed) {
    $soil = convertNumber($seed, $seedToSoilMap);
    $fertilizer = convertNumber($soil, $soilToFertilizerMap);
    $water = convertNumber($fertilizer, $fertilizerToWaterMap);
    $light = convertNumber($water, $waterToLightMap);
    $temperature = convertNumber($light, $lightToTemperatureMap);
    $humidity = convertNumber($temperature, $temperatureToHumidityMap);
    $location = convertNumber($humidity, $humidityToLocationMap);

    $minLocation = min($minLocation, $location);
}

echo "The lowest location number: " . $minLocation;
