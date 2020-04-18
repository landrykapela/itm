<?php
session_start();
ini_set("display_errors",1);
require('manager.php');
$isAdmin = false;
if(isset($_SESSION['user'])){
    $isAdmin = DB::isAdmin($_SESSION['user']);
}

if(isset($_GET['id'])){
    
    $event = DB::getEventById($_GET['id']);
    if(!$event){
        $location = ($_SERVER['HTTPS']) ? "https://":"http://";
        $location .= $_SERVER['HTTP_HOST']."/events.php";
        header("Location: ".$location,true);
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
          <span id="training">Training</span>
          <span id="news">News & Events</span>
          <!-- <span id="contacts">Contacts</span> -->
        </nav>
        <span id="menu"><i class="material-icons">menu</i></span>
      </div>';
      $background = "background-image:url('events/".$event['image']."');background-size:cover;";
      $html .='<div
        class="flex-row flex-start w-100 margin-std v-100" style="'.$background.'" >
        <div class="w-100-no-padding flex-column flex-start padding-std primary-bg-transparent">
         
            <p class="white-text title focus text-left">'.$event['title'].'</p>
            <p class="white-text text-left">
               '.$event['caption'].'
            </p>
            <span class="white-text text-left">'.date('d M Y',$event['event_date']).' '.@$event['location'].'</span>
            <span class="vspacer"></span>';
            if(!empty($event['link'])){
              $html .='<div class="text-left"><a href="'.$event['link'].'" target="_blank" class="button primary-bg round-corner border-white-all white-text">'.$event['link_text'].'</a></div>';
            }
            
            $html .='<span class="vspacer"></span>
            <span class="vspacer"></span>
            
            
        </div>
        </div>

      
      </div>
    </header>';

   $html .='<div class="w-100 margin-auto flex-row flex-between flex-middle">
   <a class="flex-row flex-start flex-middle plain-link" href="../events.php"><i class="material-icons padding-small">keyboard_backspace</i>Back to Events</a>';
   
   if($isAdmin){
       $html .= '<div class="flex-row flex-end flex-middle"><a class="flex-row flex-start flex-middle plain-link" href="edit_event.php?id='.$event['id'].'"><i class="material-icons padding-small">edit</i></a></div>';
   }
   $html .='</div>';

            $html .= '<section class="w-100 flex-row flex-start flex-top margin-auto">
            <div class="w-75">
            <p class="subtitle primary-text">'.$event['title'].'</p>';
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
            
            
            
            
            $html .='</div>
           </div>
              
                                     
              
            </section>
           
            <footer class="flex-row flex-space dark-bg white-text min-width-full ">';
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
        $location = ($_SERVER['HTTPS']) ? "https://":"http://";
            $location .= $_SERVER['HTTP_HOST']."/events.php";
            header("Location: ".$location,true);
    }



?>
