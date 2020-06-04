<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'])=="on" ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);

    $user = DB::getUser($_SESSION['user']);
    $candidate = DB::getUserById($_GET['cid']);
    $job_id = $_GET['jid'];
    $job = DB::getJobById($job_id);
    $readonly = $admin ? '':'readonly';
    $profile = explode(",",$candidate['profile']);
    $completion = 0;
    foreach($profile as $key => $value){
        $completion += $value;
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
<link rel="stylesheet" href="../styles/css/progress-circle.css"/>
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
  <a href="../admin/account.php?e='.$user['id'].'" >Account</a>
  <a href="../events/events_admin.php" >Events</a>
  <a href="../training/training_admin.php" >Training</a>
  <a href="job_listings.php">Jobs</a>
  <a href="../admin/signout.php" >Signout</a>
</nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';

$message = "";
if($job['deadline'] < time()) $message = "Sorry, this application is closed.";
echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-column flex-start flex-middle padding-small white-text">
        <p class="title">Job Application</p>
        <span class="subtitle">'.$job['position'].'</span>
    <div>
    
</section>';
echo '<section class="w-100 margin-std " id="">

<div class="w-100 margin-auto text-left " >
<span class="vspacer"></span>
<p class="text-center error-text">'.$message.'
  
</p>
<div class="form-group flex-column flex-center  padding-small"><span class="text-center">Profile Completion</span>
    <div class="progress-container text-center"><div class="progress-circle progress-'.$completion.' "><span>'.$completion.'</span></div>';
  if($completion < 50) echo '<p class="primary-text">Please update your profile to increase your chance of selection</p>';
echo '</div>
<div class="form-group flex-row flex-center padding-small">
 
  <span class="text-center dark-text padding-small w-50">By clicking apply, you agree to the terms of use of this platform and that your personal and professional information will be shared with employers or their representatives. </span>
</div>


<span class="vspacer"></span>';
echo '<form action="confirm_apply.php" enctype="multipart/form-data" method="post"><input type="hidden" value='.$candidate['id'].' name="cid" id="cid"/><input type="hidden" name="jid" id="jid" value="'.$job_id.'" /><div class="form-group flex-row flex-space flex-middle margin-auto">';

 $back = $admin ? '<a
    href="../admin/admin.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>' : '<a
    href="job_listings.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>';
echo $back .'<input type="submit" name="btnSubmit" id="btnSubmit" class="button primary-bg border-white-all round-corner text-center white-text" value="APPLY NOW"/></div>
<span class="vspacer"></span>
</div>';
echo "</body>";

?>
