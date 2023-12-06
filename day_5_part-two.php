<?php


function parseInput($inputString) {
	$sections = preg_split('/\n\n/', $inputString);

	$seeds = [];
	$maps = [];

	foreach ($sections as $section) {
		$lines = explode("\n", trim($section));
		$header = array_shift($lines);

		if (strpos($header, 'seeds:') !== false) {
			$seedRanges = array_map('intval', explode(' ', str_replace('seeds: ', '', $header)));
			$seeds = array_chunk($seedRanges, 2); // Store ranges as pairs
		} else {
			$mapName = strtolower(trim(explode(':', $header)[0]));
			$maps[$mapName] = processMap($lines);
		}
	}

	return ['seeds' => $seeds, 'maps' => $maps];
}

function processMap($lines) {
	$map = [];
	foreach ($lines as $line) {
		[$destStart, $sourceStart, $length] = array_map('intval', explode(' ', $line));
		if ($destStart === 0 && $sourceStart === 0) {
			// Special handling for 0-to-0 mappings
			$map['zeroMapping'] = true;
			continue;
		}
		$map['ranges'][] = [
			'sourceStart' => $sourceStart,
			'sourceEnd' => $sourceStart + $length - 1,
			'destStart' => $destStart
		];
	}
	return $map;
}

function convertNumber($number, $map) {
	// Quick return if it's a zero-to-zero mapping
	if (!empty($map['zeroMapping'])) {
		return $number;
	}

	foreach ($map['ranges'] as $mapping) {
		if ($number >= $mapping['sourceStart'] && $number <= $mapping['sourceEnd']) {
			return $mapping['destStart'] + ($number - $mapping['sourceStart']);
		}
	}
	return $number;
}

function findMinimumLocation($seedRanges, $maps) {
	$minLocation = PHP_INT_MAX;

	foreach ($seedRanges as $range) {
		list($start, $length) = $range;

		for ($seed = $start; $seed < $start + $length; $seed++) {
			$soil = convertNumber($seed, $maps['seed-to-soil map']);
			$fertilizer = convertNumber($soil, $maps['soil-to-fertilizer map']);
			$water = convertNumber($fertilizer, $maps['fertilizer-to-water map']);
			$light = convertNumber($water, $maps['water-to-light map']);
			$temperature = convertNumber($light, $maps['light-to-temperature map']);
			$humidity = convertNumber($temperature, $maps['temperature-to-humidity map']);
			$location = convertNumber($humidity, $maps['humidity-to-location map']);

			$minLocation = min($minLocation, $location);
		}
	}

	return $minLocation;
}

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
$minLocation = findMinimumLocation($data['seeds'], $data['maps']);
echo "The lowest location number: " . $minLocation;

