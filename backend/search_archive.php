<?php
session_start();
ini_set("display_errors",1);
require('manager.php');
$location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);
if(!$admin){
    $fb = "You need to login as admin to view this page!";
    $location = "Location: http://".$_SERVER['HTTP_HOST']."/signup.html?fb=".$fb."#login";
    header($location,true);
}
else{
  $hasResult = false;
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

<title>ITM Tanzania - Events</title>
</head>
<body>
<header
  id="header"
  class="min-width-full flex-column flex-top flex-start margin-auto"
>
  <div
    class="flex-row flex-end flex-middle w-100 padding-std margin-auto"
  >
    
  <nav class="flex-row flex-center white-bg" id="navigation">
  <a href="account.php?e='.$user['id'].'" >Account</a>
  <a href="events_admin.php" >Events</a>
  <a href="training_admin.php" >Training</a>
  <a href="http://'.$_SERVER['HTTP_HOST'].'/jobs.php">Jobs</a>
  <a href="signout.php" >Signout</a>
</nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
if(isset($_POST['submitSearch'])){
  
  $keyword = filter_var($_POST['search'],FILTER_SANITIZE_STRING);
  if(!empty($keyword)){
    $results = DB::searchArchivedEvents($keyword);
  
  }
  else $result = false;
  
    
    echo '
    <section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
        <div class="margin-auto flex-row flex-start flex-middle padding-small">
            <span class="title white-text">Search Result</span>
        </div>
    </section>';

  echo '<section><table class="w-100 margin-auto text-left">
  <thead class="primary-bg white-text"><tr><td>Title/Theme</td><td>Description</td><td>Event Date</td></tr></thead>
    <tbody>';
  if(!$results){
   echo '<tr><td colspan=3 class="text-center">No matching results</td></tr>';
}
else {
    
  for($i=0;$i<sizeof($results);$i++){
    $event = $results[$i];
  
  echo '<tr><td><a class="plain-link" href="event_detail.php?id='.$event['id'].'">'.$event['title'].'</a></td><td><a href="event_detail.php?id='.$event['id'].'">'.(strlen($event['content']) > 72 ? substr($event['content'],0,72) : $event['content']).'</a></td><td><a href="event_detail.php?id='.$event['id'].'">'.date('d M Y',$event['event_date']).'</a></td></tr>';
  }
  }

 echo'</tbody>
</table><span class="vspacer"></span><span class="vspacer"></span><a href="events_admin.php" class="plain-link">Back to Search</a>';

echo '</section>';
  }

echo "</body>";
}
?>
