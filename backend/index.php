<?php

require ("manager.php");
ini_set("display_errors",1);

$result = array();
if(isset($_POST['submit'])){
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    
    //validate email address
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $response = "Invalid e-mail address";
    $location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html?fb=".$response;
    header($location,true);
    }
    else{
        $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $subscribe = ($_POST['subscribe'] == 1) ? true : false;

    $encrypted_password = password_hash($password,PASSWORD_BCRYPT);

    $action = DB::createUser($email,$name,$phone,$encrypted_password,$subscribe);

    if($action){
        session_start();
        $_SESSION['user'] = $email;
        $location = "Location: http://".$_SERVER['HTTP_HOST']."/backend/profile.php";
        header($location,true);
    }
    else {
        $response = "Could not create user";
        $location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html?fb=".$response;
        header($location,true);
    }
    }


}
else{

    if(isset($_POST['btnLoginSubmit'])){
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    // $encrypted_password = password_hash($password,PASSWORD_BCRYPT);
    $action = DB::signIn($email,$password);

        if(!$action) {
            $fb = "Could not log you in. Please try again later";
            $location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html?fb=".$fb."#login";
       header($location,true);
        
        }
        else {
            
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
            if(!$action) $result['response'] = "Could not reset your password. Make sure you are using the same email address you used at registration";
            else $result['response'] = "Your password was reset successfully. Check your email for instructions";
    
            $fb = $result['response'];
            $location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html?fb=".$fb."#login";
            

    //    header($location,true);
        }
        else echo "Access Denied!";
    }

    echo "Access Denied!";
}

?>