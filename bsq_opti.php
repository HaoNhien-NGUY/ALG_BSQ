<?php

if (!isset($argv[1])) exit("please specify a file \n");
if (!file_exists($argv[1])) exit("file doesn't exists \n");

$board = explode("\n", file_get_contents($argv[1]));
$nbRow = $board[0];
array_shift($board);

$matrice = [];
$square = ["x" => 0, "y" => 0, "side" => 0];
for ($y = 0; $y < $nbRow; $y++) {
    if ($y == 0) {
        $matrice[] = array_map(function ($v) { return $v == "." ? 1 : 0; }, str_split($board[$y]));
        continue;
    }
    foreach (str_split($board[$y]) as $x => $value) {
        if ($x == 0) {
            $matrice[$y][$x] = $value == "." ? 1 : 0;
        } else if ($value == "o") {
            $matrice[$y][$x] = 0;
        } else {
            $ayo = min([$matrice[$y - 1][$x - 1], $matrice[$y - 1][$x], $matrice[$y][$x - 1]]) + 1;
            $matrice[$y][$x] = $ayo;
            if ($ayo > $square["side"]) $square = ["x" => $x - $ayo + 1, "y" => $y - $ayo + 1, "side" => $ayo];
        }
    }
}

for ($y = $square["y"]; $y < ($square["y"] + $square["side"]); $y++) {
    $board[$y] =  substr_replace($board[$y], str_repeat("x", $square["side"]), $square["x"], $square["side"]);
}

echo implode("\n", $board);