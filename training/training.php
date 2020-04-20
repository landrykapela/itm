<?php
session_start();
ini_set("display_errors",1);
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
<script>
function changeTitle(){
let selector = document.getElementById("program");
        let text = selector.options[event.target.selectedIndex].text;
        console.log("test: ",text);
        let title = document.getElementById("program_title");
        title.textContent = text;

}
function showCompanyDetails(){
    let cd = document.getElementById("company_details");
    cd.classList.remove("hidden");let an = document.getElementById("app_name");
    an.classList.add("hidden");
}
function hideCompanyDetails(){
    let cd = document.getElementById("company_details");
    cd.classList.add("hidden");
    let an = document.getElementById("app_name");
    an.classList.remove("hidden");
}
</script>
<header
      id="header"
      class="min-width-full flex-column flex-top flex-start margin-auto"
    >
      <div
        class="white-bg flex-row flex-between flex-middle w-100 padding-std margin-auto"
      >
        <img src="../images/logo.png" class="logo" alt="ITM logo" />
        <nav class="flex-row flex-center" id="navigation">
          <span id="home">Home</span>
          <span id="about">About</span>
          <span id="services">Services</span>
          <span id="jobs">Jobs</span>
          <span id="training" class="active">Training</span>
          <span id="news">News & Events</span>
          <!-- <span id="contacts">Contacts</span> -->
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>
    </header>';
$msg = "";
$programs = DB::getTrainingPrograms();

echo '<p class="error-text">'.$msg.'</p>
<section class="min-width-full margin-auto flex-row flex-center flex-middle primary-bg white-text">
   
    <span id="btn-search" class="title padding-std">Training Programs</span> 
    
    </div>
</section>';
echo '<section class="w-100 margin-std " id="candidates">
<p class="title primary-text"></p>
<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Title/Theme</td><td>Description</td><td>Start Date</td><td>End Date</td><td>Available Applications</td></tr></thead>
    <tbody>';

if(!$programs || count($programs) == 0){
    echo '<tr><td colspan=5 class="text-center">No programs to show</td></tr>';
}
else{
for($i=0;$i<sizeof($programs);$i++){
  $program = $programs[$i];
  
  echo '<tr><td><a class="plain-link" href="training_detail.php?id='.$program['id'].'">'.$program['title'].'</a></td><td><a href="training_detail.php?id='.$program['id'].'">'.(strlen($program['description']) > 72 ? substr($program['description'],0,72) : $program['description']).'</a></td><td><a href="training_detail.php?id='.$program['id'].'">'.date('d M Y',$program['start_date']).'</a></td><td><a href="training_detail.php?id='.$program['id'].'">'.date('d M Y',$program['end_date']).'</a></td><td class="text-right"><a href="training_detail.php?id='.$program['id'].'">'.($program['target'] - $program['registered']).'</a></td></tr>';
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
