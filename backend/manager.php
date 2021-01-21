<?php

class DB{

    static function randomPassword(){
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()";
        $result = "";
        for($i=0; $i<8;$i++){
            $randomIndex = rand(0,strlen($string));
            $result .= substr($string,$i,1);
            
        }
        return $result;
    }
    static function test(){
        echo "Cool";
    }
    static function connect(){
        $connect = mysqli_connect("localhost","itm_jobs","itm_jobs","itm_jobs") or die("Unable to connect to database ".mysqli_error());
        return $connect;
    }

    static function addToMailingList($email,$name){
        $sql = "insert into mailing_list (email,name) values('".$email."','".$name."')";
        $query = mysqli_query(DB::connect(),$sql);
        if($query){
            return true;
        }
        else return false;
    }

    static function createUser($email,$name,$phone,$password){
        $sql = "insert into user (email,name,phone,password) values ('".$email."','".$name."','".$phone."','".$password."')";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return true;
    }
    else return false;
    }

    static function signIn($email,$password){
        $sql = "select * from user where email ='".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            $row = mysqli_fetch_array($query);
                $enc_password = $row['password'];
                if(password_verify($password,$enc_password))
                    return $row;
            
                else return false;
            
        }
    }

    static function resetPassword($email){
        $sql = "select * from user where email = '".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if(mysqli_num_rows($query) > 0){
            $password = self::randomPassword();
            $hash = passsword_hash($password,PASSWORD_BCRYPT);
            $sql2 = "update user set password ='".$hash."' where email='".$email."'";
            $query2 = mysqli_query(self::connect(),$sql2);
            if($query2){
                mail($email,"Password Reset","Your password has been reset. Please use ".$password." next time you login");
                return true;
            }
            else return false;
        }
    }

    static function getUser($email){
        $sql = "select * from user where email='".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return mysqli_fetch_array($query);
        }
        else return false;
    }
}

?>