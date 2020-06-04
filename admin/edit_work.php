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
  $work = DB::getWorkRecord($_GET['del']);
}
else{
  if(isset($_GET['ed'])) {
    $work = DB::getWorkRecord($_GET['ed']);
    $task = "update";
  }
  else{
    $work = false;
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
    $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
    $tasks = $_POST['tasks'];
    $year_start = $_POST['year_start'];
    $year_end = isset($_POST['current']) ? $_POST['current'] : $_POST['year_end'];
    $month_start = $_POST['month_start'];
    $month_end = $_POST['month_end'];
    $country = $_POST['country'];

    $data = array();
    $info = array("title"=>$title,"institution"=>$institution,"tasks"=>$tasks,"year_start"=>$year_start,"year_end"=>$year_end,"month_start"=>$month_start,"month_end"=>$month_end,"country"=>$country);
    $data[0] = $info;
    $action = DB::createWorkProfile($user['email'],$data);
    if($action){
      $msg = "Record successfully saved!";
    }
    else $msg = "Could not save record!";
}

if(isset($_POST['submitUpdate'])){
  $institution = filter_var($_POST['institution'],FILTER_SANITIZE_STRING);
  $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
  $tasks = $_POST['tasks'];
  $year_start = $_POST['year_start'];
  $year_end = isset($_POST['current']) ? $_POST['current'] : $_POST['year_end'];
  $month_start = $_POST['month_start'];
  $month_end = $_POST['month_end'];
  $country = $_POST['country'];

  $info = array("title"=>$title,"institution"=>$institution,"tasks"=>$tasks,"year_start"=>$year_start,"year_end"=>$year_end,"month_start"=>$month_start,"month_end"=>$month_end,"country"=>$country);
  
  $action = DB::updateWorkRecord($info,$_GET['ed']);
  if($action){
    $msg = "Record successfully updated!";
    $work = $action;
  }
  else $msg = "Could not update record!";
}

if(isset($_POST['submitDel'])){
  
  $action = DB::deleteWorkRecord($_GET['del']);
  if($action){
    $msg = "Record successfully deleted!";
  }
  else $msg = "Could not delete record!";
}

echo ' <span class="error-text">'.$msg.'</span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Professional Background</p><a class="button primary-bg border-white-all round-corner" href="profile.php">Close</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="w-100 flex-column flex-start flex-top accent-bg dark-text padding-std" action="" method="POST">
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="institution">Institution</label>
<input type="text" name="institution" id="institution" placeholder="Institution" class="w-100 form-control padding-small" value="'.$work['institution'].'"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="title">Title/Position</label>
<input type="text" name="title" id="title" placeholder="Position"class="w-100 form-control padding-small" value="'.$work['title'].'"/>
</div>
<div class="w-100 flex-row flex-start flex-middle">
<div class="w-50 padding-small flex-column flex-start flex-top">
<label for="month_start">Start Month</label>
<select name="month_start" id="month_start" class=" form-control padding-small">';
  foreach(DB::months() as $key=>$value){
    if($value == $work['month_start'])
    echo "<option selected value=".$value.">".$key."</option>";
    else
      echo "<option value=".$value.">".$key."</option>";
  }  
    
echo '</select>
</div>
<div class="w-50 padding-small flex-column flex-start flex-top">
<label for="year_start">Start Year</label>
<select name="year_start" id="year_start" class="form-control padding-small">';
$year = date('Y');
for($i=0;$i<40;$i++){
    $y = $year - $i;
    if($y == $work['year_start'])
    echo "<option selected>".$y."</option>";
    else 
    echo "<option>".$y."</option>";
}
    
echo '</select></div>

</div>

<div class="w-100 flex-row flex-start flex-middle">
<div class="w-50 padding-small flex-column flex-start flex-top">
<label for="month_end">End Month</label>
<select name="month_end" id="month_end" class="form-control padding-small">';
  foreach(DB::months() as $key=>$value){
    if($value == $work['month_end'])
    echo "<option selected value=".$value.">".$key."</option>";
    else
      echo "<option value=".$value.">".$key."</option>";
  }  
    
echo '</select>
</div>
<div class="w-50 padding-small flex-column flex-start flex-top">
<label for="year_end">End Year</label>
<select name="year_end" id="year_end" class="form-control padding-small">';
$year = date('Y');
for($i=0;$i<40;$i++){
    $y = $year - $i;
    if($y == $work['year_end'])
    echo "<option selected>".$y."</option>";
    else 
    echo "<option>".$y."</option>";
}
    $checked = ($work['year_end'] == -1 ? "checked" : "");
echo '</select></div>
<div class="w-50 padding-small flex-column flex-start flex-top">
<label for="current">Still Working</label>
<input type="checkbox" '.$checked.' name="current" id="current" class="form-control padding-std" value="-1"/></div>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="tasks">Major Tasks</label>
<textarea name="tasks" id="tasks" class="w-100 form-control padding-small" rows="10">'.$work['tasks'].'</textarea></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="country">Country</label>
<select name="country" id="country" class="w-75 form-control padding-small">';
$countries = DB::listCountries();
foreach($countries as $code => $name){
  if($work['country'] == $code)
  echo "<option value=".$code." selected>".$code." - ".$name."</option>";
  else 
    echo "<option value=".$code.">".$code." - ".$name."</option>";
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
<input type="submit" name="submitDel" id="submitDel" value="DELETE" class="button round-corner alert-bg border-white-all white-text w-100 form-control padding-small"/>';
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
