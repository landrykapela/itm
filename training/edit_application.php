<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$isAdmin = false;
if(!isset($_SESSION['app'])){
    if(isset($_SESSION['user']) && DB::isAdmin($_SESSION['user'])){
        $isAdmin = true;
    }
    else{
        $fb = "You need to login to access this page!";
        $location = HEADER ."/training/training_login.php?fb=".$fb;
        header($location,true);
    }
    
}
$isAdmin = DB::isAdmin($_SESSION['user']);
// $programs = DB::getTrainingPrograms();
$app = $_SESSION['app'];
if(isset($_GET['id'])){
  $app_id = $_GET['id'];
  if($app['id'] != $app_id){
    $fb = "You are not authorized to access this page!";
    $location = HEADER ."/training/training_login.php?fb=".$fb;
    header($location,true);
  }
  else $app = DB::getApplicationWithId($app_id);
  
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

<title>ITM Tanzania - Training Portal</title>


</head>
<body>
<script>
function changeTitle(){
let selector = document.getElementById("program");
        let text = selector.options[event.target.selectedIndex].text;
        console.log("test: ",text);
        let title = document.getElementById("program_title");
        title.textContent = text;

}
function showCompanyDetails(){
    let cd = document.getElementById("company_details");
    cd.classList.remove("hidden");let an = document.getElementById("app_name");
    an.classList.add("hidden");
}
function hideCompanyDetails(){
    let cd = document.getElementById("company_details");
    cd.classList.add("hidden");
    let an = document.getElementById("app_name");
    an.classList.remove("hidden");
}
</script>

<header
  id="header"
  class="min-width-full flex-column flex-top flex-start margin-auto"
>
  <div
    class="flex-row flex-between flex-middle w-100 padding-std margin-auto"
  >
  <img src="../images/logo.png" class="logo" alt="ITM logo" />
  <nav class="flex-row flex-center" id="navigation">
    <span id="home">Home</span>
    <span id="about">About</span>
    <span id="services">Services</span>
    <span id="jobs">Jobs</span>
    <span id="training" class="active">Training</span>
    <span id="news">News & Events</span>
    <!-- <span id="contacts">Contacts</span> -->
  </nav>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
  
</header>';
$msg = "";
$programs = DB::getTrainingPrograms();
$applications = DB::getApplications();
if(isset($_POST['btnUpdate'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $institution = filter_var($_POST['institution'],FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
   
    $number_of_staff = filter_var($_POST['number_of_staff'],FILTER_DEFAULT);
    
    $isCompany = $_POST['is_company'];
    if($isCompany == 1) $name = $institution;
    $data = array(); 
    if(!empty($phone) && $phone != $app['phone']) $data['phone'] = $phone;
    if(!empty($isCompany) && $isCompany != $app['is_company']) $data['is_company'] = $isCompany;
    if(!empty($contact) && $contact != $app['contact']) $data['contact'] = $contact;
    if(!empty($name) && $name != $app['name']) $data['name'] = $name;
    if(!empty($institution) && $institution != $app['institution']) {
        $data['institution'] = $institution;   
    } 
    if(!empty($number_of_staff) && $number_of_staff != $app['number_of_applicants']){
        $data['number_of_applicants'] = $number_of_staff;
        $data['number_before'] = $app['number_of_applicants'];
    }
    

    if(isset($_FILES['proof']) && !empty($_FILES['proof']['name'])) {
        $file = $_FILES['proof'];
        $data['proof'] = $file;
    }

    // echo "data: ".json_encode($data);
    // if(!empty($data['contact']) && !empty($data['name']) ){
        $action = DB::updateApplication($data,$app_id);
        $msg = $action['message'];
        $app = $action['application'];
    // }
    // else $msg = "Please fill in mandatory fields!";
      
}
if(isset($_POST['btnAccept'])){
    $accept = DB::acceptApplication($app_id);
    
        $msg = $accept['message'];
        $app = $accept['application'];
    
}
if(isset($_POST['btnReject'])){
    $accept = DB::rejectApplication($app_id);
    
        $msg = $accept['message'];
        $app = $accept['application'];
    
}

echo '<p class="error-text">'.$msg.'</p>
<section class="min-width-full margin-auto flex-row flex-center flex-middle primary-bg white-text">
   
    <span id="btn-search" class="title padding-std">Edit Application</span> 
    
    </div>
</section>';
echo '<section class="w-100 margin-std" >
<p class="title primary-text text-center" id="program_title"></p>
<form action="" enctype="multipart/form-data" method="post" class="w-60 border-primary-all padding-std flex-column flex-start text-left margin-auto">
    <div class="form-group flex-column flex-start margin-std-bottom margin-std-top">
    <label for="program">Select Training Program<span class="error-text">*</span></label>
    <select disabled onchange="changeTitle();"
      name="program"
      id="program"
      class="form-control padding-small">';
      for($i=0;$i<count($programs);$i++){
          if($target == $programs[$i]['id']) 
          echo '<option value='.$programs[$i]['id'].' selected>'.$programs[$i]['title'].'</option>';
          else echo '<option value='.$programs[$i]['id'].'>'.$programs[$i]['title'].'</option>';
      }
  echo '</select></div>
  
    <div class="form-group  flex-column flex-start padding-std">
        <label for="">Applicantion Nature</span></label>
        
        <div class="form-group flex-row flex-start flex-middle padding-small">
            <input value=0 type="radio" '.($app['is_company'] == 0 ? 'checked' : ' ').'  onchange="hideCompanyDetails();"
            name="is_company"
            id="individual"
            class="form-control margin-std-right"
        /><label for="is_company">Individual</span></label>
        
        </div>
        <div class="form-group flex-row flex-start flex-middle padding-small">
        
        <input value=1 onchange="showCompanyDetails();"
            type="radio"  '.($app['is_company'] == 1 ? 'checked' : ' ').'
            name="is_company"
            id="company"
            class="form-control margin-std-right"
        /><label for="is_company">Company</span></label>
        </div>
    </div>';
    // <div class="form-group flex-column flex-start padding-small">
    // <label for="">Gender</span></label>

    // <div class="form-group flex-row flex-start flex-middle padding-small">
    // <input value="male"
    // type="radio" checked
    // name="gender"
    // id="male"
    // class="form-control margin-std-right"
    // /><label for="male">Male</span></label>

    // </div>
    // <div class="form-group flex-row flex-start flex-middle padding-small">

    // <input value="female"
    // type="radio"
    // name="gender"
    // id="female"
    // class="form-control margin-std-right"
    // /><label for="female">Female</span></label>
    // </div>
    // </div>
    $hidden = "hidden";
    if($app['is_company'] == 1) $hidden = "";
echo '</div>
<div class="form-group flex-column flex-start '.$hidden.'" id="company_details">
<div class="form-group flex-column flex-start padding-small">
<label for="institution">Company Name</label>
<input value="'.$app['institution'].'"
  type="text"
  name="institution"
  id="institution"
  class="form-control padding-small"
  placeholder="Company name..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="number_of_staff">Number of Staffs to Train</label>
<input value="'.$app['number_of_applicants'].'"
  type="number"
  name="number_of_staff"
  id="number_of_staff"
  class="form-control padding-small"
  placeholder="Number of staffs..."
/>
</div>

</div>
<div class="form-group flex-column flex-start padding-small" id="app_name">
  <label for="name">Applicant\'s Name <span class="error-text">*</span></label>
  <input value="'.$app['name'].'"
    type="text"
    name="name"
    id="name" placeholder="Name of applicant..."
    class="form-control padding-small"
  />
</div>

<div class="form-group flex-column flex-start padding-small">
<label for="contact">Contact Email <span class="error-text">*</span></label>
<input value="'.$app['contact'].'"
  type="email"
  name="contact"
  id="contact"
  class="form-control padding-small"
  placeholder="Enter email..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="phone">Contact Phone</label>
<input value="'.$app['phone'].'"
  type="text"
  name="phone"
  id="phone"
  class="form-control padding-small"
  placeholder="Enter phone number..."
/>
</div>';

// <div class="form-group flex-column flex-start padding-small">
// <label for="password">Password <span class="error-text">*</span></label>
// <input 
//   type="password"
//   name="password"
//   id="password"
//   class="form-control padding-small"
//   placeholder="Enter password..."
// />
echo '</div>
<div class="form-group flex-column flex-start padding-small">
<label for="proof">Upload Proof of Payment (PDF or Images < 2mb)</label>';
if(isset($app['proof'])) echo '<a class=" padding-small plain-link" target="_blank" href="proofs/'.$app['proof'].'">View Proof</a>';
echo '<input accept="application/pdf,image/*"
  type="file"
  name="proof"
  id="proof"
  class="form-control padding-small"
/>
</div>
<div class="form-group flex-row flex-between flex-middle padding-small">

<input
  type="submit"
  name="btnUpdate"
  id="btnUpdate"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value=" UPDATE "
/>';
if($isAdmin){
    echo '
    <input
      type="submit"
      name="btnAccept"
      id="btnAccept"
      class="button form-control padding-small success-bg white-text round-corner border-all-white"
      value=" ACCEPT "
    />
    
<input
type="submit"
name="btnReject"
id="btnReject"
class="button form-control padding-small alert-bg white-text round-corner border-all-white"
value=" REJECT "
/>
    ';
}

echo '<a href="training.php" class="plain-link">CANCEL</a>
</div>
</form>
</section>';

echo ' <script src="../js/general.js"></script></body>';

?>
