<?php
require_once "../includes/config.php";
$mconn = mysqli_connect($mq_host, $mq_user, $mq_pass, $mq_data);


$SQL = "SELECT `id`, `user`, `type`, `image`, `location`, `lat`, `lon`, `time` FROM `incident` ORDER BY `time` DESC LIMIT 0, 10";
$MQ = mysqli_query($mconn, $SQL);
$jq = array();
$uName = array();

if(mysqli_num_rows($MQ) > 0){
    while($MFA = mysqli_fetch_array($MQ)){
        $uid = $MFA['user'];
        if(!isset($uName[$uid])){
            $SQL = "SELECT * FROM `user` WHERE `id` = ".$uid;
            $MQ_U = mysqli_query($mconn, $SQL);
            $MFA_U = mysqli_fetch_array($MQ_U);
            $uName[$uid] = $MFA_U['first_name'] . " " . $MFA_U['last_name'] ;
            $uMail[$uid] = $MFA_U['mail'];
        }

        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $uMail[$uid] ) ) ) . "&s=60";

        $jq[] = array("id" => $MFA['id'], "user_name" => $uName[$uid], "type" => $MFA['type'], "avatar" => $grav_url, 
                      "image" => $MFA['image'], "location" => $MFA['location'],
                      "lat" => $MFA['lat'], "lon" => $MFA['lon'], "time" => $MFA['time']);

    }
}

echo json_encode($jq);

?>