<?php

require ("manager.php");
ini_set("display_errors",1);

$result = array();
if(isset($_POST['submit'])){
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    // $cpassword = filter_var($_POST['cpassword'],FILTER_SANITIZE_STRING);

    $subscribe = ($_POST['subscribe'] == 1) ? true : false;

    $encrypted_password = password_hash($password,PASSWORD_BCRYPT);

    $action = DB::createUser($email,$name,$phone,$encrypted_password,$subscribe);


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

    if(isset($_POST['btnLoginSubmit'])){
        $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    // $encrypted_password = password_hash($password,PASSWORD_BCRYPT);
    $action = DB::signIn($email,$password);

        if(!$action) $result['response'] = "Could not log you in. Please try again later";
        else {
            $result['response'] = "Successful login";
            echo json_encode($result);
            session_start();
            $_SESSION['user'] = $email;
            $location = "Location: http://".$_SERVER['HTTP_HOST']."/backend/profile.php";
       header($location,true);
        
        }

    }
    else{
        if(isset($_POST['btnResetSubmit'])){
            $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
            $action = DB::resetPassword($email);
            if($action) $result['response'] = "Your password was reset successfully. Check your email for instructions";
            else $result['response'] = "Could not reset your password. Make sure you are using the same email address you used at registration";
    
            echo json_encode($result);
        }
        else echo "Access Denied!";
    }

    echo "Access Denied!";
}

?>