<?php
session_start();
ini_set("display_errors",1);
require('../libs/manager.php');
$location = "Location: ".((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? "https://":"http://") .$_SERVER['HTTP_HOST']."/jobs/signup.html#login";
if(!isset($_SESSION['user'])) header($location);
$loggedInUser = DB::getUser($_SESSION['user']);
if(DB::isAdmin($loggedInUser['email'])) $user = DB::getUserById($_GET['e']);
else $user = $loggedInUser;
$html = '<!DOCTYPE html>
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

<title>ITM Tanzania - Resume</title>
</head>
<body width="100%">
<span class="vspacer"></span>
<h2>Curriculum Vitae</h2>
<span class="vspacer"></span>
 <section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-25  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="subtitle">Personal Info</p>
</div>
<div class="w-75 flex-column flex-start flex-top accent-bg dark-text padding-std">

<p>'.$user['name'].'</p>
<p>'.$user['email'].'</p>
<p>'.$user['phone'].'</p>';
$cities = DB::getTanzaniaCities();
$location = in_array($user['location'],$cities) ? $user['location'] : DB::getCountry($user['location']);

$html .= '<p>'.$location.'</p>
</div>
</section> <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-25  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="subtitle">Education Background</p>


</div>';
$education = DB::getEducationProfile($user['email']);
$html .='<div class="w-75 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$education){
  $html .='<p class="subtitle">Nothing to show</p>';
}
else{
  // $html .=json_encode($education);
  for($i=0; $i<sizeof($education);$i++){
    $html .= '<span class="subtitle text-left">'.$education[$i]['title'].'</span>
    <span>'.$education[$i]['institution'].'</span><span>'.$education[$i]['major'].', '.$education[$i]['level'].'</span><span>'.$education[$i]['year'].', '.DB::getCountry($education[$i]['country']).'</span><span class="vspacer-small"></span><span class="vspacer-small"></span><span class="vspacer-small"></span>';
    if($i < count($education) -1) $html .='<span class="vspacer-small border-dark-bottom"></span><span class="vspacer-small"></span><span class="vspacer-small"></span>';
  }
}

$html .= '</section><span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-25  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="subtitle">Professional Experience</p>


</div>';
$work = DB::getWorkProfile($user['email']);
// $html .="work: ".json_encode($work);
$html .= '<div class="w-75 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$work) $html .='<p class="subtitle">Nothing to show</p>';
else{
  for($i=0; $i<sizeof($work);$i++){
    $html .='<span class="subtitle">'.$work[$i]['title'].'</span>';
    $html .='<span>'.$work[$i]['institution'].'</span>';
    $html .='<span>'.DB::getCountry($work[$i]['country']).'</span>';
    $html .='<span>'.DB::getMonth($work[$i]['month_start']).' '.$work[$i]['year_start'].' - '.($work[$i]['year_end']== -1 ? 'Present': (DB::getMonth($work[$i]['month_end']).' - '.$work[$i]['year_end'])).'</span>';
    $html .='<span class="text-left w-75">'.$work[$i]['tasks'].'</span>';
    $html .='<span class="vspacer-small"></span>';
    $html .='<span class="vspacer-small"></span>';
    
    $html .='<span class="vspacer-small"></span>';
    if($i < count($work) -1) $html .='<span class="vspacer-small border-dark-bottom"></span>';
    $html .='<span class="vspacer-small"></span>';
    $html .='<span class="vspacer-small"></span>';
  }
}

$html .='</div>
</section>';

$html .=' <span class="vspacer-small"></span><section
class="min-width-full v-100  flex-row flex-center"
>
<div class="w-25  padding-std flex-column flex-top flex-start  primary-bg white-text">
<p class="subtitle">Reference</p></div>';
$reference = DB::getReferenceProfile($user['email']);

$html .='<div class="w-75 flex-column flex-start flex-top accent-bg dark-text padding-std">';
if(!$reference) $html .='<p class="subtitle">Nothing to show</p>';
else{
  for($i=0; $i<sizeof($reference);$i++){
    $html .='<span class="subtitle">'.$reference[$i]['name'].'</span>';
    $html .='<span>'.$reference[$i]['title'].'</span>';
    $html .='<span>'.$reference[$i]['contact'].'</span>';
    $html .='<span>'.$reference[$i]['phone'].'</span>';
    $html .='<span class="vspacer-small"></span>';
    $html .='<span class="vspacer-small"></span>';
    
    $html .='<span class="vspacer-small"></span>';
    if($i < count($reference) -1) $html .='<span class="vspacer-small border-dark-bottom"></span>';
    $html .='<span class="vspacer-small"></span>';
    $html .='<span class="vspacer-small"></span>';
  }
}
$html .='</div></section>';
$html .="</body>
<script src='../libs/html2canvas.min.js'></script>
<script src='../libs/jspdf.min.js'></script>
<script>
window.addEventListener('load',()=>{
    window.scrollTo(0,0);
    document.body.overflow = 'none';
    html2canvas(document.body).then(canvas=>{

        var margin= 5; 
        let doc = new jsPDF('p','mm','a4');
        let img = canvas.toDataURL('image/jpg');
        var imgWidth = 210;
        var pageHeight = 290;
        var imgHeight = canvas.height * imgWidth / canvas.width;
        var heightLeft = imgHeight;

        var position = 0;

        doc.addImage(img, 'JPG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight ;
            doc.addPage();
            doc.addImage(img, 'JPG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        
        doc.save('resume.pdf');
    });
});
</script>";


echo $html;

?>
