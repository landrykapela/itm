<?php

class DB{

    static function randomPassword(){
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()";
        $result = "";
        for($i=0; $i<8;$i++){
            $randomIndex = rand(0,strlen($string));
            $result .= substr($string,$i,1);
            
        }
        return $result;
    }
    static function test(){
        echo "Cool";
    }
    static function connect(){
        $connect = mysqli_connect("localhost","itm_jobs","itm_jobs","itm_jobs") or die("Unable to connect to database ".mysqli_error());
        return $connect;
    }

    static function addToMailingList($email,$name){
        $sql = "insert into mailing_list (email,name) values('".$email."','".$name."')";
        $query = mysqli_query(DB::connect(),$sql);
        if($query){
            return true;
        }
        else return false;
    }

    static function createUser($email,$name,$phone,$password,$subscribe){
        $sql = "insert into user (email,name,phone,password) values ('".$email."','".$name."','".$phone."','".$password."')";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            if($subscribe) self::addToMailingList($email,$name);
            return true;
    }
    else return false;
    }

    static function signIn($email,$password){
        $sql = "select * from user where email ='".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            $row = mysqli_fetch_array($query);
                $enc_password = $row['password'];
                if(password_verify($password,$enc_password))
                    return $row;
            
                else return false;
            
        }
    }

    static function resetPassword($email){
        $sql = "select * from user where email = '".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if(mysqli_num_rows($query) > 0){
            $password = self::randomPassword();
            $hash = passsword_hash($password,PASSWORD_BCRYPT);
            $sql2 = "update user set password ='".$hash."' where email='".$email."'";
            $query2 = mysqli_query(self::connect(),$sql2);
            if($query2){
                mail($email,"Password Reset","Your password has been reset. Please use ".$password." next time you login");
                return true;
            }
            else return false;
        }
    }

    static function getUser($email){
        $sql = "select * from user where email='".$email."' order by id asc limit 1";
        $query = mysqli_query(self::connect(),$sql);
        if($query){
            return mysqli_fetch_array($query);
        }
        else return false;
    }

    static function getEducationProfile($email){
        $sql = "select * from education where email='".$email."' order by year desc";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            $item = array();
            while($row = mysqli_fetch_row($query)){
                $item['title'] = $row[2];
                $item['institution'] = $row[3];
                $item['major'] = $row[7];
                $item['country'] = $row[4];
                $item['year'] = $row[5];
                $result[] = $item; 
            }
            return $result;
        }
        else return false;
    }
    static function createEducationProfile($email,$data){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "insert into education (title,level,institution,major,year,country,email) values ";
            for($i=0; $i<count($data);$i++){
                $d = $data[$i];
                $title = $d['title'];
            $level = $d['level'];
            $institution = $d['institution'];
            $major = $d['major'];
            $year = $d['year'];
            $country = $d['country'];

            $values .= "('".$title."','".$level."','".$institution."','".$major."',".$year.",'".$country."','".$email."')";
            if($i < sizeof($data)-1){
                $values .= ",";
            }
            }
            $sql .= $values;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                $user = self::getUser($email);
                $progress = explode(",",$user['profile']);
                $progress[1] = "40";
                $profile = implode(",",$progress);
                mysqli_query(self::connect(),"update user set profile = '".$profile."' where email='".$email."'");
                return true;
            }
            else return false;
        // }
    }

    static function getWorkProfile($email){
        $sql = "select * from work where email='".$email."' order by year desc";
        $query = mysqli_query(self::connect(),$sql);
        $result = array();
        if($query){
            $item = array();
            while($row = mysqli_fetch_row($query)){
                $item['title'] = $row[1];
                $item['institution'] = $row[2];
                $item['tasks'] = $row[3];
                $item['country'] = $row[4];
                $item['year_start'] = $row[5];
                $item['year_end'] = $row[6];
                $item['month_start'] = $row[7];
                $item['month_end'] = $row[8];
                $result[] = $item; 
            }
            return $result;
        }
        else return false;
    }

    static function createWorkProfile($email,$data){
        if($data == null){
            return false;
        }
            $values = "";
            $sql = "insert into work (title,institution,tasks,country,year_start,year_end,month_start,month_end,email) values ";
            for($i=0; $i<count($data);$i++){
                $d = $data[$i];
                $title = $d['title'];
            $institution = $d['institution'];
            $tasks = $d['tasks'];
            $country = $d['country'];
            $year_start = $d['year_start'];
            $year_end = $d['year_end'];
            $month_start = $d['month_start'];
            $month_end = $d['month_end'];

            $values .= "('".$title."','".$institution."','".$tasks."','".$country."',".$year_start.",".$year_end.",".$month_start.",".$month_end.",'".$email."')";
            if($i < sizeof($data)-1){
                $values .= ",";
            }
            }
            $sql .= $values;
            $query = mysqli_query(self::connect(),$sql);
            if($query) {
                $user = self::getUser($email);
                $progress = explode(",",$user['profile']);
                $progress[2] = "40";
                $profile = implode(",",$progress);
                mysqli_query(self::connect(),"update user set profile = '".$profile."' where email='".$email."'");
                return true;
            }
            else return false;
        // }
    }

    static function months(){
       return array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12);
    }
    static function listCountries(){
        $countries =
 
array(
"AF" => "Afghanistan",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"IO" => "British Indian Ocean Territory",
"BN" => "Brunei Darussalam",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos (Keeling) Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo",
"CD" => "Congo, the Democratic Republic of the",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"CI" => "Cote D'Ivoire",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands (Malvinas)",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GN" => "Guinea",
"GW" => "Guinea-Bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and Mcdonald Islands",
"VA" => "Holy See (Vatican City State)",
"HN" => "Honduras",
"HK" => "Hong Kong",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran, Islamic Republic of",
"IQ" => "Iraq",
"IE" => "Ireland",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KP" => "Korea, Democratic People's Republic of",
"KR" => "Korea, Republic of",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Lao People's Democratic Republic",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libyan Arab Jamahiriya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macao",
"MK" => "Macedonia, the Former Yugoslav Republic of",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"MX" => "Mexico",
"FM" => "Micronesia, Federated States of",
"MD" => "Moldova, Republic of",
"MC" => "Monaco",
"MN" => "Mongolia",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territory, Occupied",
"PA" => "Panama",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RE" => "Reunion",
"RO" => "Romania",
"RU" => "Russian Federation",
"RW" => "Rwanda",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and the Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"ST" => "Sao Tome and Principe",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"CS" => "Serbia and Montenegro",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and the South Sandwich Islands",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syrian Arab Republic",
"TW" => "Taiwan, Province of China",
"TJ" => "Tajikistan",
"TZ" => "Tanzania, United Republic of",
"TH" => "Thailand",
"TL" => "Timor-Leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UG" => "Uganda",
"UA" => "Ukraine",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"UM" => "United States Minor Outlying Islands",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VE" => "Venezuela",
"VN" => "Viet Nam",
"VG" => "Virgin Islands, British",
"VI" => "Virgin Islands, U.s.",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe"
);
  return $countries;
  }

  static function getCountry($code){
      return self::listCountries()[$code];
  }
}

?>