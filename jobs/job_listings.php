<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'])=="on" ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(isset($_SESSION['user'])){

$user = DB::getUser($_SESSION['user']);
}
$jobs = DB::getJobListings();
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

if(isset($_POST['btnSearch'])){
  $search = filter_var($_POST['search'],FILTER_SANITIZE_STRING);
  $jobs = DB::searchJobs($search);
  
}
if(isset($_POST['clearSearch'])){
  $jobs = DB::getJobListings();
}
echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small">
    <p class="title white-text">Job Listings</p>
    </div>
</section>';
echo '<section class="w-100 margin-std" id="listings">
<span class="flex-row flex-space flex-middle w-100"><p class="title primary-text"><form action="" method="post"><input class="padding-small" type="text" id="search" name="search" placeholder="search..."/><input class="padding-small primary-bg white-text" type="submit" id="btnSearch" name="btnSearch" value="search"/><input class="padding-small accent-bg white-text" type="submit" id="clearSearch" name="clearSearch" value="clear"/></form></p></span><div class="w-100 flex-row flex-center margin-std ">';
// <table class="w-100 margin-auto text-left">
//     <thead class="primary-bg white-text"><tr><td>Title</td><td>Description</td><td>Date uploaded</td><td>Deadline</td></tr></thead>
//     <tbody>';
    if(!$jobs){
      echo '<p colspan=4 class="text-center">No jobs found</p>';
    }
     else{
       for($i=0; $i<sizeof($jobs);$i++){
         $job = $jobs[$i];
         echo '<div class="shadow margin-std news-card flex-column flex-between flex-middle w-40" >
        <a href="job_details.php?jid='.$job['id'].'" class="plain-link">
          
          <p class="dark-text text-center padding-small">'.$job['position'].'</p>    
          </a>
          <span class="w-100 primary-bg padding-small-top padding-small-bottom white-text">Deadline: '.date('d M Y',$job['deadline']).'</span>
      </div> ';
        
       }
       echo '</div>';
     }   
    


echo "</section></body>";

?>
