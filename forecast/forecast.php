<?php

function co_convert($lat, $lon, $map_width = 3600, $map_height = 1800){
    $y = ((-1 * $lat) + 90) * ($map_height / 180);
    $x = ($lon + 180) * ($map_width / 360);
    return array("x" => floor($x), "y" => floor($y));
}

if(isset($argv[1])){$lat = floatval($argv[1]);}
if(isset($argv[2])){$lon = floatval($argv[2]);}

if(isset($_GET['lat'])){$lat = floatval($_GET['lat']);}
if(isset($_GET['lon'])){$lon = floatval($_GET['lon']);}

$conv = co_convert($lat, $lon);

$x = $conv['x'];
$y = $conv['y'];

$x_lat = round($lat, 1);
$y_lon = round($lon, 1);

shell_exec("python3 fire-pixel.py ".$x." ".$y);
$out_file = "data/processed_e/".$x."x".$y.".csv";
if(file_exists($out_file)){
    shell_exec("python3 time-series.py ".$x." ".$y);
    $out_csv = "data/predicted/".$x."x".$y.".csv";
    $out_plot = "plots/".$x."x".$y.".png";
    if(file_exists($out_csv) and file_exists($out_plot)){
        echo '<br><b>Fire Hazard Plot for 2017</b><br>';
        echo '<img src="forecast/'.$out_plot.'" width="100%">';
        //echo "<br>".nl2br(file_get_contents($out_csv));
    }else{
        echo "<br><br>No Hazard Found!";
    }
}else{
    echo "<br><br>No Hazard Found!!";
}


?>
