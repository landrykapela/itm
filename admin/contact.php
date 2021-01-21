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
    $html_start = "<html><head></head><body>";
    $html_end = "</body></html>";
    $message = "<h3> Dear ITM Tanzania,</h3>";
    $message .= "<p>".$body. "</p>";
    $message .= "<p><b>".$name."</b></p>";
    $message .= $phone. ", ".$email ."\n\n";
    
    $reply_message = "<h3>Dear ".$name.",</h3>";
    $reply_message = "<p>Thank you for getting in touch. Our team will contact you as soon as possible.</p>";
    $reply_message .= "<b>ITM Tanzania Team</b>";
    $reply_message .= "<p>---------------------------------------------</p>";
    $reply_message .= $message;
    $feedback = "Thank you ".$name."! Your message has been received!";
    $location.="?feedback=".$feedback;
    $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                       
                      // Create email headers
                      $headers .= 'From: customercare@itmtanzania.co.tz'."\r\n".
                          'Reply-To: no-reply@itmtanzania.co.tz'."\r\n" .
                          'X-Mailer: PHP/' . phpversion();
    mail("info@itmafrica.com","Service Enquiry",$html_start.$message.$html_end,$headers);
    mail($email,"Service Enquiry",$reply_message.$html_end,$headers);
    
    header($location,true);
}


?>