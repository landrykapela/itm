<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'])=="on" ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);

    $user = DB::getUser($_SESSION['user']);
    
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
if(isset($_POST['btnSubmit'])){
    $cid = $_POST['cid'];
    $jid = $_POST['jid'];
    $job = DB::getJobById($jid);
    if(!DB::jobAppExists($cid,$jid)){
        $application = DB::applyJob($cid,$jid);
    
       
        if($application) $message = "Congratulations! Your application is well received.";
        else $message = "Sorry! Could not process your application. Please try again later!";
    }
    else $message = "You have already applied. Your application is being processed and you will be notified of any progress!";
}

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
<div class="form-group flex-column flex-center  padding-small">
</div>
<div class="form-group flex-row flex-center padding-small">
 
  <span class="text-center dark-text padding-small w-50"></span>
</div>


<span class="vspacer"></span>';
echo '<div class="form-group flex-row flex-space flex-middle margin-auto">';

 $back = $admin ? '<a
    href="../admin/admin.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>' : '<a
    href="job_listings.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>';
echo $back .'</div>
<span class="vspacer"></span>
</div>';
echo "</body>";

?>
