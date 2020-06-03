<?php
ini_set("display_errors",1);
require("../libs/manager.php");
$location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/services.html";
if(!isset($_POST['btnContact'])){
header($location);
}
else{
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $body = filter_var($_POST['body'],FILTER_SANITIZE_STRING);

    $message = $body. "\n\n";
    $message .= $name."\n\n";
    $message .= $phone. "\n\n";
    $message .= $email ."\n\n";

    $reply_message = "Thank you ".$name." for getting in touch. Our team will contact you as soon as possible.\n\n";
    $reply_message .= "ITM Tanzania Team\n\n";
    $reply_message .= "---------------------------------------------\n\n";
    $reply_message .= $message;
    $feedback = "Thank you ".$name."! Your message has been received!";
    $location.="?feedback=".$feedback;
    mail("info@neelansoft.co.tz","Service Enquiry",$message);
    mail($email,"Service Enquiry",$reply_message);
    
    header($location,true);
}


?>