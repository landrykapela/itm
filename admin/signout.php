<?php
session_start();
$_SESSION = array();

if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),"",time()-4200,"/");
}
session_destroy();

$location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
header($location,true);
?>