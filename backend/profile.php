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
    <link rel="stylesheet" type="text/css" href="slick/slick.css" />
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
        class="white-bg flex-row flex-between flex-middle w-100 padding-std margin-auto"
      >
        
        <nav class="flex-row flex-center" id="navigation">
          <span id="home">Account</span>
          <span id="jobs">Jobs</span>
          <span id="contacts">Signout</span>
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
<p class="title">Education</p><a class="button primary-bg border-white-all round-corner" href="edit_education.php?e='.$user['id'].'">Edit</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<p class="subtitle">MSc. IT and Management
<p>Avinashillingam University/Institute of Finance Management</p>
<p>2012-2014</p>
<p>Dar es Salaam</p>

<p class="subtitle">BSc. Information and Communication Technology Management
<p>Mzumbe University</p>
<p>2006-2009</p>
<p>Morogoro</p>
</div>
</section>';

echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Professional Experience</p><a class="button primary-bg border-white-all round-corner" href="edit_experience.php?e='.$user['id'].'">Edit</a>


</div>
<div class="w-60 flex-column flex-start flex-top accent-bg dark-text padding-std">
<p class="subtitle">Mentor (Junior Web Developer and Android Developer Paths)
<p>Open Classrooms International</p>
<p>Since 2019</p>
<p>Paris</p>

<p class="subtitle">Software Developer
<p>Neelansoft Technologies</p>
<p>Since 2016</p>
<p>Dar es salaam</p>
</div>
</section>';
echo "</body>";
?>
