<?php
ini_set("display_errors",1);
require("../libs/manager.php");
session_start();
$msg = "";

$isAdmin = false;
if(!isset($_GET['id']) || !isset($_SESSION['user'])){
        $location = HEADER ."/training/training.php";
        header($location,true);
}
else{
    if(isset($_SESSION['user'])){
        $user = DB::getUser($_SESSION['user']);
        $isAdmin = DB::isAdmin($user['email']);
        if(!$isAdmin){
            $fb = "You are not authorized to access the page!";
        $location = HEADER . "/training/training.php?fb=".$fb;
        header($location,true);
        }
        else{

            $program = DB::getTrainingProgram($_GET['id']);
            if(isset($_POST['deleteProgram'])){
              $delete = DB::deleteTrainingProgram($_GET['id']);
              $msg = ($delete) ? "Successfully deleted event!":"Sorry! Could not delete event!";
              
            }
           
            if(isset($_POST['updateProgram'])){
                $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
                $contact = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
                $start_date = strtotime(filter_var($_POST['start_date'],FILTER_SANITIZE_STRING));
                $end_date = strtotime(filter_var($_POST['end_date'],FILTER_SANITIZE_STRING));
                $target = filter_var($_POST['target'],FILTER_DEFAULT);

                $instructor = filter_var($_POST['instructor'],FILTER_SANITIZE_STRING);
                $location = filter_var($_POST['location'],FILTER_SANITIZE_STRING);
                $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
                // $feature_image = filter_var($_POST['feature_image'],FILTER_SANITIZE_STRING);
                
                $data = array();
                if(!empty($title)) $data['title'] = $title;
                if(!empty($contact)) $data['contact'] = $contact;
                if(!empty($description)) $data['description'] = $description;
                if(!empty($target)) $data['target'] = $target;
                if(!empty($phone)) $data['phone'] = $phone;
                if(!empty($instructor)) $data['instructor'] = $instructor;
                if(!empty($location)) $data['location'] = $location;
                
                if(isset($_POST['start_date'])) $data['start_date'] = $start_date;
                if(isset($_POST['end_date'])) $data['end_date'] = $end_date;
                
                if(isset($_FILES['feature_image']) && !empty($_FILES['feature_image']['name'])) {
                    $file = $_FILES['feature_image'];
                    $data['image'] = $file;
                }
                $action = DB::updateTrainingProgram($data,$_GET['id']);
                
                $msg = (!$action) ? "Invalid Request" : $action['message'];
                $program = $action['program'];
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

<link
  href="https://fonts.googleapis.com/icon?family=Material+Icons"
  rel="stylesheet"
/>
<link
  href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
  rel="stylesheet"
/>
<link rel="icon" href="../images/favicon.png" />

<title>ITM Tanzania - Training</title>
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
  <a href="../jobs/job_listings.php">Jobs</a>
  <a href="../admin/signout.php" >Signout</a>
</nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
echo '<p class="error-text">'.$msg.'</p>
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="title white-text margin-auto flex-row flex-center flex-middle padding-small">Edit Training Program
    </div>
    </section>';
            echo '<section class="w-100 margin-std">

<form action="" enctype="multipart/form-data" method="post" class="w-60 flex-column flex-start text-left margin-auto">
    <div class="form-group flex-column flex-start padding-small">
    <label for="title">Title/Theme</label>
    <input value="'.$program['title'].'" 
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
 echo '<input  value="'.date('d M Y',$program['start_date']).'" onfocus="'.$focus.'" onblur="'.$blur.'" 
    type="text"
    name="start_date"
    id="start_date"
    class="form-control padding-small"
  />
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="event_date">Event Date</label>';
  $focus = "this.type = 'date';";
  $blur = "this.type = 'text';";
 echo '<input  value="'.date('d M Y',$program['end_date']).'" onfocus="'.$focus.'" onblur="'.$blur.'" 
    type="text"
    name="end_date"
    id="end_date"
    class="form-control padding-small"
  />
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="target">Open Applications</label>

<input value="'.$program['target'].'"
  type="number"
  name="target"
  id="target"
  class="form-control padding-small"
  placeholder="Number of applications..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="feature_image">Feature Image</label>';
if($program['image']) echo '<img src="programs/'.$program['image'].'" class="w-50" />';
echo '<input accept="image/*"
  type="file"
  name="feature_image"
  id="feature_image"
  class="form-control padding-small"
  placeholder="Change image..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="instructor">Instructor/Coordinator</label>
<input  value="'.$program['instructor'].'" 
  type="text"
  name="instructor"
  id="instructor"
  class="form-control padding-small"
  placeholder="Enter Caption..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="content">Description</label>
<textarea rows=10
  name="description"
  id="description"
  class="form-control padding-small">'.$program['description'].'</textarea>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="contact">Contact Email</label>
<input  value="'.$program['contact'].'" 
  type="email"
  name="contact"
  id="contact"
  class="form-control padding-small"
  placeholder="Contact email..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="phone">Contact Phone</label>
<input  value="'.$program['phone'].'" 
  type="text"
  name="phone"
  id="phone"
  class="form-control padding-small"
  placeholder="Phone number..."
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
              if($cities[$i] == $program['location']) echo '<option selected>'.$cities[$i].'</option>';
              else echo '<option>'.$cities[$i].'</option>';
            }
echo '</select>
</div>
<div class="form-group flex-row flex-space flex-middle padding-small">';
if($isAdmin){
  echo '<input
  type="submit"
  name="updateProgram"
  id="updateProgram"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value="UPDATE"
/>

<input
type="submit"
name="deleteProgram"
id="deleteProgram"
class="button form-control padding-small alert-bg white-text round-corner border-all-white"
value="DELETE"
/>';
}

 
echo '<a href="training_detail.php?id='.$program['id'].'" class="plain-link">CANCEL</a>
</div>
</form>
</section>';
        }
    
  }
    else{
        $fb = "You need to login to access the page!";
            
        $location = HEADER . "/training/training.php?fb=".$fb;
        header($location,true);
    }
  
}
