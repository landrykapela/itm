<?php
session_start();
ini_set("display_errors",1);
require('manager.php');
$location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
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
        
        <nav class="w-100 flex-row flex-end " id="navigation">
          <a href="account.php?e='.$user['email'].'" >Account</a>
          <a href="http://'.$_SERVER['HTTP_HOST'].'/jobs.html">Jobs</a>
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


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">

<p>'.$user['name'].'</p>
<p>'.$_SESSION['user'].'</p>
<p>'.$user['phone'].'</p>

<p>Dar es Salaam</p>
</div>
</section>';

echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Education Background</p><a class="button primary-bg border-white-all round-corner" href="edit_education.php?e='.$user['id'].'">Edit</a>


</div>';
$education = DB::getEducationProfile($user['email']);
echo '<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$education){
  echo '<p class="subtitle">Nothing to show</p>';
}
else{
  // echo json_encode($education);
  for($i=0; $i<sizeof($education);$i++){
    echo '<span class="subtitle">'.$education[$i]['title'].'</span>';
    echo '<span>'.$education[$i]['institution'].'</span>';
    echo '<span>'.$education[$i]['major'].'</span>';
    echo '<span>'.$education[$i]['year'].', '.DB::getCountry($education[$i]['country']).'</span>';
    echo '<span class="vspacer-small"></span>';
    echo '<span class="vspacer-small"></span>';
  }
}

echo '</section>';

echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Professional Experience</p><a class="button primary-bg border-white-all round-corner" href="edit_work.php?e='.$user['id'].'">Edit</a>


</div>';
$work = DB::getWorkProfile($user['email']);
echo '<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$work) echo '<p class="subtitle">Nothing to show</p>';
else{
  for($i=0; $i<sizeof($work);$i++){
    echo '<span class="subtitle">'.$work[$i]['title'].'</span>';
    echo '<span>'.$work[$i]['institution'].'</span>';
    echo '<span>'.$work[$i]['country'].'</span>';
    echo '<span>'.$work[$i]['month_start'].' '.$work[$i]['year_start'].' - '.$work[$i]['month_end'].' '.$work[$i]['year_end'].', '.DB::getCountry($work[$i]['country']).'</span>';
    echo '<p>'.$work[$i]['tasks'].'</p>';
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
<p class="title">Reference</p><a class="button primary-bg border-white-all round-corner" href="edit_reference.php?e='.$user['id'].'">Edit</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<p class="subtitle">Mark Zuckerberg
<p>Facebook</p>
<p>mark.zuckerberg@facebook.com</p>

<p class="subtitle">Jack Ma
<p>Chinese Entrepreneur</p>
<p>jackma@alibaba.com</p>
<p></p>
</div>
</section>';
echo "</body>";
?>