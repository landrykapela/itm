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
          <span id="jobs" class="active">Jobs</span>
          <span id="training">Training</span>
          <span id="news">News & Events</span>
          
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>
      <div
        class="flex-row flex-start w-100 margin-std  bg-img-header5 v-100"
      >
        <div class="w-100-no-padding flex-column flex-start padding-std primary-bg-transparent">
         
            <p class="white-text title focus">Jobs Portal</p>
            <p class="white-text">
               Get matched with the best employers and land your dream job
            </p>
            <span class="vspacer"></span>
            <span class="vspacer"></span>';
            $open_signup =  "window.location=window.location.origin+'/signup.html'";
            $open_signin =  "window.location=window.location.origin+'/signup.html#login'";
            echo '<div class="w-50 flex-row flex-between flex-middle white-text margin-auto"><span class="button primary-bg round-corner border-white-all white-text" onclick="'.$open_signup.'">SIGNUP NOW</span><span>OR</span><span class="button border-white-all round-corner white-text" onclick="'.$open_signin.'">LOGIN</span></div>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            
            
        </div>
        </div>

      
      </div>
    </header>
    
    <section class="w-100 margin-std ">
        <p class="title primary-text">Recent Listings</p>
        <table class="w-100 margin-auto text-left">
          <thead class="primary-bg white-text"><tr><td>Title</td><td>Description</td><td>Date uploaded</td><td>Deadline</td></tr></thead>
          <tbody>';
              require('../libs/manager.php');
          $jobs = DB::getJobListings();
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
      </table>
    </section>
   
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
