<?php

if (!isset($argv[1])) exit("please specify a file \n");
if (!file_exists($argv[1])) exit("file doesn't exists \n");

$board = explode("\n", file_get_contents($argv[1]));
$nbCol = strlen($board[1]) + 1;
$nbRow = $board[0] + 1;
array_shift($board);

$matrice[] = array_fill(0, $nbCol, 0);
foreach ($board as $key => $value) {
    $temp = array_map(function ($v) { return $v == "." ? 1 : 0; }, str_split($value));
    array_unshift($temp, 0);
    $matrice[] = $temp;
}

$square = ["x" => 0, "y" => 0, "side" => 0];
for ($y = 1; $y < $nbRow; $y++) {
    for ($x = 1; $x < $nbCol; $x++) {
        if ($matrice[$y][$x] != 0) {
            $ayo = min([$matrice[$y - 1][$x - 1], $matrice[$y - 1][$x], $matrice[$y][$x - 1]]) + 1;
            $matrice[$y][$x] = $ayo;
            if ($ayo > $square["side"]) $square = ["x" => $x - $ayo, "y" => $y - $ayo, "side" => $ayo];
        }
    }
}

for ($y = $square["y"]; $y < ($square["y"] + $square["side"]); $y++) {
    $board[$y] =  substr_replace($board[$y], str_repeat("x", $square["side"]), $square["x"], $square["side"]);
}

echo implode("\n", $board);