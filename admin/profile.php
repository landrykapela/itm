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
<p class="title">Personal Info</p><a class="button primary-bg border-white-all round-corner" href="edit_profile.php?e='.$user['id'].'">Edit</a>
<span><a  class="flex-row flex-start flex-middle" target="_blank" href="profile_pdf.php?e='.$user['id'].'"><i class="material-icons padding-small">print</i> Generate CV</a></span>


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

echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Education Background</p><a class="button primary-bg border-white-all round-corner" href="edit_education.php?e='.$user['id'].'">Add</a>


</div>';
$education = DB::getEducationProfile($user['email']);
echo '<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$education){
  echo '<p class="subtitle">Nothing to show</p>';
}
else{
  // echo json_encode($education);
  for($i=0; $i<sizeof($education);$i++){
    echo '<span class="subtitle text-left">'.$education[$i]['title'].'</span>';
    echo '<span>'.$education[$i]['institution'].'</span>';
    echo '<span>'.$education[$i]['major'].', '.$education[$i]['level'].'</span>';
    echo '<span>'.$education[$i]['year'].', '.DB::getCountry($education[$i]['country']).'</span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
    echo '<div class="w-100 flex-row flex-between flex-middle">
    <a class="plain-link " href="edit_education.php?e='.$user['id'].'&ed='.$education[$i]['id'].'">Edit</a>
    <a class="plain-link " href="edit_education.php?e='.$user['id'].'&del='.$education[$i]['id'].'">Delete</a></div>';
    echo '<span class="vspacer-small"></span>';
    if($i < count($education) -1) echo '<span class="vspacer-small border-dark-bottom"></span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
  }
}

echo '</section>';

echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Professional Experience</p><a class="button primary-bg border-white-all round-corner" href="edit_work.php?e='.$user['id'].'">Add</a>


</div>';
$work = DB::getWorkProfile($user['email']);
// echo "work: ".json_encode($work);
echo '<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$work) echo '<p class="subtitle">Nothing to show</p>';
else{
  for($i=0; $i<sizeof($work);$i++){
    echo '<span class="subtitle">'.$work[$i]['title'].'</span>';
    echo '<span>'.$work[$i]['institution'].'</span>';
    echo '<span>'.DB::getCountry($work[$i]['country']).'</span>';
    echo '<span>'.DB::getMonth($work[$i]['month_start']).' '.$work[$i]['year_start'].' - '.($work[$i]['year_end']== -1 ? 'Present': (DB::getMonth($work[$i]['month_end']).' - '.$work[$i]['year_end'])).'</span>';
    echo '<span class="text-left">'.$work[$i]['tasks'].'</span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
    echo '<div class="w-100 flex-row flex-between flex-middle">
    <a class="plain-link " href="edit_work.php?e='.$user['id'].'&ed='.$work[$i]['id'].'">Edit</a>
    <a class="plain-link " href="edit_work.php?e='.$user['id'].'&del='.$work[$i]['id'].'">Delete</a></div>';
    echo '<span class="vspacer-small"></span>';
    if($i < count($work) -1) echo '<span class="vspacer-small border-dark-bottom"></span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
  }
}

echo '</div>
</section>';



echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Reference</p><a class="button primary-bg border-white-all round-corner" href="edit_reference.php?e='.$user['id'].'">Add</a>


</div>';
$reference = DB::getReferenceProfile($user['email']);

echo '<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$reference) echo '<p class="subtitle">Nothing to show</p>';
else{
  for($i=0; $i<sizeof($reference);$i++){
    echo '<span class="subtitle">'.$reference[$i]['name'].'</span>';
    echo '<span>'.$reference[$i]['title'].'</span>';
    echo '<span>'.$reference[$i]['contact'].'</span>';
    echo '<span>'.$reference[$i]['phone'].'</span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
    echo '<div class="w-100 flex-row flex-between flex-middle">
    <a class="plain-link " href="edit_reference.php?e='.$user['id'].'&ed='.$reference[$i]['id'].'">Edit</a>
    <a class="plain-link " href="edit_reference.php?e='.$user['id'].'&del='.$reference[$i]['id'].'">Delete</a></div>';
    echo '<span class="vspacer-small"></span>';
    if($i < count($reference) -1) echo '<span class="vspacer-small border-dark-bottom"></span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
  }
}
echo '</div></section>';echo '<span class="vspacer-small"></span>';
echo '<span class="vspacer-small"></span>';
echo "</body>";
}
?>
