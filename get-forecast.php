<?php

function co_convert($lat, $lon, $map_width = 3600, $map_height = 1800){
    $y = ((-1 * $lat) + 90) * ($map_height / 180);
    $x = ($lon + 180) * ($map_width / 360);
    return array("x" => floor($x), "y" => floor($y));
}

$lat = floatval($argv[1]); // x
$lon = floatval($argv[2]); // y

$conv = co_convert($lat, $lon);

$x = $conv['x'];
$y = $conv['y'];

echo "(x,y) : ".$x.", ".$y;
echo "\n";

shell_exec("python3 fire-pixel.py ".$x." ".$y);
shell_exec("python3 time-series.py ".$x." ".$y);
?>
