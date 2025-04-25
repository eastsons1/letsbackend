<?php
error_reporting(0);
session_start(); 
// Include autoloader 
require_once 'dompdf/autoload.inc.php'; 
//require_once 'dompdf/autoload.inc.php'; 


 
// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 use Dompdf\Options;
// Instantiate and use the dompdf class 

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

//$dompdf = new Dompdf();



//ob_start();	
//session_start(); 
//include('config.php');

$servername = "localhost";
$username = "mytutors_tutorapp_ver3";
$password = "^%&^*&TYY6567*(&uyur$7";
$dbname = "mytutors_tutorapp_ver3";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 



///Quatation Generate start


	
	 
	
	
	
	/// Display image in pdf function start
	function encode_img_base64($img_path = false): string
	{
		if($img_path){
			$path = $img_path;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			return 'data:image/' . $type . ';base64,' . base64_encode($data);
		}
		return '';
	}
	
	
	
	
	 
	
	/// Display Logo
	
	$logo_pdf = encode_img_base64('1_10.png');
	
	
	
	// Fetch user data
	$user_id = $_GET['tutor_id'];
	$tutor_info = mysqli_fetch_array(
    $conn->query("SELECT info.first_name,info.last_name,info.mobile, info.created_date, tinfo.profile_image,tinfo.tutor_code,tinfo.qualification FROM user_tutor_info as tinfo INNER JOIN user_info as info ON tinfo.user_id = info.user_id WHERE info.user_id = '".$user_id."' ")
);

//echo $tutor_info['profile_image'];

// Extract user details
	$tutor_name = $tutor_info['first_name'] . ' ' . $tutor_info['last_name'];
	$profile_image = 'https://mytutors.moe/version3/UPLOAD_file/' . $tutor_info['profile_image'];
	$tutor_code = $tutor_info['tutor_code'];
	$qualification = $tutor_info['qualification'];
	$mobile = $tutor_info['mobile'];
	$created_date = $tutor_info['created_date'];
	
	$dd = explode("-",$created_date);  //10-11-2024
	//print_r($dd);
	//$dd2 = explode("-",$dd[1]);
	 $month = $dd[1];
	 $year = $dd[2];
	$showDate = $month.'/'.$year;
	
	
	$tutor_img = encode_img_base64($profile_image);
	
	
	
	/// Display image in pdf function end
						

	

		
		$html = '<html style="background: #F3FAFA;" lang="en">
		<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Example</title>
    <style>
            ._failed{ border-bottom: solid 4px red !important; }
            ._failed i{  color:red !important;  }

            ._success {
                box-shadow: 0 15px 25px #00000019;
                padding: ;
                width: 100%;
                text-align: center;
                margin: 40px auto;
                border-bottom: ;
            }

            ._success i {
                font-size: 55px;
                color: #2d51a3;
            }

            ._success h2 {
                margin-bottom: 12px;
                font-size: 27px;
                font-weight: bold;
                line-height: 1.2;
                margin-top: 10px;
            }

            ._success p {
                margin-bottom: 0px;
                font-size: 15px;
                color: #495057;
                font-weight: 500;
            }
			
			
        </style>
		<style>
					#main_box{width:100%; background:#2e5597; border-radius:17px;}
					#header_part{padding: 17px 0 0 0; clear:both;}
					#footer_part{
							padding: 30px 30px 27px 10px;text-align: right;clear: both;width: 100%;color: #fff;
							}
					#middle_part{padding:41px 0 108px 0;clear:both;}
					#logo{float: left;width: 50%;text-align: left;padding: 0 0 0 25px;}
					#member_title{color: #fff;width: 50%;float: left;font-size: 14px;padding: 25px 0px 0 65px;}
						#user_desc{text-align: left;width: 100%;}
					#user_desc p{color:#ffffff; width: 50%; float:left; }

				#logo2{float:left; width: 37%; }					
					</style>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
		
		<body style="background-color:F3FAFA;" >';
		//$html .= $pdf_1;
		
		$html .= '<div class="container">
		
			
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="message-box _success">
					
<div id="main_box" style="width:100%; background:#2e5597; border-radius:17px;">
    <div id="header_part" style="padding: 17px 0 0 0; clear:both;">
        <div id="logo" style="float: left;width: 50%; text-align: left;padding: 14px 0 0 20px;">
            <img src="'.$logo_pdf.'" style="width: 100%; max-width:250px;">
        </div>
        <div id="member_title" style="color: #fff;width: 50%;float: left;font-size: 14px;padding: 25px 0px 0 10px;">
            Member Since '.$showDate.'
        </div>
    </div>
    <div id="middle_part" style="padding:41px 0 0px 0;clear:both;">
	
	<table border="0" style="width:100%;">
	<tr>
	<td style="text-align: right;width:30%;"><img src="'.$tutor_img.'" style="width: 130px; border-radius: 50%;margin: 0 23px 0 0px;height: 130px;"></td>
	
	<td style="width:50%;padding-left:15px;">
	<div style="color:#ffffff; width: 100%; margin-bottom:3px; clear:both;  font-weight: bold; font-size: 20px;">'.$tutor_code.'</div>
            <div style="color:#ffffff; width: 100%; margin-bottom:3px; clear:both;  font-size: 18px;">'.$tutor_name.'</div>
            <div style="color:#ffffff; width: 100%; margin-bottom:3px; clear:both;  font-size: 17px;">'.$qualification.'</div>
            <div style="color:#ffffff; width: 100%;  margin-bottom:3px; clear:both; font-size: 16px;">'.$mobile.'</div>
	</td>
	</tr>
	</table>
	
       
    </div>
	
	
	<table border="0" style="width:100%; margin:10px 0px 20px 0px;">
	<tr>
	<td style="width:50%;"></td>
	
	<td style="width:50%; color:#ffffff;">
	<div style="width: 100%;color:#ffffff;margin-bottom:30px; margin-top:30px; ">...you are smarter than you think</div>
	</td>
	</tr>
	</table>
	
	
    
</div>
 </div>
</div>
 </div>
</div>';
		

	 
     $html .= '</body></html>';

// Load HTML into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render PDF
$dompdf->render();

// Stream PDF to browser
$dompdf->stream('tutor_profile.pdf', ['Attachment' => true]);

// End script
exit;
?>
