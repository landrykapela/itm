<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');
$location = HEADER ."/training/training.php";
if(!isset($_SESSION['user']) || !DB::isAdmin($_SESSION['user'])) header($location);

$applications = DB::getApplications();
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
    class="flex-row flex-end flex-middle w-100 padding-std margin-auto"
  >
    
  <nav class="flex-row flex-center white-bg" id="navigation">
  <a href="../admin/admin_account.php" >Account</a>
  <a href="../events/events_admin.php" >Events</a>
  <a href="training_admin.php" >Training</a>
  <a href="../admin/admin.php">Jobs</a>
  <a href="../admin/signout.php" >Signout</a>
</nav>
    <span id="menu2"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
if(isset($_POST['submitSearch'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $program = $_POST['program'];
     
    $options = array();
    if(empty($name) || empty($program)){
      $msg = "Please provide a search keyword!";
    }
    else{
      if(!empty($name)) $options['name'] = $name;
      if(!empty($program)) $options['program'] = $program;
  
      $applications = DB::searchApplications($options);
    }
  }

  if(isset($_POST['clearSearch'])){
      $applications = DB::getApplications();
  }
echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small">
    <p class="title white-text">Applications Search Result</p>
    </div>
</section>';
echo '<section class="w-100 margin-std" id="listings">
<span class="flex-row flex-space flex-middle w-100"><p class="title primary-text"><form action="" method="post"><input class="padding-small" type="text" id="search" name="search" placeholder="search..."/><input class="padding-small primary-bg white-text" type="submit" id="btnSearch" name="btnSearch" value="search"/><input class="padding-small accent-bg white-text" type="submit" id="clearSearch" name="clearSearch" value="clear"/></form></p></span>

<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Name</td><td>Program</td><td>E-mail</td><td>Phone</td><td>Proof of Payment</td><td>Status</td></tr></thead>
    <tbody>';

if(!$applications || count($applications) == 0){
    echo '<tr><td colspan=6 class="text-center">No Applications Found</td></tr>';
}
else{
for($i=0;$i<sizeof($applications);$i++){
  $application = $applications[$i];
  
  echo '<tr><td><a class="plain-link" href="application_details.php?id='.$application['id'].'">'.$application['name'].'</a></td><td><a href="application_details.php?id='.$application['id'].'">'.$application['program_title'].'</a></td><td><a href="application_details.php?id='.$application['id'].'">'.$application['contact'].'</a></td><td class="text-right"><a href="application_details.php?id='.$application['id'].'">'.$application['phone'].'</a></td><td class="text-right"><a href="proofs/'.$application['proof'].'">View Proof</a></td><td><a href="application_details.php?id='.$application['id'].'">'.$application['status_text'].'</a></td></tr>';
  }
}
        
   echo' </tbody>
</table>
</section>';

echo "</body>";

?>
