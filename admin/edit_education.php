<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$user = DB::getUser($_SESSION['user']);
$msg = "";
$task = "new";
if($_GET['e'] != $user['id']) die("Not your account");
else{
if(isset($_GET['del'])) {
 
  $task = "delete";
  $education = DB::getEducationRecord($_GET['del']);
}
else{
  if(isset($_GET['ed'])) {
    $education = DB::getEducationRecord($_GET['ed']);
    $task = "update";
  }
  else{
    $education = false;
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
        class="flex-row flex-end flex-middle w-100 padding-std margin-auto"
      >
        
        <nav class="flex-row flex-center white-bg" id="navigation">
          <a href="account.php?e='.$user['email'].'" >Account</a>
          <a href="../jobs/job_listings.php">Jobs</a>
          <a href="signout.php" >Signout</a>
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>
    </header>
    
';

if(isset($_POST['submit'])){
    $institution = filter_var($_POST['institution'],FILTER_SANITIZE_STRING);
    $title = filter_var($_POST['program'],FILTER_SANITIZE_STRING);
    $level = $_POST['level'];
    $major = $_POST['major'];
    $year = $_POST['year'];
    $country = $_POST['country'];

    $data = array();
    $info = array("level"=>$level,"title"=>$title,"institution"=>$institution,"major"=>$major,"country"=>$country,"year"=>$year);
    $data[0] = $info;
    $action = DB::createEducationProfile($user,$data);
    if($action){
      $msg = "Record successfully saved!";
    }
    else $msg = "Could not save record!";
}
if(isset($_POST['submitUpdate'])){
  $institution = filter_var($_POST['institution'],FILTER_SANITIZE_STRING);
  $title = filter_var($_POST['program'],FILTER_SANITIZE_STRING);
  $level = $_POST['level'];
  $major = $_POST['major'];
  $year = $_POST['year'];
  $country = $_POST['country'];

  $info = array("level"=>$level,"title"=>$title,"institution"=>$institution,"major"=>$major,"country"=>$country,"year"=>$year);
  
  $action = DB::updateEducationRecord($info,$_GET['ed']);
  if(!$action){
    $msg = "Could not update record!";
  }
  else {
    $education = $action;
    $msg = "Record successfully updated!";
  }
}
if(isset($_POST['submitDelete'])){
  
  $action = DB::deleteEducationRecord($_GET['del']);
  if($action){
    $msg = "Record successfully deleted!";
  }
  else $msg = "Could not delete record!";
}

echo ' <span class="error-text padding-small">'.$msg.'</span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Education Background</p><a class="button primary-bg border-white-all round-corner" href="profile.php">Close</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="w-100 flex-column flex-start flex-top accent-bg dark-text padding-std" action="" method="POST">
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="institution">Institution</label>
<input type="text" name="institution" id="institution" placeholder="Institution" value="'.$education['institution'].'" class="w-100 form-control padding-small"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="program">Study Program</label>
<input type="text" name="program" id="program"  value="'.$education['title'].'" placeholder="program"class="w-100 form-control padding-small"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="level">Select Level</label>
<select name="level" id="level" class="w-75 form-control padding-small">';
    $levels = DB::getLevels();
    for($i=0;$i<sizeof($levels);$i++){
      if($education['level'] == $levels[$i])
      echo '<option selected>'.$levels[$i].'</option>';
      else echo '<option>'.$levels[$i].'</option>';
    }
    
echo '</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="major">Select Area of Study</label>
<select name="major" id="major" class="w-75 form-control padding-small">';
   $careers = DB::listCareers();
   for($i=0;$i<sizeof($careers);$i++){
     if($education['major'] == $careers[$i]['name'])
     echo '<option selected>'.$careers[$i]['name'].'</option>';
     else echo '<option>'.$careers[$i]['name'].'</option>';
   }
    
echo '</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="country">Country</label>
<select name="country" id="country" class="w-75 form-control padding-small">';
$countries = DB::listCountries();
foreach($countries as $code => $name){
    if($education['country'] == $code)
    echo "<option value=".$code." selected>".$code." - ".$name."</option>";
    else 
    echo "<option value=".$code.">".$code." - ".$name."</option>";
}
    
echo '</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="year">Year of Completion</label>
<select name="year" id="year" class="w-75 form-control padding-small">';
$year = date('Y');
for($i=0;$i<40;$i++){
    $y = $year - $i;
    if($y == $education['year'])
    echo "<option selected>".$y."</option>";
    else 
    echo "<option>".$y."</option>";
}
    
echo '</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">';
if($task == 'update') {
  echo'
<input type="submit" name="submitUpdate" id="submitUpdate" value="UPDATE" class="button round-corner primary-bg border-white-all white-text w-100 form-control padding-small"/>';
}
else{
   if($task == 'delete') {
     echo'
<input type="submit" name="submitDelete" id="submitDelete" value="DELETE" class="button round-corner alert-bg border-white-all white-text w-100 form-control padding-small"/>';
   }
else {
   echo'
<input type="submit" name="submit" id="submit" value="SAVE" class="button round-corner primary-bg border-white-all white-text w-100 form-control padding-small"/>';
}
}
echo '</div></form>
</div>
</section>';

echo "</body>";
?>
