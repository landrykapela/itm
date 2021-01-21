<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$user = DB::getUser($_SESSION['user']);
if($_GET['e'] != $user['id']) die("Not your account");
$msg = "";
$task = "new";
if($_GET['e'] != $user['id']) die("Not your account");
else{
if(isset($_GET['del'])) {
 
  $task = "delete";
  $referee = DB::getReferenceRecord($_GET['del']);
}
else{
  if(isset($_GET['ed'])) {
    $referee = DB::getReferenceRecord($_GET['ed']);
    $task = "update";
  }
  else{
    $referee = false;
  }
}
}
echo '<!DOCTYPE html>
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
<link href="../styles/general.css" rel="stylesheet" />
<link href="../styles/general_mobile.css" rel="stylesheet" />
<link href="../styles/general_large.css" rel="stylesheet" />
<link href="../styles/general_tablet.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" href="../images/favicon.png" />

    <title>ITM Tanzania - Job Portal</title>
  </head>
  <body>
    <header
      id="header"
      class="min-width-full flex-column flex-top flex-start margin-auto"
    >
      <div
        class="flex-row flex-start flex-middle w-100 padding-std margin-auto"
      >
        
        <nav class="flex-row flex-center white-bg" id="navigation">
          <a href="account.php?e='.$user['id'].'" >Account</a>
          <a href="..jobs/job_listings.php">Jobs</a>
          <a href="signout.php" >Signout</a>
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>
    </header>
';

if(isset($_POST['submit'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'],FILTER_SANITIZE_EMAIL);
    $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $data = array();
    $info = array("name"=>$name,"title"=>$title,"contact"=>$contact,"phone"=>$phone);
    $data[0] = $info;
    $action = DB::createReferenceProfile($user['email'],$data);
    if(!$action){
      $msg = "Could not create record!";
      
    }
    else{
      $msg = "Record successfully saved!";
      // $referee = $action;
    }
}

if(isset($_POST['submitUpdate'])){
  $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
  $contact = filter_var($_POST['contact'],FILTER_SANITIZE_EMAIL);
  $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
  $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
  
  $info = array("name"=>$name,"title"=>$title,"contact"=>$contact,"phone"=>$phone);
  
  $action = DB::updateReferenceRecord($info,$_GET['ed']);
  if(!$action){
    $msg = "Could not update record!";
    
  }
  else{
    $msg = "Record successfully updated!";
    $referee = $action;
  }
}


if(isset($_POST['submitDel'])){
  
  $action = DB::deleteReferenceRecord($_GET['del']);
  if(!$action){
    $msg = "Could not delete record!";
    
  }
  else{
    $msg = "Record successfully deleted!";
  }
}


echo ' <span class="error-text">'.$msg.'</span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-middle  primary-bg white-text">
<p class="title">Reference</p><a class="button primary-bg border-white-all round-corner" href="profile.php">Close</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="margin-auto w-80 flex-column flex-start flex-top accent-bg dark-text padding-std" action="" method="POST">
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="name">Name of Referee</label>
<input type="text" name="name" id="name" placeholder="Enter the name of the referee" class="w-100  padding-small" value="'.$referee['name'].'"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="title">Title/Company</label>
<input type="text" name="title" id="title" placeholder="Title or company" class="w-100  padding-small" value="'.$referee['title'].'"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="contact">Referee E-mail </label>
<input type="text" name="contact" id="contact" placeholder="E-mail address" class="w-100  padding-small" value="'.$referee['contact'].'"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="contact">Referee Phone Number </label>
<input type="text" name="phone" id="phone" placeholder="Phone number..." class="w-100  padding-small" value="'.$referee['phone'].'"/>
</div>

<div class="w-100 padding-small flex-column flex-start flex-top">';
if($task == 'update') {
  echo'
<input type="submit" name="submitUpdate" id="submitUpdate" value="UPDATE" class="button round-corner primary-bg border-white-all white-text padding-small"/>';
}
else{
   if($task == 'delete') {
     echo'
<input type="submit" name="submitDel" id="submitDel" value="DELETE" class="button round-corner alert-bg border-white-all white-text padding-small"/>';
   }
else {
   echo'
<input type="submit" name="submit" id="submit" value="SAVE" class="button round-corner primary-bg border-white-all white-text padding-small"/>';
}
}
echo '</div></form>
</div>
</section>';

echo "</body>";
?>
