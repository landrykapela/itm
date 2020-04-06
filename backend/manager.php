<?php

class DB{

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
        $query = mysqli_query(DB::connect(),$sql);
        if($query){
            return true;
    }
    else return false;
    }

}

?>