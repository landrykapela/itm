<?php
ini_set('display_errors',1);
require('../libs/manager.php');
if(isset($_POST['btnSubscribe'])){
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);

        $action = DB::addToMailingList($email,$name);
        if($action){
            $msg = "Thank you for subscribing to our newsletter.";
            echo $msg;
            // $mail = mail($email,"ITM Tanzania Newsletter",$msg);
            
        }
        else{
            $msg = "Sorry! We failed to add you to our mailing list. Please try again later";
            echo $msg;
        }
    }
    else {
        $msg = "Invalid email address";
    }
    $location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
    $location .= $_SERVER['HTTP_HOST']."/index.html?fb=".$msg;
    header($location,true);
}
else{
    die("Invalid request");
}



?>