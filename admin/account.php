<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$user = DB::getUser($_SESSION['user']);
if(DB::isAdmin($user['email'])){
  $location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/admin/admin.php";
  header($location,true);
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
      <a href="account.php?e='.$user['id'].'" >Account</a>
      <a href="../jobs/job_listings.php">Jobs</a>
      <a href="signout.php" >Signout</a>
    </nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
</header>
    
';
echo ' <section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Personal Info</p>
<div class="flex-row flex-space margin-small">
<a class="button primary-bg border-white-all round-corner" href="edit_profile.php?e='.$user['id'].'">Edit</a>&nbsp;&nbsp;<a class="button primary-bg border-white-all round-corner" href="edit_profile.php?d='.$user['id'].'">Delete My Account</a>
</div>

</div>
<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">

<p>'.$user['name'].'</p>
<p>'.$_SESSION['user'].'</p>
<p>'.$user['phone'].'</p>';
$cities = DB::getTanzaniaCities();
$location = in_array($user['location'],$cities) ? $user['location'] : DB::getCountry($user['location']);

echo '<p>'.$location.'</p>
</div>
</section>';

echo "</body>";
}
?>
