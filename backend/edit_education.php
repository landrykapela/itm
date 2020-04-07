<?php
session_start();
ini_set("display_errors",1);
require('manager.php');
$location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$user = DB::getUser($_SESSION['user']);
if($_GET['e'] != $user['id']) die("Not your account");
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
    
    <!-- // Add the new slick-theme.css if you want the default styling -->
    <link rel="stylesheet" type="text/css" href="../slick/slick-theme.css" />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" href="images/favicon.png" />

    <title>ITM Tanzania - Jobs</title>
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
          <a href="http://'.$_SERVER['HTTP_HOST'].'/jobs.html">Jobs</a>
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
    $action = DB::createEducationProfile($user['email'],$data);
}

echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Education Background</p><a class="button primary-bg border-white-all round-corner" href="profile.php">Close</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="w-100 flex-column flex-start flex-top accent-bg dark-text padding-std" action="" method="POST">
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="institution">Institution</label>
<input type="text" name="institution" id="institution" placeholder="Institution" class="w-100 form-control padding-small"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="program">Study Program</label>
<input type="text" name="program" id="program" placeholder="program"class="w-100 form-control padding-small"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="level">Select Level</label>
<select name="level" id="level" class="w-75 form-control padding-small">
    <option>Doctorate</option>
    <option>Master</option>
    <option>Bachelor</option>
    <option>Diploma</option>
    <option>Certificate</option>
    <option>Short Course</option>
    
</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="major">Select Area of Study</label>
<select name="major" id="major" class="w-75 form-control padding-small">
    <option>Accounting</option>
    <option>Aeronautical Engineering</option>
    <option>Administration</option>
    <option>Biological Science</option>
    <option>Business Management</option>
    <option>Chemical Engineering</option>
    <option>Computer Science</option>
    <option>Information Technology</option>
    <option>Graphics & Arts</option>
    <option>Mechanical Engineering</option>
    <option>Geology</option>
    <option>Law</option>
    <option>Software Engineering</option>Short Course
    
</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="country">Country</label>
<select name="country" id="country" class="w-75 form-control padding-small">';
$countries = DB::listCountries();
foreach($countries as $code => $name){
    
    echo "<option value=".$code.">".$code." - ".$name."</option>";
}
    
echo '</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="year">Year of Completion</label>
<select name="year" id="year" class="w-75 form-control padding-small">';
$year = date('Y');
for($i=0;$i<40;$i++){
    $y = $year - $i;
    echo "<option>".$y."</option>";
}
    
echo '</select></div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<input type="submit" name="submit" id="submit" value="SAVE" class="button round-corner primary-bg border-white-all white-text w-100 form-control padding-small"/>
</form>
</div>
</section>';

echo "</body>";
?>