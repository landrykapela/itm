<?php
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
        <span id="jobs" class="active">Jobs</span>
        <span id="training">Training</span>
        <span id="news">News & Events</span>
        <!-- <span id="contacts">Contacts</span> -->
      </nav>
    </div>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
    <header
      id="header"
      class="min-width-full bg-img-header5 "
    >
        <div class="flex-column flex-start padding-std primary-bg-transparent margin-auto">
         <span class="vspacer"></span> <span class="vspacer"></span> <span class="vspacer"></span>
            <p class="white-text title focus">Jobs Portal</p>
            <p class="white-text">
               Get matched with the best employers and land your dream job
            </p>
            <span class="vspacer"></span>
            <span class="vspacer"></span>';
            $open_signup =  "window.location=window.location.origin+'/jobs/signup.html'";
            $open_signin =  "window.location=window.location.origin+'/jobs/signup.html#login'";
            echo '<div class="w-50 flex-row flex-between flex-middle white-text margin-auto"><span class="button primary-bg round-corner border-white-all white-text" onclick="'.$open_signup.'">SIGNUP NOW</span><span class="desktop-only">OR</span><span class="button border-white-all round-corner white-text" onclick="'.$open_signin.'">LOGIN</span></div>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            
            
        </div>
    </header>';
    require('../libs/manager.php');
          $jobs = DB::getJobListings();
    echo '<section class="w-100 margin-std ">
        <p class="title primary-text">Recent Listings</p>
        <table class="w-100 margin-auto text-left desktop-only">
          <thead class="primary-bg white-text"><tr><td>Title</td><td>Description</td><td>Date uploaded</td><td>Deadline</td></tr></thead>
          <tbody>';
              
          if(!$jobs){
            echo '<tr><td colspan=4 class="text-center">No job openings</td></tr>';
          }
           else{
             for($i=0; $i<sizeof($jobs);$i++){
               $job = $jobs[$i];
               echo '<tr><td><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.$job['position'].'</a></td><td><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.(strlen($job['description']) > 64 ? substr($job['description'],0,64):$job['description']).'</a></td><td><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.date('d M Y',$job['date_created']).'</a></td><td><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.date('d M Y',$job['deadline']).'</a></td></tr>';
             }
           }   
  echo '</tbody>
      </table>';
echo '<div class="flex-column flex-center flex-middle mobile-only">';
if(!$jobs){
  echo '<p class="text-center">No job openings</p>';
}
else {
  for($i=0; $i<sizeof($jobs);$i++){
    $job = $jobs[$i];
    echo '<div class="w-100 flex-column flex-center flex-middle margin-std-top"><span class="primary-bg w-100 padding-small white-text">'.$job['position'].'</span>
    <p>'.date('d M Y',$job['deadline']).'</p>
    <p>'.(strlen($job['description']) > 72 ? substr($job['description'],0,72):$job['description']).'</p>
    <a href="../jobs/job_details.php?jid='.$job['id'].'"><p class="button primary-bg white-text round-corner border-white-all"> View Job</p></a></div>';
}
}
echo '</div>';
echo '</section>
   
    <footer class="flex-row flex-space dark-bg white-text min-width-full ">
      <span class="copyright">2020 &copy;ITM Tanzania Ltd</span
      ><span class="copyright"
        >Developed and maintained by
        <a target="_blank" href="https://neelansoft.co.tz"
          >Neelansoft Technologies</a
        ></span
      >
    </footer>
    <div
      id="scroll_top"
      class="hidden button-scroll-top round primary-bg border-white-all white-text flex-center flex-row flex-middle"
    >
      <i class="material-icons">arrow_upward</i>
    </div>

    <script src="../js/general.js"></script>
    
  </body>
</html>';?>
