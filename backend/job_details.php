<?php
session_start();
ini_set("display_errors",1);
require('manager.php');
$location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);

    $user = DB::getUser($_SESSION['user']);
    $job_id = $_GET['jid'];
    $job = DB::getJobById($job_id);
    $readonly = $admin ? '':'readonly';
    
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
      <a href="account.php?e='.$user['id'].'" >Account</a>
      <a href="job_listings.php">Jobs</a>
      <a href="signout.php" >Signout</a>
    </nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';

$message = "";

echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small white-text">
        <p class="title">Job Details</p>
        
    <div>
    
</section>';
echo '<section class="w-100 margin-std " id="">

<div class="w-100 margin-auto text-left " >
<span class="vspacer"></span>
<p class="text-center error-text">'.$message.'
  
</p>
<div class="form-group flex-row flex-start  padding-small">
  <span for="position" class="text-right padding-small w-40 primary-text">Job Position</span>
  <span class=" padding-small w-50">'.$job['position'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="description" class="text-right padding-small w-40 primary-text">Job Description</span>
  <span class=" padding-small w-50"
  >'.$job['description'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="company" class="text-right padding-small w-40 primary-text">Company</span>
  <span class=" padding-small w-50">'.$job['company'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="contact" class="text-right padding-small w-40 primary-text">Contact E-maill</span>
  <span class=" padding-small w-50">'.$job['contact'].'
  </span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="deadline" class="text-right padding-small w-40 primary-text">Application Deadline</span>
  <span class=" padding-small w-50">'.date('d M Y',$job['deadline']).'
  </span>
</div>
<span class="vspacer"></span>';
if($admin){
echo '<div class="form-group flex-row flex-space flex-middle">
  <a class="plain-link primary-text"
    href="edit_job.php?jid='.$job['id'].'"
    >EDIT</a>';
}
 $back = $admin ? '<a
    href="admin.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>' : '<a
    href="../jobs.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>';
echo $back .'</div>
<span class="vspacer"></span>
</div>';
echo "</body>";

?>
