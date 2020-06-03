<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
unset($_SESSION['app']);
if(isset($_SESSION['user']) && !DB::isAdmin($_SESSION['user'])) $user = DB::getUser($_SESSION['user']);
else $user = false;
$programs = DB::getTrainingPrograms();
$target = false;$program = false;
if(isset($_GET['pg'])){
  $target = $_GET['pg'];
  $program = DB::getTrainingProgram($target);
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
<div
    id="floating-header"
    class="floating-header flex-row flex-between flex-top w-100-no-padding padding-std margin-auto"
  >
    <img src="../images/logo.png" class="logo" alt="ITM logo" />
    <div class="flex-column flex-center flex-end">
      <div class="flex-row flex-end margin-std-right desktop-only">
        <img src="../images/tanzania.png" alt="ITM Tanzania" class="flag" />
        <img
          src="../images/rwanda.png"
          alt="ITM Rwanda"
          class="flag"
          onclick="window.location=\'https://itmafrica.rw\';"
        />
        <img
          src="../images/angola.png"
          alt="ITM Angola"
          class="flag"
          onclick="window.location=\'https://itmafrica.ao\';"
        />
        <img
          src="../images/drc.png"
          alt="ITM Group"
          class="flag"
          onclick="window.location=\'https://itmafrica.com\';"
        />
        <img
          src="../images/south_africa.png"
          alt="ITM South Africa"
          class="flag"
          onclick="window.location=\'https://itmkatope.co.za\';"
        />
        <img
          src="../images/germany.png"
          alt="ITM Germany"
          class="flag"
          onclick="window.location=\'https://itmnexus.com\';"
        />
        <img
          src="../images/nigeria.png"
          alt="ITM Nigeria"
          class="flag"
          onclick="window.location=\'https://itmafrica.com.ng\';"
        />
      </div>
      <nav class="flex-row flex-center margin-std-right" id="navigation">
        <span id="home">Home</span>
        <span id="about">About</span>
        <span id="services">Services<span id="expandable" class="hidden flex-column flex-top flex-start" ><a href="../services.html#hr">Human Resources Solutions</a><a href="../services.html#sales">Sales and Distribution</a><a href="../services.html#industrial">Industrial Solutions</a><a href="../services.html#b2b">Business-2-Business</a></span></span>
        <span id="jobs">Jobs</span>
        <span id="training class="active"">Training</span>
        <span id="news">News & Events</span>
        <!-- <span id="contacts">Contacts</span> -->
      </nav>
    </div>
    <span id="menu"><i class="material-icons">menu</i></span>
  </div>
<header
  id="header"
  class="primary-bg min-width-full flex-column flex-top flex-start margin-auto"
>
  <span class="vspacer"></span><span class="vspacer"></span><span class="vspacer"></span><span class="vspacer"></span>
</header>';
$msg = "";
$programs = DB::getTrainingPrograms();
$applications = DB::getApplications();

if(isset($_POST['btnApply'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $institution = filter_var($_POST['institution'],FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'],FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $program = filter_var($_POST['program'],FILTER_SANITIZE_STRING);
    $institution = filter_var($_POST['institution'],FILTER_SANITIZE_STRING);
    $number_of_staff = filter_var($_POST['number_of_staff'],FILTER_DEFAULT);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $isCompany = $_POST['is_company'];
    
    $data = array();
    if(!empty($name)) $data['name'] = $name;else $data['name'] = $institution;
    if(!empty($institution)) $data['institution'] = $institution;
    if(!empty($contact)) $data['contact'] = $contact;
    if(!empty($program)) $data['program'] = $program;
    if(!empty($password)) $data['password'] = $password;
    if(!empty($phone)) $data['phone'] = $phone;
    if(!empty($isCompany)) $data['is_company'] = $isCompany;
    if(!empty($number_of_staff)) $data['number_of_applicants'] = $number_of_staff;
     else $data['number_of_applicants'] = 1;

    if(isset($_FILES['proof'])) {
        $file = $_FILES['proof'];
        $data['proof'] = $file;
    }

    if(!empty($data['contact']) && !empty($data['name']) && !empty($password)){
        $action = DB::createApplication($data);
        $msg = $action['message'];
        
    }

    else {
      $msg = "Please fill in mandatory fields!";
      
    }
}

echo '
<section class="min-width-full margin-auto flex-row flex-center flex-middle primary-bg white-text">
   
    <span id="btn-search" class="title padding-std">Training Program Application</span> 
    
    </div>
</section>';
echo '<section class="w-100 margin-std" ><p class="error-text">'.$msg.'</p>
<p class="title primary-text text-center" id="program_title">';
if(isset($program['title'])) echo $program['title']; 
echo '</p>
<form action="" enctype="multipart/form-data" method="post" class="w-60 border-primary-all padding-std flex-column flex-start text-left margin-auto">
    <div class="form-group flex-column flex-start margin-std-bottom margin-std-top">
    <label for="program">Select Training Program<span class="error-text">*</span></label>
    <select onchange="changeTitle();"
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
            <input value=0 type="radio" checked  onchange="hideCompanyDetails();"
            name="is_company"
            id="individual"
            class="form-control margin-std-right"
        /><label for="is_company">Individual</span></label>
        
        </div>
        <div class="form-group flex-row flex-start flex-middle padding-small">
        
        <input value=1 onchange="showCompanyDetails();"
            type="radio"
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
echo '</div>
<div class="form-group flex-column flex-start hidden" id="company_details">
<div class="form-group flex-column flex-start padding-small">
<label for="institution">Company Name</label>
<input 
  type="text"
  name="institution"
  id="institution"
  class="form-control padding-small"
  placeholder="Company name..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="number_of_staff">Number of Staffs to Train</label>
<input 
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
  <input value="'.$user['name'].'"
    type="text"
    name="name"
    id="name" placeholder="Name of applicant..."
    class="form-control padding-small"
  />
</div>

<div class="form-group flex-column flex-start padding-small">
<label for="contact">Contact Email <span class="error-text">*</span></label>
<input value="'.$user['email'].'"
  type="email"
  name="contact"
  id="contact"
  class="form-control padding-small"
  placeholder="Enter email..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="phone">Contact Phone</label>
<input value="'.$user['phone'].'"
  type="text"
  name="phone"
  id="phone"
  class="form-control padding-small"
  placeholder="Enter phone number..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="password">Password <span class="error-text">*</span></label>
<input 
  type="password"
  name="password"
  id="password"
  class="form-control padding-small"
  placeholder="Enter password..."
/>
</div>
<div class="form-group flex-column flex-start padding-small">
<label for="proof">Upload Proof of Payment (PDF or Images < 2mb)</label>
<input accept="application/pdf,image/*"
  type="file"
  name="proof"
  id="proof"
  class="form-control padding-small"
/>
</div>
<div class="form-group flex-row flex-between flex-middle padding-small">

<input
  type="submit"
  name="btnApply"
  id="btnApply"
  class="button form-control padding-small primary-bg white-text round-corner border-all-white"
  value=" APPLY "
/>
<a href="training_login.php" class="plain-link">VIEW APPLICATION</a>
<a href="training.php" class="plain-link">CANCEL</a>
</div>
</form>
</section>';

echo ' <script src="../js/general.js"></script></body>';

?>
