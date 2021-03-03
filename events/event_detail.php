<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ";
if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on"){
  $location .= "https://".$_SERVER['HTTP_HOST'];
} 
else $location .= "http://".$_SERVER['HTTP_HOST'];
$isAdmin = false;
if(isset($_SESSION['user'])){
    $isAdmin = DB::isAdmin($_SESSION['user']);
}

if(isset($_GET['id'])){
    
    $event = DB::getEventById($_GET['id']);
    if(!$event){
        $location .= "/events/events.php";
        header($location,true);
    }
    else{
        $more = DB::getEvents();
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

    <title>ITM Tanzania - News and Events</title>
  </head>
  <body>
<div id="floating-header" class="floating-header white-bg">
    <div id="top-bar">
      <img src="../images/logo.png" class="logo" alt="ITM logo" /> 
      <div class="flex-row flex-end">
          <div class="tip">
            <img src="../images/tanzania.png" alt="ITM Tanzania" class="flag" />
            <span class="tooltip">Tanzania</span>
          </div>
          <div class="tip">
            <img
              src="../images/rwanda.png"
              alt="ITM Rwanda"
              class="flag"
              onclick="window.location=\'https://itmafrica.rw\';"
            />
            <span class="tooltip">Rwanda</span>
          </div>
          <div class="tip">
            <img
              src="../images/angola.png"
              alt="ITM Angola"
              class="flag"
              onclick="window.location=\'https://itmafrica.ao\';"
            /><span class="tooltip">Angola</span>
          </div>
          <div class="tip">
            <img
              src="../images/drc.png"
              alt="ITM Group"
              class="flag"
              onclick="window.location=\'https://itmafrica.com\';"
            /><span class="tooltip">DR Congo</span>
          </div>
          <div class="tip">
            <img
              src="../images/south_africa.png"
              alt="ITM South Africa"
              class="flag"
              onclick="window.location=\'https://itmkatope.co.za\';"
            /><span class="tooltip">South Africa</span>
          </div>
          <div class="tip">
            <img
              src="../images/germany.png"
              alt="ITM Germany"
              class="flag"
              onclick="window.location=\'https://itmnexus.com\';"
            /><span class="tooltip">Germany</span>
          </div>
          <div class="tip">
            <img
              src="../images/nigeria.png"
              alt="ITM Nigeria"
              class="flag"
              onclick="window.location=\'https://itmafrica.com.ng\';"
            /><span class="tooltip">Nigeria</span>
          </div>
       </div>
        <span id="menu"><i class="material-icons">menu</i></span>
    </div> 
    <nav id="navigation">
          <span id="home">Home</span>
          <span id="about">About us</span> 
          <div id="services">Services
          <span 
              id="expandable"
              class="hidden flex-column flex-top flex-start"
              ><a href="../services.html#hr">Human Resources Solutions</a
              ><a href="training/training.php">Professional Training</a><a href="../services.html#sales">Sales Force Solutions</a
              ><a href="../services.html#industrial">Logistics and Procurement</a
              >
              </span
            ></span
          ></div>
          <span id="jobs">ITM Jobs</span>
          <span id="news" class="active">Events</span>
          <span id="contacts">Contacts</span>
    </nav>
</div> 

    <header
      id="header"
      class="flex-column flex-top flex-start margin-auto"';
      $background = "background-image:url('snaps/".$event['image']."');background-size:cover;";
      $html .=' style="'.$background.'" >
        <div class="w-100 flex-column flex-start primary-bg-transparent">
         <span class="vspacer"></span><span class="vspacer"></span><span class="vspacer"></span><span class="vspacer"></span>
            <span class="white-text title focus text-left padding-small-left">'.$event['title'].'</span>
            <span class="white-text text-left padding-std-left">
               '.$event['caption'].'
            </span>
            <span class="white-text text-left padding-std-left">'.date('d M Y',$event['event_date']).' '.@$event['location'].'</span>
            <span class="vspacer"></span>';
            if(!empty($event['link'])){
              $html .='<div class="text-left margin-std-left"><a href="'.$event['link'].'" target="_blank" class="button primary-bg round-corner border-white-all white-text">'.$event['link_text'].'</a></div>';
            }
            
            $html .='<span class="vspacer"></span>
            <span class="vspacer"></span>
     </div>
    </header>';

   $html .='<div class="w-100 margin-auto flex-row flex-between flex-middle">
   <a class="flex-row flex-start flex-middle plain-link" href="events.php"><i class="material-icons padding-small">keyboard_backspace</i>Back to Events</a>';
   
   if($isAdmin){
       $html .= '<div class="flex-row flex-end flex-middle"><a class="flex-row flex-start flex-middle plain-link" href="edit_event.php?id='.$event['id'].'"><i class="material-icons padding-small">edit</i></a></div>';
   }
   $html .='</div>';

            $html .= '<section class="w-100 flex-column flex-start flex-top margin-auto"><h2 class="subtitle primary-text text-left padding-std-left">'.$event['title'].'</h2>
            <div class="flex-row flex-start flex-top">
            <div class="w-75 padding-std-left">
            ';
            $para = explode("\n",$event['content']);
            for($i=0;$i<sizeof($para);$i++){
                $html .= '<p class="dark-text text-left padding-small">'.$para[$i].'</p>';
            }
            
                
            $html .='</div>     
           <div class="w-25 text-left margin-std">';
           if(sizeof($more) > 1){
               $html .= '<p class="subtitle accent-text">More Events</p><div class="flex-column flex-start">';
               for($k=0;$k<sizeof($more);$k++){
                if($event['id'] != $more[$k]['id']){
                    $html .='<span><a class="plain-link" href="?id='.$more[$k]['id'].'">'.$more[$k]['title'].'</a></span>';
                }
               }
           }
            
            $html .='</div></div></section>
           
            <footer class="flex-row flex-space dark-bg white-text">';
            if($isAdmin){
                $html .= '<a class="copyright" href="events_admin.php"
                >Events Admin</a
              >';
            }
              $html .='<span class="copyright">2020 &copy;ITM Tanzania Ltd</span
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
        </html>';
        echo $html;
        }
    }
    else{
            $location .= "/events/events.php";
            header($location,true);
    }



?>
