<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$fb = "You need to login to access this page!";
$location = HEADER."/training/training_login.php?fb=".$fb;
$application = false;

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

<title>ITM Tanzania - Training Portal</title>
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
  <a href="../training.php">Jobs</a>
  <a href="../admin/signout.php" >Signout</a>
</nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';

    if(isset($_POST['btnLogin'])){
        $program = $_POST['program'];
        $email = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $fb = "Please enter a valid e-mail address";
            $location = HEADER."/training/training_login.php?fb=".$fb;
            header($location,true);
        }
        else{
            $data = array();
            if(!empty($email)) $data['email'] = $email;
            if(!empty($password)) $data['password'] = $password;
            $data['program'] = $program;
            if(!empty($data['email']) && !empty($password)){
                $action = DB::loginApplication($data);
                if(!$action) {
                    $fb = "Could not find a matching record. Please signup first!";
                    $location = HEADER."/training/training_login.php?fb=".$fb;
                    header($location,true);
                }
                else {
                    $application = $action;
                    $_SESSION['app'] = $application;
                    
                }
            }
            else {
                $fb = "Please fill in mandatory fields!";
                $location = HEADER."/training/training_login.php?fb=".$fb;
                header($location,true);
            }
        }
    }
    else{
        if(isset($_GET['id'])){
            $application = DB::getApplicationWithId($_GET['id']);
        }
        if(!isset($_SESSION['app'])) header($location);
        else{
  $application = $_SESSION['app'];
        }
    }

$message = "";

if($application){
echo '
<section class="min-width-full margin-auto flex-row flex-start flex-middle primary-bg">
    <div class="margin-auto flex-row flex-start flex-middle padding-small white-text">
        <p class="title">Application Details</p>
        
    <div>
    
</section>';
echo '<section class="w-100 margin-std " id="">

<div class="w-100 margin-auto text-left " >
<span class="vspacer"></span>';
$style = "";
if($application['status_text'] == "Accepted") $style = "success-text";
if($application['status_text'] == "Rejected") $style = "error-text";
echo '<p class="text-center error-text">'.$message.'
  
</p>
<div class="form-group flex-row flex-start  padding-small">
  <span for="program" class="text-right padding-small w-50 primary-text">Training Program</span>
  <span class=" padding-small w-50">'.$application['program_title'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="program" class="text-right padding-small w-50 primary-text">Applicant\'s Name</span>
  <span class=" padding-small w-50">'.$application['name'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="program" class="text-right padding-small w-50 primary-text">Application Status</span>
  <span class=" padding-small w-50 '.$style.'">'.$application['status_text'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="is_company" class="text-right padding-small w-50 primary-text">Applicant Category</span>
  <span class=" padding-small w-50"
  >'.($application['is_company'] == 0 ? 'Individual':'Company').'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="company" class="text-right padding-small w-50 primary-text">Company</span>
  <span class=" padding-small w-50">'.($application['institution'] == null ? 'N/A':$application['institution']).'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="number_of_applicants" class="text-right padding-small w-50 primary-text">Number of Applicants</span>
  <span class=" padding-small w-50">'.$application['number_of_applicants'].'</span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="contact" class="text-right padding-small w-50 primary-text">Contact E-maill</span>
  <span class=" padding-small w-50">'.$application['contact'].'
  </span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="deadline" class="text-right padding-small w-50 primary-text">Application Date</span>
  <span class=" padding-small w-50">'.date('d M Y',$application['date_created']).'
  </span>
</div>
<div class="form-group flex-row flex-start  padding-small">
  <span for="deadline" class="text-right padding-small w-50 primary-text">Proof of Payment</span>';
  $proof = "Not Provided";
  if($application['proof'] != null){
    $proof = '<a class=" padding-small plain-link" target="_blank" href="proofs/'.$application['proof'].'">View Proof</a>';
  }
 
  echo $proof.'</span>
</div>
<span class="vspacer"></span>';

echo '<div class="form-group flex-row flex-space flex-middle">
  <a class="round-corner text-center button border-white-all primary-bg white-text"
    href="edit_application.php?id='.$application['id'].'"
    >EDIT</a>';

 $back = '<a
    href="training.php"
    class="plain-link text-center primary-text"
    >CLOSE</a>';
echo $back .'</div>
<span class="vspacer"></span>
</div>';
echo "</body>";
    }

?>
