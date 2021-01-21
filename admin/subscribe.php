<?php
// ini_set('display_errors',1);
require('../libs/manager.php');
if(isset($_POST['btnSubscribe'])){
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);

        $action = DB::addToMailingList($email,$name);
        if($action){
            $html_start = "<html><head></head><body>";
    $html_end = "</body></html>";
            $msg = "<h3>Dear ".$name.",</h3>";
            $msg .= "<p>Thank you for subscribing to our newsletter.</p>";
            $msg .= "<p>Please click this <a href='https://itmafrica.co.tz/admin/activate.php?e=".$email."'>link to confirm</a> your email address. </p>";
            $msg .= "<p>If you did not request subscription to our newsletter please ignore this email!</p><b>ITM Tanzania Team<b>";
            // echo $msg;
             $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                       
                      // Create email headers
                      $headers .= 'From: customercare@itmtanzania.co.tz'."\r\n".
                          'Reply-To: no-reply@itmtanzania.co.tz'."\r\n" .
                          'X-Mailer: PHP/' . phpversion();
            mail($email,"ITM Tanzania Newsletter",$html_start.$msg.$html_end,$headers);
            $fb = "Thank you for subscribing to our newsletter.";
        }
        else{
            $fb = "Sorry! We failed to add you to our mailing list. Please try again later";
            // echo $msg;
        }
    }
    else {
        $fb = "Invalid email address";
    }
    $location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
    $location .= $_SERVER['HTTP_HOST']."/index.html?fb=".$fb;
    header($location,true);
}
else{
    die("Invalid request");
}



?>