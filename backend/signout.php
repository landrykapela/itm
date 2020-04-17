<?php
session_destroy();
$_SESSION = [];
header("Location: http://".$_SERVER['HTTP_HOST']."/signup.html#login",true);
?>