<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');

$location = HEADER."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);
if(!$admin){
    $fb = "You need to login as admin to view this page!";
    $location = HEADER. "/jobs/signup.html?fb=".$fb."#login";
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
<link href="../styles/general_large.css" rel="stylesheet" />
<link href="../styles/general_tablet.css" rel="stylesheet" />

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
<link rel="icon" href="../images/favicon.png" />

<title>ITM Tanzania - Training Portal</title>
</head>
<body>
<header
  id="header"
  class="min-width-full flex-column flex-top flex-start margin-auto"
>
  <div
    class="flex-row flex-start flex-middle w-100 padding-std margin-auto"
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
$msg = "";
$programs = DB::getTrainingPrograms();
$applications = DB::getApplications();
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
if(isset($_POST['saveProgram'])){
    $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
    $start_date = strtotime(filter_var($_POST['start_date'],FILTER_SANITIZE_STRING));
    $end_date = strtotime(filter_var($_POST['end_date'],FILTER_SANITIZE_STRING));

    $location = filter_var($_POST['location'],FILTER_SANITIZE_STRING);
    $instructor = filter_var($_POST['instructor'],FILTER_SANITIZE_STRING);
    $target = filter_var($_POST['target'],FILTER_SANITIZE_STRING);
    
    $data = array();
                if(!empty($title)) $data['title'] = $title;
                if(!empty($contact)) $data['contact'] = $contact;
                if(!empty($description)) $data['description'] = $description;

                if(!empty($instructor)) $data['instructor'] = $instructor;
                if(!empty($target)) $data['target'] = $target;
                if(!empty($location)) $data['location'] = $location;
                
                if(isset($_POST['start_date'])) $data['start_date'] = $start_date;
                if(isset($_POST['end_date'])) $data['end_date'] = $end_date;
                
                if(isset($_FILES['feature_image'])) {
                    $file = $_FILES['feature_image'];
                    $data['image'] = $file;
                }
   
                if(!empty($data['contact']) && !empty($data['title']) && !empty($data['description']) && !empty($data['start_date']) && !empty($data['end_date'])){
                  $action = DB::createTrainingProgram($data);
                  (!$action) ? "Could not create training program!":"Program created successfully!";
                  $programs = DB::getTrainingPrograms();
                }
    
                else $msg = "Please fill in mandatory fields!";
    
}

echo '<p class="error-text">'.$msg.'</p>
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small">
    <span id="btn-search" class="button primary-bg white-text padding-std margin-std">Applications</span> 
    </div><div class="margin-auto flex-row flex-start flex-middle padding-small">
        <span id="btn-events" class="button accent-bg white-text padding-std margin-std">Manage Programs</span>
    <div>
    <div class="margin-auto flex-row flex-end flex-middle padding-small">
        <span id="btn-new" class="button primary-bg white-text padding-std margin-std">New Program</span>
    </div>
</section>';
echo '<section class="w-100 margin-std hidden" id="listings">
<span class="flex-row flex-space flex-middle w-100"><p class="title primary-text">Add New Program</p></span>
<form action="" enctype="multipart/form-data" method="post" class="w-60 flex-column flex-start text-left margin-auto">
    <div class="form-group flex-column flex-start padding-small">
    <label for="title">Title/Theme <span class="error-text">*</span></label>
    <input
      type="text"
      name="title"
      id="title"
      class="form-control padding-small"
      placeholder="Title..."
    />
  </div>
  <div class="form-group flex-column flex-start padding-small">
  <label for="start_date">Start Date <span class="error-text">*</span></label>
  <input
    type="date"
    name="start_date"
    id="start_date"
    class="form-control padding-small"
  />
</div>
<div class="form-group flex-column flex-start padding-small">
  <label for="end_date">End Date <span class="error-text">*</span></label>
  <input
    type="date"
    name="end_date"
    id="end_date"
    class="form-control padding-small"
  />
</div>

<div class="form-group flex-column flex-start padding-small">
<label for="description">Description <span class="error-text">*</span></label>
<textarea rows=10
  name="description"
  id="description"
  class="form-control padding-small"></textarea>
</div>

<div class="form-group flex-column flex-start padding-small">
<label for="target">Open Applications</label>
<input 
  type="number"
  name="target"
  id="target"
  class="form-control padding-small"
  placeholder="Number of Applications..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="instructor">Instructor/Coordinator</label>
<input 
  type="text"
  name="instructor"
  id="instructor"
  class="form-control padding-small"
  placeholder="Instructor name..."
/>
</div><div class="form-group flex-column flex-start padding-small">
<label for="contact">Contact Email <span class="error-text">*</span></label>
<input
  type="email"
  name="contact"
  id="contact"
  class="form-control padding-small"
  placeholder="Enter email..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="phone">Contact Phone</label>
<input
  type="text"
  name="phone"
  id="phone"
  class="form-control padding-small"
  placeholder="Enter phone number..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="feature_image">Feature Image</label>
<input 
  type="file"
  name="feature_image"
  id="feature_image"
  class="form-control padding-small"
/>
</div>';
// <div class="form-group flex-column flex-start padding-small">
// <label for="link_text">Link Text</label>
// <input 
//   type="text"
//   name="link_text"
//   id="link_text"
//   class="form-control padding-small"
//   placeholder="eg: View Details, Signup..."
// />
// </div>
echo '<div class="form-group flex-column flex-start padding-small">
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
<div class="form-group flex-row flex-space flex-middle padding-small">

<input
  type="submit"
  name="saveProgram"
  id="saveProgram"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value=" SAVE "
/>
<a href="" class="plain-link">CANCEL</a>
</div>
</form>
</section>';
echo '<section class="w-100 margin-std " id="candidates">
<p class="title primary-text"></p>
<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Title/Theme</td><td>Description</td><td>Start Date</td><td>End Date</td><td>Available Applications</td></tr></thead>
    <tbody>';

if(!$programs || count($programs) == 0){
    echo '<tr><td colspan=5 class="text-center">No programs to show</td></tr>';
}
else{
for($i=0;$i<sizeof($programs);$i++){
  $program = $programs[$i];
  
  echo '<tr><td><a class="plain-link" href="training_detail.php?id='.$program['id'].'">'.$program['title'].'</a></td><td><a href="training_detail.php?id='.$program['id'].'">'.(strlen($program['description']) > 72 ? substr($program['description'],0,72) : $program['description']).'</a></td><td><a href="training_detail.php?id='.$program['id'].'">'.date('d M Y',$program['start_date']).'</a></td><td><a href="training_detail.php?id='.$program['id'].'">'.date('d M Y',$program['end_date']).'</a></td><td class="text-right"><a href="training_detail.php?id='.$program['id'].'">'.($program['target'] - $program['registered']).'</a></td></tr>';
  }
}
        
   echo' </tbody>
</table>
</section>';

echo '<section class="w-100 margin-std hidden" id="search-form">
<p class="title primary-text">Applications</p>
<form class="w-100 margin-auto accent-bg flex-row flex-center flex-bottom" action="search_applications.php" method="post">

  <div class="flex-column flex-center flex-middle padding-small margin-std-bottom margin-std-top ">
    <label for="program">Applicant\'s Name</label>
      <input type="text" name="name" id="name" placeholder="candidate name..." class="form-control padding-small"/>
  </div>
  <div class="flex-column flex-center flex-middle padding-small margin-std-bottom margin-std-top ">
    <label for="program">Training Program</label>
    <select
      name="program"
      id="program"
      class="form-control padding-small"><option>--select--</option>';
            
            for($i=0;$i<count($programs);$i++){
              echo '<option value='.$programs[$i]['id'].'>'.$programs[$i]['title'].'</option>';
            }
      echo '</select>
  </div>
  <div class="flex-column flex-center flex-middle padding-small">
    <input type="submit" name="submitSearch" id="submitSearch" value="Search" class="text-center button round-corner primary-bg border-white-all white-text form-control padding-small"/>
  </div>

</form>

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
