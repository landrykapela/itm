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
      <a href="account.php?e='.$user['id'].'" >Account</a>
      <a href="events_admin.php" >Events</a>
      <a href="training_admin.php" >Training</a>
      <a href="job_listings.php">Jobs</a>
      <a href="signout.php" >Signout</a>
    </nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small">
        <span id="btn-candidates" class="button accent-bg white-text padding-std margin-std">Candidates</span>
        <span id="btn-search" class="button primary-bg white-text padding-std margin-std">Search Candidate</span>
    <div>
    <div class="margin-auto flex-row flex-end flex-middle padding-small">
        <span id="btn-listings" class="button primary-bg white-text padding-std margin-std">Jobs</span>
    </div>
</section>';
echo '<section class="w-100 margin-std hidden" id="listings">
<span class="flex-row flex-space flex-middle w-100"><p class="title primary-text">Listings</p><div class="text-center"><span class="vspacer"><a href="add_job.php" class="white-text button primary-bg round-corner border-white-all">Add Job</a></span></div></span>
<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Title</td><td>Description</td><td>Date uploaded</td><td>Deadline</td></tr></thead>
    <tbody>';
    $jobs = DB::getJobListings();
    if(!$jobs){
      echo '<tr><td colspan=4 class="text-center">No job openings</td></tr></tbody></table>';
      echo '<p></p>';
    }
     else{
       for($i=0; $i<sizeof($jobs);$i++){
         $job = $jobs[$i];
         echo '<tr><td><a href="job_details.php?jid='.$job['id'].'" class="plain-link">'.$job['position'].'</a></td><td><a href="job_details.php?jid='.$job['id'].'" class="plain-link">'.(strlen($job['description']) > 64 ? substr($job['description'],0,64):$job['description']).'</a></td><td><a href="job_details.php?jid='.$job['id'].'" class="plain-link">'.date('d M Y',$job['date_created']).'</a></td><td><a href="job_details.php?jid='.$job['id'].'" class="plain-link">'.date('d M Y',$job['deadline']).'</a></td></tr>';
       }
     }   
    echo '</tbody>
</table>
</section>';
echo '<section class="w-100 margin-std " id="candidates">
<p class="title primary-text">Candidate Profiles</p>
<table class="w-100 margin-auto text-left">
    <thead class="primary-bg white-text"><tr><td>Name</td><td>Qualification</td><td>Career</td><td>Recent Employer</td></tr></thead>
    <tbody>';
$candidates = DB::listCandidates();
for($i=0;$i<sizeof($candidates);$i++){
  $candidate = $candidates[$i];
  $qual = DB::getHighestQualification($candidate['email']);
  $exp = DB::getLatestEmployment($candidate['email']);
  if($qual != null){
  echo '<tr><td><a class="plain-link" href="admin_profile.php?u='.$candidate['id'].'">'.$candidate['name'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$qual['level'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$qual['major'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$exp['institution'].'</a></td></tr>';
  }
}
        
   echo' </tbody>
</table>
</section>';

echo '<section class="w-100 margin-std hidden" id="search-form">
<p class="title primary-text">Advanced Search</p>
<form class="w-100 margin-auto flex-column flex-center" action="search_result.php" method="post">
<div class=" text-left flex-row flex-space flex-top">
   <div class="flex-column flex-start flex-top margin-std">
    <label for="name">Candidate Name</label>
    <input type="text" name="name" id="name" placeholder="Candidate\'s name" class="form-control padding-small"/>
   </div>
   <div class="flex-column flex-start flex-top margin-std">
    <label for="profession">Professional Career</label>';
      $careers = DB::listCareers();
      if(!$careers){
        echo '<input type="text" name="major" id="major" placeholder="Career" class="form-control padding-small"/>';
      }
      else{
echo '<select name="major" id="major" class="form-control padding-small"><option>Any</option>';
        for($i=0;$i<sizeof($careers);$i++){
          echo '<option>'.$careers[$i]['name'].'</option>';
        }
        echo '</select>';
      }
 echo '</div>
  <div class="flex-column flex-start flex-top margin-std">
    <label for="level">Level of Education</label>
    <select name="level" id="level" class="form-control padding-small">
        <option>Any</option>
        <option>Doctorate</option>
        <option>Master</option>
        <option>Bachelor</option>
        <option>Diploma</option>
        <option>Certificate</option>
        <option>Short Course</option>
    
    </select>
  </div>
</div>
<div class="w-100 flex-column flex-center flex-middle">
    <input type="submit" name="submitSearch" id="submitSearch" value="Search" class="button round-corner primary-bg border-white-all white-text w-100 form-control padding-small"/>
    </div>
</form>';


echo '</section>';

echo '
    <script>
    const btnCandidates = document.getElementById("btn-candidates");
    const btnSearch = document.getElementById("btn-search");
    const btnListings = document.getElementById("btn-listings");
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
