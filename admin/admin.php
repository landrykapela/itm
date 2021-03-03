<?php
session_start();
// ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);
if(!$admin){
    $fb = "You need to login as admin to view this page!";
    $location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/jobs/signup.html?fb=".$fb."#login";
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
<link href="../styles/general_tablet.css" rel="stylesheet" />
<link href="../styles/general_large.css" rel="stylesheet" />

<link
  href="https://fonts.googleapis.com/icon?family=Material+Icons"
  rel="stylesheet"
/>
<link
  href="https://fonts.googleapis.com/css?family=Robot|Montserrat|Open+Sans&display=swap"
  rel="stylesheet"
/>
<link rel="icon" href="../../images/favicon.png" />

<title>ITM Tanzania - Admin Panel</title>
</head>
<body>
<header
  id="header"
  class="min-width-full flex-column flex-top flex-start margin-auto"
>
  <div
    class="flex-row flex-start flex-middle w-100 padding-std margin-auto"
  >
    
  <nav class="flex-row flex-center white-bg" id="navigation2">
  <a href="admin_account.php" >Account</a>
  <a href="../events/events_admin.php" >Events</a>
  <a href="../training/training_admin.php" >Training</a>
  <a href="admin.php">Jobs</a>
  <a href="signout.php" >Signout</a>
</nav>
    <span id="menu2"><i class="material-icons primary-text mobile-only">menu</i></span>
  </div>
  
</header><span class="mobile-only"><span class="vspacer"></span></span>';
echo '
<section class="mobile-only min-width-full margin-auto flex-row flex-center flex-middle primary-bg">
        
        <span id="btn-candidates_mobile" class="button accent-bg white-text padding-small margin-small">Candidates</span>
        
    <span id="btn-search_mobile" class="button primary-bg white-text padding-small">Search Candidate</span>
        <span id="btn-listings_mobile" class="button primary-bg white-text padding-small margin-small">Jobs</span>
    
        <span id="btn-applications_mobile" class="button primary-bg white-text padding-small margin-small">Applications</span>
    
</section>';
echo '
<section class="no-mobile flex-row flex-center flex-middle primary-bg">

        <span id="btn-candidates" class="button accent-bg white-text padding-std">Candidates</span>
   
        <span id="btn-search" class="button primary-bg white-text padding-std">Search Candidate</span>
        <span id="btn-listings" class="button primary-bg white-text padding-std">Jobs</span>
    
        <span id="btn-applications" class="button primary-bg white-text padding-std">Applications</span>
   
</section>';
echo '<span class="vspacer"></span>';
echo '<section class="w-100 margin-auto hidden" id="listings">
<div class="flex-row flex-space flex-middle w-100">
<p class="title primary-text">Listings</p>
<span class="text-center"><a href="../jobs/add_job.php" class="white-text button primary-bg round-corner ">Add Job</a></span>
</div>
<table class="w-100 margin-auto text-left" >
    <thead class="no-mobile primary-bg white-text">
    <tr><td>Title</td><td>Description</td><td>Date uploaded</td><td>Deadline</td></tr></thead>
    <tbody>';
    $jobs = DB::getJobListings();
    if(!$jobs){
      echo '<tr><td colspan=4 class="text-center">No job openings</td></tr></tbody></table>';
      echo '<p></p>';
    }
     else{
       for($i=0; $i<sizeof($jobs);$i++){
         $job = $jobs[$i];
         echo '<tr class="no-mobile"><td valign="top"><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.$job['position'].'</a></td><td valign="top" class="border-primary-bottom"><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.str_replace("\r\n","<br />",(strlen($job['description']) > 360 ? substr($job['description'],0,360)."...":$job['description'])).'</a></td><td valign="top"><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.date('d M Y',$job['date_created']).'</a></td><td valign="top"><a href="../jobs/job_details.php?jid='.$job['id'].'" class="plain-link">'.date('d M Y',$job['deadline']).'</a></td></tr>';
         
         echo '<tr class="mobile-only"><td class="border-primary-all padding-small">'.$job['position'].'<p>'.str_replace("\r\n","<br/>",(strlen($job['description']) > 360 ? substr($job['description'],0,360)."...":$job['description'])).'</p><p>'.date('d M Y',$job['date_created']).'</p><p class="text-right"><a class="button primary-bg white-text round-corner" href="../jobs/job_details.php?jid='.$job['id'].'">View Job</a></p></td></tr>';
       }
     }   
    echo '</tbody>
</table>
</section>';
echo '<section class="w-100 margin-auto" id="candidates">
<p class="title primary-text text-center">Candidate Profiles</p>
<table class="margin-auto text-left">
    <thead class="primary-bg white-text">
    <tr class="no-mobile"><td>Name</td><td>Qualification</td><td>Career</td><td>Recent Employer</td></tr>
    </thead>
    <tbody>';
$candidates = DB::listCandidates();
for($i=0;$i<sizeof($candidates);$i++){
  $candidate = $candidates[$i];
  $qual = DB::getHighestQualification($candidate['email']);
  $exp = DB::getLatestEmployment($candidate['email']);
  if($qual != null){
  echo '<tr class="no-mobile"><td><a class="plain-link" href="admin_profile.php?u='.$candidate['id'].'">'.$candidate['name'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$qual['level'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$qual['major'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$exp['institution'].'</a></td></tr>';
  echo '<tr class="mobile-only"><td class="padding-small border-primary-all"><a href="admin_profile.php?u='.$candidate['id'].'">'.$candidate['name'].'</a><p>'.$qual['major'].'</p><p>'.$qual['level'].'</p><p class="text-right"><a class="button primary-bg round-corner margin-small white-text" href="admin_profile.php?u='.$candidate['id'].'">View Profile</a></p></td></tr>';
  }
}
        
   echo' </tbody>
</table>
</section>';
echo '<section class="w-100 margin-std hidden" id="applications">
<p class="title primary-text text-center">Job Applications</p>
<table class="w-100 margin-auto text-left">
    <thead class="no-mobile primary-bg white-text"><tr><td>Applicant Name</td><td>Qualification</td><td>Profession</td><td>Position</td><td>Date Applied</td><td>Status</td></tr></thead>
    
    <tbody>';
$applications = DB::getJobApplications(null);
for($i=0;$i<sizeof($applications);$i++){
  $application = $applications[$i];
  
  echo '<tr class="no-mobile"><td><a class="plain-link" href="admin_profile.php?u='.$application['uid'].'">'.$application['name'].'</a></td><td><a href="admin_profile.php?u='.$application['uid'].'">'.$application['qualification']['level'].'</a></td><td><a href="admin_profile.php?u='.$application['uid'].'">'.$application['qualification']['major'].'</a></td><td><a href="admin_profile.php?u='.$application['uid'].'">'.$application['position'].'</a></td><td><a href="admin_profile.php?u='.$application['uid'].'">'.date('d M Y',$application['date_created']).'</a></td><td><a href="admin_profile.php?u='.$application['uid'].'">'.$application['status'].'</a></td></tr>';
  
  echo '<tr class="mobile-only"><td class="border-primary-all padding-small">'.$application['name'].'<p>'.$application['qualification']['level'].'</p><p>'.$application['qualification']['major'].'</p><p>'.$application['position'].'</p><p class="text-right"><a class="button primary-bg white-text round-corner" href="admin_profile.php?u='.$application['uid'].'">View Profile</a></p></td></tr>';
}
        
   echo' </tbody>
</table>
</section>';
echo '<section class="min-width-full margin-auto hidden accent-bg" id="search-form">
<p class="title primary-text">Advanced Search</p>
<form class="w-100 margin-auto " action="search_result.php" method="post">
<div class=" text-left flex-row flex-space flex-top border-all-white">
   <div class="flex-column flex-start flex-top margin-std">
    <label for="name">Candidate Name</label>
    <input type="text" name="name" id="name" placeholder="Candidate\'s name"/>
   </div>
   <div class="flex-column flex-start flex-top margin-std">
    <label for="profession">Professional Career</label>';
      $careers = DB::listCareers();
      if(!$careers){
        echo '<input type="text" name="major" id="major" placeholder="Career"/>';
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
    <select name="level" id="level">
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
echo '<script src="../js/general.js"></script>';
echo '
    <script>
    const btnCandidates = document.getElementById("btn-candidates");
    const btnSearch = document.getElementById("btn-search");
    const btnListings = document.getElementById("btn-listings");
    const btnApplications = document.getElementById("btn-applications");
    const btnCandidatesMobile = document.getElementById("btn-candidates_mobile");
    const btnSearchMobile = document.getElementById("btn-search_mobile");
    const btnListingsMobile = document.getElementById("btn-listings_mobile");
    const btnApplicationsMobile = document.getElementById("btn-applications_mobile");
    const candidates = document.getElementById("candidates");
    const listings = document.getElementById("listings");
    const search = document.getElementById("search-form");
    const applications = document.getElementById("applications");
    
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

          btnApplications.classList.remove("accent-bg");
          btnApplications.classList.add("primary-bg");
          applications.classList.add("hidden");
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
            btnApplications.classList.remove("accent-bg");
            btnApplications.classList.add("primary-bg");
            applications.classList.add("hidden");

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
            btnApplications.classList.remove("accent-bg");
            btnApplications.classList.add("primary-bg");
            applications.classList.add("hidden");

            btnSearch.classList.add("primary-bg");
            btnSearch.classList.remove("accent-bg");
            search.classList.add("hidden");
        });
    }
    if(btnApplications){
      btnApplications.addEventListener("click",()=>{
          btnCandidates.classList.add("primary-bg");
          btnCandidates.classList.remove("accent-bg");
          btnApplications.classList.add("accent-bg");
          btnApplications.classList.remove("primary-bg");
          applications.classList.remove("hidden");
          btnListings.classList.remove("accent-bg");
          btnListings.classList.add("primary-bg");
          candidates.classList.add("hidden");
          listings.classList.add("hidden");
          applications.classList.remove("hidden");
          btnSearch.classList.add("primary-bg");
          btnSearch.classList.remove("accent-bg");
          search.classList.add("hidden");
      });
  }
   
    if(btnSearchMobile){
        btnSearchMobile.addEventListener("click",()=>{
            btnSearchMobile.classList.remove("primary-bg");
            btnSearchMobile.classList.add("accent-bg");
            search.classList.remove("hidden");
            btnCandidatesMobile.classList.remove("accent-bg");
            btnCandidatesMobile.classList.add("primary-bg");
            btnListingsMobile.classList.remove("accent-bg");
            btnListingsMobile.classList.add("primary-bg");
            candidates.classList.add("hidden");
            listings.classList.add("hidden");

          btnApplicationsMobile.classList.remove("accent-bg");
          btnApplicationsMobile.classList.add("primary-bg");
          applications.classList.add("hidden");
        });
    }
    if(btnCandidatesMobile){
        btnCandidatesMobile.addEventListener("click",()=>{
            btnCandidatesMobile.classList.remove("primary-bg");
            btnCandidatesMobile.classList.add("accent-bg");
            btnListingsMobile.classList.remove("accent-bg");
            btnListingsMobile.classList.add("primary-bg");
            candidates.classList.remove("hidden");
            listings.classList.add("hidden");
            btnApplicationsMobile.classList.remove("accent-bg");
            btnApplicationsMobile.classList.add("primary-bg");
            applications.classList.add("hidden");

            btnSearchMobile.classList.add("primary-bg");
            btnSearchMobile.classList.remove("accent-bg");
            search.classList.add("hidden");
        });
    }
    if(btnListingsMobile){
        btnListingsMobile.addEventListener("click",()=>{
            btnCandidatesMobile.classList.add("primary-bg");
            btnCandidatesMobile.classList.remove("accent-bg");
            btnListingsMobile.classList.add("accent-bg");
            btnListingsMobile.classList.remove("primary-bg");
            candidates.classList.add("hidden");
            listings.classList.remove("hidden");
            btnApplicationsMobile.classList.remove("accent-bg");
            btnApplicationsMobile.classList.add("primary-bg");
            applications.classList.add("hidden");

            btnSearchMobile.classList.add("primary-bg");
            btnSearchMobile.classList.remove("accent-bg");
            search.classList.add("hidden");
        });
    }
    if(btnApplicationsMobile){
      btnApplicationsMobile.addEventListener("click",()=>{
          btnCandidatesMobile.classList.add("primary-bg");
          btnCandidatesMobile.classList.remove("accent-bg");
          btnApplicationsMobile.classList.add("accent-bg");
          btnApplicationsMobile.classList.remove("primary-bg");
          applications.classList.remove("hidden");
          btnListingsMobile.classList.remove("accent-bg");
          btnListingsMobile.classList.add("primary-bg");
          candidates.classList.add("hidden");
          listings.classList.add("hidden");
          applications.classList.remove("hidden");
          btnSearchMobile.classList.add("primary-bg");
          btnSearchMobile.classList.remove("accent-bg");
          search.classList.add("hidden");
      });
  }
    </script>
';
echo "</body>";
}
?>
