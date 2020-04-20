<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');

if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on"){
    $location = "https://";
} 
else $location = "http://";
$location .= $_SERVER['HTTP_HOST']."/signup.html#login";
if(!isset($_SESSION['user'])) header("Location: ".$location);
$admin = DB::isAdmin($_SESSION['user']);
if(!$admin){
    $fb = "You need to login as admin to view this page!";
    $location .= "?fb=".$fb."#login";
    header("Location: ".$location,true);
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
      <a href="events_admin.php" >Events</a>
      <a href="../training/training_admin.php" >Training</a>
      <a href="../jobs/job_listings.php">Jobs</a>
      <a href="../admin/signout.php" >Signout</a>
    </nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
$msg = "";
if(isset($_POST['saveEvent'])){
    $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'],FILTER_SANITIZE_STRING);
    $caption = filter_var($_POST['caption'],FILTER_SANITIZE_STRING);
    $date = strtotime(filter_var($_POST['event_date'],FILTER_SANITIZE_STRING));

    $location = filter_var($_POST['location'],FILTER_SANITIZE_STRING);
    $link = filter_var($_POST['link'],FILTER_SANITIZE_STRING);
    $link_text = filter_var($_POST['link_text'],FILTER_SANITIZE_STRING);
    $data = array();
                if(!empty($title)) $data['title'] = $title;
                if(!empty($content)) $data['content'] = $content;
                if(!empty($caption)) $data['caption'] = $caption;

                if(!empty($link)) $data['link'] = $link;
                if(!empty($link_text)) $data['link_text'] = $link_text;
                if(!empty($location)) $data['location'] = $location;
                
                if(isset($_POST['event_date'])) $data['event_date'] = $date;
                
                if(isset($_FILES['feature_image'])) {
                    $file = $_FILES['feature_image'];
                    $data['image'] = $file;
                }
   
                if(!empty($data['title']) && !empty($data['content']) && !empty($data['event_date'])){
                  $action = DB::createEvent($data);
                  $msg = $action['message'];
                }
    
                else $msg = "Please fill in mandatory fields!";
    
}

echo '<p class="error-text">'.$msg.'</p>
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small">
    <span id="btn-search" class="button primary-bg white-text padding-std margin-std">Search Archive</span> 
    </div><div class="margin-auto flex-row flex-start flex-middle padding-small">
        <span id="btn-events" class="button accent-bg white-text padding-std margin-std">Manage Events</span>
    <div>
    <div class="margin-auto flex-row flex-end flex-middle padding-small">
        <span id="btn-new" class="button primary-bg white-text padding-std margin-std">New Event</span>
    </div>
</section>';
echo '<section class="w-100 margin-std hidden" id="listings">
<span class="flex-row flex-space flex-middle w-100"><p class="title primary-text">Add New Event</p></span>
<form action="" enctype="multipart/form-data" method="post" class="w-60 flex-column flex-start text-left margin-auto">
    <div class="form-group flex-column flex-start padding-small">
    <label for="title">Title/Theme</label>
    <input
      type="text"
      name="title"
      id="title"
      class="form-control padding-small"
      placeholder="Title..."
    />
  </div>
  <div class="form-group flex-column flex-start padding-small">
  <label for="event_date">Event Date</label>
  <input
    type="date"
    name="event_date"
    id="event_date"
    class="form-control padding-small"
  />
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="feature_image">Feature Image</label>
<input accept="image/*"
  type="file"
  name="feature_image"
  id="feature_image"
  class="form-control padding-small"
  placeholder="Feature image..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="caption">Image Caption</label>
<input
  type="text"
  name="caption"
  id="caption"
  class="form-control padding-small"
  placeholder="Enter Caption..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="content">Description</label>
<textarea rows=10
  name="content"
  id="content"
  class="form-control padding-small"></textarea>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="link">External Link</label>
<input 
  type="text"
  name="link"
  id="link"
  class="form-control padding-small"
  placeholder="https://example.com..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="link_text">Link Text</label>
<input 
  type="text"
  name="link_text"
  id="link_text"
  class="form-control padding-small"
  placeholder="eg: View Details, Signup..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="location">Location</label>
<select
  
  name="location"
  id="location"
  class="form-control padding-small"><option>--select--</option>';
            $cities = DB::getTanzaniaCities();
            for($i=0;$i<count($cities);$i++){
              if($cities[$i] == $event['location']) echo '<option selected>'.$cities[$i].'</option>';
              else echo '<option>'.$cities[$i].'</option>';
            }
echo '</select>
</div>
<div class="form-group flex-row flex-space flex-middle padding-small">

<input
  type="submit"
  name="saveEvent"
  id="saveEvent"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value="SAVE"
/>
<a href="" class="plain-link">CANCEL</a>
</div>
</form>
</section>';
echo '<section class="w-100 margin-std " id="candidates">
<p class="title primary-text"></p>
<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Title/Theme</td><td>Description</td><td>Event Date</td></tr></thead>
    <tbody>';
$events = DB::getEvents();
if(!$events || count($events) == 0){
    echo '<tr><td colspan=4 class="text-center">No events to show</td></tr>';
}
else{
for($i=0;$i<sizeof($events);$i++){
  $event = $events[$i];
  
  echo '<tr><td><a class="plain-link" href="event_detail.php?id='.$event['id'].'">'.$event['title'].'</a></td><td><a href="event_detail.php?id='.$event['id'].'">'.(strlen($event['content']) > 72 ? substr($event['content'],0,72) : $event['content']).'</a></td><td><a href="event_detail.php?id='.$event['id'].'">'.date('d M Y',$event['event_date']).'</a></td></tr>';
  }
}
        
   echo' </tbody>
</table>
</section>';

echo '<section class="w-100 margin-std hidden" id="search-form">
<p class="title primary-text">Search Archive</p>
<form class="w-100 margin-auto flex-column flex-center" action="search_archive.php" method="post">
<div class=" text-center flex-row flex-center flex-top">
   <div class="flex-column flex-center flex-top margin-std">
    
    <input type="text" name="search" id="search" placeholder="keyword..." class="form-control padding-small"/>
   </div>
  </div>
<div class="text-center flex-column flex-center flex-middle">
    <input type="submit" name="submitSearch" id="submitSearch" value="Search" class="button round-corner primary-bg border-white-all white-text w-100 form-control padding-small"/>
    </div>
</form>';


echo '</section>';

echo '
    <script>
    const btnCandidates = document.getElementById("btn-events");
    const btnSearch = document.getElementById("btn-search");
    const btnListings = document.getElementById("btn-new");
    const candidates = document.getElementById("candidates");
    const listings = document.getElementById("listings");
    const search = document.getElementById("search-form");
    
    if(btnSearch){
        btnSearch.addEventListener("click",()=>{
            btnSearch.classList.remove("primary-bg");
            btnSearch.classList.add("accent-bg");
            search.classList.remove("hidden");
            btnCandidates.classList.remove("accent-bg");
            btnCandidates.classList.add("primary-bg");
            btnListings.classList.remove("accent-bg");
            btnListings.classList.add("primary-bg");
            candidates.classList.add("hidden");
            listings.classList.add("hidden");
        });
    }
    if(btnCandidates){
        btnCandidates.addEventListener("click",()=>{
            btnCandidates.classList.remove("primary-bg");
            btnCandidates.classList.add("accent-bg");
            btnListings.classList.remove("accent-bg");
            btnListings.classList.add("primary-bg");
            candidates.classList.remove("hidden");
            listings.classList.add("hidden");

            btnSearch.classList.add("primary-bg");
            btnSearch.classList.remove("accent-bg");
            search.classList.add("hidden");
        });
    }
    if(btnListings){
        btnListings.addEventListener("click",()=>{
            btnCandidates.classList.add("primary-bg");
            btnCandidates.classList.remove("accent-bg");
            btnListings.classList.add("accent-bg");
            btnListings.classList.remove("primary-bg");
            candidates.classList.add("hidden");
            listings.classList.remove("hidden");

            btnSearch.classList.add("primary-bg");
            btnSearch.classList.remove("accent-bg");
            search.classList.add("hidden");
        });
    }
    </script>
';
echo "</body>";
}
?>
