<?php
// ini_set('display_errors',1);
require('../libs/manager.php');

if(!isset($_GET['e']) && !isset($_GET['ne'])){
     $fb = "Invalid email address";
    
}
else{
    $target = 1;
    $msg = "<h3>Hi there!</h3>";
    if(isset($_GET['ne'])){
        
    $email = filter_var($_GET['ne'],FILTER_SANITIZE_STRING);
        $target = 0;
        $msg .= "<p>You have successfully unsubscribed from our newsletter.</p>";
            $msg .= "<p>Please click here to <a href='https://itmafrica.co.tz/'>visit our website</a> at any time. </p>";
            $msg .= "<b>ITM Tanzania Team<b>";
    }
    else{
        
    $email = filter_var($_GET['e'],FILTER_SANITIZE_STRING);
            $msg .= "<p>You have successfully confirmed your email address for our newsletter.</p>";
            $msg .= "<p>Please click here to <a href='https://itmafrica.co.tz/admin/activate.php?ne=".$email."'>unsubscribe</a> at any time. </p>";
            $msg .= "<b>ITM Tanzania Team<b>";
    }
    
    if($target == 1){
    $action = DB::activateMailingListItem($email);
        
    }
    else {
        $action = DB::deactivateMailingListItem($email);
    }
    
    if($action){
            $html_start = "<html><head></head><body>";
    $html_end = "</body></html>";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                       
                      // Create email headers
                      $headers .= 'From: customercare@itmtanzania.co.tz'."\r\n".
                          'Reply-To: no-reply@itmtanzania.co.tz'."\r\n" .
                          'X-Mailer: PHP/' . phpversion();
            mail($email,"ITM Tanzania Newsletter",$html_start.$msg.$html_end,$headers);
            $fb = "Your request was successful!";
    }
    else{
        $fb = "Sorry! Could not add you to the mailing list";
    }
}
    
             
 
    $location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
    $location .= $_SERVER['HTTP_HOST']."/index.html?fb=".$fb;
    header($location,true);



?>