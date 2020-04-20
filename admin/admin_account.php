<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$msg = "";
$location = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://" : "http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header("Location: ".$location);
$user = DB::getUser($_SESSION['user']);
if(!DB::isAdmin($user['email'])){
    $fb = "You are not allowed to access this page!";
    
  $location .= "?fb=".$fb;
  header("Location: ".$location,true);
}
else{
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

<title>ITM Tanzania - Admin Panel</title>
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
  <a href="admin_account.php" >Account</a>
  <a href="../events/events_admin.php" >Events</a>
  <a href="../training/training_admin.php" >Training</a>
  <a href="../jobs/job_listings.php">Jobs</a>
  <a href="signout.php" >Signout</a>
</nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
</header>';
$careers = DB::listCareers();
if(isset($_POST['btnSend'])){
    $subject = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
    $body = filter_var($_POST['message'],FILTER_SANITIZE_STRING);
    $data = array();
    $data['subject'] = $subject;
    $data['message'] = $body;
    if(isset($_FILES['image'])) $data['image'] = $_FILES['image'];

    $send = DB::sendGroupMail($data);
    $msg = $send['message'];
}
if(isset($_POST['btnSaveCareer'])){
    $name = filter_var($_POST['career'],FILTER_SANITIZE_STRING);
    if(!empty($name)){
        $res = DB::addCareer($name);
        if(!$res) $msg = "Could not add career!";
        else {
        $msg = "Career successfully added!";
        $careers = $res;
        }
    }
}
echo '<p class="error-text">'.$msg.'</p>';
echo ' <section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Basic Info</p><a class="button primary-bg border-white-all round-corner" href="admin_edit.php?e='.$user['id'].'">Edit</a>


</div>
<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">

<p>'.$user['name'].'</p>
<p>'.$user['email'].'</p>
<p>'.$user['phone'].'</p>

</div>
</section><span class="vspacer-small"></span>';
echo ' <section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Group Mail</p><span class="text-left white-text">Send group mail to recipients in mailing list</span>


</div>
<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="w-100 margin-auto text-left" action="" method="POST">
<span class="vspacer"></span>

<div class="form-group flex-column flex-start padding-small">
  <label for="subject">Subject</label>
  <input
    type="text"
    name="subject"
    id="subject"
    class="form-control padding-small"
    placeholder="Subject..."
  />
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="message">Message Body</label>
  <textarea rows=10 
    name="message"
    id="message"
    class="form-control padding-small"
  ></textarea>
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="image">Attach Image</label>
  <input
    type="file"
    name="image"
    id="image"
    class="form-control padding-small"
    placeholder="Select image file..."
  />
</div>

<span class="vspacer"></span>
<div class="form-group flex-row flex-start flex-middle padding-small">
  <input type="submit"
    name="btnSend"
    id="btnSend"
    class="form-control button border-white-all round-corner text-center primary-bg white-text"
    value=" SEND " />
  
</div>
<span class="vspacer"></span>
</form>
</div>
</section>';
echo ' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-40  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="title">Other</p><span class="text-left white-text">Other Settings</span>


</div>
<div class="w-50 flex-column flex-start flex-top accent-bg dark-text padding-std">
<form class="w-100 margin-auto text-left" action="" method="POST" enctype="multipart/form-data">
<span class="vspacer"></span>

<div class="form-group flex-column flex-start padding-small">
  <label for="careers">Saved Careers</label>
  <select
    name="careers"
    id="careers"
    class="form-control padding-small">';
    
    for($i=0;$i<sizeof($careers);$i++){
      if($education['major'] == $careers[$i]['name'])
      echo '<option>'.$careers[$i]['name'].'</option>';
      else echo '<option>'.$careers[$i]['name'].'</option>';
    }
  echo '</select></div>
  <div class="form-group flex-column flex-start padding-small">
  <label for="career">Add Profession/Career</label>
  <input type="text"
    name="career"
    id="career" placeholder="Profession..."
    class="form-control padding-small"/></div>
    <div class="form-group flex-row flex-start flex-middle padding-small">
      <input type="submit"
        name="btnSaveCareer"
        id="btnSaveCareer"
        class="form-control button border-white-all round-corner text-center primary-bg white-text"
        value=" SAVE " />
      
    </div>
</form></section>
<span class="vspacer"></span>';
echo "</body>";
}
?>
