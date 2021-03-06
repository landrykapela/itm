<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');

$target = false;
if(isset($_GET['id'])) $target = $_GET['id'];
if(isset($_SESSION['user'])){
    $user = DB::getUser($_SESSION['user']);
    if(DB::isAdmin($user['email'])){
        $location = HEADER . "/training/training_admin.php";
        header($location,true);
    }
} 
else $user = false;
$msg = "";
if(isset($_GET['fb'])) $msg = $_GET['fb'];
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

<link
  href="https://fonts.googleapis.com/icon?family=Material+Icons"
  rel="stylesheet"
/>
<link
  href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
  rel="stylesheet"
/>
<link rel="icon" href="../images/favicon.png" />

<title>ITM Tanzania - Training Portal</title>


</head>
<body>
<div
id="floating-header"
class="floating-header flex-row flex-between flex-top w-100-no-padding padding-std margin-auto"
>
<img src="../images/logo.png" class="logo" alt="ITM logo" />
<div class="flex-column flex-center flex-end">
  <div class="flex-row flex-end margin-std-right no-mobile">
    <img src="../images/tanzania.png" alt="ITM Tanzania" class="flag" />
    <img
      src="../images/rwanda.png"
      alt="ITM Rwanda"
      class="flag"
      onclick="window.location=\'https://itmafrica.rw\';"
    />
    <img
      src="../images/angola.png"
      alt="ITM Angola"
      class="flag"
      onclick="window.location=\'https://itmafrica.ao\';"
    />
    <img
      src="../images/drc.png"
      alt="ITM Group"
      class="flag"
      onclick="window.location=\'https://itmafrica.com\';"
    />
    <img
      src="../images/south_africa.png"
      alt="ITM South Africa"
      class="flag"
      onclick="window.location=\'https://itmkatope.co.za\';"
    />
    <img
      src="../images/germany.png"
      alt="ITM Germany"
      class="flag"
      onclick="window.location=\'https://itmnexus.com\';"
    />
    <img
      src="../images/nigeria.png"
      alt="ITM Nigeria"
      class="flag"
      onclick="window.location=\'https://itmafrica.com.ng\';"
    />
  </div>
  <nav class="flex-row flex-center margin-std-right" id="navigation">
    <span id="home">Home</span>
    <span id="about">About</span>
    <span id="services">Services</span>
    <span id="jobs">Jobs</span>
    <span id="training" class="active">Training</span>
    <span id="news">News & Events</span>
    <!-- <span id="contacts">Contacts</span> -->
  </nav>
</div>
<span id="menu"><i class="material-icons">menu</i></span>
</div>

<header
  id="header"
  class="primary-bg min-width-full flex-column flex-top flex-start margin-auto"
>
<span class="vspacer"></span><span class="vspacer"></span><span class="vspacer"></span><span class="vspacer"></span>
</header>';
$programs = DB::getTrainingPrograms();
$application = false;

echo '<section class="min-width-full margin-auto flex-row flex-center flex-middle primary-bg white-text">
   
    <span id="btn-search" class="title padding-std">Training Program Application</span> 
    
    </div>
</section>';
echo '<section class="w-100 margin-std" >';
echo '<p class="error-text">'.$msg.'</p>
<p class="title primary-text text-center" id="program_title">Login</p>
<form action="application_details.php" enctype="multipart/form-data" method="post" class="w-60 border-primary-all padding-std flex-column flex-start text-left margin-auto">
   
<div class="form-group flex-column flex-start padding-small">
<label for="program">Training Program<span class="error-text">*</span></label>
<select 
  name="program"
  id="program"
  class="form-control padding-small">';
    for($i=0;$i<count($programs);$i++){
        if($programs[$i]['id'] == $target) echo '<option selected value="'.$programs[$i]['id'].'">'.$programs[$i]['title'].'</option>';
        else echo '<option value="'.$programs[$i]['id'].'">'.$programs[$i]['title'].'</option>';
    }
echo '</select></div>
<div class="form-group flex-column flex-start padding-small">
<label for="contact">Contact Email <span class="error-text">*</span></label>
<input value="'.$user['email'].'"
  type="email"
  name="contact"
  id="contact"
  class="form-control padding-small"
  placeholder="Enter email..."
/>
</div>

<div class="form-group flex-column flex-start padding-small">
<label for="password">Password <span class="error-text">*</span></label>
<input 
  type="password"
  name="password"
  id="password"
  class="form-control padding-small"
  placeholder="Enter password..."
/>
</div>

<div class="form-group flex-row flex-space flex-middle padding-small">

<input
  type="submit"
  name="btnLogin"
  id="btnLogin"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value=" LOGIN "
/>
<a href="training_signup.php" class="plain-link">SIGNUP</a>
</div>
</form>
</section>';

echo ' <script src="../js/general.js"></script></body>';

?>
