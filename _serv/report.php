<?php
require_once "../includes/config.php";



if($_SERVER['REQUEST_METHOD'] == "POST"){

    $mconn = mysqli_connect($mq_host, $mq_user, $mq_pass, $mq_data);

    $lat = mysqli_real_escape_string($mconn, $_POST['lat']);
    $lon = mysqli_real_escape_string($mconn, $_POST['lon']);
    $location = mysqli_real_escape_string($mconn, $_POST['location']);
    $type = mysqli_real_escape_string($mconn, $_POST['type']);
    $date = mysqli_real_escape_string($mconn, $_POST['date']);
    $recaptcha = mysqli_real_escape_string($mconn, $_POST['recaptcha']);
    $_user = mysqli_real_escape_string($mconn, $_POST['_user']);
    $_token = mysqli_real_escape_string($mconn, $_POST['_token']);
    $_ukey = mysqli_real_escape_string($mconn, $_POST['_ukey']);
    $news = '';
    $video = '';
    $image = '';
    $date_uo = new DateTime($date); // Sample: 04/28/2017 8:27 PM GMT+06:00
    $date_u = $date_uo->format('U');

    if(isset($_SESSION['posted'][$_ukey])){
        echo "Duplicate Entry!";
        exit();
    }

    // reCaptcha
	/*
    if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=".urlencode($reCaptchaKey)."&response=".urlencode($recaptcha)."&remoteip=".urlencode($_SERVER['REMOTE_ADDR']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $reCap = json_decode($server_output);

        if($reCap->success == "false"){
            echo "Error: reCaptcha Failed!";
            exit();
        }
	*/

    // Check For File Upload
    if(isset($_FILES["image"]["tmp_name"])){
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false){
            $target_dir = "../_hosted/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if($imageFileType == "jpg"){
                $image_file = md5(date('U').$lat.$lon) . ".jpg";
                $target_file = $target_dir . $image_file;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image = "_hosted/".$image_file;
            }else{
                echo "Error: Only JPG format is supported!";
                exit();
            }
        }else{
            echo "Error: Image size must be less then 5 MB!";
            exit();
        }
    }

    // Validate User
    if($_user != ""){

        $time = date("U");
        $post_time = date("U");
        $update_time = date("U");

        $SQL = "SELECT `id`,`mail`,`password` FROM `user` WHERE `mail` = '".$_user."'";
        $MQ = mysqli_query($mconn, $SQL);
        if(mysqli_num_rows($MQ) == 1){
            $uMFA = mysqli_fetch_array($MQ);
            
            $uid = $uMFA['id'];
            $mail = $uMFA['mail'];
            $pass = $uMFA['password'];
            
            $_xtoken = md5($mail.$pass.$pSalt);

            if($_xtoken == $_token){
                $SQL = "INSERT INTO `incident` VALUES(NULL, '".         // id
                                                  $uid."', '".          // user
                                                  $type."', '".         // type
                                                  $news."', '".         // news
                                                  $image."', '".        // image
                                                  $video."', '".        // video
                                                  $location."', '".     // location
                                                  $lat."', '".          // lat
                                                  $lon."', '".          // lon
                                                  $date_u."', '".       // time
                                                  $post_time."', '".    // post_time
                                                  $update_time."');";   // update_time
                
                $MQ = mysqli_query($mconn, $SQL);
                $_SESSION['posted'][$_ukey] = true;
                echo "Success!";
                exit();
            }else{
                echo "Error: Token Mismatch!";
                exit();
            }
        }else{
            echo "Error: Do we know you? Please login first!";
            exit();
        }
    }else{
        echo "Error: Invalid User!";
        exit();
    }
}else{
    echo "Error: Invalid Usage!";
    exit();
}

?>
