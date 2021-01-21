<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');

if(isset($_SESSION['user'])) $user = DB::getUser($_SESSION['user']);
$programs = DB::getTrainingPrograms();

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
    <link rel="stylesheet" type="text/css" href="../slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="../slick/slick-theme.css" />
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
        <span id="services">Services<span id="expandable" class="hidden flex-column flex-top flex-start" ><a href="../services.html#hr">Human Resources Solutions</a><a href="../services.html#sales">Sales and Distribution</a><a href="../services.html#industrial">Industrial Solutions</a><a href="../services.html#b2b">Business-2-Business</a></span></span>
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
      class="min-width-full bg-img-header_"
    >
        <div class="flex-column flex-start padding-std primary-bg-transparent margin-auto">
        <span class="vspacer"></span><span class="vspacer"></span>
         <span class="vspacer"></span> <span class="vspacer"></span> <span class="vspacer"></span>
            <p class="white-text title focus">Training Calendar</p>
            <p class="white-text">
               Enroll in any of our professional training programs and get ready for your next dream job
            </p>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            
            
        </div>
    </header>';
$msg = "";
$programs = DB::getTrainingPrograms();

echo '<p class="error-text">'.$msg.'</p>';
echo '<section class="w-100 margin-std " id="candidates">
<p class="title primary-text"></p>
<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Title/Theme</td><td class="desktop-only">Description</td><td>Start Date</td><td>End Date</td></tr></thead>
    <tbody>';

if(!$programs || count($programs) == 0){
    echo '<tr><td colspan=5 class="text-center">No programs to show</td></tr>';
}
else{
for($i=0;$i<sizeof($programs);$i++){
  $program = $programs[$i];
  
  echo '<tr><td><a class="plain-link" href="training_detail.php?id='.$program['id'].'">'.$program['title'].'</a></td><td class="desktop-only"><a class="plain-link" href="training_detail.php?id='.$program['id'].'">'.(strlen($program['description']) > 72 ? substr($program['description'],0,72) : $program['description']).'</a></td><td><a class="plain-link" href="training_detail.php?id='.$program['id'].'">'.date('d M Y',$program['start_date']).'</a></td><td><a class="plain-link" href="training_detail.php?id='.$program['id'].'">'.date('d M Y',$program['end_date']).'</a></td></tr>';
  }
}
        
   echo' </tbody>
</table>
</section>';
echo '<footer class="flex-row flex-space dark-bg white-text min-width-full ">
<a class="copyright" href="training_admin.php"
      >Training Admin</a
    >
  <span class="copyright">2020 &copy;ITM Tanzania Ltd</span
  ><span class="copyright"
    >Developed and maintained by
    <a target="_blank" href="https://neelansoft.co.tz"
      >Neelansoft Technologies</a
    ></span
  >
</footer>';
echo ' <script src="../js/general.js"></script></body>';

?>
