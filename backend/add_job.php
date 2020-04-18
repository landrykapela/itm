<?php
session_start();
ini_set("display_errors",1);
require('manager.php');
$location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);
if(!$admin){
    $fb = "You need to login as admin to view this page!";
    $location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html?fb=".$fb."#login";
    header($location,true);
}
else{
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
  <a href="admin_account.php" >Account</a>
  <a href="events_admin.php" >Events</a>
  <a href="training_admin.php" >Training</a>
  <a href="job_listings.php">Jobs</a>
  <a href="signout.php" >Signout</a>
</nav>

    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';

$message = "";
if(isset($_POST['btnSubmitJob'])){

    $contact = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
    if(!filter_var($contact,FILTER_VALIDATE_EMAIL)){
        $message = "Invalid e-mail address";
    
    }
    else{
    $position = filter_var($_POST['position'],FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
    $company = filter_var($_POST['company'],FILTER_SANITIZE_STRING);
    $deadline = strtotime($_POST['deadline']);
    $job = array();
    $job['position'] = $position;
    $job['description'] = $description;
    $job['company'] = $company;
    $job['contact'] = $contact;
    $job['deadline'] = $deadline;
    
    $action = DB::createJob([$job]);
    if($action){
        $message = "Job successfully added!";
    }
    else{
        $message = "Something went wrong";
    }
    }
}

echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small white-text">
        <p class="title">Add Job Listing</p>
        
    <div>
    
</section>';
echo '<section class="w-100 margin-std " id="">

<form class="w-50 margin-auto text-left" action="" method="POST">
<span class="vspacer"></span>
<p class="text-center error-text">'.$message.'
  
</p>
<div class="form-group flex-column flex-start padding-small">
  <label for="position">Job Position</label>
  <input
    type="text"
    name="position"
    id="position"
    class="form-control padding-small"
    placeholder="Position..."
  />
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="description">Job Description</label>
  <textarea rows=10 
    name="description"
    id="descripon"
    class="form-control padding-small"
  ></textarea>
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="company">Company</label>
  <input
    type="text"
    name="company"
    id="company"
    class="form-control padding-small"
    placeholder="Company..."
  />
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="contact">Contact E-maill</label>
  <input
    type="email"
    name="contact"
    id="contact"
    class="form-control padding-small"
    placeholder="Contact..."
  />
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="deadline">Application Deadline</label>
  <input
    type="date"
    name="deadline"
    id="deadline"
    class="form-control padding-small"
    placeholder="Deadline..."
  />
</div>
<span class="vspacer"></span>
<div class="form-group flex-row flex-space flex-middle">
  <input type="submit"
    name="btnSubmitJob"
    id="btnSubmitJob"
    class="form-control button border-white-all round-corner text-center primary-bg white-text"
    value="SAVE" />
  <a
    href="admin.php"
    class="plain-link text-center round-corner primary-text"
    >CANCEL</a>
</div>
<span class="vspacer"></span>
</form>';
echo "</body>";
}
?>
