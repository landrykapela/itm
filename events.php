<?php

ini_set("display_errors",1);
require("backend/manager.php");
$msg = "";
if(isset($_GET['fb'])){
  $msg = urldecode($_GET['fb']);
}
$html = '<!DOCTYPE html>
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
      content="ITM, ITM Africa, ITM Tanzania, Career Development,Career, Professional Training, Training, recruitment,achievement"
    />
    <link href="styles/general.css" rel="stylesheet" />
    <link href="styles/general_mobile.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="slick/slick.css" />
    <!-- // Add the new slick-theme.css if you want the default styling -->
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css" />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" href="images/favicon.png" />

    <title>ITM Tanzania - News and Events</title>
  </head>
  <body>
    <div
    id="popup"
    class="padding-std min-width-full black-bg-transparent flex-column flex-center-flex-middle hidden"
  >
    <span class="vspacer"></span>
    <form action="backend/subscribe.php" method="POST"
      class="margin-auto flex-column flex-middle flex-center w-50 primary-bg padding-std"
    >
      <span id="close-popup" class="round white-bg flex-row flex-center"
        ><i class="material-icons">close</i></span
      ><span class="vspacer"></span>
      <span class="white-text"
        >Subscribe to our Newsletter to get updates</span
      >
      <!-- <label for="email">E-mail</label> -->
      <span class="vspacer"></span>
      <input
        class="round-corner"
        type="email"
        id="email"
        name="email"
        placeholder="Enter your e-mail address"
      />
      <!-- <label for="name">Name</label> -->
      <input
        class="round-corner"
        type="text"
        id="name"
        name="name"
        placeholder="Enter your full name"
      />
      <input
        class="button primary-bg border-white-all white-text round-corner"
        type="submit"
        name="btnSubscribe"
        id="btnSubscribe"
        value="SUBSCRIBE"
      />
    </form>
  </div>
    <header
      id="header"
      class="min-width-full flex-column flex-top flex-start margin-auto"
    ><span class="padding-small error-text">'.$msg.'</span>
      <div
        class="white-bg flex-row flex-between flex-middle w-100 padding-std margin-auto"
      >
        <img src="images/logo.png" class="logo" alt="ITM logo" />
        <nav class="flex-row flex-center" id="navigation">
          <span id="home">Home</span>
          <span id="about">About</span>
          <span id="services">Services</span>
          <span id="jobs">Jobs</span>
          <span id="training">Training</span>
          <span id="news" class="active">News & Events</span>
          <!-- <span id="contacts">Contacts</span> -->
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>
      <div
        class="flex-row flex-start w-100 margin-std  bg-img-header6 v-100"
      >
        <div class="w-100-no-padding flex-column flex-start padding-std primary-bg-transparent">
         
            <p class="white-text title focus text-left">News and Events</p>
            <p class="white-text text-left">
               Stay updated with news and events around ITM
            </p>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            <div class="text-left"><span id="btn-subscribe" class="button primary-bg round-corner border-white-all white-text">SUBSCRIBE NOW</span></div>
            <span class="vspacer"></span>
            <span class="vspacer"></span>
            
            
        </div>
        </div>

      
      </div>
    </header>
    <p class="title primary-text">Recent Events</p>
    <section class="w-100 flex-row flex-center margin-std ">';
    $events = DB::getEvents();
    if($events){
      for($i=0;$i<sizeof($events);$i++){
        $event = $events[$i];
        $html .='
        <div class="shadow margin-std news-card accent-bg w-40" >
        <a href="backend/event_detail.php?id='.$event['id'].'" class="plain-link">
          <img src="backend/events/'.$event['image'].'" class="w-100-no-padding"/>
          
          <p class="dark-text text-left padding-small">'.$event['title'].'</p>    
          </a>
      </div> ';
      }
    }
    
  $html .='</section>
   
    <footer class="flex-row flex-space dark-bg white-text min-width-full ">
    <a class="copyright" href="backend/events_admin.php"
          >Events Admin</a
        >
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

    <script src="js/general.js"></script>
    
  </body>
</html>';

echo $html;

?>
