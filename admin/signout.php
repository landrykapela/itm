<?php

session_start();
$_SESSION = array();

if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),"",time()-4200,"/");
}
session_destroy();

if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on"){
    $location = "https://";
} 
else $location = "http://";
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
header("Location: ".$location,true);
?>