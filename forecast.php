<?php

$lat = $argv[1]; // x
$lon = $argv[2]; // y

function co_convert($lat, $lon, $map_width = 3600, $map_height = 1800){
    $y = ((-1 * $lat) + 90) * ($map_height / 180);
    $x = ($lon + 180) * ($map_width / 360);
    return array("x" => $x, "y" => $y);
}

?>
