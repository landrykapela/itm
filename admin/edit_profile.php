<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'])=="on" ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$user = DB::getUser($_SESSION['user']);
$msg = "";
$target = 0;
if(!isset($_GET['e']) && !isset($_GET['d'])) header($location);
else{
    if(isset($_GET['e']) && $_GET['e'] == $user['id']) $target = 0; 
    else{ 
        if(isset($_GET['d']) && $_GET['d'] == $user['id']) $target =1;
        else header($location);
    }
}

if(isset($_POST['submit'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $dob = strtotime($_POST['date_of_birth']);
    $region = isset($_POST['abroad']) ? filter_var($_POST['country'],FILTER_SANITIZE_STRING):filter_var($_POST['location'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
   
    $info = array("name"=>$name,"email"=>$email,"date_of_birth"=>$dob,"location"=>$region,"phone"=>$phone);
   
    $action = DB::updateUserInfo($user['id'],$info);
    if(!$action){
      $msg = "Could not update user info!";
    }
    else{
      $user = $action;
      $msg = "Successfully updated user info!";
    }
}
if(isset($_POST['btnDelete'])){
    $action = DB::deleteUser($user['id']);
    if(!$action) $msg = "Could not delete this account! Please contact the platform admin.";
    else{
        $msg = "Account successfully deleted!";
        $location = str_replace("#login","?fb=".$msg,$location);
        $_SESSION['user'] = null;
        header($location,true);
    }
}
else{
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
          <a href="account.php?e='.$user['email'].'" >Account</a>
          <a href="../jobs/job_listings.php">Jobs</a>
          <a href="signout.php" >Signout</a>
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>
    </header>';

echo "<script>
function showCountry(){
  
  let cb = document.getElementById('abroad');
  let c=document.getElementById('c');
  if(cb.checked) c.classList.remove('hidden');else c.classList.add('hidden');
}

</script>";
echo ' <span class="error-text">'.$msg.'</span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Personal Info</p><a class="button primary-bg border-white-all round-corner" href="profile.php">Close</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="margin-auto w-80 flex-column flex-start flex-top accent-bg dark-text padding-std" action="" method="POST">';
if($target == 0){
echo '<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="name">Full Name</label>
<input type="text" name="name" id="name" placeholder="Full name..." value="'.$user['name'].'" class="w-100  padding-small"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="date_of_birth">Date of Birth</label>';
$onfocus = "this.type = 'date';";
$onblur = "this.type = 'text';";
echo '<input type="text" onfocus="'.$onfocus.'" onblur="'.$onblur.'" name="date_of_birth" id="date_of_birth" class="  padding-small" placeholder="Enter date of birth" value="'.date('d M Y',$user['date_of_birth']).'"/>
 </div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="email">E-mail</label>
<input type="text" name="email" id="email" placeholder="Email..." value="'.$user['email'].'" class="w-100  padding-small"/>
</div>
<div class="w-100 padding-small flex-column flex-start flex-top">
<label for="phone">Phone</label>
<input type="text" name="phone" id="phone" placeholder="Phone..." value="'.$user['phone'].'" class="w-100  padding-small"/>
</div>
<div class="w-100 flex-row flex-start flex-middle">
<div class="w-75 padding-small flex-column flex-center flex-top">
<label for="location">Current Location</label>
<select name="location" id="location" class="w-100  padding-small">';
$cities = DB::getTanzaniaCities();
for($i=0; $i<sizeof($cities);$i++){
    if($user['location'] == $cities[$i])
    echo "<option selected>".$cities[$i]."</option>";
    else  echo "<option>".$cities[$i]."</option>";
}
    
echo '</select></div>';

echo '<div class="padding-small flex-row flex-start flex-top">
<input type="checkbox" name="abroad" id="abroad" class=" padding-std" value="-1" onchange="showCountry();" />
<label for="abroad">Not in Tanzania</label></div>
</div>

<div class="w-100 padding-small flex-column flex-start flex-top hidden" id="c">
<label for="country">Country</label>
<select name="country" id="country" class="w-75 padding-small">';
$countries = DB::listCountries();
foreach($countries as $code => $name){
    if($user['location'] == $code)
    echo "<option value=".$code." selected>".$code." - ".$name."</option>";
    else 
    echo "<option value=".$code.">".$code." - ".$name."</option>";
}
    
echo '</select></div>


<div class="w-100 padding-small flex-column flex-start flex-top">
<input type="submit" name="submit" id="submit" value="SAVE" class="button round-corner primary-bg border-white-all white-text padding-small"/>';
}
else {
    if($target==1){
    echo '<div class="flex-column flex-middle flex-center margin-auto"><p>Your account and everything associated with it on this platform will be deleted. Click the delete button if your wish to delete your account</p>';
    echo '<span class="vspacer"></span><input type="submit" name="btnDelete" id="btnDelete" value="DELETE ACCOUNT" class="alert-bg white-text button round-corner border-white-all"/></div>';
    }
    else{
        
        die("You are not authorized to access this page.");
    }
}
echo '</form>
</div>
</section>';}

echo "</body>";
?>