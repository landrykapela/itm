<?php

require ("manager.php");
ini_set("display_errors",1);


if(isset($_POST['submit'])){
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    // $cpassword = filter_var($_POST['cpassword'],FILTER_SANITIZE_STRING);

    $encrypted_password = password_hash($password,PASSWORD_BCRYPT);

    $action = DB::createUser($email,$name,$phone,$encrypted_password);
    $result = array();
if($action){
    $result["response"] = "User created successfully";
}
else $result["response"] = "Could not create user";
echo json_encode($result);
}
else{
    echo "Access Denied!";
}

?>