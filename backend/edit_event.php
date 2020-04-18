<?php
ini_set("display_errors",1);
require("manager.php");
session_start();
$msg = "";
$isAdmin = false;
if(!isset($_GET['id']) || !isset($_SESSION['user'])){
    
            if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on"){
                $location = "https://";
            } 
            else $location = "http://";
        $location .= $_SERVER['HTTP_HOST']."/events.php";
        header("Location: ".$location,true);
}
else{
    if(isset($_SESSION['user'])){
        $user = DB::getUser($_SESSION['user']);
        $isAdmin = DB::isAdmin($user['email']);
        if(!$isAdmin){
            $fb = "You are not authorized to access the page!";
            $location = ($_SERVER['HTTPS']) ? "https://":"http://";
        $location .= $_SERVER['HTTP_HOST']."/events.php?fb=".$fb;
        header("Location: ".$location,true);
        }
        else{

            $event = DB::getEventById($_GET['id']);
            if(isset($_POST['deleteEvent'])){
              $delete = DB::deleteEvent($_GET['id']);
              $msg = ($delete) ? "Successfully deleted event!":"Sorry! Could not delete event!";
              
            }
            if(isset($_POST['archiveEvent'])){
              $archive = DB::archiveEvent($_GET['id']);
              $msg = ($archive) ? "Successfully archived event!":"Sorry! Could not archive event!";
              
            }
            if(isset($_POST['updateEvent'])){
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
                
                if(isset($_FILES['feature_image']) && !empty($_FILES['feature_image']['name'])) {
                    $file = $_FILES['feature_image'];
                    $data['image'] = $file;
                }
                $action = DB::updateEvent($data,$_GET['id']);
                
                $msg = (!$action) ? "Invalid Request" : $action['message'];
                $event = $action['event'];
            }

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
      <a href="job_listings.php">Jobs</a>
      <a href="signout.php" >Signout</a>
    </nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
echo '<p class="error-text">'.$msg.'</p>
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="title white-text margin-auto flex-row flex-center flex-middle padding-small">Edit Event
    </div>
    </section>';
            echo '<section class="w-100 margin-std">

<form action="" enctype="multipart/form-data" method="post" class="w-60 flex-column flex-start text-left margin-auto">
    <div class="form-group flex-column flex-start padding-small">
    <label for="title">Title/Theme</label>
    <input value="'.$event['title'].'" 
      type="text"
      name="title"
      id="title"
      class="form-control padding-small"
      placeholder="Title..."
    />
  </div>
  <div class="form-group flex-column flex-start padding-small">
  <label for="event_date">Event Date</label>';
  $focus = "this.type = 'date';";
  $blur = "this.type = 'text';";
 echo '<input  value="'.date('d M Y',$event['event_date']).'" onfocus="'.$focus.'" onblur="'.$blur.'" 
    type="text"
    name="event_date"
    id="event_date"
    class="form-control padding-small"
  />
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="feature_image">Feature Image</label>
<img src="events/'.$event['image'].'" class="w-50" />
<input accept="image/*"
  type="file"
  name="feature_image"
  id="feature_image"
  class="form-control padding-small"
  placeholder="Change image..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="caption">Image Caption</label>
<input  value="'.$event['caption'].'" 
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
  class="form-control padding-small">'.$event['content'].'</textarea>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="link">External Link</label>
<input  value="'.$event['link'].'" 
  type="url"
  name="link"
  id="link"
  class="form-control padding-small"
  placeholder="https://example.com..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="link_text">Link Text</label>
<input  value="'.$event['link_text'].'" 
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
<div class="form-group flex-row flex-space flex-middle padding-small">';
if($isAdmin){
  echo '<input
  type="submit"
  name="updateEvent"
  id="updateEvent"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value="UPDATE"
/>
<input
type="submit"
name="archiveEvent"
id="archiveEvent"
class="button form-control padding-small success-bg white-text round-corner border-all-white"
value="ARCHIVE"
/>
<input
type="submit"
name="deleteEvent"
id="deleteEvent"
class="button form-control padding-small alert-bg white-text round-corner border-all-white"
value="DELETE"
/>';
}

 
echo '<a href="event_detail.php?id='.$event['id'].'" class="plain-link">CANCEL</a>
</div>
</form>
</section>';
        }
    
  }
    else{
        $fb = "You need to login to access the page!";
            $location = ($_SERVER['HTTPS']) ? "https://":"http://";
        $location .= $_SERVER['HTTP_HOST']."/events.php?fb=".$fb;
        header("Location: ".$location,true);
    }
  
}
