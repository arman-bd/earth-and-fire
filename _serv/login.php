<?php
require_once "../includes/config.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $mconn = mysqli_connect($mq_host, $mq_user, $mq_pass, $mq_data);
    
    $mail = mysqli_real_escape_string($mconn, $_POST['username']);
    $pass = md5(mysqli_real_escape_string($mconn, $_POST['password']).$pSalt);

    $SQL = "SELECT `id`, `mail`, `password` FROM `user` WHERE `mail` = '".$mail."' AND `password` = '".$pass."'";
    $MQ = mysqli_query($mconn, $SQL);

    if(mysqli_num_rows($MQ) == 1){
        $MFA = mysqli_fetch_array($MQ);
        $mail = $MFA['mail'];
        $pass = $MFA['password'];
        $_xtoken = md5($mail.$pass.$pSalt);

        echo json_encode(array("user" => $mail, "token" => $_xtoken));
    }else{
        echo "Invalid";
    }

}else{
    echo "Invalid";
}

?>