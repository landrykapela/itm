<?php
require('config.php');
require('class.phpmailer.php');
$http = "http://";
if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on") $http = "https://";
define('HEADER',"Location: ".$http.$_SERVER['HTTP_HOST']);


class DB{

    static function randomPassword(){
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()";
        $result = "";
        for($i=0; $i<8;$i++){
            $randomIndex = rand(0,strlen($string));
            $result .= substr($string,$randomIndex,1);
            
        }
        return $result;
    }
    static function test(){
        echo "Cool";
    }
    static function connect(){
        $connect = mysqli_connect(HOST,USER,PWORD,DB) or die("Unable to connect to database ");
        return $connect;
    }

    //mailing
    static function addToMailingList($email,$name){
        $test = mysqli_query(DB::connect(),"select * from mailing_list where email='".$email."'");
        if(mysqli_num_rows($test) > 0){
            return true;
        }
        else{
            $sql = "insert into mailing_list (email,name) values('".$email."','".$name."')";
            $query = mysqli_query(DB::connect(),$sql);
            if($query){
                return true;    
            }
            else return false;
        }
        
    }
    static function activateMailingListItem($email){
        $sql = "update mailing_list set status=1 where email='".$email."'";
        $query = mysqli_query(self::connect(),$sql);
        if($query) return true;
        else return false;
    }
      static function deactivateMailingListItem($email){
        $sql = "update mailing_list set status=0 where email='".$email."'";
        $query = mysqli_query(self::connect(),$sql);
        if($query) return true;
        else return false;
    }
    static function getMailingList(){
        $sql = "select email,name from mailing_list where status=1";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            while($r = mysqli_fetch_row($query)){
                $i['email'] = $r[0];
                $i['name'] = $r[1];
                $result[] = $i;
            }
            return $result;
        }
        else return false;
    }
    static function sendGroupMail($data){
        $result = array();
        $image_data = "";
        $body = $data['message'];
        $subject = $data['subject'];
        $html_message ='<p class="primary-text subtitle">Hello </p>';
        $html_message .= '<p class="dark-text text-left">'.$body.'</p>';
        $html_message .='<p class="dark-text text-left primary-text">From ITM Tanzania</p>';

        if(array_key_exists('image',$data)){
            $file = $data['image'];
            $upload = "events/";
            $allowedFiles = array("png","jpg","jpeg");
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            if(!in_array($ext,$allowedFiles)){
                $result['status'] = false;
                $result['message'] = "The image you uploaded is not supported!";
                return $result;
            }
            else{
                if($file['size'] > 2048000){
                    $result['status'] = false;
                    $result['message'] = "The image you uploaded is too large!";
                    return $result;
                }
                else{
                    $image_data = "data:image/".$ext.";base64,".base64_encode(file_get_contents($file['tmp_name']));
                    $html_message .'<img src="'.$image_data.'" class="w-100"/>';
                }
                
            }
        }
        
                    $html_head = '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                        <meta name="author" content="Landry Kapela" />
                        <meta name="viewport" content="width=device-width,initial-scale=1" />
                        <meta
                          name="description"
                          content="ITM Tanzania Ltd is the East African division of the ITM AFRICA Group of companies, a respected, multi-faceted service provider to different sectors throughout Africa."
                        />
                        <meta name="twitter:card" content="summary_large_image" />
                        <meta name="twitter:title" content="ITM Tanzania" />
                        <meta name="twitter:site" content="@itmafrica" />
                        <meta
                          name="twitter:image"
                          content="https://landrykapela.github.io/itm/images/office.jpg"
                        />
                        <meta
                          name="keyword"
                          content="ITM, ITM Africa, Jobs, empolyment, ITM Tanzania, Career Development,Career, Professional Training, Training, recruitment,achievement"
                        />
                        
                        <link
                          href="https://fonts.googleapis.com/icon?family=Material+Icons"
                          rel="stylesheet"
                        />
                        <link
                          href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
                          rel="stylesheet"
                        />
                        <link href="https://itmafrica.co.tz/styles/general.css rel="stylesheet"/>
                        <link href="https://itmafrica.co.tz/styles/general_large.css rel="stylesheet"/><link href="https://itmafrica.co.tz/styles/general_mobile.css rel="stylesheet"/>
                        <link rel="icon" href="https://itmafrica.co.tz/images/favicon.png" />
                    
                        <title>ITM Tanzania - Newsletter</title>
                      </head><body>
                      <header
      id="header"
      class="min-width-full flex-column flex-top flex-start margin-auto"
    >
      <div
        class="white-bg flex-row flex-between flex-middle w-100 padding-std margin-auto"
      >
        <img src="https://itmafrica.co.tz/images/logo.png" class="logo" alt="ITM logo" />
        
      </div>
    </header>
                      
                      <section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
                      <div class="margin-auto primary-bg white-text flex-row flex-start flex-middle padding-small">
                      <span class="primary-bg white-text padding-std margin-std">ITM Tanzania Newsletter</span>
                      <div></section>';
                      
                      
                      $recipients = array();
                      $list = self::getMailingList();
                      for($i=0; $i<sizeof($list);$i++){
                          $l = $list[$i];
                          $recipients[] = $l['email'];
                      }
                    
                      $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                       
                      // Create email headers
                      $headers .= 'From: customercare@itmtanzania.co.tz'."\r\n".
                          'Reply-To: no-reply@itmtanzania.co.tz'."\r\n" .
                          'X-Mailer: PHP/' . phpversion();

                          $html_message = $html_head . $html_message;
                          $to = "";
                          for($i=0;$i<sizeof($recipients);$i++){
                              if($i < sizeof($recipients)-1) $to .= $recipients[$i]['email'].", ";
                              else $recipients[$i]['email'];
                          }

                          $action = mail($to,$subject,$html_message,$headers);
                    if($action){
                        $result['status'] = true;
                        $result['message'] = "Email was sent successfully";
                        return $result;
                    }
                    else{
                        $result['status'] = false;
                        $result['message'] = "Email was not sent successfully";
                        return $result;
                    }
        
    }


    //users
    static function createUser($email,$name,$phone,$password,$subscribe){
        $sql = "insert into user (email,name,phone,password) values ('".$email."','".$name."','".$phone."','".$password."')";
        $con = self::connect();
        $query = mysqli_query($con,$sql);
        if($query){
            if($subscribe) self::addToMailingList($email,$name);
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
                if(password_verify($password,$enc_password)){
                    $time = time();
                    mysqli_query(self::connect(),"update user set last_login=".$time." where email='".$email."'");
                    return true;
                }
                
            
                else return false;
            
        }
    }

    static function resetPassword($email){
        $sql = "select * from user where email = '".$email."' order by id asc limit 1";
        $con = self::connect();
        $query = mysqli_query($con,$sql);
        if(mysqli_num_rows($query) > 0){
            $password = self::randomPassword();
            
            $hash = password_hash($password,PASSWORD_BCRYPT);
            $sql2 = "update user set password ='".$hash."' where email='".$email."'";
            $query2 = mysqli_query(self::connect(),$sql2);
            if($query2){
                
                $headers ="From: ITM Tanzania\r\nReply-To: noreply@itmafrica.co.tz\r\n";
                mail($email,"Password Reset","Your password has been reset. Please use ".$password." next time you login",$headers);
                return true;
            }
            else return false;
        }
    }

    static function isAdmin($email){
        $query = mysqli_query(self::connect(),"select id from user where email='".$email."'");
        if($query && mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_row($query);
            if($row[0] == 1) return true;
            else return false;
        }
        else return false;
    }
    static function getUser($email){
        $sql = "select * from user where email='".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return mysqli_fetch_array($query);
        }
        else return false;
    }
    static function getUserById($id){
        $sql = "select * from user where id='".$id."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return mysqli_fetch_array($query);
        }
        else return false;
    }
    // delete user account; use carefully
    static function deleteUser($userid){
        $user = self::getUserById($userid);
        if(!$user){
            return false;
        }
        else{
            $query = mysqli_query(self::connect(),"delete from user where email='".$user['email']."'");
            if($query){
                mysqli_query(self::connect(),"delete from work where email='".$user['email']."'");
                mysqli_query(self::connect(),"delete from education where email='".$user['email']."'");
                mysqli_query(self::connect(),"delete from reference where email='".$user['email']."'");
                 mysqli_query(self::connect(),"delete from mailing_list where email='".$user['email']."'");
                return true;
            }
        }
    }
    static function updateUserInfo($id,$data){
        if($data == null){
            return false;
        }
        $sql = "update user ";
        $set = "set ";
        
        foreach($data as $key => $value){
            if($key == 'password'){
                $hash = password_hash($value,PASSWORD_BCRYPT);
                $set .= $key ." = '".$hash."', ";
            }
            else $set .= $key ." = '".$value."', ";
        }
        $sql .= substr($set,0,strlen($set)-2) ." where id=".$id;
        
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return self::getUserById($id);

        }
        else return false;
    }
    static function deleteEducationRecord($eid){
        $sql = "delete from education where id=".$eid;
        $query = mysqli_query(self::connect(),$sql);
        if($query) return true;
        else return false;
    }
    static function updateEducationRecord($data,$eid){
        if($data == null){
            return false;
        }
            $set = " set ";
            $sql = "update education ";
            foreach($data as $key => $value){
                $set .= $key ." = '".$value."', ";
            }
            $sql .= substr($set,0,strlen($set)-2)." where id=".$eid;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                return self::getEducationRecord($eid);
            }
            else return false;
    }
    static function getEducationRecord($id){
        $sql = "select * from education where id='".$id."' order by year desc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            $item = array();
            while($row = mysqli_fetch_row($query)){
                $item['id'] = $row[0];
                $item['level'] = $row[1];
                $item['title'] = $row[2];
                $item['institution'] = $row[3];
                $item['major'] = $row[8];
                $item['country'] = $row[4];
                $item['year'] = $row[5];
                $result = $item; 
            }
            return $result;
        }
        else return false;
    }
    static function getEducationProfile($email){
        $sql = "select * from education where email='".$email."' order by year desc";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            $item = array();
            while($row = mysqli_fetch_row($query)){
                $item['id'] = $row[0];
                $item['level'] = $row[1];
                $item['title'] = $row[2];
                $item['institution'] = $row[3];
                $item['major'] = $row[8];
                $item['country'] = $row[4];
                $item['year'] = $row[5];
                $result[] = $item; 
            }
            return $result;
        }
        else return false;
    }
    static function createEducationProfile($user,$data){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "insert into education (title,level,institution,major,year,country,email,user) values ";
            for($i=0; $i<count($data);$i++){
                $d = $data[$i];
                $title = $d['title'];
            $level = $d['level'];
            $institution = $d['institution'];
            $major = $d['major'];
            $year = $d['year'];
            $country = $d['country'];
            

            $values .= "('".$title."','".$level."','".$institution."','".$major."',".$year.",'".$country."','".$user['email']."',".$user['id'].")";
            if($i < sizeof($data)-1){
                $values .= ",";
            }
            }
            $sql .= $values;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                
                $progress = explode(",",$user['profile']);
                $progress[1] = "40";
                $profile = implode(",",$progress);
                mysqli_query(self::connect(),"update user set profile = '".$profile."' where email='".$user['email']."'");
                return true;
            }
            else return false;
        // }
    }

    static function getWorkProfile($email){
        $sql = "select * from work where email='".$email."' order by year_end desc";
        $query = mysqli_query(self::connect(),$sql) or die(mysqli_error(self::connect()));
        $result = array();
        if($query){
            $item = array(); 
            while($row = mysqli_fetch_row($query)){
                $item['id'] = $row[0];
                $item['title'] = $row[1];
                $item['institution'] = $row[2];
                $item['tasks'] = $row[3];
                $item['country'] = $row[4];
                $item['year_start'] = $row[5];
                $item['year_end'] = $row[6];
                $item['month_start'] = $row[7];
                $item['month_end'] = $row[8];
                $result[] = $item; 
            }
            return $result;
        }
        else return false;
    }
    static function getWorkRecord($id){
        $sql = "select * from work where id=".$id." order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            $item = array();
            while($row = mysqli_fetch_row($query)){
                $item['id'] = $row[0];
                $item['title'] = $row[1];
                $item['institution'] = $row[2];
                $item['tasks'] = $row[3];
                $item['country'] = $row[4];
                $item['year_start'] = $row[5];
                $item['year_end'] = $row[6];
                $item['month_start'] = $row[7];
                $item['month_end'] = $row[8];
                $result = $item; 
            }
            return $result;
        }
        else return false;
    }
    static function updateWorkRecord($data,$id){
        if($data == null){
            return false;
        }
            $set = " set ";
            $sql = "update work ";
            foreach($data as $key => $value){
                $set .= $key ." = '".$value."', ";
            }
            $sql .= substr($set,0,strlen($set)-2)." where id=".$id;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                return self::getWorkRecord($id);
            }
            else return false;
    }
    static function deleteWorkRecord($id){
        $sql = "delete from work where id=".$id;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return true;
        }
        else return false;
    }
    static function createWorkProfile($email,$data){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "insert into work (title,institution,tasks,country,year_start,year_end,month_start,month_end,email) values ";
            for($i=0; $i<count($data);$i++){
                $d = $data[$i];
                $title = $d['title'];
            $institution = $d['institution'];
            $tasks = $d['tasks'];
            $country = $d['country'];
            $year_start = $d['year_start'];
            $year_end = $d['year_end'];
            $month_start = $d['month_start'];
            $month_end = $d['month_end'];

            $values .= "('".$title."','".$institution."','".$tasks."','".$country."',".$year_start.",".$year_end.",".$month_start.",".$month_end.",'".$email."')";
            if($i < sizeof($data)-1){
                $values .= ",";
            }
            }
            $sql .= $values;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                $user = self::getUser($email);
                $progress = explode(",",$user['profile']);
                $progress[2] = "40";
                $profile = implode(",",$progress);
                mysqli_query(self::connect(),"update user set profile = '".$profile."' where email='".$email."'");
                return true;
            }
            else return false;
        // }
    }
    static function createReferenceProfile($email,$data){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "insert into reference (name,title,contact,email,phone) values ";
            for($i=0; $i<count($data);$i++){
                $d = $data[$i];
                $title = $d['title'];
            $name = $d['name'];
            $contact = $d['contact'];
            $phone = $d['phone'];
            $values .= "('".$name."','".$title."','".$contact."','".$email."','".$phone."')";
            if($i < sizeof($data)-1){
                $values .= ",";
            }
            }
            $sql .= $values;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                $user = self::getUser($email);
                $progress = explode(",",$user['profile']);
                $progress[3] = "40";
                $profile = implode(",",$progress);
                mysqli_query(self::connect(),"update user set profile = '".$profile."' where email='".$email."'");
                return true;
            }
            else return false;
        // }
    }

    static function updateReferenceRecord($data,$id){
        if($data == null){
            return false;
        }

        $sql = "update reference ";
        $set = "set ";
        foreach($data as $key => $value){
            $set .= $key." = '".$value."', ";
        }
        $sql .= substr($set,0,strlen($set)-2)." where id=".$id;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return self::getReferenceRecord($id);
        }
        else return false;
        
    }
    static function deleteReferenceRecord($id){
        $sql = "delete from reference where id=".$id;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return true;
        }
        else return false;
    }
    static function getReferenceRecord($id){
        $sql = "select * from reference where id=".$id." order by id asc";
        $query = mysqli_query(DB::connect(),$sql);
        $result = array();
        if($query){
            while($row=mysqli_fetch_row($query)){
                $item['id'] = $row[0];
                $item['name'] = $row[1];
                $item['contact'] = $row[2];
                $item['title'] = $row[3];
                $item['email'] = $row[4];
                $item['phone'] = $row[6];
                $result = $item;
            }
            return $result;
        }
        else return false;
    }
    static function getReferenceProfile($email){
        $sql = "select * from reference where email='".$email."' order by id asc";
        $query = mysqli_query(DB::connect(),$sql);
        $result = array();
        if($query){
            while($row=mysqli_fetch_row($query)){
                $item['id'] = $row[0];
                $item['name'] = $row[1];
                $item['contact'] = $row[2];
                $item['title'] = $row[3];
                $item['email'] = $row[4];
                $item['phone'] = $row[6];
                $result[] = $item;
            }
            return $result;
        }
        else return false;
    }

    static function searchCandidates($options){
        $sql = "select u.id,u.name,u.email,u.phone,e.level,e.major,e.institution,e.title from user as u left join education as e on e.user where u.id=e.user and u.id <>1 order by u.name asc";
        if($options != null){
            $condition = "";
            
            foreach($options as $key =>$value){
                $condition .= " and ".$key." like '%".$value."%' ";
            }
        
            $sql .= $condition;
        }
        
            $query = mysqli_query(self::connect(),$sql);
            $result = array();
            if($query){
                while($row = mysqli_fetch_row($query)){
                    $item = array();
                    $item['id'] = $row[0];
                    $item['name'] = $row[1];
                    $item['email'] = $row[2];
                    $item['phone'] = $row[3];
                    $item['level'] = $row[4];
                    $item['major'] = $row[5];
                    $item['institution'] = $row[6];
                    $item['title'] = $row[7];
                    
           
                    $result[] = $item;
                }
                return $result;
            }
            else return false;
       
    }
    static function mapQualifications($levels){
        $result = array();
        $keys = array();
        foreach($levels as $key =>$value){
            $keys[$key];
            
        }
       $sortedKeys = ksort($keys);
       for($i=0;$i<sizeof($sortedKeys);$i++){
           $result[] = $levels[$sortedKeys[$i]];
       }
        return $result;
    }
    static function getHighestQualification($email){
        $sql = "select level,institution,major from education where email ='".$email."'";
        $eds= array();
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            while($r=mysqli_fetch_row($query)){
                $level = array();
                $level['level'] = $r[0];
                $level['institution'] = $r[1];
                $level['major'] = $r[2];
                $eds[] = $level;
            }
        }
        $values = array();
        for($i=0;$i<sizeof($eds);$i++){
            $e = $eds[$i];
            if($e['level'] == 'Doctorate') return $e;
            else{
                $val = 0;
                switch($e['level']){
                    case "Master":
                        $val = 4;
                    break;
                    case "Bachelor":
                        $val = 3;
                    break;
                    case "Diploma":
                        $val = 2;
                    break;
                    case "Certificate":
                        $val = 1;
                    break;
                    
                }
                $e['val'] = $val;
                $values[$val] = $e;
            }
            
        }
        krsort($values);
        // echo "eds: ".json_encode(($values));
        return reset($values);
    }
    static function getLatestEmployment($email){
        $sql = "select institution,year_start,year_end from work where email ='".$email."' order by year_start";
        $employment = array();
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            while($r=mysqli_fetch_row($query)){
                $job= array();
                $job['institution'] = $r[0];
                $job['year_start'] = $r[1];
                $job['year_end'] = $r[2];
                $employment[] = $job;
            }
        }
        $values = array();
        for($i=0;$i<sizeof($employment);$i++){
            $job = $employment[$i];
            if($job['year_end'] == -1){
                return $job;
            }
            else{
                $values[$job['year_start']] = $job;
            }
        }
        krsort($values);
        // echo "jobs: ".json_encode(array_keys($values))."\n";
        return reset($values);
    }

    //careers
    static function addCareer($name){
       
        $query = mysqli_query(self::connect(),"insert into career (name) values ('".$name."')");
        if($query){
            return self::listCareers();
        }
        else return false;
    }
    static function listCareers(){
        $result = array();
        $sql = "select * from career order by name asc";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            while($r = mysqli_fetch_row($query)){
                $item = array();
                $item['id'] = $r[0];
                $item['name'] = $r[1];
                $result[] = $item;
            }
            return $result;
        }
        else return false;
    }
    static function listCandidates(){
        $sql = "select * from user where id <> 1 order by id desc";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        while($row = mysqli_fetch_row($query)){
            $item['id'] = $row[0];
            $item['name'] = $row[1];
            $item['email'] = $row[2];
            $item['phone'] = $row[3];
            $result[] = $item;
        }
        return $result;
    }

//training programs
    static function getTrainingPrograms(){
        
        $sql = "select * from training where status = 0 order by start_date asc";
        $query= mysqli_query(self::connect(),$sql);
        if($query){
            
            $result = array();
            while($r =mysqli_fetch_row($query)){
                $i=array();
                $i['id'] = $r[0];
                $i['title'] = $r[1];
                $i['description'] = $r[2];
                $i['start_date'] = $r[3];
                $i['end_date'] = $r[4];
                $i['target'] = $r[5];
                $i['instructor'] = $r[6];
                $i['registered'] = $r[7];
                $i['last_updated'] = $r[8];
                $i['contact'] = $r[9];
                $i['phone'] = $r[10];
                $i['location'] = $r[11];
                $i['image'] = $r[13];
            $result[] = $i;
            }
            // echo "ok: ".json_encode($result);
            return $result;
        }
        return false;
    }
    static function getTrainingProgram($id){
        $sql = "select * from training where id=".$id." order by start_date desc";
        $query= mysqli_query(self::connect(),$sql);
        if($query){
            $result = array();
            while($r =mysqli_fetch_row($query)){
                $i=array();
                $i['id'] = $r[0];
                $i['title'] = $r[1];
                $i['description'] = $r[2];
                $i['start_date'] = $r[3];
                $i['end_date'] = $r[4];
                $i['target'] = $r[5];
                $i['instructor'] = $r[6];
                $i['registered'] = $r[7];
                $i['last_updated'] = $r[8];
                $i['contact'] = $r[9];
                $i['phone'] = $r[10];
                $i['location'] = $r[11];
                $i['image'] = $r[13];
            $result = $i;
            }
            return $result;
        }
        return false;
    }
    static function deleteTrainingProgram($id){
        $query = mysqli_query(self::connect(),"update training set status=2 where id=".$id);
        if($query) return true;
        else return false;
    }
    static function updateTrainingProgram($data,$id){
        $result = array();
        $time = time();
        if($data == null) {
            $result['status'] = false;
            $result['message'] = "Please provide valid data";
            $result['program'] = false;
            
            return $result;

        }
        if(array_key_exists("image",$data)){
            $file = $data['image'];
            $allowedFiles = array("png","jpg","jpeg");
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            if(!in_array($ext,$allowedFiles)) {
                $result['status'] = false;
                $result['message'] = "Only images are allowed!";
                $result['program'] = self::getTrainingProgram($id);
                return $result;
            }
            if($file['size'] > 2048000){
                $result['status'] = false;
                $result['message'] = "Image file is too large. Please upload a file less than 2mb";
                $result['program'] = self::getTrainingProgram($id);
                return $result;
            }
            
        $filename = $time."_".basename($data['image']['name']);
        }
        
        $sql = "update training set last_updated = ".$time;
        $set = " ,";
        $upload = "programs/";
        
        foreach($data as $key => $value){
            if($key == "image"){
                $set .= $key." ='".$filename."', ";
            }
            else
            $set .= $key." = '".$value."', ";
        }
        $sql .= substr($set,0,strlen($set)-2)." where id=".$id;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            if(array_key_exists("image",$data)){
                $target_file = $upload.$filename;
                if(!move_uploaded_file($file['tmp_name'],$target_file)){
                    $result['status'] = true;
                $result['message'] = "Program was updated successfully but the image failed to upload";
                $result['program'] = self::getTrainingProgram($id);
                return $result;
                }
            }
            $result['status'] = true;
                $result['message'] = "Program was updated successfully";
                $result['program'] = self::getTrainingProgram($id);
                return $result;
        }
        else return false;
    }
    static function closeRegistrations($id){
        $query = mysqli_query(self::connect(),"update training set status=1 where id=".$id);
        if($query) return true;
        else return false;
    }
    static function createTrainingProgram($data){
        $result = array();
        $time = time();
        
        $upload = "programs/";
        if($data == null) {
            $result['status'] = false;
            $result['message'] = "Invalid event data!";
            return $result;
        }
        if(array_key_exists("image",$data)){
            $filename = $time."_".basename($data['image']['name']);
            $file = $data['image'];
            $allowedFiles = array("png","jpg","jpeg");
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            if(!in_array($ext,$allowedFiles)) {
                $result['status'] = false;
                $result['message'] = "Only images are allowed!";
                return $result;
            }
            if($file['size'] > 2048000){
                $result['status'] = false;
                $result['message'] = "Image file is too large. Please upload a file less than 2mb";
                return $result;
            }
        }
       
        
        $fields = "(last_updated,";
        $values = " values (".$time.",";
        $sql = "insert into training ";
        foreach($data as $key=>$value){
            if($key == "image"){
                $fields .= $key.",";
                $values .= "'".$filename."',";
            }
            else{
                $fields .= $key.",";
                $values .= "'".$value."',";
            }
            
        }
        $values = substr($values,0,strlen($values)-1).")";
        $fields = substr($fields,0,strlen($fields)-1).")";
        $sql .= $fields . $values;
        // echo $sql;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            if(array_key_exists("image",$data)){
                $target_file = $upload.$filename;
                if(move_uploaded_file($file['tmp_name'],$target_file)){
                    $result['status'] = true;
                $result['message'] = "Program was successfully created";
                return $result;
                }
            }
            
            $result['status'] = true;
            $result['message'] = "Program was successfully created but could not upload feature image";
            return $result;
        }
        else {
            $result['status'] = false;
            $result['message'] = "Could not create training program";
            return $result;
        }
    }
//end training programs

//start of jobs functions
    //create job listing
    static function createJob($data){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "insert into jobs (date_created,last_updated,position,contact,description,company,deadline) values ";
            $date_created = time();
            for($i=0; $i<count($data);$i++){
                $d = $data[$i];
            $position = $d['position'];
            $contact = $d['contact'];
            $description = $d['description'];
            $company = $d['company'];
            $deadline = $d['deadline'];
            
            $values .= "(".$date_created.",".$date_created.",'".$position."','".$contact."','".$description."','".$company."',".$deadline.")";
            if($i < sizeof($data)-1){
                $values .= ",";
            }
            }
            $sql .= $values;
            $query = mysqli_query(self::connect(),$sql);
            if($query){
                return true;
            }else return false;
    }
    static function updateJob($data,$jid){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "update jobs ";
            $set = " set ";
            $date_created = time();
            foreach($data as $key => $value){
                $set .= $key." = '".$value."', ";
            // $position = $d['position'];
            // $contact = $d['contact'];
            // $description = $d['description'];
            // $company = $d['company'];
            // $deadline = $d['deadline'];
            
            // $values .= "(".$date_created.",".$date_created.",'".$position."','".$contact."','".$description."','".$company."',".$deadline.")";
            // if($i < sizeof($data)-1){
            //     $values .= ",";
            // }
            }
            $sql .= substr($set,0,strlen($set)-2). " where id=".$jid;
            // echo $sql;
            $query = mysqli_query(self::connect(),$sql);
            if($query){
                return self::getJobById($jid);
            }else return false;
    }

    //delete job
    static function deleteJob($jid){
        $sql = "update jobs set status=1 where id=".$jid;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return true;
        }
        else return false;
    }

    //get job by id
    static function getJobById($jid){
        $result = array();
        $sql = "select * from jobs where id=".$jid." order by date_created desc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            while($r=mysqli_fetch_row($query)){
                $rec['id'] = $r[0];
                $rec['position'] = $r[1];
                $rec['description'] = $r[2];
                $rec['company'] = $r[3];
                $rec['contact'] = $r[4];
                $rec['date_created'] = $r[5];
                $rec['last_updated'] = $r[6];
                $rec['deadline'] = $r[7];

                $result = $rec;
            }

            return $result;
        }
        else return false;
    }
    //get job listings
    static function getJobListings(){
        $result = array();
        $deadline = time();
        $sql = "select * from jobs where status=0 order by date_created desc";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            while($r=mysqli_fetch_row($query)){
                $rec['id'] = $r[0];
                $rec['position'] = $r[1];
                $rec['description'] = $r[2];
                $rec['company'] = $r[3];
                $rec['contact'] = $r[4];
                $rec['date_created'] = $r[5];
                $rec['last_updated'] = $r[6];
                $rec['deadline'] = $r[7];

                $result[] = $rec;
            }

            return $result;
        }
        else return false;
    }
    static function searchJobs($keyword){
        $result = array();
        $sql = "select * from jobs where position like '%".$keyword."%' or description like '%".$keyword."%' or company like '%".$keyword."%' order by date_created desc";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            while($r=mysqli_fetch_row($query)){
                $rec['id'] = $r[0];
                $rec['position'] = $r[1];
                $rec['description'] = $r[2];
                $rec['company'] = $r[3];
                $rec['contact'] = $r[4];
                $rec['date_created'] = $r[5];
                $rec['last_updated'] = $r[6];
                $rec['deadline'] = $r[7];

                $result[] = $rec;
            }

            return $result;
        }
        else return false;
    }

    // check if job application already exists
    static function jobAppExists($cid,$jid){
        $sql = "select * from job_applications where candidate_id=".$cid." and job_id=".$jid;
        $query = mysqli_query(self::connect(),$sql);
        if($query && mysqli_num_rows($query) > 0) return true;
        else return false;
    }
    //create job application
    static function applyJob($candidate_id,$job_id,$attachment){
        $result = array();
        $con = self::connect();
        $date_created = time();
        $sql = 'insert into job_applications (job_id,candidate_id,date_created) values('.$job_id.','.$candidate_id.','.$date_created.')';
        $query = mysqli_query($con,$sql);
        if($query){
            $app = self::getApplicationWithId($con->insert_id);
$cv_path = "cvs/";
        $cover_letter_path = "cover_letters/";
        $allowedFiles = array("pdf","doc","docx");
        if(array_key_exists("cv",$attachment)){
            $ext = pathinfo($attachment['cv']['name'],PATHINFO_EXTENSION);
            $result = self::validateUploadedFile($attachment['cv'],array("extensions"=>$allowedFiles,"max_size"=>2048000));
            if(!$result['status']) return $result;
            $filename ="_".time().".".$ext;
            
            $target = $cv_path.$filename;
            if(!move_uploaded_file($attachment['cv']['tmp_name'],$target)){
                $result['status'] = false;
                $result['message'] = "Could not upload your CV file!";
            } 
            else{
                $cvSql = "update job_applications set cv='".$target."' where id=".$app['id'];
                $q = $con->query($cvSql);
                if(!$q) {
                    $result['status'] = false;
                    $result['message'] = "Could not update CV information";
                    unlink($target);
                }
            }
        }
        //verify and upload cover letter
         if(array_key_exists("letter",$attachment)){
            $ext = pathinfo($attachment['letter']['name'],PATHINFO_EXTENSION);
            $result = self::validateUploadedFile($attachment['letter'],array("extensions"=>$allowedFiles,"max_size"=>2048000));
            if(!$result['status']) return $result;
                $filename ="_".time().".".$ext;
                $target = $cover_letter_path.$filename;
            if(!move_uploaded_file($attachment['letter']['tmp_name'],$target)){
                $result['status'] = false;
                $result['message'] = "Could not upload your cover letter file!";
            } 
            else{
                $clSql = "update job_applications set letter='".$target."' where id=".$app['id'];
                $q = $con->query($clSql);
                if(!$q) {
                    $result['status'] = false;
                    $result['message'] = "Could not update cover letter information";
                    unlink($target);
                }
            }
        }
        return $result;
    }
}

    //get list of job applications
    static function getJobApplications($job_id){
        $sql = "select u.id as uid,u.name,u.email,u.phone,j.id as jid,j.position,j.company,ja.id as jaid,ja.date_created,ja.status from user as u join job_applications as ja on u.id = ja.candidate_id join jobs as j on j.id=ja.job_id";
        if($job_id != null) $sql .= " where j.id=".$job_id;
        $result = array();
        $query = mysqli_query(self::connect(),$sql);
        if(mysqli_num_rows($query) > 0){
            while($r = mysqli_fetch_row($query)){
                $rs['uid'] = $r[0];
                $rs['name'] = $r[1];
                $rs['email'] = $r[2];
                $rs['qualification'] = self::getHighestQualification($r[2]);
                $rs['phone'] = $r[3];
                $rs['jid'] = $r[4];
                $rs['position'] = $r[5];
                $rs['company'] = $r[6];
                $rs['jaid'] = $r[7];
                $rs['date_created'] = $r[8];
                $rs['status'] = self::getJobApplicationStatus($r[9]);
                $result[] = $rs;
            }
            return $result;
        }
        else return false;
    }

    //get job application status
    static function getJobApplicationStatus($status_id){
        switch($status_id){
            case 0:
                return "Received";
            case 1:
                return "Accepted";
            case 2: 
                return "Rejected";
        }
    }
//end jobs

//start applications
static function loginApplication($data){
    if($data == null) return false;
    
    $sql = "select * from applications where contact='".$data['email']."' and program=".$data['program']." order by id desc";
    $query = mysqli_query(self::connect(),$sql);
    if(mysqli_num_rows($query) ==1){
        $result = array();
        while($r = mysqli_fetch_row($query)){
            $i = array();
            $i['id'] = $r[0];
            $i['name'] = $r[1];
            $i['is_company'] = $r[2];
            $i['contact'] = $r[3];
            $i['phone'] = $r[4];
            $i['institution'] = $r[5];
            $i['proof'] = $r[6];
            $i['status'] = $r[7];
            $i['program'] = $r[8];
            $i['date_created'] = $r[9];
            $i['last_updated'] = $r[10];
            $i['number_of_applicants'] = $r[12];
            $i['password'] = $r[13];
            $i['status_text'] = self::getApplicationStatus()[$r[7]];
            $i['program_title'] = self::getTrainingProgram($r[8])['title'];
            $result = $i;
        }
        if(password_verify($data['password'],$result['password'])){
            unset($result['password']);
            return $result;
        }
        return false;
    }
    return false;
}
static function getApplications(){
    $sql = "select * from applications order by id desc";
    $query = mysqli_query(self::connect(),$sql);
    if($query){
        $result = array();
        while($r=mysqli_fetch_row($query)){
            $i = array();
            $i['id'] = $r[0];
            $i['name'] = $r[1];
            $i['is_company'] = $r[2];
            $i['contact'] = $r[3];
            $i['phone'] = $r[4];
            $i['institution'] = $r[5];
            $i['proof'] = $r[6];
            $i['status'] = $r[7];
            $i['program'] = $r[8];
            $i['date_created'] = $r[9];
            $i['last_updated'] = $r[10];
            $i['status_text'] = self::getApplicationStatus()[$r[7]];
            $i['program_title'] = self::getTrainingProgram($r[8])['title'];
            $result[] = $i;
        }
        return $result;
    }
    return false;
}

static function getApplicationWithId($id){
    $sql = "select * from applications where id=".$id." limit 1";
    $query = mysqli_query(self::connect(),$sql);
    if($query){
        $result = array();
        while($r=mysqli_fetch_row($query)){
            $i = array();
            $i['id'] = $r[0];
            $i['name'] = $r[1];
            $i['is_company'] = $r[2];
            $i['contact'] = $r[3];
            $i['phone'] = $r[4];
            $i['institution'] = $r[5];
            $i['proof'] = $r[6];
            $i['status'] = $r[7];
            $i['program'] = $r[8];
            $i['date_created'] = $r[9];
            $i['last_updated'] = $r[10];
            $i['number_of_applicants'] = $r[12];
            $i['status_text'] = self::getApplicationStatus()[$r[7]];
            $i['program_title'] = self::getTrainingProgram($r[8])['title'];
            $result = $i;
        }
        return $result;
    }
    return false; 
}
static function acceptApplication($id){
    $sql = "update applications set status=1 where id=".$id;
    $query = mysqli_query(self::connect(),$sql);
    if($query){
        $result['status'] = true;
        $result['message'] = "Application was updated successfully!";
        $result['application'] = self::getApplicationWithId($id);
        return $result;
    }
    $result['status'] = false;
        $result['message'] = "Could not successfully update this application!";
        $result['application'] = self::getApplicationWithId($id);
        return $result;
}
static function rejectApplication($id){
    $sql = "update applications set status=2 where id=".$id;
   
    $query = mysqli_query(self::connect(),$sql);
    if($query){
        $result['status'] = true;
        $result['message'] = "Application was updated successfully!";
        $result['application'] = self::getApplicationWithId($id);
        return $result;
    }
    $result['status'] = false;
        $result['message'] = "Could not successfully update this application!";
        $result['application'] = self::getApplicationWithId($id);
        return $result;
}
static function deleteApplication($id){
    $sql = "update applications set status=3 where id=".$id;
    $query = mysqli_query(self::connect(),$sql);
    return $query;
}
static function applicantionExists($email,$program){
    $check = "select contact from applications where contact ='".$data['contact']."' and program=".$program;
    $query = mysqli_query(self::connect(),$sql);
    if($query){
        if(mysqli_num_rows($query) > 0){
            return true;
        }
    }
    
    return false;
}
static function createApplication($data){
    $result = array();
    if($data == null){
        $result['status'] = false;
        $result['message'] = "Please provide application data!";
        $result['application'] = false;
        return $result;
    }
    if(self::applicantionExists($data['contact'],$data['program'])){
        $result['status'] = false;
        $result['message'] = "You already registered for this program! Please login to view your application";
        $result['application'] = false;
        return $result;
    }
    $proofs = "proofs/";
    $allowedFiles = array("pdf","jpg","jpeg","png");
    if(array_key_exists("proof",$data)){
        $ext = pathinfo($data['proof']['name'],PATHINFO_EXTENSION);
        $result = self::validateUploadedFile($data['proof'],array("extensions"=>$allowedFiles,"max_size"=>2048000));
        if(!$result['status']) return $result;
    }
   
    $time = time();
    $sql = "insert into applications ";
    $fields = "(date_created,last_updated,";
    $values = " values (".$time.",".$time.",";
    $number_of_apps = 1;
    if(array_key_exists("number_of_applicants",$data)) $number_of_apps = $data['number_of_applicants'];
    foreach($data as $key => $value){
        
        if($key == 'proof'){
            $filename = "_".$time.".".$ext;
            $fields .= $key.",";
            $values .= "'".$filename."',";
        }
        else{
            if($key == "password"){
                $hash = password_hash($value,PASSWORD_BCRYPT);
                $fields .= $key.",";
                $values .= "'".$hash."',";
            }
            else{
            $fields .= $key.",";
            $values .= "'".$value."',";
            }
        }
    }
    $fields = substr($fields,0,strlen($fields)-1) .")";
    $values = substr($values,0,strlen($values)-1) .")";

    $sql .= $fields . $values ;
    $query = mysqli_query(self::connect(),$sql);
    if($query){
        $result['status'] = true;
        $result['message'] = "Congratulations! Your application was successful";
        if(array_key_exists("proof",$data)){
            $target_file = $proofs."_".$time.".".$ext;
            if(!move_uploaded_file($data['proof']['tmp_name'],$target_file)){
                $result['message'] = "Congratulations! Your application was successful";
            }
        }
        $result['application'] = true;
        mysqli_query(self::connect(),"update training set registered =(registered + ".$number_of_apps.") where id=".$data['program']);
        return $result;
    }
    else{
        $result['status'] = false;
        $result['message'] = "Sorry! Could not create your application! Please try again later";
        $result['application'] = false;
        return $result;
    }
}

static function updateApplication($data,$id){
    $result = array();
    if($data == null){
        $result['status'] = false;
        $result['message'] = "Please provide application data!";
        $result['application'] = false;
        return $result;
    }
    $number_before = false;
    if(array_key_exists("number_before",$data)){
        $number_before = $data['number_before'];
        unset($data['number_before']);
    }
    $proofs = "proofs/";
    $allowedFiles = array("pdf","jpg","jpeg","png");
    $time = time();
    $sql = "update applications set ";
    $set = "date_created = ".$time.", last_updated=".$time.", ";

    if(array_key_exists("proof",$data)){
        $result = self::validateUploadedFile($data['proof'],array("extensions"=>$allowedFiles,"max_size"=>2048000));
        if(!$result['status']) return $result;
        $ext = pathinfo($data['proof']['name'],PATHINFO_EXTENSION);
    }
   
    foreach($data as $key => $value){
       
        if($key == 'proof'){
            $filename = "_".$time.".".$ext;
            $set .= $key." = '".$filename."', ";
        }
        else{
            $set .= $key." = '".$value."', ";
        }
       
    }
    $sql .= substr($set,0,strlen($set)-2) ." where id=".$id;
    
    $query = mysqli_query(self::connect(),$sql);
    
    if($query){
        $result['status'] = true;
        $result['message'] = "Congratulations! Your application was successfully updated";
        if(array_key_exists("proof",$data)){
            $ext = pathinfo($data['proof']['name'],PATHINFO_EXTENSION);
            $target_file = $proofs."_".$time.".".$ext;
            if(!move_uploaded_file($data['proof']['tmp_name'],$target_file)){
                $result['message'] = "Congratulations! Your application was successful. But your proof of payment was not upload successfully";
            }
        }
        $result['application'] = self::getApplicationWithId($id);

        if(!$number_before){
            
        }
        else{
            $change = $data['number_of_applicants'] - $number_before;
            if($change < 0) $op = " - "; else $op = " + ";
            $sql = "update training set registered =(registered".$op. abs($change).") where id=".$result['application']['program'];
            echo "sql: ".$sql;
            mysqli_query(self::connect(),$sql);
        }
        return $result;
    }
    else{
        $result['status'] = false;
        $result['message'] = "Sorry! Could not update your application! Please try again later";
        $result['application'] = false;
        return $result;
    }
}

static function searchApplications($options){
    if($options == null) return false;
    
    $sql = "select * from applications ";
    $condition = "where ";
    if(is_array($options)){
        if(isset($options['name'])) $keyword = $options['name'];
        if(isset($options['program'])) $program = $options['program'];
        $condition .= "name like '%".$keyword."%' or institution like '%".$keyword."%' and program=".$program;
    }
   else $condition .= "name like '%".$options."%' or institution like '%".$options."%'";
    $sql .= $condition;

    $query = mysqli_query(self::connect(),$sql);
    if($query){
        $result = array();
        while($r = mysqli_fetch_row($query)){
            $i = array();
            $i['id'] = $r[0];
            $i['name'] = $r[1];
            $i['is_company'] = $r[2];
            $i['contact'] = $r[3];
            $i['phone'] = $r[4];
            $i['institution'] = $r[5];
            $i['proof'] = $r[6];
            $i['status'] = $r[7];
            $i['program'] = $r[8];
            $i['date_created'] = $r[9];
            $i['last_updated'] = $r[10];
            $i['status_text'] = self::getApplicationStatus()[$r[7]];
            $i['program_title'] = self::getTrainingProgram($r[8])['title'];
            $result[] = $i;
        }
        return $result;
    }
    return false;
}
//end applicaitons


//start of events
    static function getEvents(){
        $sql = "select * from events where status >0 order by id desc";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            while($r = mysqli_fetch_row($query)){
                $item = array();
                $item['id'] = $r[0];
                $item['title'] = $r[1];
                $item['content'] = $r[2];
                $item['image'] = $r[3];
                $item['caption'] = $r[4];
                $item['status'] = $r[5];
                $item['date_created'] = $r[6];
                $item['event_date'] = $r[7];
                $item['last_updated'] = $r[8];
                $item['location'] = $r[9];
                $item['link'] = $r[10];
                $item['link_text'] = $r[11];

                $result[] = $item;
            }
            return $result;
        }
        else return false;
    }
    static function searchArchivedEvents($keyword){
        $sql = "select * from events where status = 2 and title like '%".$keyword."%' or content like '%".$keyword."%' or caption like '%".$keyword."%' order by event_date desc";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            while($r = mysqli_fetch_row($query)){
                $item = array();
                $item['id'] = $r[0];
                $item['title'] = $r[1];
                $item['content'] = $r[2];
                $item['image'] = $r[3];
                $item['caption'] = $r[4];
                $item['status'] = $r[5];
                $item['date_created'] = $r[6];
                $item['event_date'] = $r[7];
                $item['last_updated'] = $r[8];
                $item['location'] = $r[9];
                $item['link'] = $r[10];
                $item['link_text'] = $r[11];

                $result[] = $item;
            }
            return $result;
        }
        else return false;
    }
    static function getEventById($id){
        $sql = "select * from events where id=".$id." limit 1";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            while($r = mysqli_fetch_row($query)){
                $item = array();
                $item['id'] = $r[0];
                $item['title'] = $r[1];
                $item['content'] = $r[2];
                $item['image'] = $r[3];
                $item['caption'] = $r[4];
                $item['status'] = $r[5];
                $item['date_created'] = $r[6];
                $item['event_date'] = $r[7];
                $item['last_updated'] = $r[8];
                $item['location'] = $r[9];
                $item['link'] = $r[10];
                $item['link_text'] = $r[11];

                $result = $item;
            }
            return $result;
        }
        else return false;
    }
    static function updateEvent($event,$id){
        $result = array();
        $time = time();
        $upload = "snaps/";
        if($event == null) {
            $result['status'] = false;
            $result['message'] = "Invalid event data!";
            $result['event'] = self::getEventById($id);
            return $result;
        }
        if(array_key_exists("image",$event)){
            $file = $event['image'];
            $allowedFiles = array("png","jpg","jpeg");
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            if(!in_array($ext,$allowedFiles)) {
                $result['status'] = false;
                $result['message'] = "Only images are allowed!";
                $result['event'] = self::getEventById($id);
                return $result;
            }
            if($file['size'] > 2048000){
                $result['status'] = false;
                $result['message'] = "Image file is too large. Please upload a file less than 2mb";
                $result['event'] = self::getEventById($id);
                return $result;
            }
            
        $filename = $time."_".basename($event['image']['name']);
        }
        
        $sql = "update events set last_updated =".$time;
        $set = ", ";
        foreach($event as $key=>$value){
            if($key == "image"){
                $set .= $key." = '".$filename."', ";
            }
            else{
                $set .= $key." = '".$value."', ";
            }
            
        }
        $set = substr($set,0,strlen($set)-2)." where id=".$id;
        $sql .= $set;
        // echo $sql;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            $result['status'] = true;
            
            if(array_key_exists("image",$event)){
                $target_file = $upload.$filename;
                if(move_uploaded_file($file['tmp_name'],$target_file)) 
                    $result['message'] = "Event was successfully updated";
                else 
            $result['message'] = "Event was successfully updated but could not upload feature image";

           }
           else {
               $result['message'] = "Event was successfully updated";
           }
           $result['event'] = self::getEventById($id);
            return $result;
            
        }
        else {
            $result['status'] = false;
            $result['message'] = "Could not update event";
            $result['event'] = self::getEventById($id);
            return $result;
        }
    }

    static function createEvent($event){
        $result = array();
        $upload = "snaps/";
        if($event == null) {
            $result['status'] = false;
            $result['message'] = "Invalid event data!";
            return $result;
        }
        $file = $event['image'];
        $allowedFiles = array("png","jpg","jpeg");
        $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
        if(!in_array($ext,$allowedFiles)) {
            $result['status'] = false;
            $result['message'] = "Only images are allowed!";
            return $result;
        }
        if($file['size'] > 2048000){
            $result['status'] = false;
            $result['message'] = "Image file is too large. Please upload a file less than 2mb";
            return $result;
        }
        $time = time();
        $filename = $time."_".basename($event['image']['name']);
        $fields = "(date_created,last_updated,";
        $values = " values (".$time.",".$time.",";
        $sql = "insert into events ";
        foreach($event as $key=>$value){
            if($key == "image"){
                $fields .= $key.",";
                $values .= "'".$filename."',";
            }
            else{
                $fields .= $key.",";
                $values .= "'".$value."',";
            }
            
        }
        $values = substr($values,0,strlen($values)-1).")";
        $fields = substr($fields,0,strlen($fields)-1).")";
        $sql .= $fields . $values;
        // echo $sql;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            $target_file = $upload.$filename;
            if(move_uploaded_file($file['tmp_name'],$target_file)){
                $result['status'] = true;
            $result['message'] = "Event was successfully created";
            return $result;
            }
            $result['status'] = true;
            $result['message'] = "Event was successfully created but could not upload feature image";
            return $result;
        }
        else {
            $result['status'] = false;
            $result['message'] = "Could not create event";
            return $result;
        }
    }

    static function deleteEvent($id){
        $last_updated = time();
        $sql = "update events set status=2, last_updated=".$last_updated." where id=".$id;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return true;
        }
        return false;
    }

    static function archiveEvent($id){
        $last_updated = time();
        $sql = "update events set status=1, last_updated=".$last_updated." where id=".$id;
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return true;
        }
        return false;
    }
//end events

    static function getApplicationStatus(){
        $stata = array("Received","Accepted","Rejected","Deleted");
        return $stata;
    }

    static function validateUploadedFile($file,$options){
        $allowedFiles = $options['extensions'];
        $fileSize = $options['max_size'];
       
            if($file['error'] != 0){
                $result['status'] = false;
                $result['message'] = "Oops! Something went wrong. Make sure the file is in the supported format and the correct file size";
                
                return $result;
            }
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            if(!in_array($ext,$allowedFiles)){
                $result['status'] = false;
                $result['message'] = "Oops! That kind of file is not supported. We accept PDF,JPG,JPEG and PNG";
                
                return $result;
            }
            
            if($file['size'] > 2048000){
                $result['status'] = false;
                $result['message'] = "Sorry! That file is too large. Please make it 2mb or less!";
                
                return $result;
            }
            $result['status'] = true;
                $result['message'] = "Your file is good to upload";
                
                return $result;
        
    }
    static function getLevels(){
        $levels = array("Doctorate","Master","Bachelor","Diploma","Certificate","ACSEE Certificate","CSEE Certificate");
        return $levels;
    }
    static function months(){
       return array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12);
    }
    static function getMonth($number){
        foreach(self::months() as $key => $value){
            if($value == $number) return $key;
        }
    }
    static function listCountries(){
        $countries =
 
array(
"AF" => "Afghanistan",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"IO" => "British Indian Ocean Territory",
"BN" => "Brunei Darussalam",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos (Keeling) Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo",
"CD" => "Congo, the Democratic Republic of the",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"CI" => "Cote D'Ivoire",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands (Malvinas)",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GN" => "Guinea",
"GW" => "Guinea-Bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and Mcdonald Islands",
"VA" => "Holy See (Vatican City State)",
"HN" => "Honduras",
"HK" => "Hong Kong",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran, Islamic Republic of",
"IQ" => "Iraq",
"IE" => "Ireland",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KP" => "Korea, Democratic People's Republic of",
"KR" => "Korea, Republic of",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Lao People's Democratic Republic",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libyan Arab Jamahiriya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macao",
"MK" => "Macedonia, the Former Yugoslav Republic of",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"MX" => "Mexico",
"FM" => "Micronesia, Federated States of",
"MD" => "Moldova, Republic of",
"MC" => "Monaco",
"MN" => "Mongolia",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territory, Occupied",
"PA" => "Panama",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RE" => "Reunion",
"RO" => "Romania",
"RU" => "Russian Federation",
"RW" => "Rwanda",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and the Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"ST" => "Sao Tome and Principe",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"CS" => "Serbia and Montenegro",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and the South Sandwich Islands",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syrian Arab Republic",
"TW" => "Taiwan, Province of China",
"TJ" => "Tajikistan",
"TZ" => "Tanzania, United Republic of",
"TH" => "Thailand",
"TL" => "Timor-Leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UG" => "Uganda",
"UA" => "Ukraine",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"UM" => "United States Minor Outlying Islands",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VE" => "Venezuela",
"VN" => "Viet Nam",
"VG" => "Virgin Islands, British",
"VI" => "Virgin Islands, U.s.",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe"
);
  return $countries;
  }

  static function getCountry($code){
      return array_key_exists($code,self::listCountries()) ? self::listCountries()[$code] : 'Not Available';
  }

  static function getTanzaniaCities(){
      $cities = array(
    "Arusha",
    "Dar es Salaam",
     "Dodoma",
     "Geita",
     "Iringa",
     "Kagera",
     "Kaskazini Pemba",
     "Kaskazini Unguja",
     "Katavi",
     "Kilimanjaro",
     "Kigoma",
     "Kusini Pemba",
     "Kusini Unguja",
     "Lindi",
     "Manyara",
     "Mara",
     "Mbeya",
     "Mjini Magharibi",
     "Morogoro",
     "Mtwara",
     "Mwanza",
     "Njombe",
     "Pwani",
     "Rukwa",
     "Ruvuma",
     "Shinyanga",
     "Simiyu",
     "Singida",
     "Songwe",
     "Tabora",
     "Tanga");

     return $cities;

  }
}

?>