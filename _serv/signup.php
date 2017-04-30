<?php
require_once "../includes/config.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $mconn = mysqli_connect($mq_host, $mq_user, $mq_pass, $mq_data);
    
    $first_name = mysqli_real_escape_string($mconn, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($mconn, $_POST['lastname']);
    $password_1 = md5(mysqli_real_escape_string($mconn, $_POST['password_1']).$pSalt);
    $password_2 = md5(mysqli_real_escape_string($mconn, $_POST['password_2']).$pSalt);
    $mail = mysqli_real_escape_string($mconn, $_POST['email']);
    $phone = mysqli_real_escape_string($mconn, $_POST['phone']);
    $alert = mysqli_real_escape_string($mconn, $_POST['alert']);
    $location = mysqli_real_escape_string($mconn, $_POST['location']);
    $lat = mysqli_real_escape_string($mconn, $_POST['lat']);
    $lon = mysqli_real_escape_string($mconn, $_POST['lon']);
    $last_active = date("U");

    if($first_name == "" and $last_name == ""){
        echo "Please Enter Name";
        exit();
    }

    if($mail == ""){
        echo "Please Enter E-Mail";
        exit();
    }

    if($phone == "" and $alert == "1"){
        echo "You must provide Phone number for alert.";
        exit();
    }

    if($password_1 == ""){
        echo "Blank Password Not Allowed!";
        exit();
    }
    if($password_1 != $password_2){
        echo "Password Do Not Match!";
        exit();
    }

    $SQL = "INSERT INTO `user` VALUES(NULL, '".$first_name."', '".$last_name."', '".$password_1."', '".$mail."', '".$phone."', '".$alert."', '".$location."', '".$lat."', '".
                                               $lon."', '".$last_active."');";

    if($MQ = mysqli_query($mconn, $SQL)){
        echo "Success!";
    }else{
        echo "Failed! : " . $SQL;
    }
}else{
    echo "Invalid!";
}

?>