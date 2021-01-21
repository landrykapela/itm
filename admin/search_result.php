<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
$location .= $_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$admin = DB::isAdmin($_SESSION['user']);
if(!$admin){
    $fb = "You need to login as admin to view this page!";
    $location = "Location: ".($_SERVER['HTTPS'] ? "https://":"http://");
    $location .= $_SERVER['HTTP_HOST']."/jobs/signup.html?fb=".$fb."#login";
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
  
</header>';
if(isset($_POST['submitSearch'])){
  $options = array();
  $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
  $major= filter_var($_POST['major'],FILTER_SANITIZE_STRING);
  $level = filter_var($_POST['level'],FILTER_SANITIZE_STRING);
  if(!empty($name)) {
    $options['name'] = $name;
    // $options[] = $option;
  }
  if($major != 'Any'){
    $options['major'] = $major;
    // $options[] = $option;
  }
  if($level != 'Any'){
    $options['level'] = $level;
    // $options[] = $option;
  }
  $results = DB::searchCandidates($options);
  
    
    echo '
    <section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
        <div class="margin-auto flex-row flex-start flex-middle padding-small">
            <span class="title white-text">Search Result</span>
        </div>
    </section>';

  echo '<section><table class="w-100 margin-auto text-left">
  <thead class="primary-bg white-text"><tr><td>Name</td><td>Qualification</td><td>Career</td><td>Recent Employer</td></tr></thead>
  <tbody>';
  if(!$results){
   echo '<tr><td colspan=4 class="text-center">No matching results</td></tr>';
}
else {
    
  for($i=0;$i<sizeof($results);$i++){
    $candidate = $results[$i];
    // $qual = DB::getHighestQualification($candidate['email']);
    $exp = DB::getLatestEmployment($candidate['email']);
    
    echo '<tr><td><a class="plain-link" href="admin_profile.php?u='.$candidate['id'].'">'.$candidate['name'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$candidate['level'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$candidate['major'].'</a></td><td><a href="admin_profile.php?u='.$candidate['id'].'">'.$exp['institution'].'</a></td></tr>';
    
  }
}
 echo'</tbody>
</table><span class="vspacer"></span><span class="vspacer"></span><a href="admin.php" class="plain-link">Back to Search</a>';

echo '</section>';
  }



// echo '
//     <script>
//     const btnCandidates = document.getElementById("btn-candidates");
//     const btnSearch = document.getElementById("btn-search");
//     const btnListings = document.getElementById("btn-listings");
//     const candidates = document.getElementById("candidates");
//     const listings = document.getElementById("listings");
//     const search = document.getElementById("search-form");
    
//     if(btnSearch){
//         btnSearch.addEventListener("click",()=>{
//             btnSearch.classList.remove("primary-bg");
//             btnSearch.classList.add("accent-bg");
//             search.classList.remove("hidden");
//             btnCandidates.classList.remove("accent-bg");
//             btnCandidates.classList.add("primary-bg");
//             btnListings.classList.remove("accent-bg");
//             btnListings.classList.add("primary-bg");
//             candidates.classList.add("hidden");
//             listings.classList.add("hidden");
//         });
//     }
//     if(btnCandidates){
//         btnCandidates.addEventListener("click",()=>{
//             btnCandidates.classList.remove("primary-bg");
//             btnCandidates.classList.add("accent-bg");
//             btnListings.classList.remove("accent-bg");
//             btnListings.classList.add("primary-bg");
//             candidates.classList.remove("hidden");
//             listings.classList.add("hidden");

//             btnSearch.classList.add("primary-bg");
//             btnSearch.classList.remove("accent-bg");
//             search.classList.add("hidden");
//         });
//     }
//     if(btnListings){
//         btnListings.addEventListener("click",()=>{
//             btnCandidates.classList.add("primary-bg");
//             btnCandidates.classList.remove("accent-bg");
//             btnListings.classList.add("accent-bg");
//             btnListings.classList.remove("primary-bg");
//             candidates.classList.add("hidden");
//             listings.classList.remove("hidden");

//             btnSearch.classList.add("primary-bg");
//             btnSearch.classList.remove("accent-bg");
//             search.classList.add("hidden");
//         });
//     }
//     </script>
// ';
echo "</body>";
}
?>
