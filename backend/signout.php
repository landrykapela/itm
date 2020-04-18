<?php
session_destroy();
$_SESSION = [];
$location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/signup.html#login";
header($location,true);
?>