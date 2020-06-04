<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$isAdmin = false;

if(isset($_SESSION['user'])){
    $isAdmin = DB::isAdmin($_SESSION['user']);
}

if(isset($_GET['id'])){
    
    $program = DB::getTrainingProgram($_GET['id']);
    if(!$program){
        $location = HEADER . "/training/training.php";
        header($location,true);
    }
    else{
        $programs = DB::getTrainingPrograms();
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
  <div
  id="floating-header"
  class="floating-header flex-row flex-between flex-top w-100-no-padding padding-std margin-auto"
>
  <img src="../images/logo.png" class="logo" alt="ITM logo" />
  <div class="flex-column flex-center flex-end">
    <div class="flex-row flex-end margin-std-right desktop-only">
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
      class="min-width-full flex-column flex-top flex-start margin-auto" ';
      $background = "background-image:url('programs/".$program['image']."');background-size:cover;";
      
      
      $html .='style="'.$background.'" >
        <div class="w-100-no-padding flex-column flex-start padding-std primary-bg-transparent">
          <span class="vspacer"></span> <span class="vspacer"></span> <span class="vspacer"></span>
            <p class="white-text title focus text-left">'.$program['title'].'</p>
            <p class="white-text text-left">
               '.($program['target'] - $program['registered']).' Chances left
            </p>
            <span class="white-text text-left">'.date('d M Y',$program['start_date']).' - '.date('d M Y',$program['end_date']).'</span><span class="white-text text-left">'.$program['location'].'</span>
            <span class="vspacer"></span>';
            
              $html .='<div class="text-center flex-row flex-left flex-middle"><a href="training_signup.php?pg='.$program['id'].'" class="button primary-bg round-corner border-white-all white-text">REGISTER NOW</a><a href="training_login.php?id='.$program['id'].'" class="button round-corner  white-text">VIEW APPLICATION</a></div>';
            
            
            $html .='<span class="vspacer"></span>
            <span class="vspacer"></span>
            
            
        </div>
        </div>
    </header>';

   $html .='<div class="w-100 margin-auto flex-row flex-between flex-middle">
   <a class="flex-row flex-start flex-middle plain-link" href="training.php"><i class="material-icons padding-small">keyboard_backspace</i>Back</a>';
   
   if($isAdmin){
       $html .= '<div class="flex-row flex-end flex-middle"><a class="flex-row flex-start flex-middle plain-link" href="edit_training.php?id='.$program['id'].'"><i class="material-icons padding-small">edit</i></a></div>';
   }
   $html .='</div>';

            $html .= '<section class="w-100 flex-row flex-start flex-top margin-auto">
            <div class="w-70">
            <p class="subtitle primary-text">'.$program['title'].'</p>';
            $para = explode("\n",$program['description']);
            for($i=0;$i<sizeof($para);$i++){
                $html .= '<p class="dark-text text-left padding-small">'.$para[$i].'</p>';
            }
            
                
            $html .='</div>     
           <div class="w-30 text-left margin-std">';
           
            if($programs){
              $html .= '<p class="subtitle accent-text">More Programs</p><div class="flex-column flex-start">';
               for($k=0;$k<sizeof($programs);$k++){
                if($program['id'] != $programs[$k]['id']){
                    $html .='<span><a class="plain-link" href="?id='.$programs[$k]['id'].'">'.$programs[$k]['title'].'</a></span>';
                }
               }
            }
            
            
            
            $html .='</div>
           </div>
              
                                     
              
            </section>
           
            <footer class="flex-row flex-space dark-bg white-text min-width-full ">';
            if($isAdmin){
                $html .= '<a class="copyright" href="training_admin.php"
                >Training Admin</a
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
            $location = HEADER ."/training.php";
            header($location,true);
    }



?>
